<?php
namespace Lib\Controller\Home;

/**
 * 主控制器
 * 所有控制器都应继承这个控制器
 * @author   lixin <lixin65535@126.com>
 * @date 2014-05-28
 */
class Base extends \Lib\Controller\Base{
	
	protected $webname = 'dream128' ;
	
	protected function init(){
		$this->homepath = 'home' ;
		
		parent::init();
		
		$this->assign("page_title", $this->webname) ;
		$this->assign("page_keywords", "dream128，个人博客，IT技术，小游戏，编程语言，数据库，游戏编程") ;
	}

	
	protected function registerSmartyFuncs(){
		
	}
	
}


?>
