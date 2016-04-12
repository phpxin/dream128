<?php 
	
	if(!preg_match('/(iPhone|Android)/iU', $_SERVER['HTTP_USER_AGENT']))
	{
		header('location:/games/xxl/') ;
	}
?>
<!DOCTYPE HTML>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<title>life is beautiful</title>
	<link href="../css/m.css" type="text/css" rel="stylesheet">
	<?php 
	if(preg_match('/iphone/i', $_SERVER['HTTP_USER_AGENT'])){
		echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1" />' ;
	}
	?> 
</head>
<body>
	<header>
		<h1>连连看</h1>
	</header>
	<section>
		<div class="game-box">

		</div>
		
		<div class="clear"></div>
	</section>
	<footer>
		<p>
			designed by phpxin
			<!-- 
			mail: lixin65535@126.com ;
			csdn: lixin65535@126.com ;
			 -->
		</p>
	</footer>
	<script src="../js/jquery-1.9.0.js" type="text/javascript" ></script>
	<script>
	console.log("hello web developer !");
	console.log("mail: lixin65535@126.com");
	console.log("blog: blog.csdn.net/lixinxin65535");

	var config = {} ;
	config.w_width = $(document).width() ;
	config.w_height = $(document).height() ;
	config.box_size = 8 ; //8*8
	config.item_margin = 2 ;
	config.ic_margin = config.item_margin*2; //item checked margin

	console.log(config.w_width); 
	console.log(config.w_height); 
	console.log($(window).width());
	
	$('body').css('height', config.w_height);
	var game_view_w = config.w_width - 20 ;
	$('.game-box').css('width')
	
	var image_w = Math.floor(game_view_w/config.box_size) - config.item_margin;

	var imgIndex = new Array(0,1,2,3,4,5,6,7,8,9);	//图像索引
	var itemArr = new Array(config.box_size) ;

	for(var i=0; i<config.box_size; i++){
		var itemArrJ = new Array(config.box_size) ;
		for(var j=0; j<config.box_size; j++){
			//随机出图片
			var _index = Math.floor(Math.random()*10) % imgIndex.length;
			
			var _item = imgIndex[_index];

			itemArrJ[j] = _item;

			var y = i*image_w + i*config.item_margin;
			var x = j*image_w + j*config.item_margin;
			
			var html = '<img data-i="'+i+'" data-j="'+j+'" data-item="'+_item+'" src="../img/'+_item+'.gif" class="img-item" style="top:'+y+'px; left:'+x+'px">';
			$('.game-box').append(html);
		}
		itemArr[i] = itemArrJ;
	}

	$('.game-box .img-item').css({'width':image_w+'px', 'height':image_w+'px'}) ;
	//$('.game-box .checked').css({'width':image_w-2+'px', 'height':image_w-2+'px'}) ;

	// 界面完成，开始主业务逻辑
	
	var itemM = {"i":-1,"j":-1,"value":-1};	//比较成员1

	var alreadyArr = new Array(); //已经走过的路

	function initAlreadyArr(){
		alreadyArr = new Array();
		
		for(var i=0; i<8; i++){
			var _arr = new Array();
			
			for(var j=0; j<8; j++){
				_arr.push(0);
			}

			alreadyArr.push(_arr);
		}
	}

	//寻路函数	m,n,	bc 中转次数，不能大于2		当m.i=n.i&&m.j=n.j（重叠）寻路成功，返回可消除
	//返回 		true：可消除；					false：不可消除
	// m , n , fx(方向) , bc 	1，不能往反方向走；2，当方向不同则 bc++
	//		[{"i":3,"j":4,"bc":1,"fx":'u'}]
	//fx： u 上 、d 下 、l 左 、r 右
	function findOut(m,n,bc,fx){
			console.log(m.i);
			console.log(m.j);
		
			//递归终止条件
// 			if(m.i==n.i && m.j==n.j){
// 				return true;
// 			}
			
			if(m.j<7 && m.i==n.i && m.j+1==n.j){
				if(fx=='r' || bc+1<=2)	//非向右走需要考虑中转次数
					return true;
			}
			if(m.j>0 && m.i==n.i && m.j-1==n.j){
				if(fx=='l' || bc+1<=2)
					return true;
			}
			if(m.i<7 && m.i+1==n.i && m.j==n.j){
				if(fx=='d' || bc+1<=2)
					return true;
			}
			if(m.j>0 && m.i-1==n.i && m.j==n.j){
				if(fx=='u' || bc+1<=2)
					return true;
			}

			alreadyArr[m.i][m.j] = 1;
		
			var nextStep = [] , _bc=bc; //下一步数组
			
			if(fx!='l' && m.j<7 && alreadyArr[m.i][m.j+1]!=1 && itemArr[m.i][m.j+1]==-1){
				//右侧是否有障碍物
				//alert('右侧无')
				if(fx!=''&&fx!='r')	_bc=bc+1;	//如果上一步非向右走，则转折点+1
				nextStep.push({"m":{"i":m.i,"j":m.j+1,"value":-1},"bc":_bc,"fx":"r"});
			}
			if(fx!='r' && m.j>0 && alreadyArr[m.i][m.j-1]!=1 && itemArr[m.i][m.j-1]==-1){
				//左侧是否有障碍物
				//alert('左侧无')
				if(fx!=''&&fx!='l')	_bc=bc+1;	
				nextStep.push({"m":{"i":m.i,"j":m.j-1,"value":-1},"bc":_bc,"fx":"l"});
			}
			if(fx!='u' && m.i<7 && alreadyArr[m.i+1][m.j]!=1 && itemArr[m.i+1][m.j]==-1){
				//下方是否有障碍物
				//alert('下方无')
				if(fx!=''&&fx!='d')	_bc=bc+1;	
				nextStep.push({"m":{"i":m.i+1,"j":m.j,"value":-1},"bc":_bc,"fx":"d"});
			}

			if(fx!='d' && m.i>0 && alreadyArr[m.i-1][m.j]!=1 && itemArr[m.i-1][m.j]==-1){
				//上方是否有障碍物
				//alert('上方无')
				if(fx!=''&&fx!='u')	_bc=bc+1;	
				nextStep.push({"m":{"i":m.i-1,"j":m.j,"value":-1},"bc":_bc,"fx":"u"});
			}


			if(nextStep.length<=0 || bc>2){
				//return false;
			}
			//alert(nextStep.length)

			//var isgo = true;
			var result = false;

			for(var __i in nextStep){

				var item = nextStep[__i];
				//alert(item.m)
				
				console.log('1.')
				
				result = findOut(item.m, n, item.bc, item.fx);

				if(result == true){
					//找到了
					console.log('1')
					break;
				}
			}

			return result;
		
	}

	function checkItem(_item){
		$('.img-item').removeClass('checked');
		_item.addClass('checked');
		$('.game-box .img-item').css({'width':image_w+'px', 'height':image_w+'px'}) ;
		$('.game-box .checked').css({'width':image_w-config.ic_margin+'px', 'height':image_w-config.ic_margin+'px'}) ;
	}
	

	//alert(itemArr[1][1])
	
	$('.img-item').click(function(){
		initAlreadyArr();	//每次点击都初始化这个数组
		//alert(alreadyArr);
		
		
		var _i = parseInt($(this).attr('data-i'));
		var _j = parseInt($(this).attr('data-j'));

		var itemN = {"i":-1,"j":-1,"value":-1};	//比较成员2

		//alert(itemArr[_i][_j]);
		//alert($(this).attr('data-item'));
		//alert(itemM.i);
		
		if(itemM.value == -1){
			//没有被选中的项目
			itemM.i = _i;
			itemM.j = _j;
			itemM.value = itemArr[_i][_j];

			//$(this).addClass('checked');
			checkItem($(this));
		}else{
			//选中项已存在
			itemN.i = _i;
			itemN.j = _j;
			itemN.value = itemArr[_i][_j];

			if(itemN.i==itemM.i && itemN.j==itemM.j){
				//同一个
				return ;
			}

			if(itemN.value != itemM.value){
				//不是同色
				itemM = itemN;
				//$('.img-item').removeClass('checked');
				//$(this).addClass('checked');
				checkItem($(this));
				return ;
			}

			//alert('同色');

			var _lineMaster = {};
			var _lineSlaver = {};
			
			//判断是否可以连接
			var switchType = 0, flag = true;	//switchType：寻路方式；flag：是否消除
			if(itemN.i == itemM.i)	switchType=1;
			else if(itemN.j == itemM.j) switchType=2;
			else	switchType=3;

			switch(switchType){
			case 1:
				//在一行上；从左到右查找；
				_lineMaster = itemM.j<itemN.j ? itemM : itemN;
				_lineSlaver = itemM.j>itemN.j ? itemM : itemN;

				var i = _lineMaster.i;

				for(var j=_lineMaster.j+1; j<_lineSlaver.j; j++){
					if(itemArr[i][j]!=-1){
						//alert(1)
						flag=false;
						break;
					}
				}
				
				break;
			case 2:
				//在一列上；从上到下查找
				_lineMaster = itemM.i<itemN.i ? itemM : itemN;
				_lineSlaver = itemM.i>itemN.i ? itemM : itemN;

				var j = _lineMaster.j;

				for(var i=_lineMaster.i+1; i<_lineSlaver.i; i++){
					if(itemArr[i][j]!=-1){
						//alert(1)
						flag=false;
						break;
					}
				}
				break;
			default:
				//既不在一行也不再一列；以M为主角
				//if(itemArr[itemM]
				
				//找最近路径：m.i-n.i：如果为-，则n在下方；为0，n在平行；为+，n在上方
				//找最近路径：m.j-n.j：如果为-，则n在右侧；为0，n在垂直；为+，n在左侧
				
				
				
				flag=findOut(itemM, itemN, 0, '');
			}


			if(flag){
				//消除
				$(this).hide();
				
				var _imgDomIndex = itemM.i*8+itemM.j; //m消除项目在dom中的索引

				//alert(_imgDomIndex)

				$('.img-item').eq(_imgDomIndex).hide();

				itemArr[itemM.i][itemM.j]=-1;
				itemArr[itemN.i][itemN.j]=-1;

				itemM = {"i":-1,"j":-1,"value":-1}; //重置
				
			}else{
				//不消除
				itemM = itemN;
				//$('.img-item').removeClass('checked');
				//$(this).addClass('checked');
				checkItem($(this));
				return ;
			}
			
		}

		
	})

	</script>
</body>
</html>