<?php
namespace Lib\Controller\Home;

/**
 * 主控制器
 * 所有控制器都应继承这个控制器
 * @author   lixin <lixin65535@126.com>
 * @date 2014-05-28
 */
class Base extends \Lib\Controller\Base{
	
	
	protected function init(){
		$this->homepath = 'home' ;
		
		
		parent::init();
		
		// select the hot articles
		$this->regHotList() ;
		$this->regTypeList() ;
	}
	
	protected function regTypeList(){
		$currentType = getRequestInt('type', 0, 'get');
		$typeList = M('type')->getAll();
		$this->assign('currentType', $currentType);
		$this->assign('typeList', $typeList);
	}

	protected function regHotList() {
		$list = M("article")->getAll(10);
		$this->assign('hotlist', $list);
	}
	
	protected function registerSmartyFuncs(){
		
	}
	
}


?>
