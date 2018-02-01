<?php
namespace Lib\Controller\Home ;

class Index extends Base
{

    public function getlist(){
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


        // select the hot articles
        $this->regHotList() ;
        $this->regNewList() ;

        $this->assign('ptype', 'getlist');
        $this->assign('list', $list);
        $this->assign('pageHtml', $pageHtml);

        $this->show("index");
    }

	public function index()
	{
		$limit = 5 ;

		$db = M("article");

        $list = $db->field("id,title,content,addtime")->limit($limit)->order('id desc')->select();

		if ($list){
			foreach ($list as $key => $val){
				$list[$key]['content'] =  mb_substr(strip_tags($val['content']), 0,100, APP_CHARSET)  ;
				$list[$key]['addtime'] = date('r', $val['addtime']);
			}
		}

		// select the hot articles
		$this->regHotList() ;
		$this->regNewList() ;

        $this->assign('ptype', 'index');
		$this->assign('list', $list);

		$this->show("index");
	}

	protected function regHotList() {
		$list = M("article")->field("id,title,hits")->order('hits desc ,id asc')->limit(10)->select();
        foreach ($list as $k => $v){
//            if (mb_strlen($v['title'])>20){
//                $list[$k]['title'] = mb_substr($v['title'], 0, 20, APP_CHARSET);
//            }
            $list[$k]['title'] .= "&nbsp;&nbsp;[{$v['hits']}阅]" ;
		}
		$this->assign('hotlist', $list);
	}
	protected function regNewList() {
		$list = M("article")->field("id,title")->order('id desc')->limit(10)->select();
//        foreach ($list as $k => $v){
//			$list[$k]['title'] = mb_substr($v['title'], 0, 20, APP_CHARSET);
//		}
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
