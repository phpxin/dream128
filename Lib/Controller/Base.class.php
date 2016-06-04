<?php
namespace Lib\Controller ;
include 'Lib'.DS.'Smarty'.DS.'libs'.DS.'Smarty.class.php';

abstract class Base{

	protected $template ;
	protected $homepath = 'app' ;  //  模板位置
	protected $noLoginActions = array() ;
	
	protected $__THEME__ = '' ;
	protected $__PUBLIC__ = '' ;
	
	protected $css = array();
	protected $js = array();
	
	public function __construct(){
		$this->init();
	}
	
	protected function init()
	{
		$this->__PUBLIC__ = __THEME__.'/public' ;
		$this->__THEME__ = __THEME__.'/'.$this->homepath ;
		$this->createTempEngine(); //初始化模板引擎
	}
	
	protected function addCss($_css){
		array_push($this->css, $_css) ;
	}
	
	protected function addJs($_js){
		array_push($this->js, $_js) ;
	}
	
	/**
	 * 如果需要优化，可以在这个函数里对css打包
	 * 
	 */
	protected function getCssArr(){
		return $this->css ;
	}
	
	/**
	 * 如果需要优化可以在这个函数里对js进行打包
	 * Enter description here ...
	 */
	protected function getJsArr(){
		return $this->js ;
	}
	
	/**
	 * 显示模板
	 * Enter description here ...
	 * @param string $str （格式：Counter/userCounter 代表显示Counter组下的userCounter模板， userCounter 自动当前Action下的userCounter模板）
	 */
	public function show($str)
	{
		$className = get_class($this);
		$className = str_replace('\\', '/', $className);
		$className = substr($className, strrpos($className, '/') + 1);
	
		$mArray=explode('/', trim(str_replace('\\', '/', $str), '/'));
		
		
		
		$cssArr = $this->getCssArr() ;
		$this->assign('css_array', $cssArr);
		
		$jsArr = $this->getJsArr();
		$this->assign('js_array', $jsArr) ;
		
		/*
		$this->display('Public/header.html', $cache_id);
		$this->display('Public/nav.html');
		*/
	
		//两位， 按照用户提交格式显示模板
		if(count($mArray)>1){
			$this->display($str.'.html');
			return ;
		}
		
		if (DEBUG_MODE) {
			$sqls = \Lib\Core\Db\DbHelper::getSql();
			$this->assign('debug_sqls', $sqls);
			//$this->template->display('Public/debug.html');
		}
	
		//一位， 自动选择模板所属组（Action）
		$this->display($className.'/'.$str.'.html');
		
		//$this->template->display('Public/footer.html');
		
	}
	
	private function display($tmpFile){
		$cache_id = md5($_SERVER['QUERY_STRING']) ;
		$this->template->display($tmpFile, $cache_id);
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
	
	/**
	 * 注册私有模板函数
	 */
	abstract protected function registerSmartyFuncs() ;
	
	/**
	 * 注册公用模板函数
	 */
	private function registerSmartyFuncsSys(){
		$this->template->registerPlugin(\Smarty::PLUGIN_FUNCTION, 'U_home', 'U_home');
		$this->template->registerPlugin(\Smarty::PLUGIN_FUNCTION, 'U_admin', 'U_admin');
		
		$this->registerSmartyFuncs();
	}
	
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
	
		//$T->debugging = DEBUG_MODE ? true : false ;
		$T->debugging = false ;
		//$T->caching = DEBUG_MODE ? false : true ;
		$T->caching = false ;
		$T->cache_lifetime = 120;
	
		//注册模板需要的函数
		$T->registerPlugin(\Smarty::PLUGIN_FUNCTION, 'dump', 'dump');
	
		//初始化环境变量
		
		$T->assign('__ROOT__',__ROOT__);
		$T->assign('__PUBLIC__', $this->__PUBLIC__);
		$T->assign('__THEME__', $this->__THEME__);
		$T->assign('__DEBUG__', DEBUG_MODE ? 1 : 0 );
	
		$this->template=$T;
		
		
		$this->registerSmartyFuncsSys();
	}
}
