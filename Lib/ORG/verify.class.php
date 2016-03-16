<?php
class verify{

	//宽
	private $width;
	//高
	private $height;
	//图片类型
	private $imgType;
	//图片字符串
	private $checkCode;
	//字符数量
	private $num;
	//字符串类型
	private $type;
	//图片资源
	private $img;
	//字体
	private $font;
	

	//初使化写上很多参数：宽，高，图片类型，数量，字符串类型
	public function __construct($width=120,$height=40,$num=4,$type=3,$imgType='jpeg'){
			//初使化上面这批同时初例化字符串
			//
			//
			//字符串得到函数
			//1  0-9   2 a-z  3 0-9 a-z A-Z
		$this->width=$width;
		$this->height=$height;
		$this->num=$num;
		$this->imgType=$imgType;
		$this->type=$type;
		$this->checkCode=$this->getCheckCode();

		$this->font = rtrim($_SERVER['DOCUMENT_ROOT'], '/').__THEME__.'/public/font/arial.ttf' ;
		//fdump($_SERVER['DOCUMENT_ROOT ']);
	}

	private function getCheckCode(){
		$string='';
		//switch...case来完成
		//	1 range
		//	2 rang array_flip
		//	3 48-57  65  90  97 122 
		//	str_shuffle
		switch($this->type){
			case 1:
				$string=join('',array_rand(range(0,9),$this->num));
				break;
			case 2:
				$string=implode('',array_rand(array_flip(range('a','z')),$this->num));
				break;
			case 3:
				for($i=0;$i<$this->num;$i++){
					$r=mt_rand(0,2);
					switch($r){
						case 0:
							$ascii=mt_rand(48,57);
							break;
						case 1:
							$ascii=mt_rand(65,90);
							break;
						case 2:
							$ascii=mt_rand(97,122);
							break;
					}
					
					$string.=sprintf('%c',$ascii);
				}

				break;
		}

		//返回字符串
		return $string;
	}
	

	//创建图片资源
	private function createImage(){
		$this->img=imagecreatetruecolor($this->width,$this->height);
	}
	//
	//创建画布颜色 133-255浅
	private function bgColor(){
		
		return imagecolorallocate($this->img,mt_rand(130,255),mt_rand(130,255),mt_rand(130,255));

	}

	//创建字体颜色 0-120
	private function fontColor(){
		return imagecolorallocate($this->img,mt_rand(0,125),mt_rand(0,125),mt_rand(0,125));
	}

	//跟画布填充颜色
	private function filledColor(){
		imagefilledrectangle($this->img,0,0,$this->width,$this->height,$this->bgColor());
	}
	//画点 imagepixel
	private function pixel(){
		for($i=0;$i<50;$i++){
			imagesetpixel($this->img,mt_rand(0,$this->width),mt_rand(0,$this->height),$this->fontColor());
		}
	}
	//画弧 
	private function arc(){

		for($i=0;$i<5;$i++){
			
				imagearc($this->img,mt_rand(10,$this->width-10),mt_rand(10,$this->height-10),100,100,mt_rand(0,150),mt_rand(160,360),$this->fontColor());
		}
	}

	//写字
	private function write(){
		for($i=0;$i<$this->num;$i++){
			//	$x 宽除以个数 进一法除整*变量 $i
			$x = (ceil($this->width/$this->num)*$i)+5;
			//	$y 高-字符高度
			//$y = mt_rand(18,$this->height-14);
			$y = 24;
			//	每次循环读一个字，把字符串视为数组
			//imagechar($this->img,7,$x,$y,$this->checkCode[$i],$this->fontColor());
			imagettftext ( $this->img, 14, 0, $x, $y , $this->fontColor(), $this->font, $this->checkCode[$i]);
		}

	}

	//输出
	private function output(){
	//
		//知道是哪个函数，使用到变量函数的知识点
		$func='image'.$this->imgType;
		//	得到header
		$header='Content-type:image/'.$this->imgType;
		//	判断函数是否存在，存在则输出header头
		if(function_exists($func)){
			header($header);
			$func($this->img);
		}else{
			exit('当前服务器不支持该函数');
		}
	}
	//得到图片
	//	把上面的成员方法全组合起来
	public function getImage(){
		$this->createImage();
		$this->filledColor();
		$this->pixel();
		$this->arc();
		$this->write();
		$this->output();
	}
	//
	//得到字  __get();
	public function __get($proName){
		if($proName=='checkCode'){
			return $this->checkCode;
		}
	}

	//销毁    __destruct   imagedestroy
	public function __destruct(){
		imagedestroy($this->img);
	}

}
?>