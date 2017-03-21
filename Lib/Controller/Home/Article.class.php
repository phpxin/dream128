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

}
?>
