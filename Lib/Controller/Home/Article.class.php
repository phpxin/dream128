<?php
namespace Lib\Controller\Home ;

class Article extends Base
{
	public function detail()
	{
		$id = getRequestInt('id', 0, 'get');

		$db = M('article');

		$detail = $db->where('id='.$id)->find();
		
		$this->assign('detail' , $detail);

		$this->show('detail');
	}
}
?>
