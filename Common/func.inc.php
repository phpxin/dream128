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
 * 字符串统计
 * Enter description here ...
 * @param unknown_type $str
 */
function strLength($str)
{
	return mb_strlen($str, 'utf-8');
}

/**
 * 字符串截取
 * Enter description here ...
 * @param unknown_type $str
 * @param unknown_type $start
 * @param unknown_type $limit
 */
function subString($str, $start, $length){
	return mb_substr ( $str , $start , $length , 'utf-8' );
	
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
	
	return __ROOT__.'/index.php?m='.$module.'&a='.$action.'&'.$data;
}

function U_admin($_params=array()){
	
	$module=ucfirst($_params['m']); //module
	empty($module)?$module='Index':null;
	
	$action=$_params['a']; //action
	empty($action)?$action='index':null;
	
	$data = !empty($_params['p']) ? $_params['p'] : '' ;
	
	return __ROOT__.'/admin.php?m='.$module.'&a='.$action.'&'.$data;
}

/**
 * 字符串处理
 * @param string $s 字符串
 * @return string 
 */
function safeStr($s){
	if(!get_magic_quotes_gpc()){
		return addslashes(htmlspecialchars(trim($s))) ;
	}

	return htmlspecialchars(trim($s)) ;
}

/**
 * 获取数据库连接实例
 * @param string $table 表名
 */
function M($table){
	static $dbMaster ;	//定义一个在函数执行后不会释放的静态变量， 存放数据库类实例化的容器
	$modelName=ucfirst(strtolower($table)).'Model';
	if(empty($dbMaster[$table])){
		try{
			$dbMaster[$table] = new $modelName();
		}catch(\Lib\Exception\SourceNotFound $e){
			//如果类不存在则直接调用基类
			$dbMaster[$table] = new BaseModel($table);
		}
		return $dbMaster[$table];
	}
	return $dbMaster[$table];
}

/**
 * 处理cookie 数据
 * Enter description here ...
 */
function createCookieParams(){
	foreach($_COOKIE as $key=>$value){
		if($key=='U'){
			//处理特殊cookie参数
			$value = str_replace(" ", "+", $value);
			$value = str_replace('"', '',  $value);
		}
		$safeParam[$key] = safeStr($value) ;
	}
	
	return $safeParam;
}

/**
 * 处理http post 数据
 * Enter description here ...
 */
function createPostParams(){
	foreach($_POST as $key=>$value){
		$safeParam[$key] = safeStr($value) ;
	}
	
	return $safeParam;	
}

/**
 * 处理http get 数据
 * @param string $table 表名
 */
function createGetParams(){
	if(URL_MODE===1){
		if(!empty($_SERVER['PATH_INFO'])){
			
			$pathInfo = trim(trim($_SERVER['PATH_INFO']),'/');
			$paramArray = array_reverse(explode('/',$pathInfo));
			//获取控制器参数
			$safeParam['module'] = safeStr(array_pop($paramArray)) ;
			$safeParam['action'] = safeStr(array_pop($paramArray)) ;
			//生成GET数组其他参数
			while(!empty($paramArray)){
				$key = safeStr(array_pop($paramArray));
				$value = safeStr(array_pop($paramArray));
				$safeParam[$key] = $value ;
			}
		}
	}
	
	foreach($_GET as $key=>$value){
		$safeParam[$key] = safeStr($value) ;
	}
	
	return $safeParam;
}


?>