<?php
namespace Lib\Core\Utils ;

class Page{

//成员属性
    private $url;     //分页地址URL;
    
    private $totalData;   //数据总条数
    private $totalPage;  //总页数
    
    private $nowPage;     //当前页
    private $prev;  //上一页
    private $next;    //下一页

    private $limit;   //每页显示数
    private $itemLimit; 	//每屏显示页数
    
    private $getps ;  //get参数
    
//成员方法
	/**
	 * 构造函数
	 * Enter description here ...
	 * @param $url 地址
	 * @param $nowPage 当前页
	 * @param $totalData 数据总条目
	 * @param $itemLimit 分页显示数（非必须，默认显示全部）
	 * @param $limit 每页显示条目（非必须，默认为config配置条目）
	 */
    public function __construct($url,$nowPage,$totalData,$itemLimit=0,$limit=0,$autourl=true){ //初始化

            $this->url=$url;        //初始化地址
            $this->totalData=$totalData;    //初始化总数
            $this->limit=empty($limit)?PAGE_LIMIT:$limit;    //初始化每页显示
            $this->nowPage=$nowPage;//当前页
            $this->itemLimit=$itemLimit;
            
            $this->totalPage=$this->setTotalPage();//总页数
            $this->prev=$this->setPrev();//上一页
            $this->next=$this->setNext();    //下一页
            
            
            if ($autourl)
            	$this->autoCompleteGetParams();
    }
    
    private function autoCompleteGetParams(){
    	$this->getps = '' ;
    	$_getps = array() ;
    	foreach($_GET as $k=>$v) {
    		//$this->getps .= $k.'='.$v.'&' ;
    		if ($k == 'page')
    			continue ;
    		
    		$_getps[] = $k.'='.$v ;
    	}
    	
    	if($_getps){
    		$this->getps = implode('&', $_getps);
	    	$this->url .= $this->getps . '&' ;
    	}
    	
    }
    
    /**
     * 设置上一页
     * Enter description here ...
     */
    private function setPrev()
    {
    	if($this->nowPage==1) return $this->totalPage;
    	else return $this->nowPage-1;
    }
    
    /**
     * 设置下一页
     * Enter description here ...
     */
    private function setNext()
    {
    	if($this->nowPage==$this->totalPage) return 1;
    	else return $this->nowPage+1;
    }
    
	/**
	 * 设置总页数
	 * Enter description here ...
	 */
    private function setTotalPage()
    {
    	return ceil($this->totalData/$this->limit) ;
    }
    
    /**
     * 创建分页数组
     * Enter description here ...
     */
    private function createEachItem()
    {
    	if($this->itemLimit==0 || $this->totalPage<$this->itemLimit){
    		//循环创建数组
    		for($i=1; $i<=$this->totalPage; $i++){
    			if($i==$this->nowPage)	$class='class="active"';
				else $class='';
    			//$list.= '<a '.$class.' href="'.$this->url.'page='.$i.'">'.$i.'</a>';
    			$list .= '<li '.$class.'><a href="'.$this->url.'page='.$i.'">'.$i.'</a></li>' ;
    		}
    		
    		return $list; 
    	}

    	//设置了每屏显示数 补全
    	if($this->nowPage<$this->itemLimit){
    		$_startItem=1;
    		$_stopItem=$this->itemLimit;
    	}else{
    		$_startItem=$this->nowPage-($this->nowPage%$this->itemLimit)+1;
    		--$this->itemLimit;
    		$_stopItem=$_startItem+$this->itemLimit;
    		$_stopItem=$_stopItem>$this->totalPage?$this->totalPage:$_stopItem;
    	}
    	
	
    	//循环创建数组
		for($i=$_startItem; $i<=$_stopItem; $i++){
			if($i==$this->nowPage)	$class='class="on"';
			else $class='';
			//$list.= '<a '.$class.' href="'.$this->url.'page='.$i.'">'.$i.'</a>';
			$list .= '<li><a '.$class.' href="'.$this->url.'page='.$i.'">'.$i.'</a></li>' ;
		}
		
		
		return $list;
    }
    
    /**
     * 获取分页效果
     * Enter description here ...
     */
    public function getPage(){
    	
    	/*
        $pageView='<div id="page-view">';
    	
    	$pageView.='<a href="'.$this->url.'page=1">首页</a>';
    	
        $pageView.='<a href="'.$this->url.'page='.$this->prev.'">上一页</a>';
        
        $pageView.=$this->createEachItem();
        
        $pageView.='<a href="'.$this->url.'page='.$this->next.'">下一页</a>';
        
        $pageView.='<a href="'.$this->url.'page='.$this->totalPage.'">尾页</a>';
        
        $pageView.='<span>'.$this->nowPage.'/'.$this->totalPage.' 页</span>';
        
        $pageView.='</div>';
        */
    	
    	$pageItem = $this->createEachItem();
    	
    	$pageView = '
    	<nav>
		  <ul class="pagination">
		    <li>
		      <a href="'.$this->url.'page='.$this->prev.'" aria-label="Previous">
		        <span aria-hidden="true">&laquo;</span>
		      </a>
		    </li>
			'.$pageItem.'
		    <li>
		      <a href="'.$this->url.'page='.$this->next.'" aria-label="Next">
		        <span aria-hidden="true">&raquo;</span>
		      </a>
		    </li>
		  </ul>
		</nav>		
    			' ;
        
        return $pageView;
    }


}

?>
