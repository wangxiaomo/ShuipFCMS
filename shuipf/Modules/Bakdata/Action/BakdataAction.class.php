<?php

/**
 * Some rights reserved：黑色空白
 * Contact email:omyweb@qq.com
 */
class BakdataAction extends AdminbaseAction {

    private $menuid;

    function _initialize() {
        parent::_initialize();
        $this->menuid = I('get.menuid');
    }

    /**
      +----------------------------------------------------------
     * 列出系统中所有数据库表信息
      +----------------------------------------------------------
     */
    public function index() {
        $M = M();
        $tabs = $M->query('SHOW TABLE STATUS');
        $total = 0;
        foreach ($tabs as $k => $v) {
            $tabs[$k]['size'] = byteFormat($v['Data_length'] + $v['Index_length']);
            $total+=$v['Data_length'] + $v['Index_length'];
        }
        $this->assign("list", $tabs);
        $this->assign("total", byteFormat($total));
        $this->assign("tables", count($tabs));
        $this->display();
    }

    /**
      +----------------------------------------------------------
     * 备份数据库
      +----------------------------------------------------------
     */
    public function backup() {
        if (!IS_POST)
            $this->error("访问出错啦");
        $M = M();
        function_exists('set_time_limit') && set_time_limit(0); //防止备份数据过程超时
        $tables = empty($_POST['table']) ? array() : $_POST['table'];
        if (count($tables) == 0 && !isset($_POST['systemBackup'])) {
            $this->error("请先选择要备份的表!");
        }
        $time = time();
        if (isset($_POST['systemBackup'])) {
            $ADMIN_AUTH_KEY = session(C("ADMIN_AUTH_KEY"));
            if (empty($ADMIN_AUTH_KEY) || $ADMIN_AUTH_KEY == false) {
                $this->error("只有超级管理员账号登录后方可自动备份操作!");
            }
            $type = "系统自动备份";
            $tables = D("Bakdata")->getAllTableName();
            $path = DatabaseBackDir . "/SYSTEM_" . date("Ym");
            if (file_exists($path . "_1.sql")) {
                $this->error("本月度系统已经进行了自动备份操作!");
            }
        } else {
            $type = "管理员后台手动备份";
            $path = DatabaseBackDir . "/ShuipFCMS_" . date("Ymd") . "_" . randCode(5);
        }
        $pre = "# -----------------------------------------------------------\n" .
                "# Database backup files\n" .
                "# Web: http://www.abc3210.com\n" .
                "# Type: {$type}\n";

        $bdTable = D("Bakdata")->bakupTable($tables); //取得表结构信息

        $outPut = "";
        $file_n = 1;
        $backedTable = array();
        foreach ($tables as $table) {
            $backedTable[] = $table;
            $outPut.="\n\n# 数据库表：{$table} 数据信息\n";
            $tableInfo = $M->query("SHOW TABLE STATUS LIKE '{$table}'");
            $page = ceil($tableInfo[0]['Rows'] / 10000) - 1;
            for ($i = 0; $i <= $page; $i++) {
                $query = $M->query("SELECT * FROM {$table} LIMIT " . ($i * 10000) . ", 10000");
                foreach ($query as $val) {
                    $temSql = "";
                    $tn = 0;
                    $temSql = '';
                    foreach ($val as $v) {
                        $temSql.=$tn == 0 ? "" : ",";
                        $temSql.=$v == '' ? "''" : "'{$v}'";
                        $tn++;
                    }
                    $temSql = "INSERT INTO `{$table}` VALUES ({$temSql});\n";

                    $sqlNo = "\n# Time: " . date("Y-m-d H:i:s") . "\n" .
                            "# -----------------------------------------------------------\n" .
                            "# 当前SQL卷标：#{$file_n}\n# -----------------------------------------------------------\n\n\n";
                    if ($file_n == 1) {
                        $sqlNo = "# Description:当前SQL文件包含了表：" . implode("、", $tables) . "的结构信息，表：" . implode("、", $backedTable) . "的数据" . $sqlNo;
                    } else {
                        $sqlNo = "# Description:当前SQL文件包含了表：" . implode("、", $backedTable) . "的数据" . $sqlNo;
                    }
                    if (strlen($pre) + strlen($sqlNo) + strlen($bdTable) + strlen($outPut) + strlen($temSql) > C("sqlFileSize")) {
                        $file = $path . "_" . $file_n . ".sql";
                        $outPut = $file_n == 1 ? $pre . $sqlNo . $bdTable . $outPut : $pre . $sqlNo . $outPut;
                        file_put_contents($file, $outPut, FILE_APPEND);
                        $bdTable = $outPut = "";
                        $backedTable = array();
                        $backedTable[] = $table;
                        $file_n++;
                    }
                    $outPut.=$temSql;
                }
            }
        }

        if (strlen($bdTable . $outPut) > 0) {
            $sqlNo = "\n# Time: " . date("Y-m-d H:i:s") . "\n" .
                    "# -----------------------------------------------------------\n" .
                    "# 当前SQL卷标：#{$file_n}\n# -----------------------------------------------------------\n\n\n";
            if ($file_n == 1) {
                $sqlNo = "# Description:当前SQL文件包含了表：" . implode("\n#", $tables) . "\n#的结构信息，表：\n#" . implode("\n#", $backedTable) . "\n#的数据" . $sqlNo;
            } else {
                $sqlNo = "# Description:当前SQL文件包含了表：" . implode("\n#", $backedTable) . "的数据" . $sqlNo;
            }
            $file = $path . "_" . $file_n . ".sql";
            $outPut = $file_n == 1 ? $pre . $sqlNo . $bdTable . $outPut : $pre . $sqlNo . $outPut;
            file_put_contents($file, $outPut, FILE_APPEND);
            $file_n++;
        }
        $time = time() - $time;
        $this->success("本次备份共生成了！生成了" . ($file_n - 1) . "个SQL文件。耗时：{$time} 秒", U("restore", array('menuid' => $this->menuid)));
    }

    /**
      +----------------------------------------------------------
     * 还原数据库内容
      +----------------------------------------------------------
     */
    public function restore() {
        $data = D("Bakdata")->getSqlFilesList();
        $this->assign("list", $data['list']);
        $this->assign("total", $data['size']);
        $this->assign("files", count($data['list']));
        $this->display();
    }

    /**
      +----------------------------------------------------------
     * 读取要导入的sql文件列表并排序后插入SESSION中
      +----------------------------------------------------------
     */
    static private function getRestoreFiles() {
        $_SESSION['cacheRestore']['time'] = time();
        if (empty($_GET['sqlPre'])) {
            $this->error("错误的请求!");
        }
        //获取sql文件前缀
        $sqlPre = $_GET['sqlPre'];
        $handle = opendir(DatabaseBackDir);
        $sqlFiles = array();
        while ($file = readdir($handle)) {
            //获取以$sqlPre为前缀的所有sql文件
            if (preg_match('#\.sql$#i', $file) && preg_match('#' . $sqlPre . '#i', $file))
                $sqlFiles[] = $file;
        }
        closedir($handle);
        if (count($sqlFiles) == 0) {
            $this->error("错误的请求，不存在对应的SQL文件!");
        }
        //将要还原的sql文件按顺序组成数组，防止先导入不带表结构的sql文件
        $files = array();
        foreach ($sqlFiles as $sqlFile) {
            $k = str_replace(".sql", "", str_replace($sqlPre . "_", "", $sqlFile));
            $files[$k] = $sqlFile;
        }
        unset($sqlFiles, $sqlPre);
        ksort($files);
        $_SESSION['cacheRestore']['files'] = $files;
        return $files;
    }

    /**
      +----------------------------------------------------------
     * 执行还原数据库操作
      +----------------------------------------------------------
     */
    public function restoreData() {
        //ini_set("memory_limit", "256M");
        function_exists('set_time_limit') && set_time_limit(0); //防止备份数据过程超时
        //取得需要导入的sql文件
        $files = isset($_SESSION['cacheRestore']) ? $_SESSION['cacheRestore']['files'] : self::getRestoreFiles();
        //取得上次文件导入到sql的句柄位置
        $position = isset($_SESSION['cacheRestore']['position']) ? $_SESSION['cacheRestore']['position'] : 0;
        $M = M();
        $execute = 0;
        foreach ($files as $fileKey => $sqlFile) {
            $file = DatabaseBackDir . $sqlFile;
            if (!file_exists($file))
                continue;
            $file = fopen($file, "r");
            $sql = "";
            fseek($file, $position); //将文件指针指向上次位置
            while (!feof($file)) {
                $tem = trim(fgets($file));
                //过滤掉空行、以#号注释掉的行、以--注释掉的行
                if (empty($tem) || $tem[0] == '#' || ($tem[0] == '-' && $tem[1] == '-'))
                    continue;
                //统计一行字符串的长度
                $end = (int) (strlen($tem) - 1);
                //检测一行字符串最后有个字符是否是分号，是分号则一条sql语句结束，否则sql还有一部分在下一行中
                if ($tem[$end] == ";") {
                    $sql.=$tem;
                    $M->query($sql);
                    $sql = "";
                    $execute++;
                    if ($execute > 500) {
                        $_SESSION['cacheRestore']['position'] = ftell($file);
                        $imported = isset($_SESSION['cacheRestore']['imported']) ? $_SESSION['cacheRestore']['imported'] : 0;
                        $imported+=$execute;
                        $_SESSION['cacheRestore']['imported'] = $imported;
                        $this->success('当前导入进度：<font color="red">已经导入' . $imported . '条Sql', U("restore", array('menuid' => $this->menuid)));
                    }
                } else {
                    $sql.=$tem;
                }
            }
            fclose($file);
            unset($_SESSION['cacheRestore']['files'][$fileKey]);
            $position = 0;
        }
        $time = time() - $_SESSION['cacheRestore']['time'];
        unset($_SESSION['cacheRestore']);
        $this->success("导入成功，耗时：{$time} 秒钟");
    }

    /**
      +----------------------------------------------------------
     * 删除已备份数据库文件
      +----------------------------------------------------------
     */
    public function delSqlFiles() {
        if (IS_POST) {
            if (empty($_POST['sqlFiles']) || count($_POST['sqlFiles']) == 0) {
                $this->error("请先选择要删除的文件!");
            }
            $files = $_POST['sqlFiles'];
            foreach ($files as $file) {
                delDirAndFile(DatabaseBackDir . $file);
            }
            $this->success("已删除:" . implode("、", $files), U("restore", array('menuid' => $this->menuid)));
        }
    }

    /**
      +----------------------------------------------------------
     * 打包sql文件
      +----------------------------------------------------------
     */
    public function zipSql() {
        if (IS_POST) {
            if (!$_POST['sqlFiles'] || count($_POST['sqlFiles']) == 0) {
                $this->error("请选择要打包的sql文件");
            }
            $files = $_POST['sqlFiles'];
            $toZip = array();
            foreach ($files as $file) {
                $tem = explode("_", $file);
                unset($tem[count($tem) - 1]);
                $toZip[implode("_", $tem)][] = $file;
            }
            foreach ($toZip as $zipOut => $files) {

                if (D("Bakdata")->zip($files, $zipOut . ".zip", DatabaseBackDir . "Zip/")) {
                    foreach ($files as $file) {
                        delDirAndFile(DatabaseBackDir . $file);
                    }
                }
            }
            $this->success("打包的sql文件成功，本次打包" . count($toZip) . "个zip文件", U("zipList", array('menuid' => $this->menuid)));
        }
    }

    /**
      +----------------------------------------------------------
     * 列出以打包sql文件
      +----------------------------------------------------------
     */
    public function zipList() {
        $data = D("Bakdata")->getZipFilesList();
        $this->assign("list", $data['list']);
        $this->assign("total", $data['size']);
        $this->assign("files", count($data['list']));
        $this->display();
    }

    /**
      +----------------------------------------------------------
     * 解压指定的ZIP文件
      +----------------------------------------------------------
     */
    public function unzipSqlfile() {
        if (!IS_POST)
            return FALSE;
        if (!$_POST['zipFiles'] || count($_POST['zipFiles']) == 0) {
            $this->error("请选择要解压的zip文件");
        }
        $files = $_POST['zipFiles'];
        foreach ($files as $k => $file) {
            D("Bakdata")->unzip($file);
        }
        unset($_SESSION['unzip']);
        $this->success("已解压完成！", U("restore", array('menuid' => $this->menuid)));
    }

    /**
      +----------------------------------------------------------
     * 删除已备份数据库文件
      +----------------------------------------------------------
     */
    public function delZipFiles() {
        if (IS_POST) {
            if (!$_POST['zipFiles'] || count($_POST['zipFiles']) == 0) {
                $this->error("请选择要删除的zip文件");
            }
            $files = $_POST['zipFiles'];
            foreach ($files as $file) {
                delDirAndFile(DatabaseBackDir . "Zip/" . $file);
            }
            $this->success("已删除：" . implode("、", $files));
        }
    }

    /**
      +----------------------------------------------------------
     * 下载数据库
      +----------------------------------------------------------
     */
    public function downFile() {
        if (empty($_GET['file']) || empty($_GET['type']) || !in_array($_GET['type'], array("zip", "sql"))) {
            $this->error("下载地址不存在");
        }
        $path = array("zip" => DatabaseBackDir . "Zip/", "sql" => DatabaseBackDir);
        $filePath = $path[$_GET['type']] . $_GET['file'];
        if (!file_exists($filePath)) {
            $this->error("该文件不存在，可能是被删除");
        }
        $filename = basename($filePath);
        header("Content-type: application/octet-stream");
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header("Content-Length: " . filesize($filePath));
        readfile($filePath);
    }

    /**
      +----------------------------------------------------------
     * 修复表
      +----------------------------------------------------------
     */
    public function repair() {
        $M = M("");
        if (IS_POST) {
            if (empty($_POST['table']) || count($_POST['table']) == 0) {
                $this->error('请选择要处理的表');
            }
            $table = implode(',', $_POST['table']);
            if ($M->query("REPAIR TABLE {$table} ")) {
                $this->success("修复表成功！", U("repair", array('menuid' => $this->menuid)));
            } else {
                $this->error('修复表失败');
            }
        } else {
            $tabs = $M->query('SHOW TABLE STATUS');
            $totalsize = array('table' => 0, 'index' => 0, 'data' => 0, 'free' => 0);
            $tables = array();
            foreach ($tabs as $k => $table) {
                $table['size'] = byteFormat($table['Data_length'] + $table['Index_length']);
                $totalsize['table'] += $table['Data_length'] + $table['Index_length'];
                $totalsize['data']+=$table['Data_length'];
                $table['Data_length'] = byteFormat($table['Data_length']);
                $totalsize['index']+=$table['Index_length'];
                $table['Index_length'] = byteFormat($table['Index_length']);
                $totalsize['free']+=$table['Data_free'];
                $table['Data_free'] = byteFormat($table['Data_free']);
                $tables[] = $table;
            }
            $this->assign("list", $tables);
            $this->assign("totalsize", $totalsize);
            $this->display();
        }
    }

    /**
      +----------------------------------------------------------
     * 优化表
      +----------------------------------------------------------
     */
    public function optimize() {
        $M = M("");
        if (IS_POST) {
            if (empty($_POST['table']) || count($_POST['table']) == 0) {
                $this->error('请选择要处理的表！');
            }
            $table = implode(',', $_POST['table']);
            if ($M->query("OPTIMIZE TABLE $table")) {
                $this->success("优化表成功！", U("repair", array('menuid' => $this->menuid)));
            } else {
                $this->error('优化表失败！');
            }
        }
    }

}