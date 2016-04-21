<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>圣诞一起嗨起来，游心礼品大放送</title>
<meta name="keywords" content="圣诞一起嗨起来，游心礼品大放送" />
<meta name="description" content="圣诞一起嗨起来，游心礼品大放送" />
<meta content="width=device-width, minimum-scale=1,initial-scale=1, maximum-scale=1, user-scalable=1" id="viewport" name="viewport" />
<script type="text/javascript" src="/theme/public/js/jquery-1.8.0.min.js"></script>
<style>
body{
overflow:hidden;
}
#spirit{
	width:100px;
	height:100px;
	background: #f90;
	position:absolute;
	transform:rotate(0deg);
	text-align:center;
}
#spirit img{
	height:100%;
}
#background{
	position:absolute;
	border: 1px solid red;
}
#play{
	position: absolute;
	padding: 5px 10px;
	background: blue;
	color: #fff;	
}
</style>
</head>
<body>
	<div id="spirit" ><img src="http://static.uthing.cn/images-2.1/ucenter/uc_join_per.png" /></div>
	<div id="background"> </div>
	<button id="play">游戏开始</button>
	<script>
		
		var wheight = $(window).height() ;
		var wwidth = $(window).width();
		var spiritHeight = $('#spirit').height();
		var spiritWidth = $('#spirit').width();
		var stopHeight = wheight - spiritHeight ;
		
		var _top = spiritHeight / -1 ;
		var _rotate = 0 ;
		var _step = 1 ;
		var _r_step = 5;
		var bg_box_size = wwidth/2;
		
		var spirit = $('#spirit') ;
		var background = $('#background') ;
		var play = $('#play');
		
		spirit.css({
			'top':_top + 'px', 
			'left':(wwidth / 2 - spiritWidth / 2) + 'px',
			'z-index':2
			});
		
		background.css({
			'width': bg_box_size, 
			'height': bg_box_size,
			'top': wheight/2-bg_box_size/2,
			'left': wwidth/2-bg_box_size/2,
			'z-index':1
			});
		
		play.css({
			'top' : wheight/2 + bg_box_size/2 + play.height()/2,
			'left' : wwidth/2 - play.width()/2
		})
		
		var timmer = null;
		var timmer_rotate = null;
		
		var isdoing = false;

		$('#play').click(function(){
			
			if(!isdoing){
				isdoing = true;
				$(this).attr('disabled', true);
				$(this).css('display', 'none');

				timmer = setInterval("drop()", 10);
				timmer_rotate = setInterval("dorotate()", 1);
			}
		})
		
		$('#spirit').on('touchstart',function(){
			console.log('a')
			stopAllAction();
		})
		
		function stopAllAction(){
			if(timmer!=null){
				clearTimeout(timmer);
			}
			if(timmer_rotate!=null){
				clearTimeout(timmer_rotate);
			}
		}
		
		function dorotate(){
			_rotate = _rotate + _r_step;
			spirit.css('transform', 'rotate('+_rotate+'deg)') ;
		}
		
		function drop(){
			_step = _step+0.1;
			_top = _top + _step;
			spirit.css('top', _top+'px') ;
			if(_top >= stopHeight){
				stopAllAction()
			}
		}
	
	</script>
</body>
</html>
