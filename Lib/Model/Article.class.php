<?php
namespace Lib\Model ;

class Article extends Base
{
	protected $name = 'article' ;
	protected $alias = 'article' ;
	
	public static $_STATUS_ONLINE = 1 ;
	public static $_STATUS_OFFLINE = 0 ;
	
	protected function getName(){
		return $this->name ;
	}
	
	protected function getAlias(){
		return $this->alias;
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