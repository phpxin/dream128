<?php
namespace Lib\Controller\Admin;
use \Lib\ORG\Tips as Tips;
use \Lib\Model\Type as M_Type;

class Type extends Base
{
	public function index(){
		$list = M('type')->select() ;
		$this->assign('list', $list);
		$this->show('list');
	}
	
	
	public function add(){
		$this->show('add');
	}
	
	
	public function doAdd(){
		$name = trim($_POST['name']);
		
		if (empty($name))
			Tips::ajax_error(Tips::$_CODE_INPUT, '缺少参数NAME') ;
		
		M('type')->add(array(
			'name'=>$name
		));
		
		Tips::ajax_success(array('msg'=>'success')) ;
	}
	
	public function change(){
		$id = getRequestInt('id', 0, 'post');
		$status = getRequestInt('status', 0, 'post');
		
		if(empty($id))
			Tips::ajax_error(Tips::$_CODE_INPUT, '缺少参数ID') ;
		
		
		M('type')->where('id='.$id)->update(array(
				'status' => $status
		));
		
		Tips::ajax_success(array('msg'=>'success')) ;
	}
}
?>