<?php
namespace Lib\Controller\Admin;

class Index extends Base
{
	protected function init() {
		$this->noLoginActions = array(
				'login', 'doLogin'
		) ;
		parent::init() ;
	}
	
	public function index()
	{
		
		$this->assign("uid", "test");
		$this->show("index");
	}
	
	public function user(){
		echo 'this is user index' ;
		
	}
	
	public function doLogin()
	{
		$_U = 'root' ;
		$_P = 'd9b3956011063b98d93ef5ed747a454b' ;
		
		$pass = getRequestString('password') ;
	}
	
	public function login(){
		
		
		$this->show('login');
	}
}
?>
