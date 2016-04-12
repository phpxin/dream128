<?php
namespace Lib\Controller\Home ;

class Games extends Base
{
	public function getGame()
	{
		//act=planebattle
		$act = getRequestString('act') ;
		
		$onlyWap = array('planebattle') ;
		
		if(in_array($act, $onlyWap) && !preg_match('/(iPhone|Android)/iU', $_SERVER['HTTP_USER_AGENT'])) {
			$url = 'http://'.trim($_SERVER['HTTP_HOST'],'/').'/'.ltrim($_SERVER['REQUEST_URI'], '/') ;
			$this->assign('text', urlencode($url));
			$this->show("gamelose");
			return;
		}
		
		switch($act) {
			case 'planebattle' :
				header('location:/games/planebattle');
			default:
				header('location:/');
				;
		}
		
	}
}
?>
