<?php
/**
 *   单一号码，单一内容下发 
 *  * @return String
 */
class SendEsms{
	
	
	/**
	 * 动态获取信息字符串，用于多短信平台适配
	 * 当增加短信平台，需要增加第一维，增加信息字符串，请增加第二维
	 * Enter description here ...
	 * @param $i	第一维下标，用来确定短信平台
	 * @param $j	第二维下标，确定信息字符串（不同平台，相同功能的字符串编号要相同）
	 * @param $c1	动态参数
	 * @param $c2	动态参数 （备用）
	 * @return	返回完整信息字符串
	 */
	public static function getMessageString($i,$j,$c1,$c2=null){
		
		//拼接的模板信息
		$d[1][1] = "您正在更换账户手机号码,新号码是:{$c1},如不是本人操作请尽快联系客服010-88225888。(本条免费)" ; //更换注册手机号
		$d[1][2] = "您的密码已经重置,新密码是:{$c1}。如有疑问请联系客服010-88225888。(本条免费)"; //后台管理员重置密码
		$d[1][3] = "验证码:{$c1}。用于验证新的手机号码。(本条免费，如不是本人操作请忽略)"; //修改注册手机号验证码
		$d[1][4] = "验证码:{$c1}。您正在执行找回密码操作,请勿泄漏。如非本人操作,请联系客服010-88225888。(本条免费)"; //找回密码获取验证码
		$d[1][5] = "验证码:{$c1}。如果遇到注册问题,请联系客服010-88225888。(本条免费,如非本人操作,请忽略)"; //注册获取验证码
		
		//用于平台特殊，这里保存模板编号
		$d[2][1] = '3709';
		$d[2][2] = '3708';
		$d[2][3] = '3710';
		$d[2][4] = '3711';
		$d[2][5] = '3712';
		
		return $d[$i][$j];
	}
	//12:23
	/**
	 * 多平台适配函数
	 * Enter description here ...
	 * @param $tel	电话号
	 * @param $strNum 字符串编号
	 * @param $c1	动态参数
	 * @param $c2	动态参数 （备用）
	 */
	public static function SingleMt($tel, $strNum, $c1, $c2=null){
		global $_gConfig;
		
		$platform = empty($_gConfig['sms'])? 1 : $_gConfig['sms'];
		$message = self::getMessageString($platform, $strNum, $c1);
		
		switch ($platform){
			case 1:
				return self::SingleMt1($message,$tel) ;
				break;
			case 2:
				if($message == '3708'){	$datas[] = $c1.'。重置时间 '.date('H:i',time());}
				else{	$datas[] = $c1;}
				return self::SingleMt2($message, $tel, $datas);
				break;
		}
		
	}
	
	private static function SingleMt2($message, $tel, $datas){
	    
	    importORGClass('CCPRestSDK.php'); 
		
	    //初始化REST SDK
	    $accountSid = 'aaf98fda4526488b014526b24bd700ca';
	    $accountToken = '0bf3e0b29409444c8c3a74c05a28b5b1';
	    
	    $appId = 'aaf98f89481007680148101f1457003e';
	    
	    $serverIP = 'sandboxapp.cloopen.com';
	    $serverPort = '8883';
	    $softVersion = '2013-12-26';
	     
	    $rest = new REST($serverIP,$serverPort,$softVersion);
	    $rest->setAccount($accountSid,$accountToken);
	    $rest->setAppId($appId);
	    
	    $tempId = $message; //传入的message当做模板id
	    
	    // 发送模板短信
	    //echo "Sending TemplateSMS to $to <br/>";
	    $result = $rest->sendTemplateSMS($tel,$datas,$tempId);
	    
	    
	    if($result == NULL ) {
	        //echo "result error!";
	        return 0;
	        break;
	    }
	    if($result->statusCode!=0) {
	        //echo "error code :" . $result->statusCode . "<br>";
	        //echo "error msg :" . $result->statusMsg . "<br>";
	        //TODO 添加错误处理逻辑
	        return 0;
	    }else{
	       	//echo "Sendind TemplateSMS success!<br/>";
	        // 获取返回信息
	        //$smsmessage = $result->TemplateSMS;
	        //echo "dateCreated:".$smsmessage->dateCreated."<br/>";
	        //echo "smsMessageSid:".$smsmessage->smsMessageSid."<br/>";
	        //TODO 添加成功处理逻辑
	        return 1;
	   	}
	}
	
	/**
	 * 平台1
	 * Enter description here ...
	 * @param string $message 短信内容
	 * @param string $tel 电话号码
	 */	
	private static function SingleMt1($message,$tel) {
		
		//define('SMS_USER' , 'cs0724'); //调用接口用户名
		//define('SMS_PWD' , 'cs0724'); //密码
		
		$SMS_USER = 'cs0724'; //调用接口用户名
		$SMS_PWD = 'cs0724'; //密码
		
		//$url = 'http://userinterface.vcomcn.com/Opration.aspx'; //接口URL
		
		$sendTime = date('Y-m-d H:i:s', time());
		$series = uniqid();
		
		$_content = '
		<Group Login_Name="'.$SMS_USER.'" Login_Pwd="'.strtoupper(md5($SMS_PWD)).'" OpKind="0" InterFaceID="" SerType="SMS">
			<E_Time>'.$sendTime.'</E_Time>
			<Item>
				<Task>
					<Recive_Phone_Number>'.$tel.'</Recive_Phone_Number>
					<Content><![CDATA['.$message.']]></Content>
					<Search_ID>'.$series.'</Search_ID>
				</Task>
			</Item>
		</Group>
		';//Task 最多允许10组
		
		$content = iconv('UTF-8', 'GB2312', $_content) ;
		
		$length = strlen($content);
		
		//创建socket连接 
		$fp = fsockopen("userinterface.vcomcn.com",80,$errno,$errstr,10) or exit($errstr."--->".$errno);
		//构造post请求的头
		$header = "POST /Opration.aspx HTTP/1.1\r\n"; 
		$header .= "Host:userinterface.vcomcn.com\r\n"; 
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: ".$length."\r\n"; 
		$header .= "Connection: Close\r\n\r\n"; 
		//添加post的字符串 
		$header .= $content."\r\n";
		//发送post的数据 
		fputs($fp,$header);
		
		$inheader = 1; 
		while (!feof($fp)) {
			$line = fgets($fp,1024); //去除请求包的头只显示页面的返回数据 
			if ($inheader && ($line == "\n" || $line == "\r\n")) { 
				$inheader = 0; 
			} 
			if ($inheader == 0) { 
				// echo $line; 
			} 
		}
		
		$rData = $line;
		
		if($rData === '00'){
			$content = 1;
		}else{
			$content = 0;
		}
		
		$line = fgets($fp,1024); //去除请求包的头只显示页面的返回数据 
		
		return $content;
	}	
}

//生成6位随机数
function rand6(){
	$ychar="1,2,3,4,5,6,7,8,9";
	$list=explode(",",$ychar);
	for($i=0;$i<6;$i++){
	$randnum=rand(0,8); // 10+26;
	$authnum.=$list[$randnum];
	}
	return $authnum;
}
//生成4位随机数
function rand4(){
	$ychar="1,2,3,4,5,6,7,8,9";
	$list=explode(",",$ychar);
	for($i=0;$i<4;$i++){
	$randnum=rand(0,8); // 10+26;
	$authnum.=$list[$randnum];
	}
	return $authnum;
}

?>