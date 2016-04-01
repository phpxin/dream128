<?php
namespace Lib\ORG ;

class StringUtil{
	
	public static $charset = 'utf-8' ;
	
	/**
	 * 字符串截取
	 * Enter description here ...
	 * @param string $str
	 * @param int $start
	 * @param int $limit
	 */
	public static function subString($str, $start, $length){
		return mb_substr ( $str , $start , $length , self::$charset );
	
	}
	
	/**
	 * 字符串统计
	 * Enter description here ...
	 * @param string $str
	 */
	public static function strLength($str)
	{
		return mb_strlen($str, self::$charset);
	}
	
}