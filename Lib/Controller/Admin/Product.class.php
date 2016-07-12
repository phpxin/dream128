<?php
namespace Lib\Controller\Admin;
use \Lib\ORG\Tips as Tips;
use \Lib\Model\Article as M_Article;

class Product extends Base
{
	public function glist()
	{
		$db = M("article");
		$list = $db->getAll();
		
		$types = M("type")->getAllWithIdKey();
		
		if ($list) {
			foreach ($list as $k=>$v){
				$list[$k]['type_name'] = isset($types[$v['type']]) ? $types[$v['type']]['name'] : '--'  ;
			}
		}
		
		$this->assign('glist', $list);
		$this->show("list");
	}

	public function doAdd()
	{
		$id = getRequestInt('id', 0, 'post');
		$type = getRequestInt('type', 0, 'post');

		$title = $_POST['title'];
		$content = $_POST['content'];
		
		$title = trim($title);
		$content = trim($content);
		
		if (empty($title) || empty($type) || empty($content))
		{
			Tips::ajax_error(Tips::$_CODE_INPUT, '请填写完整') ;
		}

		$db = M("article") ;
		
		if(empty($id)){
			$db->add(array(
				'type'=>$type ,
				'title' => $title ,
				'content' => $content ,
				'addtime' => time() ,
				'update_time' => time() ,
				'status' => M_Article::$_STATUS_ONLINE ,
			));
			
		}else{
			$db->where('id='.$id)->update(array(
				'type'=>$type ,
				'title' => $title ,
				'content' => $content ,
				'update_time' => time() ,
			));
		}
		

		Tips::ajax_success(array('msg'=>'success')) ;
	}
	
	public function edit()
	{
		$this->add();
	}

	public function add()
	{
		$id = getRequestInt('id', 0, 'get') ;
		
		$typeList = M('type')->getAll();
		
		$info = array();
		if ($id){
			$info = M('article')->where('id='.$id)->find();
		}

		$this->assign('info', $info);
		$this->assign('id', $id);
		$this->assign('typeList', $typeList);
		$this->show("add") ;
	}

	public function del(){
		$id = getRequestInt('id', 0, 'post');
		
		if(empty($id))
			Tips::ajax_error(Tips::$_CODE_INPUT, '缺少参数ID') ;
		
		$db = M("article") ;
		
		$db->where('id='.$id)->del() ;
		Tips::ajax_success(array('msg'=>'success')) ;
	}
}
?>
