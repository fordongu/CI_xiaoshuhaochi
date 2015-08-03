<?php
header('content-type:text/html;charset=utf-8');
ini_set("display_errors", "Off");
define("TOKEN", $_GET['token']);

date_default_timezone_set ("PRC");
$wechatObj = new wechatCallbackapiTest();
 
$check_attached = $wechatObj->chaxun(0,$_GET['token'],'get_member_detail');
$checked_info=mysql_fetch_array($check_attached);
if ($checked_info['attached']==0){
	$wechatObj->chaxun(0,TOKEN,'updateattach');     	
}  

if (isset($_GET['echostr'])){
  $wechatObj->valid();
}

define('uf',$_GET['token']);
define("serverip", $_SERVER['HTTP_HOST']);

$wechatObj->response(TOKEN);

class wechatCallbackapiTest
{
	private $timestamp;
	public $temp;
	public $row = 0;
	public $fromUsername;
	public $toUsername;
	public $firstView=true;
	public $firstViewWord=true;
	public $viewId;
	public $viewing=0;
	public $piao=0;
	public $now;
	public $MsgType;
	public $T=60;
	private $loginFile;
	private $lastTimeFile;
	private $expire = 60;
	private $token;
	private $cookieFile;
	
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->timestamp=$this->checkSignature()){

        	echo $echoStr;
        	exit;
        }
    }

	function get_token($touser){
		
		$this->loginFile='resource/'.$touser.'_login.txt';
		$this->lastTimeFile='resource/'.$touser.'_last.txt';
		$this->cookieFile = 'resource/'.$touser.'_cookie.txt';
		
		if(!file_exists($this->cookieFile)){
			$fh = fopen($this->cookieFile,"w");
			fclose($fh);
		}
		
		if(!file_exists($this->loginFile)){
			$fh = fopen($this->loginFile,"w");
			fclose($fh);
		}
		
		if(!file_exists($this->lastTimeFile)){
			$fh = fopen($this->lastTimeFile,"w");
			fclose($fh);
		} 
		$needLogin=true;
		$nowTime=time();
		
		if($lastTime=file_get_contents($this->lastTimeFile)){
				
		}else{
			$lastTime=0;
		}
		
		if(($nowTime-$lastTime)<=$this->expire){
			$needLogin=false;
		} 
      
		$user_length = strlen($touser);
		if($touser=="gh_2c07aad760ce"){
			$username = "liuxiaofeng@xiaoshuhaochi.com";
			$appid = "wxcfc1c52ccb3c8b60";
			$appsecret = "34c1ef7aa973a7ff591eec751f656261";
		}
		
		if($needLogin==true){ 
			 
			$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
			curl_close($ch);
			$jsoninfo = json_decode($output, true);
			$token = $jsoninfo["access_token"];
			curl_close($ch);
			
			if($token){ 
			
				file_put_contents($this->lastTimeFile,$nowTime); 
				file_put_contents($this->loginFile,$token);
				$this->token=$token;
				return $token;
			}else{
				
				return false;
			}
		}else{
			if($token=file_get_contents($this->loginFile)){ 
				$this->token=$token;
				return $token;
			}else{
				return false;
			}
		}
		
	}
	 
	
//get responser_content	
	function get_response_content($result,$username,$keyword,$userinfo=""){
			
			
		$re = $this->chaxun(0, $username, 'getuid');
		$user = mysql_fetch_array($re);
		if ($user){
			 $uid = $user['m_id'];
			
			 $setresults=$this->chaxun($uid,0,"setweixin");
			 $data=mysql_fetch_array($setresults);

			 if ($data){
			 //check user exist or not 	
			 	$check_user = $this->chaxun($this->fromUsername,0,"check_user");
			 	$check_user = mysql_fetch_array($check_user);
			 	$r = $this->chaxun($this->toUsername,'','select_user');
				$rs = mysql_fetch_array($r); 
				
			 	if (!$check_user){
			 		 
				 	$save_dir = 'api_images';
				 	$image = $userinfo->headimgurl;
				 	$image_new_name = $this->generate_code(10).'.jpg';
				 	$image = $this->getImage($image,$save_dir,$image_new_name,1);
				 	
				 	if ($userinfo->sex==1){
				 		$gender = 0;
				 	}else{
				 		$gender = 1;
				 	} 
				 	$v['tu_username'] = trim($this->fromUsername);
				 	$v['tu_nickname'] = $userinfo->nickname;
				 	$v['tu_portrait'] = $image['save_path'];
				 	$v['tu_birthday'] = '1990-01-01';
				 	$v['tu_gender'] = $gender;
				 	$v['tu_weixin'] = $rs['m_id'];
				 	$v['tu_source'] = '1';
				 	$v['tu_created'] = date('Y-m-d H:i:s'); 
				 	$temp_query =$this->chaxun($v,0,'save_user');
					$temp_user = mysql_fetch_array($temp_query);
					$temp_uid = $temp_user['tu_id'];
			//筛选首次关注优惠券
			         $follow_coupon = $this->chaxun(0,0,'check_coupon');		
			         $coupon_user = mysql_fetch_array($follow_coupon);
			         if ($check_user){
			         	$coupon_id = $coupon_user['tc_id'];
			         	$user_coupon_check = $this->chaxun($temp_uid,$coupon_id,'check_user_coupon');
			         	$coupon_check = mysql_fetch_array($user_coupon_check);
			         	if(!$coupon_check){
			         		$this->chaxun($temp_uid,$coupon_id,'save_user_coupon');
			         	}
			         }
			 	}else{
			 		
				 	$this->chaxun($this->fromUsername,$rs['m_id'],'update_uid');
			 	}
			 }
	         	
			 
		 if($keyword == 'hello'){
		//error_log(print_r("进来了",1),3,__FILE__.'.log');
		 
		 	$this->responseMsg($result,$data,'hello','');
		 	
			
		 }else  {	 

	         $dat = $this->chaxun($keyword,0,'check_answer');	

	         $i = 0;	 
	         while ($row = mysql_fetch_array($dat)){
	         	$i++; 
	         	$daa[] = array(                 'tm_status'=>$row['tm_status'],
			         			'tm_title'=>$row['tm_title'],
			         			'tm_coverurl'=>$row['tm_coverurl'],
			         			'tm_source_url'=>$row['tm_source_url'],
			         			'tm_summary'=>$row['tm_summary'],
			         			'tm_content'=>$row['tm_content'],
	         			 		'tm_id'=>$row['tm_id']
			         			);
                        if($row['tm_status']=='2'){
                             $this->responseMsg($result,$daa,'text',$i);
                      				 
                        }else if($row['tm_status']=='1'){
                             $this->responseMsg($result,$daa,'news',$i);
                        }
                        	        

	         }
	       
		 }  	         	
		}				
	}
	
	 
	function chaxun($keyword,$vname,$type)
	{	

		$con = mysql_connect("localhost","root","Ha0ch197105$*");
		if (!$con)
		{
			die('Could not connect: ' . mysql_error());
			
		}
		mysql_select_db("shop", $con);
		mysql_query("set names utf8");
		$result=nothing;
		
		if ($type=="getuid"){
			$result = mysql_query("SELECT * FROM t_members where username='".$vname."'");
			
		}else if($type=="get_member_detail") {
			
			$result = mysql_query("select * from t_members where username = '".$_GET['token']."'"); 
			
		} else if($type=="setweixin") {	
			
			$result = mysql_query("SELECT * FROM t_auto_service where tas_uid= '".$keyword."'");
		
		}else if($type == "check_user"){
		//	error_log(print_r("SELECT * FROM t_users where tu_username like '%".$keyword."%'",true),3,'/home/www/tickets/check.txt');
			$result = mysql_query("SELECT * FROM t_users where tu_username like '%".$keyword."%'");
			
		
		}else if($type == "save_user"){
			$result_check = mysql_query("SELECT * FROM t_users where tu_username = '".$keyword['tu_username']."'");
			$check_user = mysql_fetch_array($result_check);
			if(!$check_user){
		   	 $result = mysql_query("insert into t_users 
		    		(tu_weixin,tu_username,tu_source,tu_created,tu_nickname,tu_portrait,tu_gender) 
		    		values ('".$keyword['tu_weixin']."','".$keyword['tu_username']."','".$keyword['tu_source']."2','".$keyword['tu_created']."','".$keyword['tu_nickname']."','".$keyword['tu_portrait']."','".$keyword['tu_gender']."')");
			}	
		    $result = mysql_query("SELECT * FROM t_users where tu_username = '".$keyword['tu_username']."'");
		    
		}else if($type == "check_answer"){
			//error_log(print_r("select * from t_materials where tm_keyword like '%".$keyword."%' order by tm_id asc",true),3,'/home/www/log.txt');
			$result = mysql_query("select * from t_materials where tm_keyword like '%".$keyword."%' order by tm_id desc limit 10");
		}else if($type == "system_help"){ 
			
			$result = mysql_query("select * from t_system_message where type='help'");
			
		}else if($type == "check_nickname"){
 
			$result = mysql_query("select tu_nickname,tu_id from t_users where tu_nickname ='".$keyword."'");
			
		}else if($type=="update_user"){
			
			$result = mysql_query("update t_users set tu_nickname='".$vname['nick_name']."',tu_fakeid='".$vname['fakeid']."',tu_created='".$vname['created']."' where tu_username='".$keyword."'");
		
		}else if($type=="save_msg"){
			
			$result = mysql_query("insert into t_weixin_question (twq_uid,twq_content,twq_created) values ('".$keyword."','".$vname."','".date("Y-m-d H:i:s")."')");
		
		}else if($type=="check_coupon"){
		
			$result = mysql_query("select * FROM t_coupons where tc_title = 'follow' and status = 1");
			
		}else if($type == "select_user"){
			
			$result = mysql_query("select * from t_members where weixin_id = '".$keyword."'"); 
			
		}else if($type == "update_uid"){
			
			$result = mysql_query("update t_users set tu_weixin='".$vname."' where tu_username='".$keyword."'");
		}else if($type == 'check_user_coupon'){
			$result = mysql_query("select * from t_coupons_record where tcr_uid = '".$keyword."' and tcr_tc_id='".$vname."'");
		}else if($type == 'save_user_coupon'){
			$result = mysql_query("insert into t_weixin_question (tcr_uid,tcr_tc_id,tcr_status,tcr_created) values ('".$keyword."','".$vname."',0,'".date("Y-m-d H:i:s")."')");
			
		} 
		
		
		if(is_resource($result))
		{
			$this->row=mysql_num_rows($result);
			if($this->row===0)
			{
				return 0;
			}		
		}
		
		return $result;
		mysql_close($con);
	}


	private function parseStr($ext_info,$type,$fromUsername,$toUsername,$flag=0)
	{
		 
		$str="<xml><ToUserName><![CDATA[".$fromUsername."]]></ToUserName><FromUserName><![CDATA[".$toUsername."]]></FromUserName><CreateTime>".time()."</CreateTime><MsgType><![CDATA[".$type."]]></MsgType>";
	
		if($type=='news')
		{
			$str.="<ArticleCount>".count($ext_info)."</ArticleCount> <Articles>";
			foreach($ext_info as $k=>$einfo)
			{
				$source_url = $einfo['tm_source_url'];
				
				if($k<=9){
				$str.="<item> <Title><![CDATA[".$einfo['tm_title']."]]></Title>
						<Description><![CDATA[".$einfo['tm_summary']."]]></Description>
					    <PicUrl><![CDATA[http://".serverip.$einfo['tm_coverurl']."]]></PicUrl> 
					    <Url><![CDATA[".$source_url."&tm_id=".$einfo['tm_id']."&user_from=".$this->fromUsername."]]></Url>
					   </item>";
				}
			}
			$str.="</Articles>";
                }
		$str.="<FuncFlag>".$flag."</FuncFlag></xml>"; 
		return $str;
	}
	private function parseStr_text($ext_info,$type,$fromUsername,$toUsername)
	{
		 
		$str="<xml><ToUserName><![CDATA[".$fromUsername."]]></ToUserName><FromUserName><![CDATA[".$toUsername."]]></FromUserName><CreateTime>".time()."</CreateTime>";
                $str.="<MsgType><![CDATA[".$type."]]></MsgType>";
				
			foreach($ext_info as $k=>$einfo)
			{								
				if($k<=9){
				$str.="<Content><![CDATA[".$einfo['tm_content']."]]></Content>";
				}
			}			              
		$str.="</xml>"; 
		return $str;
	}


    public function responseMsg($results,$para,$type,$uid='')
    {		
	
	
                $time = time();
				
                 $textTpl= "<xml>
				 			<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<ArticleCount>%s</ArticleCount>
							<Articles>%s</Articles>
							<FuncFlag>1</FuncFlag>
							</xml> ";
							
							
							
				$textTp2 = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
                                                $textTp3="<xml>
                                                        <ToUserName><![CDATA[%s]]></ToUserName>
                                                        <FromUserName><![CDATA[%s]]></FromUserName>
                                                        <CreateTime>%s</CreateTime>
                                                        <MsgType><![CDATA[%s]]></MsgType>
                                                        <Content><![CDATA[%s]]></Content>
                                                        </xml>";
		if($type == "hello")
		{
		    
	$textTpl="<xml>
      <ToUserName><![CDATA[%s]]></ToUserName>
      <FromUserName><![CDATA[%s]]></FromUserName>
      <CreateTime>%s</CreateTime>
      <MsgType><![CDATA[news]]></MsgType>
      <ArticleCount>1</ArticleCount>
      <Articles>
      <item>
       <Title><![CDATA[".$para['tas_title']."]]></Title>
      <Description><![CDATA[".$para['tas_intro']."]]></Description>
      <PicUrl><![CDATA[http://".serverip.$para['tas_image']."]]></PicUrl>
      <Url><![CDATA[".$para['tas_url']."]]></Url>
      </item>
      </Articles>
      </xml> ";
			
 
			$resultStr = sprintf($textTpl, $this->fromUsername, $this->toUsername, $time);	
					//error_log(print_r($resultStr,1),3,__FILE__.'.log');
			echo $resultStr;
			exit;
		}
                if($type=="text"){           
          $resultStr = $this->parseStr_text($para,$type,$this->fromUsername,$this->toUsername);	 
		  //error_log(print_r($resultStr,1),3,__FILE__.'.log');
				echo $resultStr;
				exit;
                                    }
		 
		if ($type=="news"){
			/*if ($uid == '1'){
				
				$para = $para[0];
				$newsItem="<item>
						  <Title><![CDATA[".$para['tm_title']."]]></Title>
						  <Description><![CDATA[".$para['tm_summary']."]]></Description>
						  <PicUrl><![CDATA[http://".serverip.$para['tm_coverurl']."]]></PicUrl>
						  <Url><![CDATA[".$para['tm_source_url']."&tm_id=".$para['tm_id']."]]></Url>
						  </item>";
				 
				$resultStr = sprintf($textTpl, $this->fromUsername, $this->toUsername, $time, 1, $newsItem);
				 
				echo $resultStr;
				exit;
			/*}else{*/
				$resultStr = $this->parseStr($para,$type,$this->fromUsername,$this->toUsername,0);
				 
				echo $resultStr;
				exit;
			/*}*/
		}
		if ($type=="gz"){
			$contentStr = $para['content'];	
		}
		
		$msgType = "text";
		$resultStr = sprintf($textTp2, $this->fromUsername, $this->toUsername, $time, $msgType, $contentStr);
		echo $resultStr;
	}
	
	
	function other_save($userinfo,$keyword){
		
		$query = $this->chaxun(trim($userinfo->nickname),'','check_nickname');
		$result = mysql_fetch_array($query);
		if ($keyword != 'hello'){
			
		 
		   $this->chaxun($result['tu_id'],$keyword,'save_msg');  
		 }else{
		 	$r = $this->chaxun($this->toUsername,'','select_user');
		 	$rs = mysql_fetch_array($r); 
		 	if(!$result){
		 		 
			 	$save_dir = 'api_images';
			 	$image = $userinfo->headimgurl;
			 	$image_new_name = $this->generate_code(10).'.jpg';
			 	$image = $this->getImage($image,$save_dir,$image_new_name,1);

			 	if ($userinfo->sex==1){
			 		$gender = 0;
			 	}else{
			 		$gender = 1;
			 	}
			  
			 	$v['tu_username'] = trim($this->fromUsername);
			 	$v['tu_nickname'] = $userinfo->nickname;
			 	$v['tu_portrait'] = $image['save_path'];
			 	$v['tu_gender'] = $gender; 
			 	$v['tu_weixin'] = $rs['m_id'];
			 	$v['tu_source'] = '1';
			 	$v['tu_created'] = date('Y-m-d H:i:s');  
			 	$rsw = $this->chaxun($v,0,'save_user');
			 	$r_s = mysql_fetch_array($rsw); 
			 	$uid = $r_s['tu_id'];
//第一次关注，发放优惠券			 	
			 	
			 	
		 	}else{
		 		$uid = $result['tu_id'];
		 	}  
		            
		 	if(!$rs){		 		
		  
		 		$this->chaxun($this->fromUsername,$rs['m_id'],'update_uid');
		 	}
		 }
		 
	}
	
	
	function get_user_info(){
		$auth_token = $this->get_token($this->toUsername);
		
		$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$auth_token."&openid=".$this->fromUsername;
		
		$output = file_get_contents($url);
		
		return json_decode($output);
	}
	
	
	
	public function response($t="")
	{	
		
		$this->now=(time());
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		
		if (!empty($postStr))
		{
			
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$this->fromUsername =$postObj->FromUserName;
			$this->toUsername =$postObj->ToUserName;
			$this->MsgType =$postObj->MsgType;
			$this->Event =$postObj->Event;
			$EventKey =$postObj->EventKey;
			$Location_X =$postObj->Location_X;
			$Location_Y =$postObj->Location_Y;
			$keyword =trim($postObj->Content);
			$create_time = time();	
			
			if($this->MsgType=='event')
			{
				
				
				if($this->Event=='subscribe')
				{	
					
					
					
					$user_info = $this->get_user_info();
					
				
 					
					$this->get_response_content($results,uf,"hello",$user_info);
					exit;
				}
				
				if($this->Event=='unsubscribe')
				{	 
			
					//$this->chaxun($this->fromUsername,uf,'delete_user');
					//exit;
				}

				
				if($this->Event=='CLICK')
				{	 
					$key = (array)$EventKey; 
					$this->get_response_content($results,uf,$key[0]);
					exit;
				}
			
			}
			if(!empty( $keyword ))
			{  
				 
				$this->temp=$keyword;
				//$this->get_response_content($results,uf,'hello');
				$this->get_response_content($results,uf,strtolower($keyword));
				exit;			
			}
		}   
		
	}	
			
 
				
	private function msubstr($str,$start,$len)
	{ 
		$strlen=$start+$len; 
		for($i=0;$i<$strlen;$i++) { 
			if(ord(substr($str,$i,1))>0xa0) { 
				$tmpstr.=substr($str,$i,2); 
				$i++; 
			} else 
				$tmpstr.=substr($str,$i,1); 
		} 
		return $tmpstr; 
	} 
	
	private function getstr($string, $length, $encoding  = 'utf-8') {    
		$string = trim($string);    
		 
		if($length && strlen($string) > $length) {   
			$wordscut = '';    
			if(strtolower($encoding) == 'utf-8') {   
				$n = 0;    
				$tn = 0;    
				$noc = 0;    
				while ($n < strlen($string)) {    
					$t = ord($string[$n]);    
					if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {    
						$tn = 1;    
						$n++;    
						$noc++;    
					} elseif(194 <= $t && $t <= 223) {    
						$tn = 2;    
						$n += 2;    
						$noc += 2;    
					} elseif(224 <= $t && $t < 239) {    
						$tn = 3;    
						$n += 3;    
						$noc += 2;    
					} elseif(240 <= $t && $t <= 247) {    
						$tn = 4;    
						$n += 4;    
						$noc += 2;    
					} elseif(248 <= $t && $t <= 251) {    
						$tn = 5;    
						$n += 5;    
						$noc += 2;    
					} elseif($t == 252 || $t == 253) {    
						$tn = 6;    
						$n += 6;    
						$noc += 2;    
					} else {    
						$n++;    
					}    
					if ($noc >= $length) {    
						break;    
					}    
				}    
				if ($noc > $length) {    
					$n -= $tn;    
				}    
				$wordscut = substr($string, 0, $n);    
			} else {    
				for($i = 0; $i < $length - 1; $i++) {    
					if(ord($string[$i]) > 127) {    
						$wordscut .= $string[$i].$string[$i + 1];    
						$i++;    
					} else {    
						$wordscut .= $string[$i];    
					}    
				}    
			}    
			$string = $wordscut;    
		}    
		return trim($string);    
	}   
	
	
		
	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr,SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return $timestamp;
		}else{
			return false;
		}
	}
	
	


	function getImage($url,$save_dir='',$filename='',$type=0){
			
		if(trim($url)==''){
			return array('file_name'=>'','save_path'=>'','error'=>1);
		}
		if(trim($save_dir)==''){
			$save_dir='./';
		}
		if(trim($filename)==''){//保存文件名
			$ext=strrchr($url,'.');
			if($ext!='.gif'&&$ext!='.jpg'){
				return array('file_name'=>'','save_path'=>'','error'=>3);
			}
			$filename=time().$ext;
		}
		if(0!==strrpos($save_dir,'/')){
			$save_dir.='/';
		}
		//创建保存目录
		if(!file_exists($save_dir)&&!mkdir($save_dir,0777,true)){
			return array('file_name'=>'','save_path'=>'','error'=>5);
		}
		//获取远程文件所采用的方法
		if($type){
			$ch=curl_init();
			$timeout=5;
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
			$img=curl_exec($ch);
			curl_close($ch);
		}else{
			ob_start();
			readfile($url);
			$img=ob_get_contents();
			ob_end_clean();
		}
			
		//$size=strlen($img);
		//文件大小
		$fp2=@fopen('/data/www/xshc/shop/'.$save_dir.$filename,'a'); 
		fwrite($fp2,$img);
		fclose($fp2);
		//unset($img,$url);
		return array('file_name'=>$filename,'save_path'=>$save_dir.$filename,'error'=>0);
	}
	
	

	function generate_code($len = 10)
	{
		 
		$chars = '0123456789';
	
		for ($i = 0, $count = strlen($chars); $i < $count; $i++)
		{
		$arr[$i] = $chars[$i];
		}
	
		mt_srand((double) microtime() * 1000000);
		shuffle($arr);
		$code = substr(implode('', $arr),0 , $len);
		return $code;
	}
	
	
		function check_valid(){
			if ($this->fromUsername!=$this->toUsername){
			    $this->valid();
			}
		}
	
}

?>
