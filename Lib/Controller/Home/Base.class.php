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
		
		$this->addCss($this->__PUBLIC__ . '/bootstrap3/bower_components/bootstrap/dist/css/bootstrap.min.css');
		$this->addCss($this->__THEME__ . '/style/main.css') ;
		
		$this->addJs($this->__THEME__ . '/script/baidu.js') ;
		$this->addJs($this->__PUBLIC__ . '/bootstrap3/bower_components/jquery/dist/jquery.min.js') ;

		// select the hot articles
		$this->regHotList() ;
		$this->regTypeList() ;
		
		$this->assign("page_title", $this->webname) ;
		$this->assign("page_keywords", "dream128，个人博客，IT技术，小游戏，编程语言，数据库，游戏编程") ;
	}
	
	protected function regTypeList(){
		$currentType = getRequestInt('type', 0, 'get');
		$typeList = M('type')->getAll();
		$this->assign('currentType', $currentType);
		$this->assign('typeList', $typeList);
	}

	protected function regHotList() {
		$list = M("article")->order('id asc')->getAll(10);
		$this->assign('hotlist', $list);
	}
	
	protected function registerSmartyFuncs(){
		
	}
	
}


?>
