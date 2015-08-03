<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class main extends Controller {

	function __construct()
	{
		parent::__construct();
		ini_set('display_errors','On');
		$this->load->library('zip');
		$this->load->model('tickets');
		$this->load->model('common');
                $this->load->helper('cookie');
		define('COUPON_USED','2');
		define('VALID_CODES','0');
		define('INVALID_CODES','1');
		define('UNREADED','0');
		define('VALID_STATUS',1);
		define('DEFAULT_ADDRESS',1);
		define('ORDER_NOT_PAYED',10);
		define('ORDER_PAYED',20);
		define('COUPON_NOT_USED',0);
		define('COUPON_FREEZED',1);
		define('WEBSITE_ORDER',0);
		define('EVENT_BUILDING',3);
		//$this->common->_oauth_check();
		define('WB_AKEY','4101484627');
		define('WB_SKEY','11a6f6e63044ad946251b0e73973d24c');
	}


	function index(){
        redirect($this->config->item('new_website'),'location');exit;
        $this->load->model('shopproduct');
	require_once APPPATH.'libraries/sina/saetv2.ex.class.php';
     	$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
     	$back_url = base_url().'index.php?c=oauth&m=sina_oauth_back';
     	$data['code_url'] = $o->getAuthorizeURL( $back_url );

			$login_flag = 0;
		$para = $this->uri->segment(3);
		if($para){
			$login_flag = 1;
		}
		$data['login_flag'] = $login_flag;

		//get_default_service_building
		//$building_id = $this->_get_cookie_building();
                 $building_id=43;
		if (!$building_id){
			$building_flag = 0;
			$data['default_building'] = '';
		}else{
			$building_flag = 1;
			$default_building = $this->tickets->api_select('service_buildings','name',array('id'=>$building_id));
			$data['default_building'] = $default_building[0]->name;
		}
		$total_building = $this->tickets->api_select('service_buildings','area_id');
		$temp_building_id = array();
		foreach($total_building as $k=>$v){
			if(!in_array($v->area_id,$temp_building_id)){
				$temp_building_id[] = $v->area_id;
			}
		}

		$area = $this->tickets->select('area',array('status'=>1),'','','','',array('area_id'=>$temp_building_id));
		$data['area'] = $area;
		$data['service_buildings'] = $this->tickets->select('service_buildings',array('area_id'=>$area[0]->area_id,'user_shipping'=>0,'status !='=>3));
		$data['building_flag'] = $building_flag;
		//service_building_end
		//get_service_goods
		$weeks = $this->common->_get_valid_weeks();

		$cookie_cart = $this->common->_get_cookie_cart();

		$user = $this->_get_uid();
		$uid = $user->tu_id;

		$data['uid'] = $uid;

		$data['cookie_good'] = $cookie_cart['cookie_cart'];
		$data['cookie_count'] = $cookie_cart['cookie_count'];

                $filtersort=$_GET["price"];

                if($filtersort=="lt20"){
                    $dav_select=2;
                }else if($filtersort=="lt30"){
                    $dav_select=3;
                }else if($filtersort=="gt30"){
                    $dav_select=4;
                }else{
                    $dav_select=1;
                }
                //主页价格分类的判断
                  if($filtersort=="lt20"){
                       $price_lower="0";
                       $price_limit="20";
                 }else if($filtersort=="lt30"){
                       $price_lower="20";
                       $price_limit="30";
                 }else if($filtersort=="gt30"){
                       $price_lower="30";
                       $price_limit="10000";
                 }else{
                       $price_lower="0";
                       $price_limit="10000";
                 }
                 $data["price_lower"]=$price_lower;
                 $data["price_limit"]=$price_limit;
               //  and t_goods.price>='$price_lower' and t_goods.price<'$price_limit'
                 //
                $data["dav_select"]=$dav_select;//导航栏筛选的DAV选择
		$service_datas = $this->shopproduct->_get_all_valid_buildings($building_id);
		if(!$service_datas['final_goods']){
			//redirect('/wechat/index');exit;
		}

                $data['goods'] = $service_datas['final_goods'];


		$data['weeks'] = common_weeks();
		$data['week_orders'] = $weeks;
		//获取每个商品和每个订单菜品总份数限制
		$count_config = $this->tickets->select('configs',array('tc_type'=>'order_count'));
		$data['per_count_limit'] = $count_config[0]->tc_title;
		$data['total_count_limit'] = $count_config[0]->tc_content;
		//订单提前天数
		$temp_valid_date = $this->tickets->select('configs',array('tc_type'=>'order_date'));
		$valid_date = 0 ;
		if($temp_valid_date){
			$valid_date = $temp_valid_date[0]->tc_content;
			$valid_time = $temp_valid_date[0]->tc_title;
		}

		$data['valid_date'] = $valid_date;
		$data['valid_time'] = $valid_time;

		//订购时间段
		$order_time = $this->tickets->select('configs',array('tc_type'=>'order_time'));

		$data['order_time'] = $order_time[0];
		$data['current_week_day'] = date("N",time());
		$sys_mobile = $this->tickets->select('configs',array('tc_type'=>'jifen_config'));
		$sys_mobile = $sys_mobile[0]->tc_content;
		$data['sys_mobile'] = $sys_mobile;

		$event = $this->common->get_valid_event($uid);
		$goods = $this->common->_get_cookie_good_detail('main',$event);
		$data["cart_goods"]=$goods["cart_goods"];

                $temp_valid_date = $this->tickets->select('configs',array('tc_type'=>'order_date'));
		$day_choose=date("w");
		$current_time_now=date("H:i:s");
		$limit_time=$temp_valid_date[0]->tc_title;


		if($current_time_now>$limit_time){
			$day_choose=$day_choose+1;
		}
                  $data["index"]=$_GET["index"];
                  if($data["index"]){
                      $data["day_choose"]=$data["index"];
                  }else{
                      $data["day_choose"]=$day_choose;
                  }


		$data["current_time"]=date('H:i:s');
		$this->load->view('main/index',$data);
	}


//cookie 快递地址的值
     function cookie_shipping_val(){
     	$name = trim($_POST['name']);
     	$val  = trim($_POST['val']);
     	setcookie('address_'.$name,$val,time()+3600*24,'/');
     	echo json_encode(array('success'=>'yes'));exit;
     }




//默认选择配送写字楼
     function default_index(){
     	$sys_mobile = $this->tickets->select('configs',array('tc_type'=>'jifen_config'));
     	$sys_mobile = $sys_mobile[0]->tc_content;
     	//sina_login
     	require_once APPPATH.'libraries/sina/saetv2.ex.class.php';
     	$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
     	$back_url = base_url().'index.php?c=oauth&m=sina_oauth_back';
     	$data['code_url'] = $o->getAuthorizeURL( $back_url );

     	$data['sys_mobile'] = $sys_mobile;
     	$data['login_flag'] = 0;
    //取出所有写字楼
        $total_building = $this->tickets->api_select('service_buildings','area_id');
		$temp_building_id = array();
		foreach($total_building as $k=>$v){
			if(!in_array($v->area_id,$temp_building_id)){
				$temp_building_id[] = $v->area_id;
			}
		}

		$area = $this->tickets->select('area',array('status'=>1),'','','','',array('area_id'=>$temp_building_id));
		$data['area'] = $area;
		$data['service_buildings'] = $this->tickets->select('service_buildings',array('area_id'=>$area[0]->area_id,'status !='=>3));

     	$this->load->view('main/default_index',$data);
     }



	function alipay_code(){
		require_once("qalipay/alipay.config.php");
		require_once("qalipay/lib/alipay_submit.class.php");
		$alipay_config_temp = $this->tickets->select('payment',array('name'=>'alipay'));
		$alipay_con = $alipay_config_temp[0];

		//接口调用时间
		$timestamp = date('Y-m-d h:i:s');
		//格式为：yyyy-MM-dd HH:mm:ss

		//动作
		$method = "add";
		//创建商品二维码
		//业务类型
		$biz_type = "10";
		//目前只支持1
		//业务数据

		$biz_data_temp = array(
							'trade_type'=>'1',
							'need_address'=>'F',
							'goods_info'=>array('id'=>'3'),
							'return_url'=>base_url()."return_url.php",
							'notify_url'=>$notify_url = base_url()."wechat/code_notify_url",

							'show_url'=>'http://www.xiaoshuhaochi.com'
				);

		$biz_data = json_encode($biz_data_temp);
		//格式：JSON 大字符串，详见技术文档4.2.1章节
		//echo '<pre>';print_r($biz_data);exit;

		/************************************************************/
		$alipay_config['partner'] = $alipay_con->app_id;
		$alipay_config['key'] = $alipay_con->app_secret;
		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service" => "alipay.mobile.qrcode.manage",
				"partner" => trim($alipay_config['partner']),
				"timestamp"	=> $timestamp,
				"method"	=> $method,
				"biz_type"	=> $biz_type,
				"biz_data"	=> $biz_data,
				"_input_charset"=> trim(strtolower($alipay_config['input_charset']))
		);
		echo '<pre>';
		print_r($parameter);
		//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestHttp($parameter);
		print_r($html_text);exit;
		//解析XML
		//注意：该功能PHP5环境及以上支持，需开通curl、SSL等PHP配置环境。建议本地调试时使用PHP开发软件
		$doc = new DOMDocument();
		$doc->loadXML($html_text);

		//请在这里加上商户的业务逻辑程序代码

		//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——

		//获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

		//解析XML
		if( ! empty($doc->getElementsByTagName( "alipay" )->item(0)->nodeValue) ) {
			$alipay = $doc->getElementsByTagName( "alipay" )->item(0)->nodeValue;
			echo $alipay;
		}
	}


	function  wechat_qcode_pay(){
		require_once(APPPATH.'libraries/wechat/WxPayPubHelper.php');
		$out_trade_no = $this->uri->segment(3);
		$order_temp = $this->tickets->select('orders',array('to_order_sn'=>$out_trade_no));
		$order = $order_temp[0];

		if ($order->to_status==ORDER_PAYED){
		  redirect('/member/order_list');
		}
		$wechat_config_temp = $this->tickets->select('payment',array('name'=>'wechat'));
		$weipay = $wechat_config_temp[0];
		//使用统一支付接口
		$unifiedOrder = new UnifiedOrder_pub($weipay->app_id,$weipay->payname,$weipay->partner_key,$weipay->app_secret);

		//设置统一支付接口参数
		//设置必填参数
		//appid已填,商户无需重复填写
		//mch_id已填,商户无需重复填写
		//noncestr已填,商户无需重复填写
		//spbill_create_ip已填,商户无需重复填写
		//sign已填,商户无需重复填写
		$unifiedOrder->setParameter("body","小树好吃");//商品描述
		//自定义订单号，此处仅作举例
		$timeStamp = time();
		$notify_url = base_url().'/wechat/wnotice';
		//$out_trade_no = $weipay->app_id."$timeStamp";

		$unifiedOrder->setParameter("out_trade_no","$out_trade_no");//商户订单号
		$unifiedOrder->setParameter("total_fee",100*$order->to_order_amount);//总金额
		$unifiedOrder->setParameter("notify_url",$notify_url);//通知地址
		$unifiedOrder->setParameter("trade_type","NATIVE");//交易类型
		//非必填参数，商户可根据实际情况选填


		//获取统一支付接口结果
		$unifiedOrderResult = $unifiedOrder->getResult();

		//商户根据实际情况设置相应的处理流程
		if ($unifiedOrderResult["return_code"] == "FAIL")
		{
		//商户自行增加处理流程
		echo "通信出错：".$unifiedOrderResult['return_msg']."<br>";
	}
	elseif($unifiedOrderResult["result_code"] == "FAIL")
	{
				//商户自行增加处理流程
				echo "错误代码：".$unifiedOrderResult['err_code']."<br>";
				echo "错误代码描述：".$unifiedOrderResult['err_code_des']."<br>";
	}
	elseif($unifiedOrderResult["code_url"] != NULL)
	{
		//从统一支付接口获取到code_url
			$code_url = $unifiedOrderResult["code_url"];
			//商户自行增加处理流程
					//......
				}
		  $data['out_trade_no']= $out_trade_no;
		  $data['code_url'] = $code_url;
	  $data['unifiedOrderResult'] = $unifiedOrderResult;
	  $this->load->view('/wechat/qcode',$data);

	}



//支付成功
    function pay_success(){

    }


//支付页面
	function pay_order(){
		$order_sn = $this->uri->segment(3);
	    $data = $this->common->pay_order($order_sn,'alipay','main');
		$this->load->view('main/pay_channel',$data);
	}



	function notify_url(){
		require_once("alipay/alipay.config.php");
		require_once("alipay/lib/alipay_notify.class.php");
		$alipay_config_temp = $this->tickets->select('payment',array('name'=>'alipay'));
		$alipay_con = $alipay_config_temp[0];
		$alipay_config['partner'] = $alipay_con->app_id;
		$alipay_config['key'] = $alipay_con->app_secret;
		//计算得出通知验证结果
		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyNotify();

		if($verify_result) {//验证成功
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//请在这里加上商户的业务逻辑程序代
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——

		    //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表

			//商户订单号

			$out_trade_no = $_POST['out_trade_no'];

			//支付宝交易号

			$trade_no = $_POST['trade_no'];

			//交易状态
			$trade_status = $_POST['trade_status'];


		    if($_POST['trade_status'] == 'TRADE_FINISHED') {
				//判断该笔订单是否在商户网站中已经做过处理
					//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
					//如果有做过处理，不执行商户的业务程序

				//注意：
				//该种交易状态只在两种情况下出现
				//1、开通了普通即时到账，买家付款成功后。
				//2、开通了高级即时到账，从该笔交易成功时间算起，过了签约时的可退款时限（如：三个月以内可退款、一年以内可退款等）后。

		        //调试用，写文本函数记录程序运行情况是否正常
		        //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
		    }
		    else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
		    	$this->common->change_order_status($out_trade_no);

				//判断该笔订单是否在商户网站中已经做过处理
					//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
					//如果有做过处理，不执行商户的业务程序

				//注意：
				//该种交易状态只在一种情况下出现——开通了高级即时到账，买家付款成功后。

		        //调试用，写文本函数记录程序运行情况是否正常
		        //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
		    }

			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

			echo "success";		//请不要修改或删除

			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		}
		else {
		    //验证失败
		    echo "fail";

		    //调试用，写文本函数记录程序运行情况是否正常
		    //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
		}
	}


	function ajax_update_service_buildings(){
		$service_id = intval($_POST['service_id']);
		$building_check = $this->tickets->select('service_buildings',array('id'=>$service_id));
		if($building_check){
			setcookie('user_building_cookie',$service_id,time()+3600*24,'/');
			setcookie('event_user_building_cookie',1,time()+3600*24,'/');
			echo json_encode(array('success'=>'yes'));exit;
		}else{
			echo json_encode(array('success'=>'no'));exit;
		}
	}



//首页
	function index2(){

		$cookie_building = $this->_get_cookie_building();

		//sina_login
		require_once APPPATH.'libraries/sina/saetv2.ex.class.php';
		$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
		$back_url = base_url().'index.php?c=oauth&m=sina_oauth_back';
		$data['code_url'] = $o->getAuthorizeURL( $back_url );

		$login_flag = 0;
		$para = $this->uri->segment(3);
		if($para){
			$login_flag = 1;
		}
		$data['login_flag'] = $login_flag;
		$cookie_cart = $this->common->_get_cookie_cart();


		//$data = $this->common->get_default_building($uid);
//取出可用省份，城市，区域
		$province = $this->tickets->select('province',array('status'=>1));
		$data['province'] = $province;
		if ($province){
			$province_id = '';
			foreach($province as $k=>$v){
				$province_id.=$v->province_id.',';
			}

			$province_id = rtrim($province_id,',');
			$city_sql = "select * from t_city where father in (".$province_id.")";
			$data['city'] = $this->tickets->personal_select($city_sql);
		}


		$data['cookie_good'] = $cookie_cart['cookie_cart'];
		$data['cookie_count'] = $cookie_cart['cookie_count'];
		$weeks = $this->common->_get_valid_weeks();
		$uid = $this->_get_uid();
		$data['uid'] = $uid;
        if(isset($_GET['keywords'])){
        	$keywords = trim($_GET['keywords']);
        }else{
        	$keywords = '';

        }

	    $service_datas = $this->common->_get_all_valid_buildings($keywords,$uid);

		$data['sys_mobile'] = $service_datas['sys_mobile'];
		if($service_datas['final_buildings']){
			$data['current_service_building'] = $service_datas['final_buildings'][0]['id'];
			$data['service_buildings'] = $service_datas['final_buildings'][0]['name'];
		}else{

			$service_datas = $this->common->_get_all_valid_buildings('');

			if ($service_datas['final_buildings']){

				$data['current_service_building'] = $service_datas['final_buildings'][0]['id'];
				$data['service_buildings'] = $service_datas['final_buildings'][0]['name'];
			}else{
				$data['service_buildings'] = '';
				$data['current_service_building'] = '';
			}
		}


		$second_datas = $this->common->_get_all_valid_buildings('',$uid,1);
		$data['goods'] = $second_datas['final_goods'];
		$data['service_building'] = $second_datas['final_buildings'];
		$data['weeks'] = common_weeks();

		$data['week_orders'] = $weeks;

//获取每个商品和每个订单菜品总份数限制
		$count_config = $this->tickets->select('configs',array('tc_type'=>'order_count'));
		$data['per_count_limit'] = $count_config[0]->tc_title;
		$data['total_count_limit'] = $count_config[0]->tc_content;
//订单提前天数
		$temp_valid_date = $this->tickets->select('configs',array('tc_type'=>'order_date'));
		$valid_date = 0 ;
		if($temp_valid_date){
			$valid_date = $temp_valid_date[0]->tc_content;
		}
		$data['valid_date'] = $valid_date;

//订购时间段
		$order_time = $this->tickets->select('configs',array('tc_type'=>'order_time'));

		$data['order_time'] = $order_time[0];
		$uid=$this->_get_uid();
		$event = $this->common->get_valid_event($uid);
		$goods = $this->common->_get_cookie_good_detail('main',$event);
		$data["cart_goods"]=$good["cart_goods"];


		$this->load->view('main/index',$data);
	}


	function clear_cookie_cart(){
		setcookie('goods_cart','',time()+3600*24,'/');
		echo json_encode(array('success'=>'yes','count'=>0));exit;
	}
	function clear_cookie_member(){
		setcookie('user_cookie','',time()-1,'/', ".xiaoshuhaochi.com");
		echo json_encode(array('success'=>'yes','count'=>0));exit;
	}
	function _get_cookie_building(){
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		if ((!strpos($user_agent, 'MicroMessenger') === false))
		{

			$event_building_flag = isset($_COOKIE['event_user_building_cookie'])?$_COOKIE['event_user_building_cookie']:0;
			//查看是否有活动写字楼
			$event_building_check = $this->tickets->api_select('service_buildings','id',array('status'=>EVENT_BUILDING));
			if ($event_building_check&&(!$event_building_flag)){
				$event_building_id = $event_building_check[0]->id;
				setcookie('user_building_cookie',$event_building_id,time()+3600*24,'/');
				return $event_building_id;
			}
		}

		$user_cookie = isset($_COOKIE['user_building_cookie'])?$_COOKIE['user_building_cookie']:'';
		if ($user_cookie) {
			return $user_cookie;
		}else{
			redirect('/main/default_index');
		}
	}



	function cookie_cart(){
		$user_agent = $_SERVER['HTTP_USER_AGENT'];

		if ((!strpos($user_agent, 'MicroMessenger') === false))
		{
			$uid = $this->_get_uid();

			$cookie_building_id = $this->_get_cookie_building();

		 //判断此用户是否买过活动菜品
			$event_building_check = $this->tickets->api_select('service_buildings','id',array('status'=>EVENT_BUILDING));
			if ($event_building_check){

				$event_building_id = $event_building_check[0]->id;
				if($event_building_id == $cookie_building_id){

					$current_date = date('Y-m-d');

					$start_time = date('Y-m-d 00:00:00');
					$end_time = date('Y-m-d 23:59:59');
					$good_ids = '12,13,14,15,16';
					$event_order_check_sql = "select t_order_good.*,t_orders.to_id,t_orders.to_created from t_orders,t_order_good where to_uid=".$uid;
					$event_order_check_sql.=" and t_orders.to_id=t_order_good.order_id and t_order_good.good_id in (".$good_ids.") and t_orders.to_created > '".$start_time."' and to_created < '".$end_time."'";

					$event_order_check = $this->tickets->personal_select($event_order_check_sql);
					if ($event_order_check){
						//echo json_encode(array('success'=>'no','msg'=>'您今天已经购买过活动菜品'));exit;
					}
				}
			}
		}
                $current_date = isset($_POST['current_date'])?trim($_POST['current_date']):'';
                $current_date_week=date("w",strtotime($current_date));
		$data_id=$current_date_week;
                $good_id = trim($_POST['id']);
                $weeks_choose_next_mon = isset($_POST['weeks_choose_next_mon'])?trim($_POST['weeks_choose_next_mon']):'';
                if((strtotime($current_date)-strtotime($weeks_choose_next_mon))/86400==0){
                     $data_id=5;
                }else if((strtotime($current_date)-strtotime($weeks_choose_next_mon))/86400==1){
                     $data_id=6;
                }else if((strtotime($current_date)-strtotime($weeks_choose_next_mon))/86400==2){
                     $data_id=7;
                }else if((strtotime($current_date)-strtotime($weeks_choose_next_mon))/86400==3){
                     $data_id=8;
                }else if((strtotime($current_date)-strtotime($weeks_choose_next_mon))/86400==4){
                     $data_id=9;
                }else if(strtotime($current_date)-strtotime($weeks_choose_next_mon)=="-1"||strtotime($current_date)-strtotime($weeks_choose_next_mon)=="-2"){
                    echo json_encode(array('success'=>'no','msg'=>'周末不能预定'));exit;
                }
                $good_id=$good_id."_".$data_id;
		$count = intval($_POST['count']);
		$building_id = isset($_POST['building_id'])?intval($_POST['building_id']):0;
                $building_id = 43;

		$temp_valid_date = $this->tickets->select('configs',array('tc_type'=>'order_date'));
		$valid_time = $temp_valid_date[0]->tc_title;
		$current_time = date('H:i');
		$current_date2 = date('Y-m-d');

		if ((strtotime($current_date) == strtotime($current_date2))&&($current_time >= $valid_time)){
			echo json_encode(array('success'=>'no','msg'=>'您不能预订过期菜品'));exit;
		}

		$this->common->cookie_cart($good_id,$count,$building_id);
	}


//保存订单
    function save_order(){
    	$uid = $this->_get_uid();
    	$event = $this->common->get_valid_event($uid);
    	$this->common->save_order_new($uid,WEBSITE_ORDER,'main',$event);
    }



    function ajax_get_shipping_address(){
    	$tsa_id = intval($_POST['tsa_id']);
    	$sql="SELECT t_service_buildings.name as building_name, t_shipping_address .*,t_companys.name as company_name,t_province.province, t_city.city, t_area.area FROM t_service_buildings,t_companys,t_shipping_address, t_city, t_province, t_area WHERE t_shipping_address.tsa_province = t_province.province_id
AND t_shipping_address.tsa_city = t_city.city_id and t_shipping_address.tsa_company = t_companys.id
AND t_shipping_address.tsa_building_id = t_service_buildings.id AND t_shipping_address.tsa_district = t_area.area_id  and t_shipping_address.tsa_id = ".$tsa_id;
    	$shipping_address = $this->tickets->personal_select($sql);

    	echo json_encode(array('success'=>'yes','msg'=>$shipping_address[0]));exit;
    }



//确认订单
	function order_confirm(){
		$uid = $this->_get_uid();
		//$building_id = $this->_get_cookie_building();

                 $building_id=43;
		$user_check = $this->tickets->api_select('users','tu_id',array('tu_id'=>$uid));
		$event = $this->common->get_valid_event($uid);
		//$goods = $this->common->_get_cookie_good_detail('main',$event);
		/*$this->load->helper('curl');

		$new_website = $this->config->item('new_website');
		$goods_json = vget($new_website."/cart/getCart",array('Cookie:this_week_cart='.$_COOKIE['this_week_cart'].';next_week_cart='.$_COOKIE['next_week_cart']));
		$goods = json_decode($goods_json, TRUE);*/
		$this->load->model('cart_model');
		$goods = $this->cart_model->getCartInfo();
           
		if (empty($goods['cart_goods'][0]) && empty($goods['cart_goods'][1])) {
			header("Content-type:text/html;charset=utf-8");
			echo "<script>alert('购物车没有菜，请点餐');window.location.href='/';</script>";exit;
		} else {
			$this->load->model('date_model');
			if (!empty($goods['cart_goods'][0])) {
				/*foreach ($goods['cart_goods'][0] as $k => $v) {
					if ($v['date'] == 0) {
						header("Content-type:text/html;charset=utf-8");
						echo "<script>alert('请选择用餐时间');window.location.href='/';</script>";exit;
					}
				}*/
				//获取可点餐的时间
				$this_week_list = $this->date_model->getDinnerDate(0);
				//print_r($data['this_week_list']);exit;
			}
			if (!empty($goods['cart_goods'][1])) {
				/*foreach ($goods['cart_goods'][1] as $k => $v) {
					if ($v['date'] == 0) {
						header("Content-type:text/html;charset=utf-8");
						echo "<script>alert('请选择用餐时间');window.location.href='/';</script>";exit;
					}
				}*/
				//获取可点餐的时间
				$next_week_list = $this->date_model->getDinnerDate(1);
			}
		}
		if ($user_check){
			$data = $this->common->get_default_building($uid);
			//获取默认配送地址的公司id

			//取出此人可以用的优惠券
			$current_time = date('Y-m-d H:i:s');
			$coupon_sql = "select t_coupons_record.*,t_coupons.tc_sale_price,t_coupons.tc_price,t_coupons.tc_start_time,t_coupons.tc_end_time from t_coupons,t_coupons_record where t_coupons.tc_id=t_coupons_record.tcr_tc_id and t_coupons_record.tcr_status= ".COUPON_NOT_USED;
			$coupon_sql.=" and t_coupons.tc_sale_price < '".$goods['total_price']."' and t_coupons.tc_start_time <='".$current_time."' and t_coupons.tc_end_time >='".$current_time."' and t_coupons_record.tcr_uid=".$uid;
			$data['coupons'] = $this->tickets->personal_select($coupon_sql);

			$sql="SELECT t_service_buildings.address as building_address, t_shipping_address .*,t_companys.address as company_address,t_province.province, t_city.city, t_area.area FROM t_service_buildings,t_companys,t_shipping_address, t_city, t_province, t_area WHERE t_shipping_address.tsa_province = t_province.province_id
AND t_shipping_address.tsa_city = t_city.city_id and t_shipping_address.tsa_company = t_companys.id
AND t_shipping_address.tsa_building_id = t_service_buildings.id AND t_shipping_address.tsa_district = t_area.area_id  and t_shipping_address.tsa_uid=".$uid." order by t_shipping_address.tsa_id desc";

			$shipping_address = $this->tickets->personal_select($sql);
			$default_flag = 0;
			foreach($shipping_address as $k=>$v){
				if($tsa_default==1){
					$default_flag = 1;
				}
			}
	//如果只有一个快递地址，则设为默认
			if ($default_flag==0){
				//$this->tickets->update('shipping_address',array('tsa_default'=>0),array('tsa_uid'=>$uid));
				//$this->tickets->update('shipping_address',array('tsa_default'=>1),array('tsa_id'=>$shipping_address[0]->tsa_id));
				$sql="SELECT t_service_buildings.address as building_address, t_shipping_address .*,t_companys.address as company_address,t_province.province, t_city.city, t_area.area FROM t_service_buildings,t_companys,t_shipping_address, t_city, t_province, t_area WHERE t_shipping_address.tsa_province = t_province.province_id
AND t_shipping_address.tsa_city = t_city.city_id and t_shipping_address.tsa_company = t_companys.id
AND tsa_building_id = t_service_buildings.id AND t_shipping_address.tsa_district = t_area.area_id and t_shipping_address.tsa_uid='$uid' order by t_shipping_address.tsa_id desc";


                                $shipping_address = $this->tickets->personal_select($sql);
			}
			$data['shipping_address'] = $shipping_address;
		}


                 //已经解锁20150330
                else{
			$cookie_shipping_id = $this->common->_get_cookie_shipping_id_no_uid();
			if (!$cookie_shipping_id){
				$sql2 ="select t_service_buildings.*, t_province.province, t_city.city, t_area.area FROM t_service_buildings, t_city, t_province, t_area where
		    		t_service_buildings.province_id = t_province.province_id AND t_service_buildings.city_id = t_city.city_id  and t_service_buildings.area_id = t_area.area_id
		    		and t_service_buildings.id = ".$building_id;
				$data['default_building'] = $this->tickets->personal_select($sql2);
			}else{

				$sql="SELECT t_service_buildings.name as building_name, t_shipping_address .*,t_companys.name as company_name,t_province.province, t_city.city, t_area.area FROM t_service_buildings,t_companys,t_shipping_address, t_city, t_province, t_area WHERE t_shipping_address.tsa_province = t_province.province_id
AND t_shipping_address.tsa_city = t_city.city_id and t_shipping_address.tsa_company = t_companys.id
AND t_shipping_address.tsa_building_id = t_service_buildings.id AND t_shipping_address.tsa_district = t_area.area_id  and t_shipping_address.tsa_id in ( ".$cookie_shipping_id['user_cookie_shipping'].")  order by t_shipping_address.tsa_id desc";
				$data['shipping_address'] = $this->tickets->personal_select($sql);
				$data['default_id'] = $cookie_shipping_id['user_cookie_shipping_default'];
			}

			$event = array();
			$data['coupons'] = '';
		}
                    //已经解锁20150330
		$sql2 ="select t_service_buildings.*, t_province.province, t_city.city, t_area.area FROM t_service_buildings, t_city, t_province, t_area where
		    		t_service_buildings.province_id = t_province.province_id AND t_service_buildings.city_id = t_city.city_id  and t_service_buildings.area_id = t_area.area_id
		    		and t_service_buildings.id = ".$building_id;
		$data['default_building'] = $this->tickets->personal_select($sql2);

		$data['company'] = $this->tickets->select('companys',array('service_building_id'=>$building_id));
		$data['uid'] = $uid;
		$data['new_flag'] = 3;
		$data['edit_flag'] = 1;
		$data['event'] = $event;

//判断菜品的配送区域，是否包含此人所选写字楼
	    $invalid_flag = 0;
	  /*  foreach($goods['cart_goods'] as $k=>$v){
	    	$temp_building = $this->tickets->api_select('good_supplier_buildings','id',array('good_id'=>$v['goods']->id,'building_id'=>$default_address[0]->tsa_building_id));
	    	if(!$temp_building){
	    		$invalid_flag = 1;
	    	}
	    }
	    */
	    $data['invalid_flag'] = $invalid_flag;
           
		$data['cookie_count'] = $goods['goods_count'];
		$data['cart_goods'] = $goods['cart_goods'];
		$data['total_count'] = $goods['total_price'];   
		$data['orignal_amount'] = $goods['order_price'];  
        
		$data['payment'] = $this->tickets->select('payment',array('status'=>VALID_STATUS));
		$data['payment_lang'] = $this->common->payment_config();

		$count_config = $this->tickets->select('configs',array('tc_type'=>'order_count'));
		$data['per_count_limit'] = $count_config[0]->tc_title;
		$data['total_count_limit'] = $count_config[0]->tc_content;

//form cookie val
        $data['address_cookie_nickname'] = isset($_COOKIE['address_nickname'])?trim($_COOKIE['address_nickname']):'';
        $data['address_cookie_mobile'] = isset($_COOKIE['address_mobile'])?trim($_COOKIE['address_mobile']):'';
        $data['address_cookie_company'] = isset($_COOKIE['address_company'])?trim($_COOKIE['address_company']):'';
		  $sql="SELECT t_service_buildings.address as building_address, t_shipping_address .*,t_companys.address as company_address,t_province.province, t_city.city, t_area.area FROM t_service_buildings,t_companys,t_shipping_address, t_city, t_province, t_area WHERE t_shipping_address.tsa_province = t_province.province_id
AND t_shipping_address.tsa_city = t_city.city_id and t_shipping_address.tsa_company = t_companys.id
AND tsa_building_id = t_service_buildings.id AND t_shipping_address.tsa_district = t_area.area_id and t_shipping_address.tsa_uid='$uid' and t_shipping_address.tsa_default=1";
		$tsa_id=$this->tickets->personal_select($sql);
		$data["tsa_id"]=$tsa_id[0]->tsa_id;
		$data["this_week_list"] = $this_week_list;
		$data["next_week_list"] = $next_week_list;

                $getWeeks=$this->getWeeks();

                $this->load->view('main/new_header',array('weeks_contorl'=>$getWeeks));
		$this->load->view('main/order_confirm',$data);
	}





//用户退出
    function user_logout(){
    	setcookie('user_cookie','',time()-1,'/');
    	echo json_encode(array('success'=>'yes','msg'=>'退出成功'));exit;
    }


//用户登录
    function user_login(){

    	$mobile_email = $this->input->get_post('mobile_email');
    	$password = trim($this->input->get_post('password'));
    	//$login_type = trim($_POST['login_type']);
    	$remember_flag = $this->input->get_post('remember_flag');
    	$remember_flag = isset($remember_flag)? $remember_flag : '';
    	$mobile_check = $this->tickets->select('users',array('tu_mobile'=>$mobile_email));
    	$email_check = $this->tickets->select('users',array('tu_email'=>$mobile_email));

    	$callback = $this->input->get('callback');
    	   	//echo 555;exit;
    	if((!$mobile_check)&&(!$email_check)){
			if($_POST['check']==0){
				$result = json_encode(array('success'=>'no','msg'=>'手机号不存在'));
				if ($callback) {
					echo $callback.'('.$result.')';exit;
				} else {
					echo $result;exit;
				}
			}else{
				$result = json_encode(array('success'=>'no','msg'=>'邮件或手机号不存在'));
				if ($callback) {
					echo $callback.'('.$result.')';exit;
				} else {
					echo $result;exit;
				};
			}

    	}

    	if($mobile_check){
    		$user = $mobile_check[0];
    	}
    	if($email_check){
    		$user = $email_check[0];
    	}

    	$md5_password = md5(md5('xiaoshu'.$password));
    	if($md5_password != $user->tu_password){
    		$result = json_encode(array('success'=>'no','msg'=>'密码错误'));
    		if ($callback) {
    			echo $callback.'('.$result.')';exit;
    		} else {
    			echo $result;exit;
    		}
    	}


    	setcookie('user_cookie',serialize($user),time()+3600*24*365,'/',".xiaoshuhaochi.com");
    	setcookie('remember_password',$remember_flag,time()+3600*24*365,'/',".xiaoshuhaochi.com");
		if($_POST['mobile_email']==0){


		}
    	$result = json_encode(array('success'=>'yes','msg'=>'登陆成功'));
    	if ($callback) {
    		echo $callback.'('.$result.')';exit;
    	} else {
    		echo $result;exit;
    	}
    }



    //找回密码
    function get_user_password(){
    	$mobile_email = trim($_POST['mobile_email']);
    	$password = trim($_POST['password']);
    	$captcha = trim($_POST['captcha']);
    	$mobile_check = $this->tickets->select('users',array('tu_mobile'=>$mobile_email));
    	if(!$mobile_check){
    		echo json_encode(array('success'=>'no','msg'=>'手机号码不存在'));exit;
    	}
    	$uid = $mobile_check[0]->tu_id;
    	$verify_result = $this->check_mobile_code($mobile_email,$captcha);
    	if ($verify_result){
    		$user_data = array(
    			'tu_password'=>md5(md5('xiaoshu'.$password))
    		);
    		$this->tickets->update('users',$user_data,array('tu_id'=>$uid));
    		$temp_user = $this->tickets->select('users',array('tu_id'=>$uid));
    		setcookie('user_cookie',serialize($temp_user[0]),time()+3600*24,'/');
    		echo json_encode(array('success'=>'yes','msg'=>'操作成功'));exit;
    	}else{
    		echo json_encode(array('success'=>'no','msg'=>'操作失败'));exit;
    	}

    }



    //新用户注册
    function user_register(){
    	$reg_type = intval($_POST['reg_type']);
    	$mobile_email = trim($_POST['mobile_email']);
    	$password = trim($_POST['password']);
    	$user_data = array(
    			'tu_password'=>md5(md5('xiaoshu'.$password)),
                        'tu_created'=>date("Y-m-d H:i:s")
    	);
    	if(!$reg_type){
    		$captcha = trim($_POST['captcha']);
    		$verify_result = $this->check_mobile_code($mobile_email,$captcha);
    		if ($verify_result){
    			$user_data['tu_mobile'] = $mobile_email;
    		}

    		$user_check = $this->tickets->select('users',array('tu_mobile'=>$mobile_email));
    		if($user_check){
    			echo json_encode(array('success'=>'no','msg'=>'此手机已经注册过'));exit;
    		}
    	}else{
    		$user_data['tu_email'] = $mobile_email;
    		$user_check = $this->tickets->select('users',array('tu_email'=>$mobile_email));
    		if($user_check){
    			echo json_encode(array('success'=>'no','msg'=>'此电子邮件已经注册过'));exit;
    		}
    	}

    	$result = $this->tickets->insert('users',$user_data);
    	if($result){
    		$temp_user = $this->tickets->select('users',array('tu_id'=>$result));
    		setcookie('user_cookie',serialize($temp_user[0]),time()+3600*24,'/', ".xiaoshuhaochi.com");
    		echo json_encode(array('success'=>'yes','msg'=>'注册成功'));exit;
    	}else{
    		echo json_encode(array('success'=>'no','msg'=>'注册失败'));exit;
    	}
    }



    //验证验证码
    function check_mobile_code($mobile,$code){

    	$check_time = strtotime("-10 min");
    	//检测验证码是否有效
    	$check = $this->tickets->select('mobile_codes',array('tmc_mobile'=>$mobile,'tmc_created >='=>$check_time));
    	if (!$check){
    		$r = array('success'=>'no','msg'=>'验证码失效');

    	}else{

    		if($check[0]->tmc_code == $code){
    			return true;

    		}else{

    			$r = array('success'=>'no','msg'=>'验证码错误');
    		}
    	}
    	echo json_encode($r);exit;
    }

    //发送手机消息
    function send_mobile_sms(){
		if($_POST["check"]==0){
			$check=0;
		}else{
			$check=1;
		}
    	$find_password_flag = $this->uri->segment(3);
    	$mobile = trim($_POST['mobile']);
    	//先判断此电话是否被别人使用
    	$uid = isset($_COOKIE['cooke_uid'])?$_COOKIE['cooke_uid']:'';
	    if(!$find_password_flag&&$check==1){
	    	$user_check = $this->tickets->select('users',array('tu_mobile'=>$mobile));
	    	if($user_check){
	    		echo json_encode(array('success'=>'used','msg'=>'此手机已经注册过'));exit;
	    	}
	    }else if($find_password_flag == 1&&$check==1){
	    	$uid = $this->_get_uid();
	    	$user_check = $this->tickets->select('users',array('tu_mobile'=>$mobile));
	    	if($user_check&&($user_check[0]->tu_id != $uid)){
	    		echo json_encode(array('success'=>'used','msg'=>'此手机已经注册过'));exit;
	    	}
	    }else if($find_password_flag == 2){
	    	$user_check = $this->tickets->select('users',array('tu_mobile'=>$mobile));
	    	if(!$user_check){
	    		echo json_encode(array('success'=>'no','msg'=>'此手机不存在'));exit;
	    	}
	    }

    	$check_time = strtotime("-1 min");
    	$sms_check = $this->tickets->select('mobile_codes',array('tmc_mobile'=>$mobile,'tmc_created >='=>$check_time));
    	if ($sms_check){
    		$r = array('success'=>'no','msg'=>'请1分钟后再试！');

    		echo json_encode($r);exit;
    	}else{
    		$this->tickets->delete('mobile_codes',array('tmc_mobile'=>$mobile));
    	}
    	$code = $this->common->_generate_code(6);
    	$msg_template = "【小树好吃】您的验证码是：".$code;//$msg[0]->tc_content;

    	$sms = $this->common->send_sms($mobile,$msg_template);
        if(!$sms){
        	$msg = array('success'=>'no','msg'=>'发送失败');

        }else{
	    	$code_data = array('tmc_mobile'=>$mobile,'tmc_code'=>$code,'tmc_created'=>time());
	    	$this->tickets->insert('mobile_codes',$code_data);

	    	$msg = array('success'=>'yes','msg'=>'发送成功');
        }

    	echo json_encode($msg);exit;
    }


	//生成兑换码
	function general_codes(){
		ini_set('display_errors','On');
		header("Content-type: text/html; charset=utf-8");
		$tc_id = $this->uri->segment(3);
		$day = $this->uri->segment(4);
		$coupons = $this->tickets->select('coupons',array('tc_id'=>$tc_id));
		if (!$coupons){
			echo json_encode(array('success'=>'no'));
		}
		$coupon = $coupons[0];
		$valid_time = date('Y-m-d H:i:s',strtotime('+ '.$day.' days'));
		$str = "面值,有效期,兑换有效期,兑换码\n";
		$str = iconv('utf-8','gb2312',$str);
		for($i=0;$i<50;$i++){
			$code = $this->_rand_num(2).date('His').$this->_rand_num(2);

			$da = array('tcc_tc_id'=>$tc_id,'tcc_codes'=>$code,'tcc_created'=>date('Y-m-d H:i:s'),'tcc_valid_time'=>$valid_time);
			$this->tickets->insert('coupons_codes',$da);
			$str.=$coupon->tc_price.",".$coupon->tc_end_time.",".$valid_time.",".$code."\n";
		}
		$name = 'export\/codes'.date('Ymd').'.csv';
		$this->export_csv($name,$str);


	}


	function export_csv($filename,$data)
	{

		header("Content-Type: application/vnd.ms-excel;harset=GB2312");
		header("Content-Disposition:attachment;filename=".$filename);
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
		header('Expires:0');
		header('Pragma:public');
		echo $data;
	}


	function _rand_num($i){

		$str='';
		for($j=0;$j<$i;$j++){
			$str.=rand(1,9);
		}
		return $str;
	}


	function auto_service(){
		$this->top();
		$user = $this->session->userdata('user');
		$uid = $user[0]->m_id;

		if ($_POST){
			$dat = array(
					'tas_title'=>trim($_POST['tas_title']),
					'tas_image'=>trim($_POST['tas_image']),
					'tas_intro'=>trim($_POST['tas_intro']),
					'tas_url'=>trim($_POST['tas_url']),
					'tas_uid'=>$uid,
					'createtime'=>date('Y-m-d H:i:s')
			);
			$check = $this->tickets->select('auto_service');

			if ($check){
				$re = $this->tickets->update('auto_service',$dat,array('tas_uid'=>$uid));
			}else{
				$re = $this->tickets->insert('auto_service',$dat);
			}

			if ($re){
				$r = array('success'=>'yes');
			}else{
				$r = array('success'=>'no');
			}
			echo json_encode($r);exit;

		}else{
			$this->top();
			$data['member'] = $user[0];
			$auto_service = $this->tickets->select('auto_service');
			if($auto_service){
				$data['auto_service'] = json_encode($auto_service);
				$data['service'] = $auto_service[0];
			}else{
				$data['service'] = '';
				$data['auto_service'] = '';
			}
			$this->load->view('main/auto_service',$data);
		}
	}



	function check_enable(){
		$type = trim($_POST['type']);
		$check_enable = intval($_POST['enable_check']);
		if ($check_enable){
			$uncheck = '0';
		}else{
			$uncheck = '1';
		}

		if ($type == 'single'){
			$this->tickets->update('materials',array('tm_enable'=>$check_enable),array('tm_status'=>'1'));
			$this->tickets->update('materials',array('tm_enable'=>$uncheck),array('tm_status'=>'0'));
		}else{
			$this->tickets->update('materials',array('tm_enable'=>$check_enable),array('tm_status'=>'0'));
			$this->tickets->update('materials',array('tm_enable'=>$uncheck),array('tm_status'=>'1'));
		}

		echo json_encode(array('success'=>'yes'));exit;
	}


	function multiply_list(){
		$this->top();
		$page = $this->uri->segment(3);
		$user = $this->session->userdata('user');
		$uid = $user[0]->m_id;
		if($_POST){
			$title = trim($_POST['title']);
			$this->session->set_userdata('material_list_title',$title);
			echo json_encode(array('success'=>'yes'));exit;
		}

		$title = $this->session->userdata('material_list_title');

		$data['title'] = $title;
		$where = "tm_status = 0 ";
		$like = array();
		if ($title){
			$like['tm_title'] = $title;
			$where .= " and tm_title like '%".$title."%'";
		}

		if($page==""){
			$page=1;
		}
		$perpage=20;
		$start = ($page-1)*$perpage;
		$end   = $page*$perpage;
		$end--;


		$order = array('tm_id'=>'asc');

		$sql = "select distinct tm_keyword from t_materials where ".$where." order by tm_id asc";
		$material = $this->tickets->personal_select($sql);

		$total = count($material);
		$data['total'] = ceil($total/$perpage);
		$data['start']=$start;
		$data['current_page'] = $page;
		$materials = array();
		if($material){
			for ($i=$start;$i<$end;$i++){
				if ($i<$total){
					$sql = "select * from t_materials where tm_keyword='".$material[$i]->tm_keyword."' order by tm_id asc limit 1";
					$material_temp = $this->tickets->personal_select($sql);
					$materials[]=$material_temp[0];
				}
			}
		}
		$data['materials'] = $materials;
		$this->load->view('main/multiply_list',$data);

	}



	function  multiply_materials(){
		$this->top();
		$user = $this->session->userdata('user');
		$uid = $user[0]->m_id;
		if ($_POST){
			$pos = json_decode($_POST['jsonData']);
			$keyword = trim($_POST['keywords']);
			$tm_id = intval($_POST['tm_id']);

			$cond = array('tm_keyword'=>$keyword);

			$materials = $this->tickets->select('materials',$cond);

			if ($materials){
				$ids = array();
				foreach ($materials as $key=>$val){
					$ids[] = $val->tm_id;
				}
			    if (!empty($ids)&&!in_array($tm_id,$ids)){
			    	echo json_encode(array('success'=>'no','msg'=>'关键字已被使用'));
			    	exit;
			    }else if(empty($tm_id)){

			    	echo json_encode(array('success'=>'no','msg'=>'关键字已被使用'));
			    	exit;
			    }else{
			    	$cond['tm_status'] = '0';
			    	$this->tickets->delete('materials',$cond);
			    }

			}


			foreach ($pos as $k=>$val){
				$post = (array)$val;
				$data = array(
						'tm_title'=>trim($post['title']),
						'tm_content'=>trim($post['content']),
						'tm_source_url'=>trim($post['sourceurl']),
						'tm_coverurl'=>trim($post['cover']),
						'tm_createtime'=>date('Y-m-d H:i:s'),
						'tm_uid'=>$uid,
						'tm_status'=>'0',
						'tm_keyword'=>$keyword
				);


				$re = $this->tickets->insert('materials',$data);


			}
			if ($re){
				$r = array('success'=>'yes');
			}else{
				$r = array('success'=>'no');
			}
			echo json_encode($r);exit;

		}else{
			$tm_id = $this->uri->segment(3);
			$cond = array();
			if ($tm_id){
				$co = $this->tickets->select('materials',array('tm_id'=>$tm_id));
			    $keyword = $co[0]->tm_keyword;
				$cond['tm_keyword'] = $keyword;
			    $cond['tm_status'] = '0';
			    $order['tm_id'] = 'asc';
				$materials = $this->tickets->select('materials',$cond,'','','',$order);
			}else{
				$materials = '';
			}
			if($materials){
				$data['materials'] = $materials;
				$data['m_count'] = count($materials);
			}else{
				$data['materials'] = '';
			}


			$this->load->view('main/multiply_materials',$data);
		}
	}


	function reset_password(){
		$user=$this->session->userdata('user');

		if ($_POST){

			$password=md5($_REQUEST['password']);//原始密码
			$newpassword=md5($_REQUEST['newpassword']);   	//新密码
			if($user[0]->password===trim($password)){
				$username=trim($user[0]->username);//用户名

				$res=$this->tickets->update('members',array('password'=>$newpassword),array('m_id'=>$user[0]->m_id));
				if($res){
					$result=array('success'=>'yes');
				} else {
					$result=array('success'=>'no');
				}
			}else{
				$result=array('error'=>'pwd');
			}
			echo json_encode($result);exit;

		}else{

			if($user!=""){
				$data['user'] = $user[0];
			}
			$this->load->view('admin/reset_password',$data);
		}
	}


function single_list(){
		$page = $this->uri->segment(3);
		$user = $this->session->userdata('user');
		$uid = $user[0]->m_id;

		if($page==""){
			$page=1;
		}
		$perpage=20;
		$start = ($page-1)*$perpage;
		$cond = array('tm_status'=>'1');
		$order = array('tm_id'=>'desc');

		$material = $this->tickets->select('materials',$cond,'','','','');
		$total = count($material);
		$data['total'] = ceil($total/$perpage);
		$data['start']=$start;
		$data['current_page'] = $page;
		$materials = $this->tickets->select('materials',$cond,$perpage,$start,'',$order);

		$data['materials'] = $materials;
		$this->load->view('main/single_list',$data);
	}


function single_text(){
		$page = $this->uri->segment(3);
		$user = $this->session->userdata('user');
		$uid = $user[0]->m_id;

		if($page==""){
			$page=1;
		}
		$perpage=20;
		$start = ($page-1)*$perpage;
		$cond = array('tm_status'=>'2');
		$order = array('tm_id'=>'desc');

		$material = $this->tickets->select('materials',$cond,'','','','');
		$total = count($material);
		$data['total'] = ceil($total/$perpage);
		$data['start']=$start;
		$data['current_page'] = $page;
		$materials = $this->tickets->select('materials',$cond,$perpage,$start,'',$order);

		$data['materials'] = $materials;
		$this->load->view('main/single_text',$data);
	}




	function single_material(){
		$user = $this->session->userdata('user');
		$uid = $user[0]->m_id;
		if ($_POST){
			$materials = $this->tickets->select('materials',array('tm_keyword'=>trim($_POST['keywords'])));
			$tm_id = intval($_POST['m_id']);
			if ($materials){

				if ($tm_id){
					if($materials[0]->tm_id != $tm_id){
						echo json_encode(array('success'=>'no','msg'=>'关键字已被使用'));
						exit;
					}
				}else{
					echo json_encode(array('success'=>'no','msg'=>'关键字已被使用'));
					exit;
				}
			}

			$data = array(
					'tm_title'=>trim($_POST['title']),
					'tm_content'=>trim($_POST['maincontent']),
					'tm_source_url'=>trim($_POST['source_url']),
					'tm_coverurl'=>trim($_POST['coverurl']),
					'tm_summary'=>trim($_POST['summary']),
					'tm_createtime'=>date('Y-m-d H:i:s'),
					'tm_keyword'=>trim($_POST['keywords']),
					'tm_status'=>'1',
					'tm_uid'=>$uid
			);
			if ($tm_id){
				$re = $this->tickets->update('materials',$data,array('tm_status'=>'1','tm_id'=>$tm_id));
			}else{

				$re = $this->tickets->insert('materials',$data);

			}
			if ($re){
				$r = array('success'=>'yes','msg'=>'操作成功');
			}else{
				$r = array('success'=>'no');
			}
			echo json_encode($r);exit;


		}else {
			$tm_id = $this->uri->segment(3);
			$data = array();
			$cond = array();
			if ($tm_id){
				$cond['tm_id'] = $tm_id;
			}
			$material = $this->tickets->select('materials',$cond);
			if ($tm_id){
				$material = $material[0];
			}else{
				$material = '';
			}
			$data['material'] = $material;
			$this->load->view('main/single_materials',$data);
		}
	}

	function single_material_text(){
		$user = $this->session->userdata('user');
		$uid = $user[0]->m_id;
		if ($_POST){
			$materials = $this->tickets->select('materials',array('tm_keyword'=>trim($_POST['keywords'])));
			$tm_id = intval($_POST['m_id']);
			if ($materials){

				if ($tm_id){
					if($materials[0]->tm_id != $tm_id){
						echo json_encode(array('success'=>'no','msg'=>'关键字已被使用'));
						exit;
					}
				}else{
					echo json_encode(array('success'=>'no','msg'=>'关键字已被使用'));
					exit;
				}
			}

			$data = array(
					'tm_title'=>trim($_POST['title']),
					'tm_content'=>trim($_POST['maincontent']),
					'tm_source_url'=>"",
					'tm_coverurl'=>"",
					'tm_summary'=>"",
					'tm_createtime'=>date('Y-m-d H:i:s'),
					'tm_keyword'=>trim($_POST['keywords']),
					'tm_status'=>'2',
					'tm_uid'=>$uid
			);
			if ($tm_id){
				$re = $this->tickets->update('materials',$data,array('tm_status'=>'2','tm_id'=>$tm_id));
			}else{

				$re = $this->tickets->insert('materials',$data);

			}
			if ($re){
				$r = array('success'=>'yes','msg'=>'操作成功');
			}else{
				$r = array('success'=>'no');
			}
			echo json_encode($r);exit;


		}else {
			$tm_id = $this->uri->segment(3);
			$data = array();
			$cond = array();
			if ($tm_id){
				$cond['tm_id'] = $tm_id;
			}
			$material = $this->tickets->select('materials',$cond);
			if ($tm_id){
				$material = $material[0];
			}else{
				$material = '';
			}
			$data['material'] = $material;
			$this->load->view('main/single_materials_text',$data);
		}
	}

	function material_delete(){
		$type = trim($this->uri->segment(3));
		$tm_id = trim($this->uri->segment(4));
		if ($type=="single"){
			$cond = array('tm_id'=>$tm_id);
		}else{
			$co = $this->tickets->select('materials',array('tm_id'=>$tm_id));
		    $tm_id = $co[0]->tm_keyword;

			$cond = array('tm_keyword'=>$tm_id);
		}

		$result = $this->tickets->delete("materials",$cond);
		if($result){
			redirect('/main/'.$type.'_list');
		}
	}




	function check_member_login(){
		$user = $this->session->userdata('member_session');
		if($user==""){
			echo json_encode(array('success'=>'no'));exit;
		}else{
			print_r($user);exit;
		}
	}





	function top(){
		$user = $this->session->userdata('user');

		if($user==""){
			//直接跳转到登录页面
			redirect('admin/login');exit;
		}
	}



//获取用户默认的写字楼cookie
	/*function _get_cookie_building(){
		$user_cookie = isset($_COOKIE['user_building_cookie'])?$_COOKIE['user_building_cookie']:'';
		if ($user_cookie) {
			return $user_cookie;
		}else{
			redirect('/main/default_index');
		}
	}*/




	//获取用户uid
	function _get_uid(){
		$user_cookie = isset($_COOKIE['user_cookie'])?$_COOKIE['user_cookie']:'';

		if($user_cookie){
			$user_cookie = unserialize($user_cookie);
			return $user_cookie->tu_id;
		}else{

			$temp_user_data = array('tu_user_type'=>1,'tu_created'=>date('Y-m-d H:i:s'),'tu_nickname'=>'游客');
			$result = $this->tickets->insert('users',$temp_user_data);
			$user = $this->tickets->select('users',array('tu_id'=>$result));
			setcookie('user_cookie',serialize($user[0]),time()+3600*24,'/');
			return $result;
		}
	}

	function first(){
		$this->load->view('main/first');
	}
 function getWeeks(){
        $day_now=date("w");
        $week_day=date("Y/m/d");
       if($day_now=="1"){
            $this_mon= date("m/d");
            $this_fri=date("m/d",  strtotime("+4 day"));
            $next_mon=date("m/d",strtotime("+7 day"));
            $next_fri=date("m/d",strtotime("+11 day"));
        }else if($day_now==2){
            $this_mon= date("m/d", strtotime("-1 day"));
            $this_fri=date("m/d",  strtotime("+3 day"));
             $next_mon=date("m/d",strtotime("+6 day"));
            $next_fri=date("m/d",strtotime("+10 day"));
        }else if($day_now==3){
            $this_mon= date("m/d", strtotime("-2 day"));
            $this_fri=date("m/d",  strtotime("+2 day"));
             $next_mon=date("m/d",strtotime("+5 day"));
            $next_fri=date("m/d",strtotime("+9 day"));
        }else if($day_now==4){
            $this_mon= date("m/d", strtotime("-3 day"));
            $this_fri=date("m/d",  strtotime("+1 day"));
             $next_mon=date("m/d",strtotime("+4 day"));
            $next_fri=date("m/d",strtotime("+8 day"));
        }else if($day_now==5){
            $this_mon= date("m/d", strtotime("-4 day"));
            $this_fri=date("m/d");
              $next_mon=date("m/d",strtotime("+3 day"));
            $next_fri=date("m/d",strtotime("+7  day"));
        }else if($day_now==6){
            $this_mon= date("m/d", strtotime("-5 day"));
            $this_fri=date("m/d",  strtotime("-1 day"));
              $next_mon=date("m/d",strtotime("+2 day"));
            $next_fri=date("m/d",strtotime("+6  day"));
        }else if($day_now==0){
            $this_mon= date("m/d", strtotime("-6 day"));
            $this_fri=date("m/d",  strtotime("-2 day"));
              $next_mon=date("m/d",strtotime("+1 day"));
            $next_fri=date("m/d",strtotime("+5  day"));
        }

        return array(array($this_mon,$this_fri),array($next_mon,$next_fri));
    }
     function chang_pay_way(){
         $pay_way=$this->input->post("pay_way");
         $order_sn=$this->input->post("order_sn");
    
         $res=$this->db->update("t_orders",array("to_pay_way"=>$pay_way),array("to_order_sn"=>$order_sn));
         if ($res) {
             echo json_encode(array("success"=>"yes", "msg"=>$pay_way));
         }else { 
             echo json_encode(array("success"=>"no",  "mgs"=>"系统错误请联系管理员"));
         }
    }
}
