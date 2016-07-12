<?php
namespace Lib\ORG ;
/**
 * 业务逻辑工具类
 * Enter description here ...
 * @author lixin
 * @info 主要功能：辅助action层计算
 */
class LogicUtil
{
	
	public static function getSafeQueryString( $value ){
		if (!get_magic_quotes_gpc()){
			return addslashes($value) ;
		}
		
		return $value ;
	}
	
	public static function removeXssString( $value ){
		$ret = str_replace('script', '', $value);
		$ret = str_replace('iframe', '', $ret);
		$ret = str_replace('link', '', $ret);
		
		return $ret ;
	}
	
	public static function localJump( $params, $action, $module, $app){
		
		//if ($app == 'home') {
			
		//}
		
		$func = "U_{$app}" ;
		
		$url = $func(array(
				'm' => $module ,
				'a' => $action ,
				'p' => trim($params, ' &?') 
		));
		
		
		
		header('location:'.$url) ;
		exit();
	}
	
	
	/**
	 * 验证手机号码是否合法
	 * Enter description here ...
	 * @param $phone
	 */
	public static function checkPhoneNum($phone)
	{
		return preg_match("/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|14[0-9]{1}[0-9]{8}$/", $phone);
	}
	
	/**
	 * 记录到用户行为表（后台统计用）
	 * Enter description here ...
	 * @param string $flag 控制器名
	 * @param int $uid 访问者ID
	 */
	public static function writeToEntryCount($flag, $uid=null)
	{
		$db_page = M('page');
		
		$page_info = $db_page->where("page_flag='$flag'")->find();
		
		if(!empty($page_info)){
			
			$save['count_time']=time();
			$save['count_date']=date('Y-m-d H:i:s',$save['count_time']);
			$save['count_pageid']=$page_info['page_id'];
			$save['count_uid']=empty($uid)?0:$uid; //uid 0 为未登录用户
			
			$db_entrycount = M("entrycount");
			$db_entrycount->add($save);
		}
		
	}
	
	/**
	 * 获取数据表索引值（分表）
	 * Enter description here ...
	 * @param $id
	 */
	public static function getTableIndexById($id){
		$id = intval($id);
		if($id<10){
			return '0'.$id;
		}
		
		return substr($id,-2);
	}
	
	//discuz加密解密函数
	public static function authCode($string, $operation = 'DECODE') {
//		global $_gConfig;
		$ckey_length = 4;
		$key = md5(AUTH_CODE);
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
		$cryptkey = $keya.md5($keya.$keyc);
		$key_length = strlen($cryptkey);
		$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', 0).substr(md5($string.$keyb), 0, 16).$string;
		$string_length = strlen($string);
		$result = '';
		$box = range(0, 255);
		$rndkey = array();
		for($i = 0; $i <= 255; $i++) {
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}
		for($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}
		for($a = $j = $i = 0; $i < $string_length; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}
		if($operation == 'DECODE') {
			if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
				return substr($result, 26);
			} else {
				return '';
			}
		} else {
			return $keyc.str_replace('=', '', base64_encode($result));
		}
	}
		
	/**
	 * 显示ajax数据
	 * Enter description here ...
	 * @param mixed $data
	 */
	public static function showAjax($data){
		if(is_array($data)){
			echo json_encode($data);
		}else{
			echo $data;
		}
		
		exit();
	}
	
	/**
	 * 解析消息正文（依赖getByte.class.php类）
	 * Enter description here ...
	 * @param $val
	 */
	public static function parseTalkBody($val){
		
		
		$messagebyte = getByte::getBytes($val) ;
		
		//消息类型
		$data['header'] = $messagebyte[0];
		unset($messagebyte[0]);
		
		//消息长度
		$_barr = array();
		
		for($i=1; $i<5; $i++)
		{
			$_barr[] = $messagebyte[$i];
			unset($messagebyte[$i]);
		}
		
		$data['len'] = getByte::bytesToInteger($_barr, 0); 
		
		//消息正文
		$data['body'] = getByte::toStr($messagebyte);

		return $data;
	}
	
	/**
	 * 增加/减少比率计算
	 * Enter description here ...
	 * @param double $m 
	 * @param double $n
	 * @return 返回计算后的值 (1.2代表增加120%，-1.2代表减少120%)
	 */
	public static function rateCalculate($m,$n)
	{
		if($m==0 && $n==0){
			return 0;
		}
		
		if($m==$n)	return 100;
		
		$operator=$m>$n?1:-1;
		
		$m=abs($m);
		$n=abs($n);
		
		$sum=(self::max($m, $n)-self::min($m, $n))/self::max($m, $n)*100;
		
		if(is_float($sum)){ //格式化浮点数
			$sum=floatval(sprintf("%.2lf",$sum));
		}
		
		return $sum*$operator;
		
	}
	
	/**
	 * 普通比率计算
	 * Enter description here ...
	 * @param double $m
	 * @param double $n
	 * @return 返回计算后的值 
	 */
	public static function rateCalculate2($m, $n)
	{
		if($m==0 && $n==0){
			return 0;
		}
		if($m==$n)	return 100;
		
		$operator=$m>$n?1:-1;
		
		$m=abs($m);
		$n=abs($n);
		
		$sum=self::min($m, $n)/self::max($m, $n)*100;
		
		if(is_float($sum)){ //格式化浮点数
			$sum=floatval(sprintf("%.2lf",$sum));
		}
		
		return $sum*$operator;
	}
	
	public static function max($m,$n){
		return $m>$n?$m:$n;
	}
	
	public static function min($m,$n){
		return $m<$n?$m:$n;
	}
}