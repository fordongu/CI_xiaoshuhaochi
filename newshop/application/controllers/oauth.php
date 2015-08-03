<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class oauth extends CI_Controller {
	
	public function __construct()
    {
        parent::__construct();
        ini_set('display_errors','On');
        define('WB_AKEY','4101484627');
        define('WB_SKEY','11a6f6e63044ad946251b0e73973d24c');
        
        $this->load->model('tickets');
        $this->load->library('qqclass');
    }
    
    
    
    function sina_oauth(){
    	 
    	require_once APPPATH.'libraries/sina/saetv2.ex.class.php';
    	$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
    	$back_url = base_url().'index.php?c=oauth&m=sina_oauth_back';
    	$data['code_url'] = $o->getAuthorizeURL( $back_url );
    	$this->load->view('/oauth/sina_oauth', $data);
    }
    
    
    function sina_oauth_back(){
    	require_once APPPATH.'libraries/sina/saetv2.ex.class.php';
    	
    	$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
    	$back_url = base_url().'index.php?c=oauth&m=sina_oauth_back';
    	if (isset($_REQUEST['code'])) {
    		$keys = array();
    		$keys['code'] = $_REQUEST['code'];
    		$keys['redirect_uri'] = $back_url;
    		try {
    			$token = $o->getAccessToken( 'code', $keys ) ;
    		} catch (OAuthException $e) {
    		}
    	}
    	

    	$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $token['access_token'] );
    	$ms  = $c->home_timeline(); // done
    	$uid_get = $c->get_uid();
    	$uid = $uid_get['uid'];
    	$user_message = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息
    	if($user_message['gender'] == 'm'){
    		$user_data['tu_gender'] = 0;
    	}else{
    		$user_data['tu_gender'] = 1;
    	}
    	
    	$user_data['tu_weibo_nickname'] = $user_message['screen_name'];
    	$user_data['tu_source'] = 0;
    	
    	$weibo_user_check= $this->tickets->select('users',$user_data);
    	if ($weibo_user_check){
    		$final_user = $weibo_user_check[0];
    	}else{
    		$save_dir = 'api_images';
    		$image = $user_message['avatar_large'];
    		$image_new_name = $this->generate_code(10).'.jpg';
    		$image = $this->getImage($image,$save_dir,$image_new_name,1);
    		$user_data['tu_portrait'] = $image['save_path'];
    		$user_data['tu_created'] = date('Y-m-d H:i:s');
    			
    		$result = $this->tickets->insert('users',$user_data);
    		$temp_user = $this->tickets->select('users',array('tu_id'=>$result));
    		$final_user = $temp_user[0];
    	}
    	
    	setcookie('user_cookie',serialize($final_user),time()+3600*24,'/');
    		
    	redirect('/main/index');
    }
    
    
	 
	/**
	 * 点击QQ登陆页面操作
	 */
	public function qqlogin()
	{
		$qq_state = md5(uniqid(rand(), TRUE)); //CSRF protection
		$this->qqclass->qq_login($qq_state, $this->config->item("qq_appid"), $this->config->item("qq_scope"), $this->config->item("qq_callback"));//用户点击qq登录按钮调用此函数	
	}
	/**
	 * QQ登陆返回到本网站
	 */
	public function qqcallback()
	{
		 
		$inputs = $_GET;
		 
		$access_token = $this->qqclass->qq_callback($inputs, $this->config->item("qq_appid"), $this->config->item("qq_appkey"), $this->config->item("qq_callback"));//QQ登录成功后的回调地址,主要保存access token
		$open_id = $this->qqclass->get_openid($inputs, $access_token);//获取用户标示id
		
		//获取用户基本资料
		$user = $this->qqclass->get_user_info($access_token, $this->config->item("qq_appid"), $open_id);
		$user_data = array();
		if ($user['gender']=='男'){
			$user_data['tu_gender'] = 0;
		}else{
			$user_data['tu_gender'] = 1;
		}
		$user_data['tu_qq_nickname'] = $user['nickname'];
		$user_data['tu_source'] = 0;
		
		$qq_user_check= $this->tickets->select('users',$user_data);
		if ($qq_user_check){
			$final_user = $qq_user_check[0];
		}else{
			$save_dir = 'api_images';
			$image = $user['figureurl_qq_2'];
			$image_new_name = $this->generate_code(10).'.jpg';
			$image = $this->getImage($image,$save_dir,$image_new_name,1);
			$user_data['tu_portrait'] = $image['save_path'];
			$user_data['tu_created'] = date('Y-m-d H:i:s');
			
			$result = $this->tickets->insert('users',$user_data);
			$temp_user = $this->tickets->select('users',array('tu_id'=>$result));
			$final_user = $temp_user[0];
		}
		
		setcookie('user_cookie',serialize($final_user),time()+3600*24,'/');
		 
		redirect('/main/index');
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
}

/* End of file oauth.php */
/* Location: ./application/controllers/oauth.php */