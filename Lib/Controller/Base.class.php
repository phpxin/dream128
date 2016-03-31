<?php
namespace Lib\Controller ;
include 'Lib'.DS.'Smarty'.DS.'libs'.DS.'Smarty.class.php';

abstract class Base{

	protected $template ;
	protected $homepath = 'app' ;  //  模板位置
	protected $noLoginAction = array();
	
	public function __construct(){
		$this->init();
		$this->createTempEngine(); //初始化模板引擎
	}
	
	abstract function init() ;
	
	/**
	 * 显示模板
	 * Enter description here ...
	 * @param string $str （格式：Counter/userCounter 代表显示Counter组下的userCounter模板， userCounter 自动当前Action下的userCounter模板）
	 */
	public function show($str)
	{
		$className=get_class($this);
		$className = basename($className);
	
		$mArray=explode('/', trim(str_replace('\\', '/', $str), '/'));
	
		//两位， 按照用户提交格式显示模板
		if(count($mArray)>1){
			$this->template->display($str.'.html');
			return ;
		}
	
		//一位， 自动选择模板所属组（Action）
		$this->template->display($className.'/'.$str.'.html');
	}
	
	/**
	 * 模板赋值操作
	 * Enter description here ...
	 * @param string $key 键
	 * @param mixed $val 值
	 * @info 直接向模板引擎中赋值
	 */
	public function assign($key,$val)
	{
		$this->template->assign($key,$val);
	}
	
	abstract function registerSmartyFuncs() ;
	
	/**
	 * 初始化模板引擎
	 * Enter description here ...
	 */
	private function createTempEngine(){
		
		$T = new \Smarty();
	
		$T->template_dir = '.'.DS.'htmls'.DS.$this->homepath.DS.'templates'.DS;
		$T->config_dir = '.'.DS.'htmls'.DS.$this->homepath.DS.'configs'.DS;
		$T->compile_dir = '.'.DS.'htmls'.DS.$this->homepath.DS.'templates_c'.DS;
		$T->cache_dir = '.'.DS.'htmls'.DS.$this->homepath.DS.'cache'.DS;
		//$T->compile_locking = false; // 防止调用touch,saemc会自动更新时间，不需要touch
	
	
		$T->left_delimiter = '<{';
		$T->right_delimiter ='}>';
	
		$T->debugging = DEBUG_MODE ? true : false ;
		$T->caching = DEBUG_MODE ? false : true ;
		$T->cache_lifetime = 120;
	
		//注册模板需要的函数
		$T->registerPlugin(\Smarty::PLUGIN_FUNCTION, 'dump', 'dump');
	
		//初始化环境变量
		$T->assign('__ROOT__',__ROOT__);
		$T->assign('__PUBLIC__', __THEME__.'/public');
		$T->assign('__THEME__',__THEME__.'/'.$this->homepath);
	
		$this->template=$T;
		
		$this->registerSmartyFuncs();
	
	}
}