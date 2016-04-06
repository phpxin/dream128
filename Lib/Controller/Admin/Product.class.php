<?php
namespace Lib\Controller\Admin;
use \Lib\ORG\Tips as Tips;

class Product extends Base
{
	public function glist()
	{
		$db = M("article");
		$list = $db->select();
		//var_dump($list);
		$this->assign('glist', $list);
		$this->show("list");
	}

	public function doAdd()
	{
		$title = getRequestString('title', '', 'post');
		$content = getRequestString('content', '', 'post');

		$db = M("article") ;
		$db->add(array(
			'title' => $title ,
			'content' => $content ,
			'addtime' => time()
		));

		Tips::ajax_success(array('msg'=>'success')) ;
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
