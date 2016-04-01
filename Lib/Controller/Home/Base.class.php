<?php
namespace Lib\Controller\Home;

/**
 * 主控制器
 * 所有控制器都应继承这个控制器
 * @author   lixin <lixin65535@126.com>
 * @date 2014-05-28
 */
abstract class Base extends \Lib\Controller\Base{
	
	
	protected function init(){
		$this->homepath = 'home' ;
		
		parent::init();
	}
	
	protected function registerSmartyFuncs(){
		$this->template->registerPlugin(\Smarty::PLUGIN_FUNCTION, 'U_home', 'U_home');
	}
	
}


?>
