<?php
/**
 * 多文件上传
 *
 * @version       v0.01
 * @create time   2013-6-9
 * @update time   
 * @author        lixin
 */
class upAllFile{
	
	private $allowType='image/jpeg,image/jpg,image/gif,image/pjpeg,image/png,image/x-png,image/wbmp,application/octet-stream';	//允许类型
	
	private $allowSufffix='jpg,jpeg,gif,png,bmp';	//允许后缀名
	
	private $allowSize=2000000;	//允许大小
	
	private $formName;	//form表单中定义文件名的数组名
	
	private $filePre;	//新文件名前缀
	
	private $autoName=true;	//是否自动创建文件名 (设为false 则使用 前缀_文件原名 的格式保存)
	
	private $savePath;	//存储路径
	
	private $files=array();	//准备处理的文件集合
	
	private $errorReport=array();	//jiegou   array('err'=array,'sizeerr'=array,mimeerr=array,...)
	
	private $movedFile=array();	//完成存储的文件
	
	public function __get($keyName)
	{
		if($keyName=='errorReport' || $keyName=='movedFile') 
			return $this->$keyName;
	}
	
	/**
	 * 获取php.ini配置文件中对上传文件的大小限制
	 * Enter description here ...
	 * @return Int 返回Byte单位的大小
	 */
	private function getByteSizeFromIniSet(){
		
		$str=min(array(ini_get("post_max_size"),ini_get("upload_max_filesize")));
		
		switch(strtoupper(substr($str,-1))){
			case 'G':$step=3;break;
			case 'M':$step=2;break;
			case 'K':$step=1;break;
			default:$step=0;
		}
		
		$num=(int)$str;
		
		for($i=0;$i<$step;$i++){
			$num*=1024;
		}
		
		return $num;
	}
	
	/*
		实例化类 请传入文件form表单中的名 允许上传类型 存储路径
	*/
	public function __construct($order=array()){
		
		//设置最大允许大小与php设置相关
		$this->allowSize=$this->getByteSizeFromIniSet();
		//处理用户设置
		foreach($order as $key=>$val){
			$this->$key=$val;
		}
		$this->savePath=rtrim(str_replace('\\','/',$this->savePath),'/').'/';
		if(!file_exists($this->savePath)){
			mkdir($this->savePath,0777);
		}
		$this->allowType=explode(',',$this->allowType);
		$this->allowSufffix=explode(',',$this->allowSufffix);
	}
	
	public function UpFile(){
		$this->files=$this->CreateFileArr();
		for($i=0,$len=count($this->files);$i<$len;$i++){
			if(!$this->CheckErr($i,$this->files[$i]['name'],$this->files[$i]['error']))	continue;
			if(!$this->CheckMine($i,$this->files[$i]['name'],$this->files[$i]['type']))	continue;
			if(!$this->CheckFix($i,$this->files[$i]['name'])) continue;
			if(!$this->IsUploaded($i,$this->files[$i]['name'],$this->files[$i]['tmp_name']))	continue;
			if(!$this->CheckSize($i,$this->files[$i]['name'],$this->files[$i]['size']))	continue;
		}
		
		$this->MoveFile();
	}
	
	private function MoveFile(){
		$i=0;
		foreach($this->files as $key=>$val){
			
			if($this->autoName){
				$_d = explode('.',$val['name']);
				$fix=array_pop($_d);
				$uniqueName=substr(uniqid(),-8);
				$uniqueName.=substr(md5($val['name']),0,8);
				$filename=$this->savePath.$this->filePre.$uniqueName.'.'.$fix;
			}else{
				$filename=$this->savePath.$this->filePre.$val['name'];
			}
			
			if(move_uploaded_file($val['tmp_name'],$filename)){
				$this->movedFile[$i]['priName']=$val['name'];
				$this->movedFile[$i]['newName']=basename($filename);
				$this->movedFile[$i]['flag']=$val['flag'];
				$i++;
			}else{
				$this->errorReport[]='文件'.$val['name'].'上传失败！';
			}
			
		}
	}
	
	private function IsUploaded($i,$name,$val){
		if(!is_uploaded_file($val)){
			$this->errorReport[]='文件'.$name.'不是通过HTTP提交的！';
			unset($this->files[$i]);
			return false;
		}
		return true;
	}
	
	private function CheckErr($i,$name,$val){
		if($val){
			if($val==3){
				$this->errorReport[]='文件'.$name.'上传失败，请重新上传！';
			}
			unset($this->files[$i]);
			return false;
		}
		return true;
	}

	private function CheckMine($i,$name,$val){
		if(!in_array($val,$this->allowType)){
			$this->errorReport[]='文件'.$name.'类型不正确！';
			unset($this->files[$i]);
			return false;
		}
		return true;
	}
	
	private function CheckFix($i,$name){
		$_d=explode('.',$name);
		$fix=strtolower(array_pop($_d));
		if(!in_array(strtolower($fix),$this->allowSufffix)){
			$this->errorReport[]='文件'.$name.'扩展名不正确！';
			unset($this->files[$i]);
			return false;
		}
		return true;
	}
	
	private function CheckSize($i,$name,$val){
		if($val>$this->allowSize){
			$this->errorReport[]='文件'.$name.'超过允许大小！';
			unset($this->files[$i]);
			return false;
		}
		return true;
	}
	
	private function CreateFileArr(){
		$fileRes=$_FILES[$this->formName];
		$len=count($fileRes['name']);
		$file=array();
		$j=0;
		for($i=0;$i<$len;$i++){
			if($fileRes['error'][$i]==4){
				continue;
			}
			$file[$j]['name']=$fileRes['name'][$i];
			$file[$j]['type']=$fileRes['type'][$i];
			$file[$j]['tmp_name']=$fileRes['tmp_name'][$i];
			$file[$j]['error']=$fileRes['error'][$i];
			$file[$j]['size']=$fileRes['size'][$i];
			$file[$j]['flag']=$i;//记录原文件在files数组中的位置
			$j++;
		}
		
		return $file;
	}
	
}
?>