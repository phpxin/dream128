<?php
namespace Lib\Model ;

class Artlog extends Base
{
	protected $name = 'artlog' ;
	protected $alias = 'artlog' ;


	protected function getName(){
		return $this->name ;
	}

	protected function getAlias(){
		return $this->alias;
	}


}