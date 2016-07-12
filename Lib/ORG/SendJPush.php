<?php
//极光推送key配置
define('JG_APP_KEY', '38e7038c9aa51a19e255587b');
define('JG_MASTER_SECRET', 'e7cdbf5922651bef919d54fb');

/**
 * 发送极光推送通知内容
 * Enter description here ...
 * @param string $title
 * @param string $content
 */
function jPushSend($title,$content)
{
	
	$appKey = JG_APP_KEY;
	$masterSecret = JG_MASTER_SECRET;
	
	$fileds['sendno'] = time() ;
	$fileds['app_key'] = $appKey;
	$fileds['receiver_type'] = 4 ;
	$fileds['receiver_value'] = 4 ;
	
	$fileds['verification_code'] = strtoupper(md5($fileds['sendno'].$fileds['receiver_type'].$fileds['receiver_value'].$masterSecret));
	
	$fileds['msg_type'] = 1 ;
	$fileds['msg_content'] = '{"n_title":"'.addcslashes($title, '\'\"').'", "n_content":"'.addcslashes($content, '\'\"').'"}';
	$fileds['platform'] = 'android,ios';
	
	$data = "sendno=$fileds[sendno]&app_key=$fileds[app_key]&receiver_type=$fileds[receiver_type]&receiver_value=$fileds[receiver_value]&verification_code=$fileds[verification_code]&msg_type=$fileds[msg_type]&msg_content=$fileds[msg_content]&platform=$fileds[platform]" ;
	$length = strlen($data);
	
	//创建socket连接 
	$fp = fsockopen("api.jpush.cn",8800,$errno,$errstr,10) or exit($errstr."--->".$errno);
	
	//构造post请求的头
	$header = "POST /v2/push HTTP/1.1\r\n"; 
	$header .= "Host: api.jpush.cn:8800\r\n"; 
	$header .= "Content-Type: application/x-www-form-urlencoded \r\n";
	$header .= "Content-Length: ".$length."\r\n"; 
	$header .= "\r\n";
	
	//添加post的字符串 
	$header .= $data."\r\n";
	
	//发送post数据 
	fputs($fp,$header);
	
	//接收post数据
	$responseHeaderStr = '';
	$responseBodyStr = '';
	
	while (!feof($fp)) {
		$line = fgets($fp,1024); //去除请求包的头只显示页面的返回数据 
		
		if($line == "\r\n"){
			break;
		}
		
		$responseHeaderStr .= $line;

	}
	
	$line = fgets($fp,2048); //正文
	$responseBodyStr .= $line;
	$line = fgets($fp,2048); //正文
	$responseBodyStr .= $line;
	
	//判断是否成功
	$isMatch = preg_match('/HTTP.* (\d{3}) .*\s/iU', $responseHeaderStr, $match);
	$errMsg=null;
	if($isMatch){
		if($match[1]==200){
			//如果请求成功，判断逻辑是否成功
			$json = substr($responseBodyStr,strpos($responseBodyStr, '{'));
			$bodyArr = json_decode($json, true);
			if($bodyArr['errcode']>0){
				$errMsg = '请求数据错误，错误码 '.$bodyArr['errcode'].'，错误信息 '.$bodyArr['errmsg'];
			}
		}else{
			$errMsg = 'http请求失败，错误码 '.$match[1];
		}
	}else{
		$errMsg = 'http请求发送失败';
	}
	
	if(!empty($errMsg)){
		//应该记录日志
		//echo '<pre>'.var_dump($errMsg).'</pre>';
	}
	
}

?>