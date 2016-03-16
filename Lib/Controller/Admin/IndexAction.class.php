<?php
namespace Controller ;

class Index extends Base
{
	public function index()
	{
		echo 1222 ;
		
		$this->assign("uid", "test");
		$this->show("index");
	}
	
	public function user(){
		echo 'this is user index' ;
		
	}
}
?>
