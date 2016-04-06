<?php
namespace Lib\Controller\Home ;

class Index extends Base
{
	public function index()
	{
		$db = M("article");
		$list = $db->select();
		$this->assign('list', $list);

		$this->show("index");
	}

	
}
?>
