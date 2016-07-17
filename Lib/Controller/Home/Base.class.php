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

        $this->addCss($this->__THEME__.'/style/style.css');
        $this->addCss($this->__PUBLIC__.'/font-awesome-4.5.0/css/font-awesome.min.css') ;
        
		$this->addJs($this->__PUBLIC__.'/bootstrap3/bower_components/jquery/dist/jquery.min.js') ;
        $this->addJs($this->__THEME__.'/script/common.js');


        $this->checkBroser(); //  检查浏览器是否支持


        $this->regTypeList();
	}

    protected function checkBroser(){
        //var_dump($_SERVER['HTTP_USER_AGENT']);
        //Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Win64; x64; Trident/4.0; .NET CLR 2.0.50727; SLCC2; .NET CLR 3.5.30729; .NET CLR 3.0.30729; InfoPath.3; .NET4.0C)
        $flag = preg_match('/MSIE ([0-9\.]+)\;/iU', $_SERVER['HTTP_USER_AGENT'], $matcher);
        if ($flag){
            if (floatval($matcher[1] <= 8)){

                $this->errorPage('本软件不支持IE8以下浏览器（包含IE8）');
            }
        }

    }

    protected function errorPage($msg,$title='错误'){
        $this->assign('title', $title);
        $this->assign('msg', $msg);
        $this->show('Public/error');
        exit();
    }


    protected function regTypeList(){
        $currentType = getRequestInt('type', 0, 'get');
        $typeList = M('type')->getAll();
        $this->assign('currentType', $currentType);
        $this->assign('typeList', $typeList);
    }

	
	protected function registerSmartyFuncs(){
		
	}
	
}


?>
