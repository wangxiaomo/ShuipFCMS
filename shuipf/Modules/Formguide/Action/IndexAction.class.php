<?php

/**
 * 表单前台
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
class IndexAction extends BaseAction {

    //表单模型缓存
    public $Model_form;
    protected $db = NULL, $formguide;
    public $formid;

    function _initialize() {
        parent::_initialize();
        $this->formguide = D("Formguide");
        $this->Model_form = F("Model_form");
        if (!$this->Model_form) {
            //生成缓存
            $this->Model_form = D("Model")->Cache(3);
        }
        $formid = I('request.formid', 0, 'intval');
        $this->formid = $formid;
        if (!empty($this->formid)) {
            $this->db = ContentModel::getInstance($this->formid)->relation(false);
        }
        $this->assign('formid', $this->formid);
    }

    //显示表单
    public function index() {
        //判断是否JS显示
        $action = I('get.action');
        if (empty($this->formid)) {
            $action == "js" ? exit : $this->error("该表单不存在！");
        }
        $r = $this->formguide->where(array("modelid" => $this->formid))->find();
        if (empty($r)) {
            $this->error("该表单不存在！");
        }
        //验证权限
        $this->competence();
        //模型
        $moinfo = $this->Model_form[$this->formid];
        if (empty($moinfo)) {
            $action == "js" ? exit : $this->error("该表单不存在或者已经关闭！");
        }
        $setting = unserialize($moinfo['setting']);
        //模板
        $show_template = $setting['show_template'] ? $setting['show_template'] : "show";
        //js模板
        $show_js_template = $setting['js_template'] ? $setting['js_template'] : "show_js";

        //引入输入表单处理类
        require_cache(RUNTIME_PATH . 'content_form.class.php');
        //实例化表单类 传入 模型ID 栏目ID 栏目数组
        $content_form = new content_form($this->formid);
        //生成对应字段的输入表单
        $forminfos = $content_form->get();
        $forminfos = $forminfos['senior'];
        //生成对应的JS提示等
        $formValidator = $content_form->formValidator;

        $this->assign("forminfos", $forminfos);
        $this->assign("formValidator", $formValidator);
        $this->assign($moinfo);
        $this->assign("modelid", $this->formid);
        $this->assign("formid", $this->formid);
        if ($action == 'js') {
            //获取模板路径
            $filepath = TEMPLATE_PATH . (empty(AppframeAction::$Cache["Config"]['theme']) ? "Default" : AppframeAction::$Cache["Config"]['theme']) . "/Formguide/";
            $html = $this->fetch($filepath . "Show/" . $show_js_template . C("TMPL_TEMPLATE_SUFFIX"));
            $dojs = $this->format_js($html); //输出js
            exit($dojs);
        }
        $this->display("Show:" . ($action == "js" ? $show_js_template : $show_template));
    }

    //表单提交
    public function post() {
        if (IS_POST) {
            //表单ID
            $modelid = $formid = $this->formid;
            //验证权限
            $this->competence();
            $info = array_merge($_POST['info'], array(C("TOKEN_NAME") => $_POST[C("TOKEN_NAME")]));
            require_cache(RUNTIME_PATH . 'content_input.class.php');
            require_cache(RUNTIME_PATH . 'content_update.class.php');
            $content_input = new content_input($modelid);
            $inputinfo = $content_input->get($info);
            if (false == $inputinfo) {
                $this->error($content_input->getError());
            }
            $inputinfo = $this->db->create($inputinfo, 1);
            if (false == $inputinfo) {
                $this->error($this->db->getError());
            }

            if ($inputinfo) {
                //主表字段内容
                $systeminfo = $inputinfo;
                //增加一些系统必要字段
                $uid = AppframeAction::$Cache['uid'];
                $username = AppframeAction::$Cache['username'];
                $systeminfo['userid'] = $uid ? $uid : 0;
                $systeminfo['username'] = $username ? $username : "游客";
                $systeminfo['datetime'] = time();
                $systeminfo['ip'] = get_client_ip();
                if (!$this->db->autoCheckToken($info)) {
                    $this->error("表单令牌错误！");
                }
                //写入数据
                $id = $this->db->data($systeminfo)->add();
                if ($id) {
                    //信息量+1
                    M("Model")->where(array("modelid" => $modelid))->setInc("items");
                    //调用 update
                    $content_update = new content_update($modelid, $id, $this);
                    $content_update->update($systeminfo);
                    $forward = $_POST['forward'] ? $_POST['forward'] : "";
                    //发送邮件
                    if ($setting['sendmail'] && $setting['mails']) {
                        $mails = explode("|", $setting['mails']);
                        $title = $systeminfo['username'] . " 提交了新的表单信息！";
                        $message = "刚刚有人在《" . $moinfo['name'] . "》中提交了新的信息，请进入后台查看！";
                        SendMail($mails, $title, $message);
                    }
                    $this->success("提交成功！", $forward);
                } else {
                    $this->error("提交失败！");
                }
            } else {
                $this->error(M($tablename)->getError());
            }
        }
    }

    /**
     * 将文本格式成适合js输出的字符串
     * @param string $string 需要处理的字符串
     * @param intval $isjs 是否执行字符串格式化，默认为执行
     * @return string 处理后的字符串
     */
    protected function format_js($string, $isjs = 1) {
        $string = addslashes(str_replace(array("\r", "\n"), array('', ''), $string));
        return $isjs ? 'document.write("' . $string . '");' : $string;
    }

    //验证提交权限
    protected function competence() {
        //判断是否JS显示
        $action = I('get.action');
        //模型
        $moinfo = $this->Model_form[$this->formid];
        if (empty($moinfo)) {
            $action == "js" ? exit : $this->error("该表单不存在或者已经关闭！");
        }
        $setting = unserialize($moinfo['setting']);
        $time = time();
        //时间判断
        if ($setting['starttime']) {
            if ($time < (int) $setting['starttime']) {
                $action == "js" ? exit : $this->error("还没开始！");
            }
        }
        if ($setting['endtime']) {
            if ($time > (int) $setting['endtime']) {
                $action == "js" ? exit : $this->error("已经结束！");
            }
        }
        //是否允许游客提交
        if ((int) $setting['allowunreg'] == 0) {
            //判断是否登陆
            if (!AppframeAction::$Cache['uid']) {
                $action == "js" ? exit : $this->error("该表单不允许游客提交，请登陆后操作！", U('Member/Index/login'));
            }
        }
        //是否允许同一IP多次提交
        if ((int) $setting['allowmultisubmit'] == 0) {
            $ip = get_client_ip();
            $count = $this->db->where(array("ip" => $ip))->count();
            if ($count) {
                $action == "js" ? exit : $this->error("你已经提交过了！");
            }
        }
    }

}

?>
