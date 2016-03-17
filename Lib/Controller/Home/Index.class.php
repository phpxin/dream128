<?php
namespace Lib\Controller\Home ;

class Index extends Base
{
	public function index()
	{
		$db = M('test') ;
		$s = $db->getAll();
		var_dump($s);
		
		$this->show("index");
	}
}
?>
