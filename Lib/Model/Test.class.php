<?php
namespace Lib\Model ;

class Test extends Base
{
	protected $name = 'test' ;
	protected $alias = 't' ;
	
	protected function getName(){
		return $this->name ;
	}
	
	protected function getAlias(){
		return $this->alias;
	}

	public function getAll($limit = 30 , $page = 1) {
		$limit = '' ;
		if($limit!=0){
			if ($page > 0){
				$start = ($page-1) * $limit;
			}else{
				$start = 0;
			}
			$limit = " limit $start,$limit" ;
		}

		return $this->query("select * from ".$this->tableName." $limit");

	}


}