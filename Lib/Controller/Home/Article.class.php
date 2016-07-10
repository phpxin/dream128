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

		$this->addCss($this->__THEME__.'/style/style.css');
		$this->addCss($this->__PUBLIC__.'/editor/third-party/SyntaxHighlighter/shCoreDefault.css');
		$this->addCss($this->__THEME__.'/style/editor_t.css') ;
		
		
		$this->addJs($this->__PUBLIC__.'/editor/ueditor.parse.js') ;
		$this->addJs($this->__PUBLIC__.'/editor/third-party/SyntaxHighlighter/shCore.js');
		

		$this->show('detail');
	}

}
?>
