<?php
/**
 * 公用函数库
 * @author   lixin <lixin65535@126.com>
 * @version  
 */

/**
 * debug
 * Enter description here ...
 * @param mixed $obj 打印调试信息
 */
function dump($obj){
	echo '<pre>';
	var_dump($obj);
	echo '</pre>';
}
function fdump($obj,$module='w+'){
	$path=defined(LOG_ERROR_PATH)?LOG_ERROR_PATH:'./log';
	$fileName=rtrim($path,'/').'/debug.txt';
	
	touch($fileName); //更新文件访问时间，如果不存在则创建
	
	$_f=fopen($fileName, $module);
	fwrite($_f, var_export($obj,TRUE));
	fclose($_f);
}

/**
 * 从org文件夹载入类
 * Enter description here ...
 * @param $str
 */
function importORGClass($str){
	include_once 'Lib/ORG/'.ltrim($str,'/') ;
}

/**
 * 自动加载类（主要）
 * @param string $s 类名
 * @return string 
 * @info 此函数为php自动调用
 */
function classLoader($className){
	$loaderArr = explode('\\', $className);
	$pathDef = $loaderArr ;
	
	$str = implode(DS, $pathDef);
	$filename = $str.'.class.php' ;
	if (file_exists($filename))
	{
		include $filename;
	}
	//不存在则使用其他Loader
	//Smarty会使用自己的Loader
}

/**
 * 获取标准路径（前台）
 * Enter description here ...
 * @param string $_params['m'] 模块名称
 * @param string $_params['a'] 控制器名称
 * @param array $_params['p'] get参数 以键值对的方式保存 (type=***&id=***)
 */
function U_home($_params=array()){
	
	$module=ucfirst($_params['m']); //module
	empty($module)?$module='Index':null;
	
	$action=$_params['a']; //action
	empty($action)?$action='index':null;
	
	$data = !empty($_params['p']) ? $_params['p'] : '' ;
	
	return rtrim(__ROOT__.'/index.php?m='.$module.'&a='.$action.'&'.$data, '&');
}

function U_admin($_params=array()){
	
	$module=ucfirst($_params['m']); //module
	empty($module)?$module='Index':null;
	
	$action=$_params['a']; //action
	empty($action)?$action='index':null;
	
	$data = !empty($_params['p']) ? $_params['p'] : '' ;
	
	return rtrim(__ROOT__.'/admin.php?m='.$module.'&a='.$action.'&'.$data, '&');
}

function U_myadmin($_params=array()){

	$module=ucfirst($_params['m']); //module
	empty($module)?$module='Index':null;

	$action=$_params['a']; //action
	empty($action)?$action='index':null;

	$data = !empty($_params['p']) ? $_params['p'] : '' ;

	return rtrim(__ROOT__.'/myadmin.php?m='.$module.'&a='.$action.'&'.$data, '&');
}

/**
 * 获取Input值
 * @param string $key				需要获取的值
 * @param string $datatype			string/int/double/float
 * @param mixed $default			
 * @param string $vartype
 */
function getRequestInt($key, $default=0, $type='get'){
	$source = $_GET ;
	if ($type == 'post'){
		$source = $_POST ;
	}
	
	if (!isset($source[$key]) || empty($source[$key])){
		return $default ;
	}
	
	return intval($source[$key]);
}
function getRequestDouble($key, $default=0.0, $type='get'){
	$source = $_GET ;
	if ($type == 'post'){
		$source = $_POST ;
	}

	if (!isset($source[$key]) || empty($source[$key])){
		return $default ;
	}

	return doubleval($source[$key]);
}
function getRequestString($key, $default='', $type='get'){
	$source = $_GET ;
	if ($type == 'post'){
		$source = $_POST ;
	}

	if (!isset($source[$key]) || empty($source[$key])){
		return $default ;
	}

	$value = strval($source[$key]);
	
	$value = \Lib\ORG\LogicUtil::removeXssString($value);
	$value = \Lib\ORG\LogicUtil::getSafeQueryString($value);
	
	return $value;
}

/**
 * 获取数据库连接实例
 * @param string $table 表名
 */
function M($table, $app=''){
	static $dbMaster ;	//定义一个在函数执行后不会释放的静态变量， 存放数据库类实例化的容器
	
	if (!empty($app)) {
		$App = ucfirst(strtolower($app));
		$modelName="\\Lib\\Model\\".$App."\\".ucfirst(strtolower($table));
	}else{
		$modelName="\\Lib\\Model\\".ucfirst(strtolower($table));
		$App = '*' ; // * is public
	}
	
	
	if(empty($dbMaster[$App][$table])){
		$dbMaster[$App][$table] = new $modelName();
	}
	
	return $dbMaster[$App][$table];
}



function isH5(){
	var_dump($_SERVER['HTTP_USER_AGENT']);
	if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/(micromessage|android|ios)/i', $_SERVER['HTTP_USER_AGENT'])){
		return true;
	}
	return false;
}

?>