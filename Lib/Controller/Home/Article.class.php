<?php
namespace Lib\Controller\Home ;

class Article extends Base
{
	public function detail()
	{
		$id = getRequestInt('id', 0, 'get');

		$db = M('article');

		$detail = $db->where('id='.$id)->find();
		
		$content = $detail['content'] ; //preg_replace('/\s+/', ' ', $detail['content']);
		
		$this->assign('detail' , $detail);
		$this->assign('content'	, $content) ;
		
		$this->assign('page_title', $detail['title'].'_'.$this->webname) ;

		$this->addCss('/theme/public/editor/third-party/SyntaxHighlighter/shCoreDefault.css');
		$this->addCss('/theme/home/style/editor_t.css') ;
		
		$this->addJs('/theme/public/editor/ueditor.parse.js') ;
		$this->addJs('/theme/public/editor/ueditor.parse.js') ;
		$this->addJs('/theme/public/editor/third-party/SyntaxHighlighter/shCore.js');
		
		$this->show('detail2');
	}

	public function detail2()
	{
		$id = getRequestInt('id', 0, 'get');

		$db = M('article');

		$detail = $db->where('id='.$id)->find();
		
		$content = $detail['content'] ; //preg_replace('/\s+/', ' ', $detail['content']);
		
		$this->assign('detail' , $detail);
		$this->assign('content'	, $content) ;
		
		$this->assign('page_title', $detail['title'].'_'.$this->webname) ;

		/*
		$this->addCss('/theme/public/editor/third-party/SyntaxHighlighter/shCoreDefault.css');
		$this->addCss('/theme/home/style/editor_t.css') ;
		
		$this->addJs('/theme/public/editor/ueditor.parse.js') ;
		$this->addJs('/theme/public/editor/ueditor.parse.js') ;
		$this->addJs('/theme/public/editor/third-party/SyntaxHighlighter/shCore.js');
		*/

		$this->show('detail2');
	}
}
?>
