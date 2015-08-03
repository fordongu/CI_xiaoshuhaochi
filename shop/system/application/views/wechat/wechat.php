<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class wechat extends Controller {

	function __construct()
	{
		parent::__construct();	
		$this->load->library('zip'); 
		$this->load->model('tickets'); 
		$this->load->model('common');
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
		define('WECHAT_ORDER',1);
		ini_set('display_errors','On');
		define('EVENT_BUILDING',4);
	}
	
	
//confirm_step1
    function confirm_step_one(){
    	$goods = $this->common->_get_cookie_good_detail('wechat',array());
    	 
    	$data['cookie_count'] = $goods['cookie_count'];
    	$cart_goods = $goods['cart_goods'];
    
    	$data['total_count'] = $goods['total_count'];
    	$data['orignal_amount'] = $goods['orignal_amount'];
    	$count_config = $this->tickets->select('configs',array('tc_type'=>'order_count'));
    	
    	
    	$event_building_id = 0;
    	$event_building_check = $this->tickets->api_select('service_buildings','id',array('status'=>EVENT_BUILDING));
    	if ($event_building_check&&$event_building_check[0]->id){
    		$event_building_id = $event_building_check[0]->id;
    		 
    	} 
    	foreach($cart_goods as $k=>$v){
    		$building_id_temp = $v['week_count']['building_id'];
    		$per_count_limit = $count_config[0]->tc_title;
			/*
    		if ($event_building_id&&($building_id_temp==$event_building_id)){
    			$per_count_limit = 3; 
    		}   
			*/
    		$cart_goods[$k]['goods']->per_count_limit = $per_count_limit;
    	 
    	}
    	 
    	$data['per_count_limit'] = $per_count_limit; 
    	$data['total_count_limit'] = $count_config[0]->tc_content;
		
    	$data['cart_goods'] = $cart_goods;
    	$this->load->view('wechat/confirm_step_one',$data);
    }	
	

    
 //confirm_step_two   
	function confirm_step_two(){
   
		$building_id = $this->_get_cookie_building();
		$user = $this->get_uid('/wechat/confirm_step_two');
		$uid = $user->tu_id; 
		 
		//判断是否活动写字楼
		$event_building_check = $this->tickets->api_select('service_buildings','id',array('status'=>EVENT_BUILDING));
		$event_building_flag = 0;
		
		if($event_building_check&&($event_building_check[0]->id==$building_id)){
			$event_building_flag = 1;
		}
		$data['event_building_flag'] = $event_building_flag;
		if($event_building_flag){
	
		$sql="SELECT t_service_buildings.name as building_name, t_shipping_address .*,t_companys.name as company_name,t_province.province, t_city.city, t_area.area FROM t_service_buildings,t_companys,t_shipping_address, t_city, t_province, t_area WHERE t_shipping_address.tsa_province = t_province.province_id
AND t_shipping_address.tsa_city = t_city.city_id and t_shipping_address.tsa_company = t_companys.id
AND t_shipping_address.tsa_building_id = t_service_buildings.id AND t_shipping_address.tsa_district = t_area.area_id   and t_shipping_address.tsa_uid=".$uid." order by t_shipping_address.tsa_id desc limit 1";
			 
		}else{
		$sql="SELECT t_service_buildings.name as building_name, t_shipping_address .*,t_companys.name as company_name,t_province.province, t_city.city, t_area.area FROM t_service_buildings,t_companys,t_shipping_address, t_city, t_province, t_area WHERE t_shipping_address.tsa_province = t_province.province_id
AND t_shipping_address.tsa_city = t_city.city_id and t_shipping_address.tsa_company = t_companys.id
AND t_shipping_address.tsa_building_id = t_service_buildings.id AND t_shipping_address.tsa_district = t_area.area_id  and t_shipping_address.tsa_building_id = ".$building_id." and t_shipping_address.tsa_uid=".$uid." order by t_shipping_address.tsa_id desc"; 
		 
		}
	 
		$shipping_address = $this->tickets->personal_select($sql);
	    //如果只有一个快递地址，则设为默认
		$default_flag = 0;
			foreach($shipping_address as $k=>$v){
				if($v->tsa_default==1){
					$default_flag = 1;
				}
			}
	//如果只有一个快递地址，则设为默认		
			if ($default_flag==0){
			//$this->tickets->update('shipping_address',array('tsa_default'=>0),array('tsa_uid'=>$uid));	
	    	//$this->tickets->update('shipping_address',array('tsa_default'=>1),array('tsa_id'=>$shipping_address[0]->tsa_id));
	    //	if($event_building_flag){
	    		$sql="SELECT t_service_buildings.name as building_name, t_shipping_address .*,t_companys.name as company_name,t_province.province, t_city.city, t_area.area FROM t_service_buildings,t_companys,t_shipping_address, t_city, t_province, t_area WHERE t_shipping_address.tsa_province = t_province.province_id
AND t_shipping_address.tsa_city = t_city.city_id and t_shipping_address.tsa_company = t_companys.id
AND t_shipping_address.tsa_building_id = t_service_buildings.id AND t_shipping_address.tsa_district = t_area.area_id  and t_shipping_address.tsa_uid=".$uid." order by t_shipping_address.tsa_id desc";
	    //	}else{
	    	/*$sql="SELECT t_service_buildings.name as building_name, t_shipping_address .*,t_companys.name as company_name,t_province.province, t_city.city, t_area.area FROM t_service_buildings,t_companys,t_shipping_address, t_city, t_province, t_area WHERE t_shipping_address.tsa_province = t_province.province_id
AND t_shipping_address.tsa_city = t_city.city_id and t_shipping_address.tsa_company = t_companys.id
AND t_shipping_address.tsa_building_id = t_service_buildings.id AND t_shipping_address.tsa_district = t_area.area_id  and t_shipping_address.tsa_building_id = ".$building_id." and t_shipping_address.tsa_uid=".$uid." order by t_shipping_address.tsa_id desc";
	    	}*/
	    	$shipping_address = $this->tickets->personal_select($sql);
	  //  }
	  
	    $data['shipping_address'] = $shipping_address;
	    
		
	    $sql2 ="select t_service_buildings.*, t_province.province, t_city.city, t_area.area FROM t_service_buildings, t_city, t_province, t_area where 
	    		t_service_buildings.province_id = t_province.province_id AND t_service_buildings.city_id = t_city.city_id  and t_service_buildings.area_id = t_area.area_id
	    		and t_service_buildings.id = ".$building_id;
	    $data['default_building'] = $this->tickets->personal_select($sql2);
	    
	    $data['default_building_flag'] = $this->tickets->api_select('shipping_address','tsa_id',array('tsa_uid'=>$uid,'tsa_default'=>1));
	    $data['company'] = $this->tickets->select('companys',array('service_building_id'=>$building_id));
	    $data['uid'] = $uid;
	    $data['new_flag'] = 3;
	    $data['edit_flag'] = 1;

	    $goods = $this->common->_get_cookie_good_detail('wechat',array());
	    
	    $data['cookie_count'] = $goods['cookie_count'];
	    $data['cart_goods'] = $goods['cart_goods'];
	    $data['total_count'] = $goods['total_count'];
	    $data['orignal_amount'] = $goods['orignal_amount'];

	    $area = $this->tickets->select('area',array('status'=>1));
	    $data['area'] = $area;
	    $data['service_buildings'] = $this->tickets->select('service_buildings',array('area_id'=>$area[0]->area_id,'user_shipping'=>0));
	    $this->load->view('wechat/confirm_step_two',$data);
	}
	
	
	
//confirm_step_three
    function confirm_step_three(){
    	
         $user = $this->get_uid('/wechat/confirm_step_three');
    	 $uid = $user->tu_id; 
     
    	$goods = $this->common->_get_cookie_good_detail('wechat',array());
    	 
    	$data['cookie_count'] = $goods['cookie_count'];
    	$data['cart_goods'] = $goods['cart_goods'];
    	$data['total_count'] = $goods['total_count'];
    	$data['orignal_amount'] = $goods['orignal_amount'];
    	
    	$pay_where = array('status'=>VALID_STATUS); 
    	$data['payment'] = $this->tickets->select('payment',$pay_where);    		
    	$data['payment_lang'] = $this->common->payment_config();
    	
    	//取出此人可以用的优惠券
    	$current_time = date('Y-m-d H:i:s');
    	$coupon_sql = "select t_coupons_record.*,t_coupons.tc_sale_price,t_coupons.tc_price,t_coupons.tc_title,t_coupons.tc_start_time,t_coupons.tc_end_time from t_coupons,t_coupons_record where t_coupons.tc_id=t_coupons_record.tcr_tc_id and t_coupons_record.tcr_status= ".COUPON_NOT_USED;
    	$coupon_sql.=" and t_coupons.tc_sale_price < '".$goods['total_count']."' and t_coupons.tc_start_time <='".$current_time."' and t_coupons.tc_end_time >='".$current_time."' and t_coupons_record.tcr_uid=".$uid;
    	$data['coupons'] = $this->tickets->personal_select($coupon_sql);
    	
    	$data['coupon_lang'] = $this->common->coupons_types();
    	 
    	$this->load->view('wechat/confirm_step_three',$data);
    }
	
	
	
	function _get_cookie_building(){
		$event_building_flag = isset($_COOKIE['event_user_building_cookie'])?$_COOKIE['event_user_building_cookie']:0;
		//查看是否有活动写字楼
		$event_building_check = $this->tickets->api_select('service_buildings','id',array('status'=>EVENT_BUILDING));
		if ($event_building_check&&(!$event_building_flag)){
			$event_building_id = $event_building_check[0]->id;
			setcookie('user_building_cookie',$event_building_id,time()+3600*24*30,'/');
			return $event_building_id;
		}
		
		$user_cookie = isset($_COOKIE['user_building_cookie'])?$_COOKIE['user_building_cookie']:'';
		if ($user_cookie) {
			return $user_cookie;
		}else{
			return 0;//redirect('/main/default_index');
		}
	}
	
	
	
	function index(){
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
		$data['service_buildings'] = $this->tickets->select('service_buildings',array('area_id'=>$area[0]->area_id,'user_shipping'=>0)); 
		$data['building_flag'] = $building_flag;
	//service_building_end	
	//get_service_goods
		$weeks = $this->common->_get_valid_weeks();
 
		$cookie_cart = $this->common->_get_cookie_cart();
		//$user = $this->get_uid('/wechat/index');
		//$uid = $user->tu_id;
	  	   
		$data['uid'] = $uid;
		 
		$data['cookie_good'] = $cookie_cart['cookie_cart'];
		$data['cookie_count'] = $cookie_cart['cookie_count'];
		  
		$service_datas = $this->common->_get_all_valid_buildings($building_id);
		if(!$service_datas['final_goods']){
			//redirect('/wechat/index');exit;
		}
		
		$data['goods'] = $service_datas['final_goods'];
		 
			
		$data['weeks'] = common_weeks();
		$data['week_orders'] = $weeks;
		//获取每个商品和每个订单菜品总份数限制
		$count_config = $this->tickets->select('configs',array('tc_type'=>'order_count'));
		$per_count_limit = $count_config[0]->tc_title;
		$total_count_limit = $count_config[0]->tc_content;
		
		$event_building_check = $this->tickets->api_select('service_buildings','id',array('status'=>EVENT_BUILDING));
		
               /*if ($event_building_check&&($event_building_check[0]->id==$building_id)){
			$per_count_limit = 20; 
		}*/
		
		$data['per_count_limit'] = $per_count_limit;
		$data['total_count_limit'] = $total_count_limit;
		
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
		 
		$this->load->view('wechat/index',$data);
	}
 
	
	function scroll(){
		$this->load->view('wechat/scroll');
	}
	
	
	//我的账户
	function member_account(){
		$user = $this->get_uid('/wechat/member_account');
   		$uid = $user->tu_id; 
		$data = $this->_get_order_coupons($uid);
		$data['wallet'] = $this->tickets->select('wallet',array('tw_uid'=>$uid));
		$data['wallet_data'] = $this->tickets->select('wallet_history',array('order_uid'=>$uid),'','','',array('id'=>'desc'));
		$this->load->view('wechat/member_account',$data);
	
	}
	 
	 
	//积分
	function member_score(){
		$user = $this->get_uid('/wechat/member_score');
   		$uid = $user->tu_id; 
   		$data = $this->_get_order_coupons($uid);
		$data['score_data'] = $this->tickets->select('score_data',array('uid'=>$uid),'','','',array('id'=>'desc'));
		$this->load->view('wechat/member_score',$data);
	}
	
	
	
	
//查看没有支付的订单和优惠券	
	function _get_order_coupons($uid){
		$order = $this->tickets->select_count_where('orders',array('to_uid'=>$uid,'to_status'=>ORDER_NOT_PAYED));  
		$coupon = $this->tickets->select_count_where('coupons_record',array('tcr_uid'=>$uid,'tcr_status'=>COUPON_NOT_USED));
		return  array('order_count'=>$order,'coupon_count'=>$coupon);
	}
	
	

	function material_view(){
		$m_id = $_GET['tm_id'];
		$material = $this->tickets->select('materials',array('tm_id'=>$m_id));
		$data['material'] = $material[0];
		$this->load->view('wechat/material_view',$data);
	}
	
	
//优惠券
   function member_coupons(){
   	$flag = $this->uri->segment(3);
   	if (!$flag){
   		//setcookie('user_cookie','',time()+3600*24,'/');
   	}
   	
   	$user = $this->get_uid('/wechat/member_coupons');
   	$uid = $user->tu_id; 
   	$data = $this->_get_order_coupons($uid);
    $current_time = date('Y-m-d H:i:s'); 
   //有效优惠券	   
	   $valid_coupon_sql = "select t_coupons_record.*,t_coupons.* from t_coupons,t_coupons_record where t_coupons.tc_id=t_coupons_record.tcr_tc_id ";
	   $valid_coupon_sql.=" and t_coupons_record.tcr_uid=".$uid;
	   
	   $valid_coupons = $this->tickets->personal_select($valid_coupon_sql);
	   foreach($valid_coupons as $k=>$v){
	   	   
	   	if($current_time > $v->tc_end_time){
	   		$valid_coupons[$k]->tc_status = '无效';
	   	}else{ 
	   		if($v->tcr_status == 0){
	   			$valid_coupons[$k]->tc_status = '有效';
	   		}else{
	   			$valid_coupons[$k]->tc_status = '无效';
	   		}
	   	}
	   	   
	   }
	$data['valid_coupons'] = $valid_coupons;
   	$data['coupon_lang'] = $this->common->coupons_types();
   	
   	$this->load->view('wechat/member_coupons',$data);
  }	
	
	
	
	
//用户订单
   function member_order(){
	   	$flag = $this->uri->segment(3);
	   	if (!$flag){
	   		//setcookie('user_cookie','',time()+3600*24,'/');
	   	}
	   	$user = $this->get_uid('/wechat/member_order');
   		$uid = $user->tu_id;
   		 
   		$data = $this->_get_order_coupons($uid);
	   	$data['order_status']= $this->common->get_order_stauts_config();
	   	$order = $this->tickets->select('orders',array('to_uid'=>$uid),'','','',array('to_id'=>'desc'));
	   	if($order){
	   		foreach($order as $k=>$v){
	   			$temp_order = $this->common->_get_order_detail($uid,$v->to_id);
	   			
	   			//获得最小用餐日期
	   			$service_date = array();
	   			foreach($temp_order as $key=>$val){
	   				$service_date[] = strtotime($val->service_date);
	   			}
	   			sort($service_date);
	   			$order[$k]->first_server_date = $service_date[0];
	   			$order[$k]->order_detail = $temp_order;
	   			if ($v->to_event_id){
	   				$temp_event = $this->tickets->api_select('event','id,name,price',array('id'=>$v->to_event_id));
	   				if (!$temp_event){
	   					$event = '';
	   				}else{
	   					$event = $temp_event[0];
	   				}
	   			}else{
	   				$event = '';
	   			}
	   			$order[$k]->event = $event;
	   			
	   			//支付方式,先看有没有优惠券
	   			if($v->to_coupon_id){
	   				$coupon_sql = "select t_coupons.tc_price from t_coupons,t_coupons_record where t_coupons.tc_id=t_coupons_record.tcr_tc_id and t_coupons_record.tcr_id=".$v->to_coupon_id;
	   				$temp_coupon = $this->tickets->personal_select($coupon_sql);
	   				$coupon_amount = $temp_coupon[0]->tc_price;
	   			}else{
	   				$coupon_amount = 0;
	   			}
	   			$order[$k]->coupon_amount = $coupon_amount;
	   		}
	   	}else{
	   		$order = '';
	   	}
	   	 
	   	$data['orders'] = $order;
	   	$order_time = $this->tickets->select('configs',array('tc_type'=>'order_date'));
	   		
	   	$data['order_time'] = $order_time[0];
	   	$this->load->view('wechat/member_order',$data);
   }	
	
	
//手机用户中心
   function member_index(){
	   	$flag = $this->uri->segment(3);
	   	if (!$flag){
	   		//setcookie('user_cookie','',time()+3600*24,'/');
	   	}
	   	$user = $this->get_uid('/wechat/member_index');
	   	$uid = $user->tu_id;
   	    $data = $this->_get_order_coupons($uid);
   	     
	   	$data['user_cookie'] = $user;  
	   	$this->load->view('wechat/member_index',$data);
   }	
 
	
//配送地址
   function member_address(){
   	$flag = $this->uri->segment(3);
   	if (!$flag){
   	 // setcookie('user_cookie','',time()+3600*24,'/');
   	}
   	
   	$user = $this->get_uid('/wechat/member_address');
    $uid = $user->tu_id;
   	 
   	$data = $this->_get_order_coupons($uid);
   	$para = $this->uri->segment(3); 
   	$new_flag = 0;
   	$edit_flag = 0;
   	$edit_address = '';
   	if($para){
   		if($para == 'add'){
   			$new_flag = 1;
   		}else{
   			$temp_address = $this->tickets->select('shipping_address',array('tsa_id'=>$para));
   			$edit_address = $temp_address[0];
   			$data['city'] = $this->tickets->select('city',array('father'=>$edit_address->tsa_province));
   			$data['area'] = $this->tickets->select('area',array('father'=>$edit_address->tsa_city));
   			$data['service_building'] = $this->tickets->select('service_buildings',array('area_id'=>$edit_address->tsa_district));
   			$edit_flag = 1;
   		}
   	}
   	 
   	$data['edit_address'] = $edit_address;
   	$data['new_flag'] = 3;
   	$data['edit_flag'] = 1;
   	$data['province'] = $this->tickets->select('province',array('status'=>1));
   	
   	$sql="SELECT t_shipping_address.*,t_service_buildings.name as building_name, t_companys.id,t_companys.name as company_name, t_province.province, t_city.city, t_area.area FROM t_companys,t_shipping_address, t_city, t_province, t_service_buildings,t_area WHERE t_shipping_address.tsa_company= t_companys.id and t_shipping_address.tsa_province = t_province.province_id
AND t_shipping_address.tsa_city = t_city.city_id
and t_shipping_address.tsa_building_id = t_service_buildings.id
AND t_shipping_address.tsa_district = t_area.area_id and t_shipping_address.tsa_uid=".$uid." order by t_shipping_address.tsa_id desc";
   	$data['shipping_address'] = $this->tickets->personal_select($sql);
   	$data['company'] = $this->tickets->api_select('companys','name,id');
   	
   	$data['uid'] = $uid;
   	$this->load->view('wechat/member_address',$data);
   }   
   
	
//微信回调函数	
	function wnotice(){
		require_once(APPPATH.'libraries/wechat/WxPayPubHelper.php'); 
		 
		//使用通用通知接口
		$wechat_config_temp = $this->tickets->select('payment',array('name'=>'wechat'));
		$weipay = $wechat_config_temp[0];
		$notify = new Notify_pub($weipay->app_id,$weipay->payname,$weipay->partner_key,$weipay->app_secret);
		
		//存储微信的回调
		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
		$notify->saveData($xml); 
		//验证签名，并回应微信。
		//对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
		//微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
		//尽可能提高通知的成功率，但微信不保证通知最终能成功。
		if($notify->checkSign() == FALSE){
			$notify->setReturnParameter("return_code","FAIL");//返回状态码
			$notify->setReturnParameter("return_msg","签名失败");//返回信息
		}else{
			$notify->setReturnParameter("return_code","SUCCESS");//设置返回码
		}
		$returnXml = $notify->returnXml();
	  
		if($notify->checkSign() == TRUE)
		{
			if ($notify->data["return_code"] == "FAIL") { 
			}
			elseif($notify->data["result_code"] == "FAIL"){ 
			}
			else{ 
			 $this->common->change_order_status($notify->data['out_trade_no']);	 
			}
		}
		 
	}
	
	
	function wechat_pay(){ 
		header("Content-type: text/html; charset=utf-8");
		$order_sn = trim($_GET['order_sn']); 
		$user = $this->get_uid(); 
		$temp_order = $this->tickets->api_select('orders','to_order_amount,to_total_amount',array('to_order_sn'=>$order_sn));
		$order = $temp_order[0];
		
		require_once(APPPATH.'libraries/wechat/WxPayPubHelper.php');
		//使用jsapi接口
		$wechat_config_temp = $this->tickets->select('payment',array('name'=>'wechat'));
		$weipay = $wechat_config_temp[0];
		$jsApi = new JsApi_pub($weipay->app_id,$weipay->payname,$weipay->partner_key,$weipay->app_secret);

		$openid = $user->tu_username; 
		//=========步骤2：使用统一支付接口，获取prepay_id============
		//使用统一支付接口
		$unifiedOrder = new UnifiedOrder_pub($weipay->app_id,$weipay->payname,$weipay->partner_key,$weipay->app_secret);	
		$unifiedOrder->setParameter("openid",$openid);//商品描述
		$unifiedOrder->setParameter("body",'小树好吃');//商品描述
		//自定义订单号，此处仅作举例
		$unifiedOrder->setParameter("out_trade_no",$order_sn);//商户订单号 
		$unifiedOrder->setParameter("total_fee",100*$order->to_order_amount);//总金额$order->to_total_amount;
		$unifiedOrder->setParameter("notify_url",base_url().'/wechat/wnotice');//通知地址 
		$unifiedOrder->setParameter("trade_type","JSAPI");//交易类型
		//$unifiedOrder->setParameter("attach",'token='.$_GET['token'].'&wecha_id='.$_GET['wecha_id'].'&from='.$_GET['from']);//附加数据

		$prepay_id = $unifiedOrder->getPrepayId(); 
		//=========步骤3：使用jsapi调起支付============
		$jsApi->setPrepayId($prepay_id);
		$jsApiParameters = $jsApi->getParameters(); 
		 
		$data['jsApiParameters'] = $jsApiParameters;
		$data['return_url'] = base_url().'wechat/member_center';  
		$this->load->view('wechat/wechat_pay',$data); 
	}
	

	//支付页面
	function pay_order(){
	    
		$order_sn = $this->uri->segment(3);
				
		require_once("walipay/alipay.config.php");
		require_once("walipay/lib/alipay_submit.class.php");
		$alipay_config_temp = $this->tickets->select('payment',array('name'=>'alipay'));
		$alipay_con = $alipay_config_temp[0];
		 
		/**************************调用授权接口alipay.wap.trade.create.direct获取授权码token**************************/
			
		//返回格式
		$format = "xml";
		//必填，不需要修改
		
		//返回格式
		$v = "2.0";
		//必填，不需要修改
		
		//请求号
		$req_id = date('Ymdhis');
		//必填，须保证每次请求都是唯一 
		//操作中断返回地址
		$merchant_url = base_url()."mobile_return_url.php";
		//用户付款中途退出返回商户的地址。需http://格 
		$notify_url = base_url()."wechat/notify_url";
		//需http://格式的完整路径，不允许加?id=123这类自定义参数
		
		//页面跳转同步通知页面路径
		$call_back_url = base_url()."return_url.php";
		//需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
		$o = $this->tickets->select('orders',array('to_order_sn'=>$order_sn));
		//卖家支付宝帐户
		$seller_email = $alipay_con->payname;//'liuxiaofeng@xiaoshuhaochi.com';
		//必填
		
		//商户订单号
		$out_trade_no = $order_sn;
		//商户网站订单系统中唯一订单号，必填
		$req_id = date('Ymdhis');
		$this->tickets->update('orders',array('to_alipay_sn'=>$req_id),array('to_order_sn'=>$order_sn));
		//订单名称
		$subject = $o[0]->to_receiver.'新订单';
		//付款金额
		$total_fee = $o[0]->to_order_amount;
		//必填
		
		//请求业务参数详细
		$req_data = '<direct_trade_create_req><notify_url>' . $notify_url . '</notify_url><call_back_url>' . $call_back_url . '</call_back_url><seller_account_name>' . $seller_email . '</seller_account_name><out_trade_no>' . $out_trade_no . '</out_trade_no><subject>' . $subject . '</subject><total_fee>' . $total_fee . '</total_fee><merchant_url>' . $merchant_url . '</merchant_url></direct_trade_create_req>';
		//必填
		
		/************************************************************/
		$alipay_config['partner'] = $alipay_con->app_id;
		$alipay_config['key'] = $alipay_con->app_secret;
		//构造要请求的参数数组，无需改动
		$para_token = array(
				"service" => "alipay.wap.trade.create.direct",
				"partner" => trim($alipay_config['partner']),
				"sec_id" => trim($alipay_config['sign_type']),
				"format"	=> $format,
				"v"	=> $v,
				"req_id"	=> $req_id,
				"req_data"	=> $req_data,
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		); 
		//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestHttp($para_token);
		
		//URLDECODE返回的信息
		$html_text = urldecode($html_text);
		
		//解析远程模拟提交后返回的信息
		$para_html_text = $alipaySubmit->parseResponse($html_text);
		
		//获取request_token
		$request_token = $para_html_text['request_token'];
		 
		/**************************根据授权码token调用交易接口alipay.wap.auth.authAndExecute**************************/
		
		//业务详细
		$req_data = '<auth_and_execute_req><request_token>' . $request_token . '</request_token></auth_and_execute_req>';
		//必填
		
		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service" => "alipay.wap.auth.authAndExecute",
				"partner" => trim($alipay_config['partner']),
				"sec_id" => trim($alipay_config['sign_type']),
				"format"	=> $format,
				"v"	=> $v,
				"req_id"	=> $req_id,
				"req_data"	=> $req_data,
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		); 
		//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter, 'get', '确认');
		$data['text'] = $html_text;
		$this->load->view('main/pay_channel',$data);
	}
	
	


	function notify_url(){
		require_once("walipay/alipay.config.php");
		require_once("walipay/lib/alipay_notify.class.php");
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
		
			//解析notify_data
			//注意：该功能PHP5环境及以上支持，需开通curl、SSL等PHP配置环境。建议本地调试时使用PHP开发软件
			$doc = new DOMDocument();
			if ($alipay_config['sign_type'] == 'MD5') {
				$doc->loadXML($_POST['notify_data']);
			}
		
			if ($alipay_config['sign_type'] == '0001') {
				$doc->loadXML($alipayNotify->decrypt($_POST['notify_data']));
			}
		
			if( ! empty($doc->getElementsByTagName( "notify" )->item(0)->nodeValue) ) {
				//商户订单号
				$out_trade_no = $doc->getElementsByTagName( "out_trade_no" )->item(0)->nodeValue;
				//支付宝交易号
				$trade_no = $doc->getElementsByTagName( "trade_no" )->item(0)->nodeValue;
				//交易状态
				$trade_status = $doc->getElementsByTagName( "trade_status" )->item(0)->nodeValue;
		
				if($trade_status == 'TRADE_FINISHED') { 
					//判断该笔订单是否在商户网站中已经做过处理
					//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
					//如果有做过处理，不执行商户的业务程序
						
					//注意：
					//该种交易状态只在两种情况下出现
					//1、开通了普通即时到账，买家付款成功后。
					//2、开通了高级即时到账，从该笔交易成功时间算起，过了签约时的可退款时限（如：三个月以内可退款、一年以内可退款等）后。
		
					//调试用，写文本函数记录程序运行情况是否正常
					//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
						
					echo "success";		//请不要修改或删除
				}
				else if ($trade_status == 'TRADE_SUCCESS') {
					$this->_change_order_status($out_trade_no); 
					//判断该笔订单是否在商户网站中已经做过处理
					//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
					//如果有做过处理，不执行商户的业务程序
						
					//注意：
					//该种交易状态只在一种情况下出现——开通了高级即时到账，买家付款成功后。
		
					//调试用，写文本函数记录程序运行情况是否正常
					//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
						
					echo "success";		//请不要修改或删除
				}
			}
		
			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
		
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		}
		else {
			//验证失败
			echo "fail";
		
			//调试用，写文本函数记录程序运行情况是否正常
			//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
		}
		 
}
	
	
	//改变订单状态
	function _change_order_status($order_sn){
		$this->tickets->translate_begin();
		$temp_order = $this->tickets->select('orders',array('to_order_sn'=>$order_sn));
		error_log(print_r($temp_order[0],true),3,'/data/www/wechat.txt');
		
		$result = $this->tickets->update('orders',array('to_status'=>ORDER_PAYED),array('to_order_sn'=>$order_sn));
	    if($result){
		   $this->tickets->translate_commit();
		}else{
		   $this->tickets->translate_rollback();
		}
	}

					
	//保存订单
	function save_order(){
		$user = $this->get_uid();
		$uid = $user->tu_id;
		$event = $this->common->get_valid_event($uid);
		$this->common->save_order($uid,WECHAT_ORDER,'wechat',$event);
	}
	
	
//个人中心
   function member_center(){
   	$flag = $this->uri->segment(3);
   	if (!$flag){
   		//setcookie('user_cookie','',time()+3600*24,'/');
   	}
   	
   	$user = $this->get_uid('/wechat/member_center');
   	$uid = $user->tu_id;
   	$data = $this->_get_order_coupons($uid);
   	$this->load->view('wechat/member_center',$data);
   }	
	
	
//首页		
	function index2(){  
		$flag = $this->uri->segment(3);
		if (!$flag){
			//setcookie('user_cookie','',time()+3600*24,'/');
		}
		
		$user = $this->get_uid('/wechat/index');  
		 
	 	$cookie_cart = $this->common->_get_cookie_cart();
		$uid = $user->tu_id;
	 
		$data['uid'] = $uid;
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
			$data['area'] = $this->tickets->select('area');
		}
		
		$data['cookie_good'] = $cookie_cart['cookie_cart'];
		$data['cookie_count'] = $cookie_cart['cookie_count'];
		$weeks = $this->common->_get_valid_weeks();
		if(isset($_GET['keywords'])){
			$keywords = trim($_GET['keywords']);
		}else{
			$keywords = '';
		}
			
		$service_datas = $this->common->_get_all_valid_buildings($keywords); 
		if(!$service_datas['final_goods']){
			redirect('/wechat/index');exit;
		}
		$data['goods'] = $service_datas['final_goods'];
		
		$service_datas = $this->common->_get_all_valid_buildings($keywords,$uid);
			
		if($service_datas['final_buildings']){
			$data['current_service_building'] = $service_datas['final_buildings'][0]['id'];
			$data['service_buildings'] = $service_datas['final_buildings'][0]['name'];
		}else{
		
			$service_datas = $this->common->_get_all_valid_buildings('');
			$data['current_service_building'] = $service_datas['final_buildings'][0]['id'];
			$data['service_buildings'] = $service_datas['final_buildings'][0]['name'];
		}
		 
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
		$this->load->view('wechat/index',$data);
	}
	
	
//确认订单	
	function order_confirm(){
		 
		$user = $this->get_uid('/wechat/order_confirm'); 
		$uid = $user->tu_id; 
		 
		$sql="SELECT t_shipping_address .*,t_companys.name as company_name,t_province.province, t_city.city, t_area.area FROM t_companys,t_shipping_address, t_city, t_province, t_area WHERE t_shipping_address.tsa_province = t_province.province_id
AND t_shipping_address.tsa_city = t_city.city_id and t_shipping_address.tsa_company = t_companys.id
AND t_shipping_address.tsa_district = t_area.area_id and t_shipping_address.tsa_default=1 and t_shipping_address.tsa_uid=".$uid;
		$default_address = $this->tickets->personal_select($sql);
		if (!$default_address){
			redirect('/wechat/member_address/add');
		}
		if($default_address){
			$data['shipping_address'] = $default_address[0];
			$data['shipping_address_flag'] = 1;
		}else{
			$data['shipping_address'] = '';
			$data['shipping_address_flag'] = 0;
		}
		
		$event = $this->common->get_valid_event($uid);
		 
		$data['event'] = $event;
		$goods = $this->common->_get_cookie_good_detail('wechat',$event);
//判断菜品的配送区域，是否包含此人所选写字楼
	    $invalid_flag = 0;
      /* foreach($goods['cart_goods'] as $k=>$v){
        	$temp_building = $this->tickets->api_select('good_supplier_buildings','id',array('good_id'=>$v['goods']->id,'building_id'=>$default_address[0]->tsa_building_id));
        	if(!$temp_building){
        		$invalid_flag = 1;
        	}
        }		
       */
        $data['invalid_flag'] = $invalid_flag; 
		$data['cookie_count'] = $goods['cookie_count'];
		$data['cart_goods'] = $goods['cart_goods'];
		$data['total_count'] = $goods['total_count'];
		$data['orignal_amount'] = $goods['orignal_amount'];
		$brower = $this->_get_brower();
		$pay_where = array('status'=>VALID_STATUS);
		/*if($brower == 'wechat'){
			$pay_where['name !='] = 'alipay';
		}else{
			$pay_where['name !='] = 'wechat';
		}*/
		$data['payment'] = $this->tickets->select('payment',$pay_where);
		 
		$data['payment_lang'] = $this->common->payment_config();
		//获取每个商品和每个订单菜品总份数限制
		$count_config = $this->tickets->select('configs',array('tc_type'=>'order_count'));
		$data['per_count_limit'] = $count_config[0]->tc_title;
		$data['total_count_limit'] = $count_config[0]->tc_content;
		
		//取出此人可以用的优惠券
		$current_time = date('Y-m-d H:i:s');
		$coupon_sql = "select t_coupons_record.*,t_coupons.tc_price,t_coupons.tc_start_time,t_coupons.tc_end_time from t_coupons,t_coupons_record where t_coupons.tc_id=t_coupons_record.tcr_tc_id and t_coupons_record.tcr_status= ".COUPON_NOT_USED;
		$coupon_sql.=" and t_coupons.tc_start_time <='".$current_time."' and t_coupons.tc_end_time >='".$current_time."' and t_coupons_record.tcr_uid=".$uid;
		$data['coupons'] = $this->tickets->personal_select($coupon_sql);
		
		$data['coupon_lang'] = $this->common->coupons_types();
		$this->load->view('wechat/order_confirm',$data);
	}
	 
	
	
	function _get_brower(){
		if(strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')){
			return 'wechat';
		}else{
			return 'other';
		}
	}
	
	
	function _curl_get_contents($url,$time)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_TIMEOUT, $time);           //设置超时
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        //返回结果
		$r = curl_exec($ch);
		if(curl_getinfo($ch, CURLINFO_HTTP_CODE) === 404) return 404;
		if(curl_getinfo($ch, CURLINFO_HTTP_CODE) === 403) return 403;
		//if(curl_getinfo($ch, CURLINFO_HTTP_CODE) === 200) return 200;
		if(curl_getinfo($ch, CURLINFO_HTTP_CODE) === 201) return 201;
		if(curl_getinfo($ch, CURLINFO_HTTP_CODE) === 202) return 202;
		if(curl_getinfo($ch, CURLINFO_HTTP_CODE) === 203) return 203;
		if(curl_getinfo($ch, CURLINFO_HTTP_CODE) === 204) return 204;
		if(curl_getinfo($ch, CURLINFO_HTTP_CODE) === 205) return 205;
		if(curl_getinfo($ch, CURLINFO_HTTP_CODE) === 206) return 206;
		curl_close($ch);
		return $r;
	}
	
	
	function change_default_address(){
		$address_id = intval($_POST['address_id']);
		 
		$user = $this->get_uid('/wechat/confirm_step_two');
		$uid = $user->tu_id;
		//$uid = 2;
		if($uid){
			$this->tickets->update('shipping_address',array('tsa_default'=>0),array('tsa_uid'=>$uid));
			$this->tickets->update('shipping_address',array('tsa_default'=>1),array('tsa_id'=>$address_id,'tsa_uid'=>$uid));
		} 
		echo json_encode(array('success'=>'yes','msg'=>$uid));exit;
	}
	
	//获取用户uid
	function get_uid($return=''){
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		if (strpos($user_agent, 'Mobile')){
			if (strpos($user_agent, 'MicroMessenger') === false)
			{
				header("Content-type: text/html; charset=utf-8");
				echo "<script>alert('请在您的微信里关注公众号“小树好吃”并下单！')</script>";exit;
			}
		}
		
		$user_cookie = isset($_COOKIE['user_cookie'])?$_COOKIE['user_cookie']:''; 
		//error_log(print_r($user_cookie,true),3,'/data/www/cookie.txt');
		if(!empty($user_cookie)){
			 
			$user_cookie = unserialize($user_cookie);
 
			return $user_cookie;
		}else{
		 
		   //调用授权页面	 
			require_once(APPPATH.'libraries/wechat/WxPayPubHelper.php');
			//使用jsapi接口
			$wechat_config_temp = $this->tickets->select('payment',array('name'=>'wechat'));
			$weipay = $wechat_config_temp[0];
			
			$jsApi = new JsApi_pub($weipay->app_id,$weipay->payname,$weipay->partner_key,$weipay->app_secret);
			//=========步骤1：网页授权获取用户openid============
			//通过code获得openid
			if (!isset($_GET['code'])){
				
				//触发微信返回code码
				$url = $jsApi->createOauthUrlForCode(urlencode(base_url().'index.php?c=wechat&m=get_uid&return='.$return));
		 
				Header("Location: $url"); exit();
			}
			 
			//获取code码，以获取openid
			$code = $_GET['code'];
			$return = $_GET['return']; 
			$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$weipay->app_id."&secret=".$weipay->app_secret."&code=".$code."&grant_type=authorization_code";
			$result = $this->_curl_get_contents($url,100);
			$result = json_decode($result);  
			// 
			//error_log(print_r($result,true),3,'/data/www/result.txt');
			if($result->openid){
				$user_temp = $this->tickets->select('users',array('tu_username'=>$result->openid));
				 
					if ($user_temp){
						$tem_uid = $user_temp[0]->tu_id; 
					}else{
						$tem_uid = $this->_register_wechat_user($result);
					}	
				}else{
					$tem_uid = $this->_register_wechat_user($result);
				}
				
				$temp_user = $this->tickets->select('users',array('tu_id'=>$tem_uid));
				$user = $temp_user[0];
				setcookie('user_cookie',serialize($user),time()+3600*24*30,'/');
				return $user;
				//redirect($return.'/1');
			}
		
	}
	
	
//获取微信授权资料	
	function _register_wechat_user($result){
		$url2 = "https://api.weixin.qq.com/sns/userinfo?access_token=".$result->access_token."&openid=".$result->openid."&lang=zh_CN";
		$result2 = $this->_curl_get_contents($url2,100);
		$result2 = json_decode($result2);
		//error_log(print_r($result2,true),3,'/data/www/result2.txt');
		$save_dir = 'api_images';
		$image = $result2->headimgurl;
		$image_new_name = $this->generate_code(10).'.jpg';
		$image = $this->getImage($image,$save_dir,$image_new_name,1);
			
		if ($result2->sex==1){
			$gender = 0;
		}else{
			$gender = 1;
		}
			
		$v['tu_username'] = $result2->openid;
		$v['tu_nickname'] = $result2->nickname;
		$v['tu_portrait'] = $image['save_path'];
		$v['tu_birthday'] = '1990-01-01';
		$v['tu_gender'] = $gender;
		$v['tu_weixin'] = 9;
		$v['tu_source'] = '1';
		$v['tu_created'] = date('Y-m-d H:i:s');
		$tem_uid = $this->tickets->insert('users',$v);
			
		return $tem_uid;
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
		//文件大小'/data/www/xshc/shop/'
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
	
	
	
	function top(){	
		$user = $this->session->userdata('user');
		
		if($user==""){ 
			//直接跳转到登录页面
			redirect('admin/login');exit;
		}
	}
	 
}	
