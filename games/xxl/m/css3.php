<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>嗨森大转盘</title>
	<?php 
	if(preg_match('/iphone/i', $_SERVER['HTTP_USER_AGENT'])){
		echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1" />' ;
	}
	?> 
<style>
	*{
		margin:0;
		padding:0;
		
	}
	
	body{
		overflow:hidden;
	}
	
	.main{
		width: 80%;
		margin-left: 10%;
		margin-top: 50px;
		overflow:hidden;
		position:relative;
	}

	#rotate-demo{
		-ms-transform:rotate(180deg); /* IE 9 */
		-webkit-transform:rotate(180deg); /* Safari and Chrome */
		transform:rotate(180deg);
		width: 100%;
	}
	
	#pointer{
		width: 15%;
		-webkit-transform:rotate(30deg); /* Safari and Chrome */
		transform:rotate(45deg);
		position:absolute;
		bottom: 15px;
		left: 5px;
	}

	.tip{
		margin-top: 20px;
		margin-left: 10px;
	}
	
</style>
</head>
<body>
<div class="main">
	<img src="../imgs/roll.png" id="rotate-demo" />
	<img src="../imgs/pointer.png" id="pointer" />
</div>
<div class="tip">Tip: 点击大转盘停止旋转，再次点击继续旋转</div>
<script>
var i=0;
var rotater = document.getElementById('rotate-demo') ;
var timmer = setInterval(go, 3);
var run = true;

rotater.onclick = function(){
	if(run){
		clearTimeout(timmer);
		run = false;
	}else{
		timmer = setInterval(go, 3);
		run = true;
	}
} ;


function go()
{
	if(i>=360){
		i = 0 ;
	}
	
	rotater.style.transform = 'rotate('+i+'deg)' ;
	i+=3;
}

</script>
</body>
</html>