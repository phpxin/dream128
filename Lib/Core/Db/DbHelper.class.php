<?php
namespace Lib\Core\Db ;

class DbHelper{
	
	private static $sqlArray = array();
	
	public static function setSql($sql){
		array_push(self::$sqlArray, $sql);
	}
	
	public static function getSql(){
		return self::$sqlArray;
	}
	
}