<?php
class upload{
	//路径
	private $path='./';
	//文件准许的MIME类型
	private $allowmime=array('image/jpeg','image/jpg','image/gif','image/pjpeg','image/png','image/x-png','image/wbmp','application/octet-stream');
	//文件准许的后缀
	private $allowsub=array('jpg','jpeg','gif','png','bmp');
	//文件准许的大小
	private $allowsize=2000000;
	//文件的错误号
	private $errorNum;
	//文件的错误信息
	private $errorInfo;
	//文件的原名
	private $orgname;
	//文件的新名
	private $newname;
	//是否启用随机文件名
	private $israndname=true;
	//文件的大小
	private $size;
	//文件的后缀
	private $subfix;
	//文件的前缀
	private $prefix='up_';
	//文件类型
	private $type;
	//临时文件路径
	private $tmpname;

	//构造方法初使化成员属性
	//
	//array('allowsize'=>10000000,'israndname'=false)
	//
	//
	public function __construct($array=array()){

		foreach($array as $key=>$value){
			
			$key=strtolower($key);

			if(!array_key_exists($key,get_class_vars(get_class($this)))){
				continue;
			}
			$this->setOption($key,$value);
		}
	}


	public function setOption($key,$value){
		$this->$key=$value;
	}

	public function up($field){
		//检测路径是否正确
		if(!$this->checkPath()){
			return false;
		}
		
		//把传进来的值都赋值给临时变量

		$name=$_FILES[$field]['name'];
		$size=$_FILES[$field]['size'];
		$tmpname=$_FILES[$field]['tmp_name'];
		$error=$_FILES[$field]['error'];
		$type=$_FILES[$field]['type'];

	
		//把传进来的参数交给setFiles来设置一批信息
		if($this->setFiles($name,$size,$tmpname,$error,$type)){
		
		//判断大小,判断MIME，判断后缀
			if($this->checkSize()&&$this->checkMime()&&$this->checkSub()){
				$this->newname=$this->randname();
				if($this->move()){
					return $this->newname;
				}else{
					return false;
				}
				
			}else{
		
				return false;
			}	
		}else{
			return false;
		}
		
	}

	private function move(){

			if(is_uploaded_file($this->tmpname)){
				$this->path=$this->path.$this->newname;
				if(move_uploaded_file($this->tmpname,$this->path)){
					return true;
				}else{
					$this->setOption('errorNum',-7);
					return false;
				}

			}else{
				$this->setOption('errorNum',-6);
				return false;
			}
	}

	private function randname(){
		if($this->israndname){
			
			return $this->prefix.$this->createNewName();
		}else{
			if(!empty($this->newname)){
				return $this->newname;
			}else{
				return $this->prefix.$this->orgname;
			}
			
		}

	}

	private function createNewName(){
			
		return uniqid().'.'.$this->subfix;

	}	

	private function checkSub(){
		if(in_array($this->subfix,$this->allowsub)){

			return true;
		}else{
			$this->setOption('errorNum',-5);
			return false;
		}

	}

	private function checkMime(){
		if(in_array($this->type,$this->allowmime)){
			return true;
		}else{
			$this->setOption('errorNum',-4);
			return false;
		}
	}
 
	private function checkSize(){
		if($this->size>$this->allowsize){
			$this->setOption('errorNum',-3);
			return false;
		}else{
			return true;
		}

	}

	private function setFiles($name,$size,$tmpname,$error,$type){
		if(!empty($error)){
			$this->setOption('errorNum',$error);
			return false;		
		}

		$this->orgname=$name;
		$this->size=$size;
		$this->tmpname=$tmpname;
		$this->type=$type;
		$arr=explode('.',$name);
		$this->subfix=array_pop($arr);
		//$this->subfix=$arr[count($arr)-1];
		return true;	
	}

	public function checkPath(){

		if(empty($this->path)){
			$this->setOption('errorNum',-1);
			//$this->errorNum=-1
			return false;
		}else{
			$this->path=rtrim($this->path,'/').'/';
			if(file_exists($this->path)&&is_writeable($this->path)){

					return true;
			}else{
				if(mkdir($this->path,0777,true)){

					return true;
				}else{
					$this->setOption('errorNum',-2);
					return false;
				}
			}
		}
	}

	private function getErrorNum(){

		switch($this->errorNum){
			case -1:
				$str='文件路径不存在';
				break;
			case -2:
				$str='文件夹创建失败';
				break;
			case -3:
				$str='文件大小超出了手动指定的大小';
				break;
			case -4:
				$str='文件类型不准许';
				break;
			case -5:
				$str='文件后缀不准许';
				break;
			case -6:
				$str='文件不是上传文件';
				break;
			case -7:
				$str='文件移动失败';
				break;
			case 1:
				$str='文件大小超过了php.ini当中设置maxsize准许的值';
				break;
			case 2:
				$str='超过了表单当中设置的最准许的最大值';
				break;
			case 3:
				$str='只有部份文件被上传';
				break;
			case 4:
				$str='没有文件被上传';
				break;
			case 6:
				$str='找不到临时文件夹';
				break;
			case 7:
				$str='临时文件写入失败';
				break;
		}
		return $str;
	}

	public function __get($proName){

		if($proName=='errorInfo'){
			return $this->getErrorNum();
		}
	}
}
?>
