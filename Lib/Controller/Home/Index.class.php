<?php
namespace Lib\Controller\Home ;

class Index extends Base
{
	public function index()
	{
		$type = getRequestInt('type', 0, 'get');
		$page = getRequestInt('page', 1, 'get');
		
		$limit = 1 ;
		$plimit = 5 ;
		
		$db = M("article");
		
		if ($type) 
			$total = $db->where("type=".$type)->count();
		else
			$total = $db->count();
		
		$pageObj = new \Lib\Core\Utils\Page($_SERVER['SCRIPT_NAME'] .'?', $page, $total,  $plimit, $limit) ;
		$pageHtml = $pageObj->getPage();
		
		$limit = (($page-1) * $limit) . ',' . $limit ;
		
		if ($type)
			$list = $db->where('type='.$type)->limit($limit)->select();
		else 
			$list = $db->limit($limit)->select();
		
		$this->assign('list', $list);
		$this->assign('pageHtml', $pageHtml);

		$this->show("index");
	}

	public function getUrlQrcode(){
		
		$text = getRequestString('text') ;
		$text = urldecode($text);
		
		importORGClass('phpqrcode/qrlib.php');
		\QRcode::png( $text ); // creates file 
	}
	
}
?>
