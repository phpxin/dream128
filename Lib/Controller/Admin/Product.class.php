<?php
namespace Lib\Controller\Admin;

class Product extends Base
{
	public function glist()
	{
		$db = M("product");
		$list = $db->select();
		//var_dump($list);
		$this->assign('glist', $list);
		$this->show("list");
	}
	
	public function add()
	{
		$this->show("add") ;
	}
	
	public function del(){
		$gid = $GLOBALS['safeGetParam']['gid'];
		echo $gid;
	}
}
?>
