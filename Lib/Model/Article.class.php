<?php
namespace Lib\Model ;

class Article extends Base
{
	protected $name = 'article' ;
	protected $alias = 'article' ;
	
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