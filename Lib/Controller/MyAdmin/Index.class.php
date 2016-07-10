<?php
namespace Lib\Controller\MyAdmin;
use \Lib\ORG\Tips as Tips;

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
		$_P = MY_ADMIN_PWD ;
				
		$pass = getRequestString('password') ;

		if ($_P == md5($pass)) {
			# code...
			$_SESSION['ismylogin'] = true ;
			Tips::ajax_success('') ;
		}

		Tips::ajax_error(Tips::$_CODE_INPUT, '密码错误');
	}
	
	public function login(){
		
		
		$this->show('login');
	}
}
?>
