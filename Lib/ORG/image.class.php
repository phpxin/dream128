<?php
class image{
	private $originalPath;
	private $goalPath;
	
	/**
	 * 构造函数
	 * Enter description here ...
	 * @param string $o 原图路径	
	 * @param string $g 新图路径
	 */
	public function __construct($o, $g){
		$this->originalPath = rtrim($o, '/').'/';
		$this->goalPath = rtrim($g, '/').'/';
	}
	
	/**
	 * 生成缩略图（图像裁切）
	 * Enter description here ...
	 * @param $original 原图片路径
	 * @param $goal 目标图片路径
	 * @param $width 宽度
	 * @param $height 高度
	 * @param $type 类型（jpg，png）
	 * @param $x 截取起点x
	 * @param $y 截取起点y
	 */
	public function thumb($original, $goal, $width, $height, $type='jpg', $x=0, $y=0){
		return $this->saveThumb($this->originalPath.$original, $this->goalPath.$goal, $width, $height, $type, $x, $y);
	}
	
	/**
	 * 生成缩略图（等比缩放）
	 * Enter description here ...
	 * @param $original 原图片路径
	 * @param $goal 目标图片路径
	 * @param $tValue 缩放后大小
	 * @param $type 类型（jpg，png）
	 * @param $x 截取起点x
	 * @param $y 截取起点y
	 */	
	public function thumb2scale($original, $goal, $tValue, $type='jpg', $x=0, $y=0){
		return $this->saveThumb2($this->originalPath.$original, $this->goalPath.$goal, $tValue, $type, $x, $y);
	}
	
	private function saveThumb2($original, $goal, $tValue, $type='jpg', $x=0, $y=0)
	{
		$minSide = $tValue/2; //窄边不能低于长边的1/2
		
		if(!file_exists($original)){
			throw new Exception("源文件不存在");
		}
		if(!file_exists(dirname($goal))){
			throw new Exception("目标文件夹不存在");
		}
		
		
		$imgInfo_d1 = getimagesize($original);
			
		//原图截取宽高
		$orgiWidth = $imgInfo_d1[0];
		$orgiHeight = $imgInfo_d1[1];
		
		//计算等比缩放
		if($imgInfo_d1[0]>$imgInfo_d1[1]){
			//宽图
			$scale = $tValue/$imgInfo_d1[0];
			$width = $tValue;
			$height = $imgInfo_d1[1]*$scale;
			
			if($height < $minSide){
				//重新计算比例，并裁切
				$height = $minSide;
				$scale = $height/$imgInfo_d1[1];
				$width = $tValue;
				$orgiWidth = $width/$scale;
			}
			
		}else{
			//高图
			$scale = $tValue/$imgInfo_d1[1];
			$height = $tValue;
			$width = $imgInfo_d1[0]*$scale;
			
			if($width < $minSide){
				//重新计算比例，并裁切
				$width = $minSide;
				$scale = $width/$imgInfo_d1[0];
				$height = $tValue;
				$orgiHeight = $height/$scale;
			}
			
		}
		
		$image = imagecreatetruecolor($width, $height); //创建图像
		switch($imgInfo_d1['mime']){
			case 'image/jpeg' : $image_d1 = imagecreatefromjpeg($original); break;
			case 'image/png' : $image_d1 = imagecreatefrompng($original); break;
			default :
				throw new Exception("未知图片格式");
				;
		}
		
		imagecopyresampled($image, $image_d1, 0, 0, 0, 0, $width, $height, $orgiWidth, $orgiHeight);
		
		switch($type){
			case 'jpg': imagejpeg($image, $goal); break;
			default : 
				throw new Exception("目标文件夹不存在");
				;
		}
		
		
		imagedestroy($image_d1);
		imagedestroy($image);
		
		return $goal;
	}
	
	private function saveThumb($original, $goal, $width, $height, $type='jpg', $x=0, $y=0)
	{
		if(!file_exists($original)){
			throw new Exception("源文件不存在");
		}
		if(!file_exists(dirname($goal))){
			throw new Exception("目标文件夹不存在");
		}
		
		
		$image = imagecreatetruecolor($width, $height); //创建图像
		
		$imgInfo_d1 = getimagesize($original);
		switch($imgInfo_d1['mime']){
			case 'image/jpeg' : $image_d1 = imagecreatefromjpeg($original); break;
			case 'image/png' : $image_d1 = imagecreatefrompng($original); break;
			default :
				throw new Exception("未知图片格式");
				;
		}
		
		$maxSize_d1 = $imgInfo_d1[0]>$imgInfo_d1[1] ? $imgInfo_d1[1] : $imgInfo_d1[0];
		
		imagecopyresampled($image, $image_d1, 0, 0, 0, 0, $width, $height, $maxSize_d1, $maxSize_d1);
		
		switch($type){
			case 'jpg': imagejpeg($image, $goal); break;
			default : 
				throw new Exception("目标文件夹不存在");
				;
		}
		
		
		imagedestroy($image_d1);
		imagedestroy($image);
		
		return $goal;
	}
}
?>