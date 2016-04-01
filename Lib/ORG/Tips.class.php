<?php
namespace Lib\ORG ;

class Tips{
	
	// 成功
	public static $_CODE_SUCC = 200 ;
	
	// 输入错误
	public static $_CODE_INPUT = 402;
	// 未登录
	public static $_CODE_FORBIDDEN = 403 ;
	// 资源找不到
	public static $_CODE_NOTFOUND = 404 ;
	// 系统错误
	public static $_CODE_SYSERR = 500 ;
	
	
	public static function ajax_success($data, $isexit = true)
	{
		$ret['code'] = self::$_CODE_SUCC ;
		$ret['now'] = date('Y-m-d H:i:s') ;
		$ret['data'] = $data ;
		
		echo json_encode($ret, JSON_UNESCAPED_UNICODE) ;
		if ($isexit)	exit() ;
	}
	
	public static function ajax_error($code, $msg, $data=array(), $isexit = true)
	{
		$ret['code'] = $code ;
		$ret['now'] = date('Y-m-d H:i:s') ;
		$ret['data'] = array(
				'msg' => $msg 
		) ;
		
		if (is_array($data)){
			$ret['data'] = array_merge($ret['data'], $data) ;
		}else{
			array_push($ret['data'], $data);
		}
		
		echo json_encode($ret, JSON_UNESCAPED_UNICODE) ;
		if ($isexit)	exit() ;
	}
	
}