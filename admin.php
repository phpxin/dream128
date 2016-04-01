<?php
/**
 * 主入口文件 网页用户接口
 * @author   lixin <lixin65535@126.com>
 * @version  
 */
include 'Common/common.php';

//注册自动加载类函数，__autoload与 smarty3 有冲突
spl_autoload_register('classLoader');

//加载控制器
$module = getRequestString('m');	//   module   模块
$action = getRequestString('a');	//	 action	  控制器

\Common::$_module = $module = empty($module)? '\\Lib\\Controller\\Admin\\Index': '\\Lib\\Controller\\Admin\\'.ucfirst(strtolower($module));
\Common::$_action = $action = empty($action)?'index': $action ;

$__m = new $module();
$__m->$action();

?>