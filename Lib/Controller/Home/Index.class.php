<?php
namespace Lib\Controller\Home ;

class Index extends Base
{
	public function index()
	{
		$type = getRequestInt('type', 0, 'get');
		
		$db = M("article");
		
		if ($type)
			$list = $db->where('type='.$type)->select();
		else 
			$list = $db->select();
		
		$this->assign('list', $list);
		
		

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
