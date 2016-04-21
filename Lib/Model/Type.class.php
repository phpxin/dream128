<?php
namespace Lib\Model ;

class Type extends Base
{
	protected $name = 'type' ;
	protected $alias = 'type' ;
	
	public static $_STATUS_ONLINE = 1 ;
	public static $_STATUS_OFFLINE = 0 ;
	
	protected function getName(){
		return $this->name ;
	}
	
	protected function getAlias(){
		return $this->alias;
	}
	
	public function getAllWithIdKey($limit = 30, $page = 1){
		$_data = $this->getAll($limit, $page);
		
		if ($_data){
			$list = array () ;
			foreach ($_data as $val){
				$list[$val['id']] = $val ;
			}
			return  $list ;
		}
		
		return array();
	}

	public function getAll($limit = 30 , $page = 1) {
		$_limit = '' ;
		if($limit!=0){
			if ($page > 0){
				$start = ($page-1) * $limit;
			}else{
				$start = 0;
			}
			$_limit = "$start,$limit" ;
		}
		
		$where = array(
				'status='.self::$_STATUS_ONLINE
		);
		
		$list = $this->where( $where )->limit($_limit)->select() ;

		return $list;

	}


}