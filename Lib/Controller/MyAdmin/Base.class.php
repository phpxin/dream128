<?php
namespace Lib\Controller\MyAdmin;
use \Lib\ORG\Tips as Tips;

/**
 * 主控制器
 * 所有控制器都应继承这个控制器
 * @author   lixin <lixin65535@126.com>
 * @date 2014-05-28
 */
abstract class Base extends \Lib\Controller\Base{
	
	protected function init(){
		if (!in_array(\Common::$_action, $this->noLoginActions)){
			if (!$_SESSION['ismylogin']){
				if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) ){
					Tips::ajax_error(Tips::$_CODE_FORBIDDEN, '请登录') ;
				}else{
					\Lib\ORG\LogicUtil::localJump('', 'login', 'index', 'myadmin');
				}
			}
		}
		
		$this->homepath = 'myadmin' ;
		
		parent::init();
	}
	
	protected function registerSmartyFuncs(){
		
	}
}


?>
