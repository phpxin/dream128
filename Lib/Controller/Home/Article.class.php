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

		$this->addCss($this->__THEME__.'/style/editor_t.css') ;
		$this->addJs($this->__PUBLIC__.'/editor/ueditor.parse.js') ;

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
		$artlog['useragent'] = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT']: '';

		$db->add($artlog);


		//更新文章冗余
		$articleModel = M('article') ;
		$articleInfo = $articleModel->where('id='.$id)->find();
		$articleModel->where('id='.$id)->update(['hits'=>$articleInfo['hits']+1]);
	}
	
	
	public function apiGetArticleList()
	{
		$list = array(
			array('id'=>1, 'title'=>'锄禾'),
			array('id'=>2, 'title'=>'早发白帝城'),
			array('id'=>3, 'title'=>'静夜思'),
		) ;
		
		echo json_encode(array('code'=>200, 'data'=>$list), JSON_UNESCAPED_UNICODE);
	}

	public function apiGetDetail()
	{
		$id = getRequestInt('id', 0, 'get');

		switch ($id) {
			case 1:
				$content = "锄禾日当午,\n汗滴禾下土;\n谁知盘中餐,\n粒粒皆辛苦。"  ; break;
			case 2:
				$content = "朝辞白帝彩云间,\n千里江陵一日还;\n两岸猿声啼不住,\n轻舟已过万重山。"  ; break;
			case 3:
				$content = "床前明月光,\n疑是地上霜;\n举头望明月,\n低头思故乡。"  ; break;
			default:
				$content = "" ;
		}

		echo json_encode(array('code'=>200, 'data'=>$content), JSON_UNESCAPED_UNICODE);
	}
}
?>
