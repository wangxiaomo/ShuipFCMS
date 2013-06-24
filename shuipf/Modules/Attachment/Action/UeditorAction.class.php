<?php

/**
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
class UeditorAction extends AttachmentsAction {

    public $maxSize;
    public $allowExts;
    public $Attachment;

    function _initialize() {
        define("Ueditor", true);
        parent::_initialize();
        if ($this->isadmin) {
            //设置上传大小
            $this->maxSize = (int) CONFIG_UPLOADMAXSIZE * 1024; //单位字节
        } else {
            $this->maxSize = (int) CONFIG_QTUPLOADMAXSIZE * 1024; //单位字节
        }
    }

    //处理远程图片抓取的地址
    public function getRemoteImage() {
        
    }

    //图片在线浏览的处理地址
    public function imageManager() {
        $data = $this->att_not_used();
        $str = "";
        foreach ($data as $v) {
            $str .= $v['src'] . "ue_separate_ue";
        }
        echo $str;
    }

    //屏幕截图的server端保存程序
    public function snapImgUp() {
        //array2file($_POST, './post.txt');
    }

    /**
     * 编辑器图片上传
     * array (
      'pictitle' => '6.jpg',
      'Filename' => '6.jpg',
      'catid' => '73',
      'Upload' => 'Submit Query',
      )
     */
    public function imageUp() {
        if (IS_POST) {
            //如果是非后台用户，进行权限判断
            if (!$this->isadmin) {
                $Member_group = F("Member_group");
                if ((int) $Member_group[$this->groupid]['allowattachment'] < 1) {
                    echo "{'url':'图片地址','state':'没有上传权限！".$this->isadmin."','title':'标题'}";
                    exit;
                }
            }
            //描述
            $pictitle = $this->_post("pictitle");
            $upload = new UploadFile();
            $this->catid = $this->_post("catid") ? $this->_post("catid") : 0;
            $this->Attachment = service("Attachment", array("module" => $this->module, "catid" => $this->catid, "isadmin" => $this->isadmin ? 1 : 0));
            $this->module = strtolower("contents");
            //上传目录
            $this->filepath = $this->Attachment->FilePath();
            //设置上传类型，强制为图片类型
            $upload->allowExts = $this->allowExts = array("jpg", "png", "gif", "jpeg");
            //设置上传目录
            $upload->savePath = $this->filepath;
            $Callback = false;

            //是否添加水印 
            if ((int) $this->_post('watermark_enable')) {
                $Callback = array(
                    array("AttachmentsAction", "water"),
                    array(),
                );
            }
            //开始上传
            if ($upload->upload($Callback)) {
                //上传成功
                $info = $upload->getUploadFileInfo();
                //保存目录路径 例如 /home/wwwroot/ecms.abc3210.com/e/home/d/album/1970/01
                $savepath = $info[0]['savepath'];
                //保存文件名
                $savename = $info[0]['savename'];
                //文件路径
                $upfilepath = $savepath . $savename;
                //附件表信息写入
                $status = $this->Attachment->FileData($info[0]);
                $in = array(
                    "url" => "",
                    "state" => "",
                    "title" => ""
                );
                if ($status) {
                    // 设置附件cookie
                    $this->Attachment->upload_json($status, $this->Attachment->filehttp, str_replace(array("\\", "/"), "", $info[0]['name']));
                    $in['url'] = $this->Attachment->filehttp;
                    $in['title'] = str_replace(array("\\", "/"), "", $pictitle ? $pictitle : $info[0]['name']);
                    $in['state'] = "SUCCESS";
                    echo json_encode($in);
                    exit;
                } else {
                    //删除已经上传的图片，这里逻辑还要优化
                    @unlink($upfilepath);
                    echo "{'url':'图片地址','state':'上传失败！','title':'标题'}";
                    exit;
                }
            }
        }
        echo "{'url':'图片地址','state':'上传失败！','title':'标题'}";
        exit;
    }

    /**
     * 视频搜索 
     */
    public function getMovie() {
        $key = $this->_post("searchKey");
        $type = $this->_post("videoType");
        $html = file_get_contents('http://api.tudou.com/v3/gw?method=item.search&appKey=myKey&format=json&kw=' . $key . '&pageNo=1&pageSize=20&channelId=' . $type . '&inDays=7&media=v&sort=s');
        echo $html;
    }

}

?>
