<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 插件后台管理
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Addon\Database\Controller;

use Addons\Util\Adminaddonbase;

class AdminController extends Adminaddonbase {

    //配置
    protected $databaseConfig = array();

    protected function _initialize() {
        parent::_initialize();
        import('Database', $this->addonPath);
        //获取插件配置
        $config = $this->getAddonConfig();
        if (empty($config)) {
            $this->error('请先进行相关配置！');
        }
        $this->databaseConfig = array(
            //数据库备份根路径（路径必须以 / 结尾）
            'path' => SITE_PATH . $config['path'],
            //数据库备份卷大小 （该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M）
            'part' => (int) $config['part'],
            //数据库备份文件是否启用压缩 （压缩备份文件需要PHP环境支持gzopen,gzwrite函数）
            'compress' => (int) $config['compress'],
            //数据库备份文件压缩级别 （数据库备份文件的压缩级别，该配置在开启压缩时生效） 1普通 4一般 9最高
            'level' => (int) $config['level'],
        );
    }

    //数据库备份
    public function index() {
        //取得表结构
        $list = M()->query('SHOW TABLE STATUS');
        //转换为小写
        $list = array_map('array_change_key_case', $list);
        $this->assign('list', $list);
        $this->display('export');
    }

    //备份恢复
    public function restore() {
        //列出备份文件列表
        $path = $this->databaseConfig['path'];
        $glob = glob($path . '*.gz', GLOB_BRACE);
        $list = array();
        foreach ($glob as $key => $file) {
            $fileInfo = pathinfo($file);
            //文件名
            $name = $fileInfo['basename'];
            if (preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql(?:\.gz)?$/', $name)) {
                $name = sscanf($name, '%4s%2s%2s-%2s%2s%2s-%d');

                $date = "{$name[0]}-{$name[1]}-{$name[2]}";
                $time = "{$name[3]}:{$name[4]}:{$name[5]}";
                $part = $name[6];

                if (isset($list["{$date} {$time}"])) {
                    $info = $list["{$date} {$time}"];
                    $info['part'] = max($info['part'], $part);
                    $info['size'] = $info['size'] + filesize($file);
                } else {
                    $info['part'] = $part;
                    $info['size'] = filesize($file);
                }

                $extension = strtoupper($fileInfo['extension']);
                $info['compress'] = ($extension === 'SQL') ? '-' : $extension;
                $info['time'] = strtotime("{$date} {$time}");

                $list["{$date} {$time}"] = $info;
            }
        }
        $this->assign('list', $list);
        $this->display('import');
    }

    //删除备份文件
    public function del() {
        $time = I('get.time', 0, 'intval');
        if ($time) {
            //备份数据库文件名
            $name = date('Ymd-His', $time) . '-*.sql*';
            $path = $this->databaseConfig['path'] . $name;
            array_map("unlink", glob($path));
            if (count(glob($path))) {
                $this->success('备份文件删除失败，请检查权限！');
            } else {
                $this->success('备份文件删除成功！');
            }
        } else {
            $this->error('参数错误！');
        }
    }

    //下载
    public function download() {
        $time = I('get.time', 0, 'intval');
        if ($time) {
            //备份数据库文件名
            $name = date('Ymd-His', $time) . '-*.sql*';
            $path = $this->databaseConfig['path'] . $name;
            $path = glob($path);
            if (empty($path)) {
                $this->error('下载文件不存在！');
            }
            $file = $path[0];
            $file_part = pathinfo($file);
            $basename = $file_part['filename'];
            //获取用户客户端UA，用来处理中文文件名
            $ua = $_SERVER["HTTP_USER_AGENT"];
            //从下载文件地址中获取的后缀
            $fileExt = $file_part['extension'];
            if (preg_match("/MSIE/", $ua)) {
                $filename = iconv("UTF-8", "GB2312//IGNORE", $basename . "." . $fileExt);
            } else {
                $filename = $basename . "." . $fileExt;
            }
            header("Content-type: application/octet-stream");
            $encoded_filename = urlencode($filename);
            $encoded_filename = str_replace("+", "%20", $encoded_filename);
            if (preg_match("/MSIE/", $ua)) {
                header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
            } else if (preg_match("/Firefox/", $ua)) {
                header("Content-Disposition: attachment; filename*=\"utf8''" . $filename . '"');
            } else {
                header('Content-Disposition: attachment; filename="' . $filename . '"');
            }
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header("Content-Length: " . filesize($file));
            readfile($file);
        } else {
            $this->error('参数错误！');
        }
    }

    //修复表
    public function repair() {
        //表名
        $tables = I('request.tables');
        if ($tables) {
            $Db = M();
            if (is_array($tables)) {
                $tables = implode('`,`', $tables);
                $list = $Db->query("REPAIR TABLE `{$tables}`");

                if ($list) {
                    $this->success("数据表修复完成！");
                } else {
                    $this->error("数据表修复出错请重试！");
                }
            } else {
                $list = $Db->query("REPAIR TABLE `{$tables}`");
                if ($list) {
                    $this->success("数据表'{$tables}'修复完成！");
                } else {
                    $this->error("数据表'{$tables}'修复出错请重试！");
                }
            }
        } else {
            $this->error("请指定要修复的表！");
        }
    }

    //优化表
    public function optimization() {
        //表名
        $tables = I('request.tables');
        if ($tables) {
            $Db = M();
            if (is_array($tables)) {
                $tables = implode('`,`', $tables);
                $list = $Db->query("OPTIMIZE TABLE `{$tables}`");

                if ($list) {
                    $this->success("数据表优化完成！");
                } else {
                    $this->error("数据表优化出错请重试！");
                }
            } else {
                $list = $Db->query("OPTIMIZE TABLE `{$tables}`");
                if ($list) {
                    $this->success("数据表'{$tables}'优化完成！");
                } else {
                    $this->error("数据表'{$tables}'优化出错请重试！");
                }
            }
        } else {
            $this->error("请指定要优化的表！");
        }
    }

    //还原数据库
    public function import() {
        //时间
        $time = I('request.time', 0, 'intval');
        $part = I('request.part', null);
        //起始行数
        $start = I('request.start', null);
        if (is_numeric($time) && is_null($part) && is_null($start)) { //初始化
            //获取备份文件信息
            $name = date('Ymd-His', $time) . '-*.sql*';
            $path = $this->databaseConfig['path'] . $name;
            $files = glob($path);
            $list = array();
            foreach ($files as $name) {
                $basename = basename($name);
                $match = sscanf($basename, '%4s%2s%2s-%2s%2s%2s-%d');
                $gz = preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql.gz$/', $basename);
                $list[$match[6]] = array($match[6], $name, $gz);
            }
            ksort($list);

            //检测文件正确性
            $last = end($list);
            if (count($list) === $last[0]) {
                session('backup_list', $list); //缓存备份列表
                $this->success('初始化完成！', '', array('part' => 1, 'start' => 0));
            } else {
                $this->error('备份文件可能已经损坏，请检查！');
            }
        } elseif (is_numeric($part) && is_numeric($start)) {
            $list = session('backup_list');
            $db = new \Database($list[$part], array(
                'path' => $this->databaseConfig['path'],
                'compress' => $list[$part][2])
            );

            $start = $db->import($start);

            if (false === $start) {
                $this->error('还原数据出错！');
            } elseif (0 === $start) { //下一卷
                if (isset($list[++$part])) {
                    $data = array('part' => $part, 'start' => 0);
                    $this->success("正在还原...#{$part}", '', $data);
                } else {
                    session('backup_list', null);
                    $this->success('还原完成！');
                }
            } else {
                $data = array('part' => $part, 'start' => $start[0]);
                if ($start[1]) {
                    $rate = floor(100 * ($start[0] / $start[1]));
                    $this->success("正在还原...#{$part} ({$rate}%)", '', $data);
                } else {
                    $data['gz'] = 1;
                    $this->success("正在还原...#{$part}", '', $data);
                }
            }
        } else {
            $this->error('参数错误！');
        }
    }

    //备份数据库
    public function export() {
        //表名
        $tables = I('request.tables');
        //表ID
        $id = I('request.id');
        //起始行数
        $start = I('request.start');
        if (IS_POST && !empty($tables) && is_array($tables)) { //初始化
            //读取备份配置
            $config = $this->databaseConfig;

            //检查是否有正在执行的任务
            $lock = "{$config['path']}backup.lock";
            if (is_file($lock)) {
                $this->error('检测到有一个备份任务正在执行，请稍后再试！');
            } else {
                //创建锁文件
                file_put_contents($lock, NOW_TIME);
            }

            //检查备份目录是否可写
            is_writeable($config['path']) || $this->error('备份目录[' . $config['path'] . ']不存在或不可写，请检查后重试！');
            session('backup_config', $config);

            //生成备份文件信息
            $file = array(
                'name' => date('Ymd-His', NOW_TIME),
                'part' => 1,
            );
            session('backup_file', $file);

            //缓存要备份的表
            session('backup_tables', $tables);

            //创建备份文件
            $Database = new \Database($file, $config);
            if (false !== $Database->create()) {
                $tab = array('id' => 0, 'start' => 0);
                $this->success('初始化成功！', '', array('tables' => $tables, 'tab' => $tab));
            } else {
                $this->error('初始化失败，备份文件创建失败！');
            }
        } elseif (IS_GET && is_numeric($id) && is_numeric($start)) { //备份数据
            $tables = session('backup_tables');
            //备份指定表
            $Database = new \Database(session('backup_file'), session('backup_config'));
            $start = $Database->backup($tables[$id], $start);
            if (false === $start) { //出错
                $this->error('备份出错！');
            } elseif (0 === $start) { //下一表
                if (isset($tables[++$id])) {
                    $tab = array('id' => $id, 'start' => 0);
                    $this->success('备份完成！', '', array('tab' => $tab));
                } else { //备份完成，清空缓存
                    unlink(session('backup_config.path') . 'backup.lock');
                    session('backup_tables', null);
                    session('backup_file', null);
                    session('backup_config', null);
                    $this->success('备份完成！');
                }
            } else {
                $tab = array('id' => $id, 'start' => $start[0]);
                $rate = floor(100 * ($start[0] / $start[1]));
                $this->success("正在备份...({$rate}%)", '', array('tab' => $tab));
            }
        } else { //出错
            $this->error('参数错误！');
        }
    }

}
