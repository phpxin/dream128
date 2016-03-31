<?php
namespace Lib\Controller\Admin;

/**
 * 主控制器
 * 所有控制器都应继承这个控制器
 * @author   lixin <lixin65535@126.com>
 * @date 2014-05-28
 */
class Base extends \Lib\Controller\Base{

	public function init(){
		$this->homepath = 'admin' ;
	}
	
	public function registerSmartyFuncs(){
		$this->template->registerPlugin(\Smarty::PLUGIN_FUNCTION, 'U_admin', 'U_admin');
	}
}


?>
