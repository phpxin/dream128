<?php
namespace Lib\Controller\Home ;

class Index extends Base
{
	public function index()
	{
		$type = getRequestInt('type', 0, 'get');
		$page = getRequestInt('page', 1, 'get');
		
		$limit = 5 ;
		$plimit = 5 ;
		
		$db = M("article");
		
		if ($type) 
			$total = $db->where("type=".$type)->count();
		else
			$total = $db->count();
		
		$pageHtml = '' ;
		if ($total > $limit){
			$pageObj = new \Lib\Core\Utils\Page($_SERVER['SCRIPT_NAME'] .'?', $page, $total,  $plimit, $limit) ;
			$pageHtml = $pageObj->getPage();
		}
		
		$limit = (($page-1) * $limit) . ',' . $limit ;
		
		if ($type)
			$list = $db->field("id,title,content,addtime")->where('type='.$type)->limit($limit)->order('id desc')->select();
		else 
			$list = $db->field("id,title,content,addtime")->limit($limit)->order('id desc')->select();

		if ($list){
			foreach ($list as $key => $val){
				$list[$key]['content'] =  mb_substr($val['content'], 0,100, APP_CHARSET)  ;
			}
		}


		// select the hot articles
		$this->regHotList() ;
		$this->regNewList() ;
		$this->regTypeList() ;
		
		$this->assign('list', $list);
		$this->assign('pageHtml', $pageHtml);

		$this->show("index2");
	}


	protected function regTypeList(){
		$currentType = getRequestInt('type', 0, 'get');
		$typeList = M('type')->getAll();
		$this->assign('currentType', $currentType);
		$this->assign('typeList', $typeList);
	}

	protected function regHotList() {
		$list = M("article")->field("id,title")->order('id asc')->getAll(10);
		foreach ($list as $k => $v){
			$list[$k]['title'] = mb_substr($v['title'], 0, 20, APP_CHARSET);
		}
		$this->assign('hotlist', $list);
	}
	protected function regNewList() {
		$list = M("article")->field("id,title")->order('id desc')->getAll(10);
		foreach ($list as $k => $v){
			$list[$k]['title'] = mb_substr($v['title'], 0, 20, APP_CHARSET);
		}
		$this->assign('newlist', $list);
	}

	public function getUrlQrcode(){
		
		$text = getRequestString('text') ;
		$text = urldecode($text);
		
		importORGClass('phpqrcode/qrlib.php');
		\QRcode::png( $text ); // creates file 
	}
	
}
?>
