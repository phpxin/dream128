<?php
/**
 * 主入口文件 命令行接口
 * @author   lixin <lixin65535@126.com>
 * @version
 */
include 'Common/common.php';

//注册自动加载类函数，__autoload与 smarty3 有冲突
spl_autoload_register('classLoader');

if (count($argv)<2) {
    echo 'usage : /usr/bin/php cli.php moduleName ' , PHP_EOL ;
    exit();
}


//加载控制器
$module = $argv[1];	//   module   模块

\Common::$_module = $module = '\\Lib\\Cli\\'.ucfirst(strtolower($module));


$__m = new $module();
$__m->run();

