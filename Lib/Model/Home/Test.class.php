<?php
namespace Lib\Model\Home ;
use Lib\Model ;

class Test extends Model\Base 
{
	
	
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