<?php
/**
 * 主入口文件 网页用户接口
 * @author   lixin <lixin65535@126.com>
 * @version  
 */
include 'Common/common.php';

//创建get参数
$GLOBALS['safeGetParam'] = createGetParams(); //将安全get参数装载到全局数组
$GLOBALS['safePostParam'] = createPostParams(); //将安全get参数装载到全局数组
$GLOBALS['safeCookieParam'] = createCookieParams(); //将安全cookie参数装载到全局数组

//注册自动加载类函数，__autoload与 smarty3 有冲突
spl_autoload_register('classLoader');

//加载控制器
$module = safeStr($GLOBALS['safeGetParam']['m']);	//   module   模块
$action = safeStr($GLOBALS['safeGetParam']['a']);	//	 action	  控制器

$module = empty($module)? 'Lib\\Controller\\Home\\Index': 'Lib\\Controller\\Home\\'.ucfirst(strtolower($module));
$action = empty($action)?'index':strtolower($action);


$__m = new $module();

$__m->$action();

?>