<?php
namespace Controller\Admin ;

/**
 * 主控制器
 * 所有控制器都应继承这个控制器
 * @author   lixin <lixin65535@126.com>
 * @date 2014-05-28
 */
class Bash{

	protected $template ;
	protected $noLoginAction = array();

	public function __construct(){

		//公用逻辑（用户验证等）

		importORGClass('DateUtil.class.php');
		importORGClass('LogicUtil.class.php');

		DateUtil::init(); //初始化日期工具类常量
		$this->createTempEngine(); //初始化模板引擎

	}

	/**
	 * 显示模板
	 * Enter description here ...
	 * @param string $str （格式：Counter/userCounter 代表显示Counter组下的userCounter模板， userCounter 自动当前Action下的userCounter模板）
	 */
	public function show($str)
	{
		$className=get_class($this);

		$mArray=explode('/', trim(str_replace('\\', '/', $str), '/'));

		//两位， 按照用户提交格式显示模板
		if(count($mArray)>1){
			$this->template->display($str.'.html');
			return ;
		}

		//一位， 自动选择模板所属组（Action）
		$this->template->display(substr($className,0,-6).'/'.$str.'.html');
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
	 * 初始化模板引擎
	 * Enter description here ...
	 */
	private function createTempEngine(){

		include 'Lib'.DS.'Smarty'.DS.'libs'.DS.'Smarty.class.php';
		$T = new Smarty();

        $T->template_dir = '.'.DS.'htmls'.DS.'admin'.DS.'templates'.DS;
		$T->config_dir = '.'.DS.'htmls'.DS.'admin'.DS.'configs'.DS;
		if(DEBUG_MODE){
			$T->compile_dir = '.'.DS.'htmls'.DS.'admin'.DS.'templates_c'.DS;
			$T->cache_dir = '.'.DS.'htmls'.DS.'admin'.DS.'cache'.DS;
		}else{
			$T->compile_dir = 'saemc://templates_c/';
			$T->cache_dir = 'saemc://templates_c/';
		}
		$T->compile_locking = false; // 防止调用touch,saemc会自动更新时间，不需要touch

		$T->left_delimiter = '<{';
		$T->right_delimiter ='}>';

		$T->debugging = false;
		$T->caching = false;
		$T->cache_lifetime = 120;

		//注册模板需要的函数
		$T->registerPlugin(Smarty::PLUGIN_FUNCTION, 'dump', 'dump');
		$T->registerPlugin(Smarty::PLUGIN_FUNCTION, 'U_admin', 'U_admin');

		//初始化环境变量
		$T->assign('__ROOT__',__ROOT__);
		$T->assign('__PUBLIC__', __THEME__.'/public');
		$T->assign('__THEME__',__THEME__.'/admin');

		$this->template=$T;

	}
}


?>
