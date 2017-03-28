<?php
namespace Lib\Controller\Home ;

class Article extends Base
{
	public function detail()
	{
		$id = getRequestInt('id', 0, 'get');

		$this->recordArticleLog($id) ;

		$db = M('article');

		$detail = $db->where('id='.$id)->find();
		
		$content = $detail['content'] ; //preg_replace('/\s+/', ' ', $detail['content']);
		
		$this->assign('detail' , $detail);
		$this->assign('content'	, $content) ;
		
		$this->assign('page_title', $detail['title'].'_'.$this->webname) ;
        
		$this->addCss($this->__PUBLIC__.'/editor/third-party/SyntaxHighlighter/shCoreDefault.css');
		$this->addCss($this->__THEME__.'/style/editor_t.css') ;
		
		
		$this->addJs($this->__PUBLIC__.'/editor/ueditor.parse.js') ;
		$this->addJs($this->__PUBLIC__.'/editor/third-party/SyntaxHighlighter/shCore.js');

		$dbArtlog = M('artlog') ;
		$readCount = $dbArtlog->where('articleid='.$id)->count();
		$this->assign('readCount', $readCount) ;

		if (isH5()){
			$this->show('detail.h5');
			exit();
		}

		$this->show('detail');
	}

	//记录浏览
	private function recordArticleLog($id){

		$now = time() ;
		$ip = getClientIp() ;
		$sessid = session_id() ;

		$where = array(
			"ip='{$ip}'" ,
			"sessid='{$sessid}'" ,
			"articleid={$id}" ,
		);

		$db = M('artlog') ;

		$data = $db->where($where)->order("created_at desc")->find();
		if ($data['created_at']+(60*5)>$now)
			return ; //同一IP地址、同一浏览器、同一文章距离上次浏览不足5分钟,不统计

		$artlog['ip'] = $ip ;
		$artlog['sessid'] = $sessid;
		$artlog['articleid'] = $id ;
		$artlog['created_at'] = $now;

		$db->add($artlog);
	}
	
	
	public function apiGetArticleList()
	{
		$type = getRequestInt('type', 0, 'get');
		$page = getRequestInt('page', 1, 'get');

		$limit = 25 ;
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
				$list[$key]['addtime'] = date('r', $val['addtime']);
			}
		}
		
		echo json_encode(array('code'=>200, 'data'=>$list), JSON_UNESCAPED_UNICODE);
	}

	public function apiGetDetail()
	{
		$id = getRequestInt('id', 0, 'get');

		$this->recordArticleLog($id) ;

		$db = M('article');

		$detail = $db->where('id='.$id)->find();

		$content = $detail['content'] ; //preg_replace('/\s+/', ' ', $detail['content']);
		$content = htmlspecialchars_decode($content) ;
		$content = preg_replace(array('/\<br.*\>/U','/\<\/p\>/U'), array("\n","\n"), $content );
		$content = strip_tags($content) ;


		echo json_encode(array('code'=>200, 'data'=>$content), JSON_UNESCAPED_UNICODE);
	}
}
?>
