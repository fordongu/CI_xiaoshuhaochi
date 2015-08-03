<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class member extends Controller {

	function __construct()
	{
		parent::__construct();	
		ini_set('display_errors','On');
		$this->load->library('zip'); 
		$this->load->model('tickets'); 
		$this->load->model('common');
		define('COUPON_USED','2');
		define('VALID_CODES','0');
		define('INVALID_CODES','1');
		define('UNREADED','0');
		define('COUPON_NOT_USED','0');

		define('VALID_STATUS',1);
                
	}
	
	
//我的账户
   function account(){
      $uid = $this->_get_uid();
   	  $data = $this->get_default_building();
   	  $data['wallet'] = $this->tickets->select('wallet',array('tw_uid'=>$uid));
      $data['wallet_data'] = $this->tickets->select('wallet_history',array('order_uid'=>$uid),'','','',array('id'=>'desc'));
      $this->load->view('member/account',$data);
      
   }
   
   
//积分
   function score(){
   	  $uid = $this->_get_uid();
   	  $data = $this->get_default_building();
      $data['score_data'] = $this->tickets->select('score_data',array('uid'=>$uid),'','','',array('id'=>'desc'));
      $this->load->view('member/score',$data);
   }	
	
	
	
//修改用户密码	
   function ajax_update_user_password(){
   	 $opassword = trim($_POST['opassword']);
   	 $new_password = trim($_POST['new_password']);
   	 $uid = $this->_get_uid();
   	 $user_check = $this->tickets->api_select('users','tu_password',array('tu_id'=>$uid));
   	 if(!$user_check){
   	 	echo json_encode(array('success'=>'no','msg'=>'用户不存在'));exit;
   	 }
   	 $user = $user_check[0];
  	 $md5_password = md5(md5('xiaoshu'.$opassword));
    	if($md5_password != $user->tu_password){
    		echo json_encode(array('success'=>'no','msg'=>'原密码错误'));exit;
    	}
    	$new_pass = md5(md5('xiaoshu'.$new_password));
	   $result = $this->tickets->update('users',array('tu_password'=>$new_pass),array('tu_id'=>$uid));
	   	if($result){
	   		echo json_encode(array('success'=>'yes','msg'=>'修改成功'));exit;
	   	}else{
	   		echo json_encode(array('success'=>'no','msg'=>'修改失败'));exit;
	   	}	
    	
   }	
	
	
//修改用户资料	
   function ajax_update_user(){
   	$uid = intval($_POST['uid']);
   	$field = trim($_POST['field']);
   	$val  = trim($_POST['val']);
   	$mobile_code = isset($_POST['mobile_code'])?trim($_POST['mobile_code']):''; 
	$password=trim($_POST['password']);
	$md5_password = md5(md5('xiaoshu'.$password));
   	if($mobile_code&&($field=='tu_mobile')){
   		$res=$this->check_mobile_code($val,$mobile_code);
		if($res["success"]=="yes"){
			$uid=$this->tickets->select('users',array($field=>$val));
			$uid=$uid[0]->tu_id;
				$result = $this->tickets->update('users',array($field=>$val,'tu_password'=>$md5_password),array('tu_id'=>$uid));
   	if($result){
   		$temp_user = $this->tickets->select('users',array('tu_id'=>$uid));
   		setcookie('user_cookie',serialize($temp_user[0]),time()+3600*24,'/');
   		 
   		echo json_encode(array('success'=>'yes','msg'=>$password));exit;
   	}else{
   		echo json_encode(array('success'=>'no1','msg'=>$password));exit;
   	}
		}else{
			echo json_encode(array('success'=>'no2','msg'=>"验证码错误"));exit;
			
		}
		
		
		
        }else if ($field=="tu_gender") {
      	$result = $this->db->update('users',array('tu_gender'=>$val),array("tu_id"=>$uid));
        if ($result) {
            echo json_encode(array('success'=>'yes','msg'=>"修改成功"));exit;
        }
        }
   	
   }	
      function ajax_update_user_info(){
   	$uid = intval($_POST['uid']);
   	$field = trim($_POST['field']);
   	$val  = trim($_POST['val']);
   	$mobile_code = isset($_POST['mobile_code'])?trim($_POST['mobile_code']):''; 
	$password=trim($_POST['password']);
	$md5_password = md5(md5('xiaoshu'.$password));
   	if($mobile_code&&($field=='tu_mobile')){
   		$res=$this->check_mobile_code($val,$mobile_code);
		if($res["success"]=="yes"){
				$result = $this->tickets->update('users',array($field=>$val,'tu_password'=>$md5_password),array('tu_id'=>$uid));
   	if($result){
   		$temp_user = $this->tickets->select('users',array('tu_id'=>$uid));
   		setcookie('user_cookie',serialize($temp_user[0]),time()+3600*24*365,'/', ".xiaoshuhaochi.com");
   		//setcookie('password',$remember_flag,time()+3600*24*365,'/');
   		echo json_encode(array('success'=>'yes','msg'=>'注册成功'));exit;
   	}else{
   		echo json_encode(array('success'=>'no1','msg'=>'注册失败请稍候再试'));exit;
   	}
		}else{
			if($res["success"]=="no1"){
				echo json_encode(array('success'=>'no2','msg'=>'验证码失效'));exit;
			}else if($res["success"]=="no2"){
				echo json_encode(array('success'=>'no2','msg'=>'验证码错误'));exit;
			}
			
			
		}
		
		
		
   	}
   	
   }	
	
	
	
   
   //验证验证码
   function check_mobile_code($mobile,$code){
   
   	$check_time = strtotime("-10 min");
   	//检测验证码是否有效
   	$check = $this->tickets->select('mobile_codes',array('tmc_mobile'=>$mobile,'tmc_created >='=>$check_time));
   	if (!$check){
   		$r = array('success'=>'no1','msg'=>'验证码失效');
			return $r;
   	}else{
   		 
   		if($check[0]->tmc_code == $code){
   			//return true;
   			$r = array('success'=>'yes','msg'=>'验证码成功');
			return $r;
   		}else{
   			//return false;
   			$r = array('success'=>'no2','msg'=>'验证码错误');
			return $r;
   		}
   	}
   	//echo json_encode($r);exit;
   }
	
//我的优惠券
   function coupons(){
   	   $uid = $this->_get_uid();
   	   
   	   $current_time = date('Y-m-d H:i:s');
   	   $data = $this->get_default_building();
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
 
   	   $this->load->view('member/coupons',$data);
   }	
	
	
	
//我的订单
    function order_list(){
    	//用户不能取消订单
    	$uid = $this->_get_uid();
    	$data = $this->get_default_building();
    	$data['order_status']= $this->common->get_order_stauts_config();
    	//$order = $this->tickets->select('orders',array('to_uid'=>$uid),'','','',array('to_id'=>'desc'));
        $sql="select * from t_orders where to_uid='$uid' and to_status!=60 order by to_id desc";
	$order=$this->tickets->personal_select($sql);
    	if($order){
	    	foreach($order as $k=>$v){
	    		$temp_order = $this->common->_get_order_detail($uid,$v->to_id);
	    //获得最小用餐日期
	            $service_date = array();
	            foreach($temp_order as $key=>$val){
	            	$service_date[] = strtotime($val->service_date);
	            }	
	            sort($service_date);
	           if(!$service_date){
	           	   $service_date_final = time();
	           }else{
	           	   $service_date_final = $service_date[0];
	           }
	            $order[$k]->first_server_date = $service_date_final;
	    		$order[$k]->order_detail = $temp_order;
	    		$temp_company = $this->tickets->api_select('companys','name',array('id'=>$v->to_company));
	    		if ($temp_company){
	    			$company_name = $temp_company[0]->name;
	    		}else{
	    			$company_name = '';
	    		}
	    		$order[$k]->company_name = $company_name;
	    //service_building_name
	            $buidling_sql= "select t_service_buildings.name from t_service_buildings,t_users where ";
	            $buidling_sql.=" t_users.tu_default_building = t_service_buildings.id and t_users.tu_id=".$v->to_uid;		
	    		$temp_building = $this->tickets->personal_select($buidling_sql);
	    		if ($temp_building){
	    			$buidling_name = $temp_building[0]->name;
	    		}else{
	    			$buidling_name = '';
	    		}
	    		
	    		$order[$k]->buidling_name = $buidling_name;
	    		
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
    	
    	$order_time = $this->tickets->select('configs',array('tc_type'=>'order_date'));
    	
    	$data['order_time'] = $order_time[0]; 
    	$data['orders'] = $order;
    	
    	
    	//echo '<pre>';print_r($data);exit;
    	$this->load->view('member/order_list',$data);
    }	
	
	
 
	
//快递地址
    function shipping_address(){
    	$para = $this->uri->segment(3);
    	$uid = $this->_get_uid();
    	
		if (!$uid){
			redirect('main/index/login');exit;
		}  
		$data = $this->common->get_default_building($uid);
		 
    	$data['login_flag'] = 0;
    	$new_flag = 0;
    	$edit_flag = 0;
    	$edit_address = '';
    	if($para){
    		if($para == 'add'){
    			$new_flag = 1;
    		}else{
    			$temp_address = $this->tickets->tickets->select('shipping_address',array('tsa_id'=>$para));
    			$edit_address = $temp_address[0];
    			$data['city'] = $this->tickets->select('city',array('father'=>$edit_address->tsa_province));
    			$data['area'] = $this->tickets->select('area',array('father'=>$edit_address->tsa_city));
    			$edit_flag = 1;
    		}
    	}
    	
    	$data['edit_address'] = $edit_address;
    	$data['new_flag'] = $new_flag;
    	$data['edit_flag'] = $edit_flag;
    	$data['province'] = $this->tickets->select('province',array('status'=>1));
    	 
    	$sql="SELECT t_shipping_address.*,t_service_buildings.address as building_address, t_companys.id,t_companys.name as company_name, t_province.province, t_city.city, t_area.area FROM t_companys,t_shipping_address, t_city, t_province, t_service_buildings,t_area WHERE t_shipping_address.tsa_company= t_companys.id and t_shipping_address.tsa_province = t_province.province_id
AND t_shipping_address.tsa_city = t_city.city_id
and t_shipping_address.tsa_building_id = t_service_buildings.id
AND t_shipping_address.tsa_district = t_area.area_id and t_shipping_address.tsa_uid=".$uid." order by t_shipping_address.tsa_id desc";
    	$data['shipping_address'] = $this->tickets->personal_select($sql);
           foreach($data['shipping_address'] as $key=>$val){//获取默认ID
               if($val->tsa_default=="1"){
                   $data["default_tsa_id"]=$val->tsa_id;
                   break;
               }
           }
     
    	//给用户修改时增加地区省份和城市的ID
		$building_id=43;
		$sql2 ="select t_service_buildings.*, t_province.province, t_city.city, t_area.area FROM t_service_buildings, t_city, t_province, t_area where
		    		t_service_buildings.province_id = t_province.province_id AND t_service_buildings.city_id = t_city.city_id  and t_service_buildings.area_id = t_area.area_id
		    		and t_service_buildings.id = ".$building_id;
				$data['default_building'] = $this->tickets->personal_select($sql2);
                               
    	$data['company'] = $this->tickets->api_select('companys','name,id');
    	$data['uid'] = $uid;
    	$this->load->view('member/shipping_address',$data);
    }
	
	
    
    
    function get_default_address(){
    	$address_id = intval($_POST['address_id']);
		$tsa_building_id=intval($_POST['tsa_building_id']);
    	//$address_check = $this->tickets->select('shipping_address',array('tsa_id'=>$address_id));
    	$sql="select t_shipping_address.*,t_companys.*,t_service_buildings.*,t_service_buildings.address as new_building_address from 
		t_shipping_address left join t_service_buildings on t_shipping_address.tsa_uid=t_service_buildings.uid
		left join t_companys on t_service_buildings.id=t_companys.service_building_id where t_shipping_address.tsa_id='$address_id' and t_service_buildings.id='$tsa_building_id';";
		$address_check = $this->tickets->personal_select($sql);
		if(!$address_check){
    		echo json_encode(array('success'=>'no','msg'=>'操作失败'));exit;
    	}else{
    		$address = $address_check[0];
    		$province = $this->tickets->select('province');
    		$city = $this->tickets->select('city',array('father'=>$address->tsa_province));
    		$area = $this->tickets->select('area',array('father'=>$address->tsa_city));
    		//$building = $this->tickets->api_select('service_buildings','id,address',array('area_id'=>$address->tsa_district));
    		//$companys = $this->tickets->api_select('companys','id,address',array('area_id'=>$address->tsa_district));
    		echo json_encode(array('success'=>'yes','msg'=>$address,'city'=>$city,'area'=>$area,'province'=>$province));exit;
    	}
    } 
    
    //更改用户默认收货地址
    function change_default_address(){
    	$address_id = intval($_POST['address_id']);
    	$uid = $this->_get_uid();
    	//$uid = 2;
    	if($uid){ 
    		$this->tickets->update('shipping_address',array('tsa_default'=>0),array('tsa_uid'=>$uid));
    		$this->tickets->update('shipping_address',array('tsa_default'=>1),array('tsa_id'=>$address_id,'tsa_uid'=>$uid));
    	}else{
    		$cookie_shipping = $this->common->_get_cookie_shipping_id_no_uid();
    		setcookie('user_cookie_shipping_default',$address_id,time()+3600*24,'/');
    		
    	}
    	echo json_encode(array('success'=>'yes'));exit;
    }
    
    
    function  delete_default_address(){
    	$address_id = intval($_POST['address_id']);
    	$address_check = $this->tickets->select('shipping_address',array('tsa_id'=>$address_id));
    	if($address_check[0]->tsa_default==1){
    		echo json_encode(array('success'=>'no','msg'=>'您不能删除默认地址'));exit;
    	}else{
		$this->tickets->delete('shipping_address',array('tsa_id'=>$address_id));
    	echo json_encode(array('success'=>'yes'));exit;
		}
    	
    }
    
    
    //异步过去城市或区域
    function ajax_get_city_area(){
    	$id = intval($_POST['id']);
    	$type = trim($_POST['type']);
    	if($type == 'area'){
    		$temp_area = $this->tickets->api_select('service_buildings','area_id',array('city_id'=>$id));
    		if ($temp_area){
    			$area_ids = array();
    			foreach($temp_area as $k=>$v){
    				if(!in_array($v->area_id,$area_ids)){
    					$area_ids[] = $v->area_id; 
    				}
    			}
    			$result = $this->tickets->select('area','','','','','',array('area_id'=>$area_ids));
    			
    		}else{
    			echo json_encode(array('success'=>'no'));exit;
    		}
    		
    		 
    	}else{
    		$result = $this->tickets->select($type,array('father'=>$id));
    	}
    	if ($result){
    		echo json_encode(array('success'=>'yes','msg'=>$result));exit;
    	}else{
    		echo json_encode(array('success'=>'no'));exit;
    	}
    }
    
    
    function ajax_get_companys(){
    	$id = intval($_POST['id']);
    	$type = trim($_POST['type']);
    	$from = isset($_POST['from'])?trim($_POST['from']):'';
        $cond = array('area_id'=>$id);
        if ($type == 'service_buildings'){
        	$cond['user_shipping']=0;
        }
        
        if($from){
        	$cond['status !='] = 3;
        }
        
        
    	$result = $this->tickets->api_select($type,'id,name',$cond);
    	if ($result){
    		echo json_encode(array('success'=>'yes','msg'=>$result));exit;
    	}else{
    		echo json_encode(array('success'=>'no'));exit;
    	}
    }
    
    

    
    function ajax_get_service_buildings(){
     
    	$keywords = trim($_POST['keywords']); 
    	$sql = "select name,id from t_service_buildings where name like '%".$keywords."%' or address like '%".$keywords."%' and user_shipping=0";
    	$result = $this->tickets->personal_select($sql);
    	if ($result){
    		echo json_encode(array('success'=>'yes','msg'=>$result));exit;
    	}else{
    		echo json_encode(array('success'=>'no'));exit;
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
    
    
    
    function ajax_get_building_name(){
    	$id = intval($_POST['id']);
    	$type = trim($_POST['type']);
    	$cond = array('service_building_id'=>$id);
    
    	$result = $this->tickets->api_select($type,'id,name',$cond);
    	if ($result){
    		echo json_encode(array('success'=>'yes','msg'=>$result));exit;
    	}else{
    		echo json_encode(array('success'=>'no'));exit;
    	}
    }
    
    
    function shipping_address_add(){
    	    $uid = intval($_POST['uid']); 
    		//判断此人是否已经有过收货地址，没有的话，这条是默认地址
    		$id = trim($_POST['id']);
			$tsa_id = $_POST["tsa_id"];
    		$address_check = $this->tickets->select('shipping_address',array('tsa_uid'=>$uid));
    		//$company = trim($_POST['company']);
    		//$company_check = $this->tickets->api_select('companys','id',array('id'=>$company));
    		$building_id = intval($tsa_id);
    	//判断新增写字楼
				
    	   // $extra_building_name = isset($_POST['extra_building_name'])?trim($_POST['extra_building_name']):''; 	
    	    $extra_building_address = isset($_POST['extra_building_address'])?trim($_POST['extra_building_address']):'';
    		if($extra_building_address){ 
    			$new_building_data = array(
    					'name'=>"",
    					'province_id'=>trim($_POST['province_id']),
    					'city_id'=>trim($_POST['city_id']),
    					'area_id'=>trim($_POST['area_id']),
    					'status'=>3,
    					'address'=>$extra_building_address,
    					'develop_time'=>date('Y-m-d H:i:s'),
    					'start_time'=>'08:00:00',
    					'end_time'=>'22:00:00',
    					'created'=>date('Y-m-d H:i:s'),
    					'user_shipping'=>1,
    					'uid'=>$uid); 
						if($tsa_id){
		      $this->tickets->update('service_buildings',$new_building_data,array("id"=>$tsa_id));
						}else{
		$building_id = $this->tickets->insert('service_buildings',$new_building_data);
						}
    		}
    		
    		if (!$company_check){
				$company_adress=trim($_POST['address']);
				//company_address是用于网站，address用于微信
				
				if(empty($company_adress)){
					$company_adress=trim($_POST['company_address']);
				}
    			$company_data = array(
    					'province_id'=>trim($_POST['province_id']),
    					'city_id'=>trim($_POST['city_id']),
    					'area_id'=>trim($_POST['area_id']),
    					'address'=>$company_adress, 
    					'created'=>date('Y-m-d H:i:s'),
    					'develop_time'=>date('Y-m-d H:i:s'),
    					'name'=>"",
    					'status'=>0,
    					'service_building_id'=>$building_id,
    					'comment'=>'用户自助生成'
    			);
				if($tsa_id){
					
		 $this->tickets->update('companys',$company_data,array("service_building_id"=>$tsa_id));
		$res=$this->tickets->select('companys',array('service_building_id'=>$building_id));
		$company=$res[0]->id;			
			}else{
		$company = $this->tickets->insert('companys',$company_data);
    			
				}
					$address = trim($_POST['address']);
    			
    		}else{
    			$temp_company = $this->tickets->api_select('companys','address',array('id'=>$company));
    			$address = $temp_company[0]->address;
    		}
    			$company_adress=trim($_POST['address']);
				//company_address是用于网站，address用于微信
				
				if(empty($company_adress)){
					$company_adress=trim($_POST['company_address']);
				}
    		$save_data = array(
    				'tsa_province'=>trim($_POST['province_id']),
    				'tsa_city'=>trim($_POST['city_id']),
    				'tsa_district'=>trim($_POST['area_id']),
    				'tsa_address'=>$company_adress,
    				'tsa_nickname'=>trim($_POST['nickname']),
    				'tsa_mobile'=>trim($_POST['mobile']),
    				'tsa_company'=>$company,
    				'tsa_building_id'=>$building_id,
    				'tsa_uid'=>$uid
    		);
    		if (!$address_check){
    			$save_data['tsa_default'] = 1;
    		}
    		if($id&&($id !='new')){
    
    			$result = $this->tickets->update('shipping_address',$save_data,array('tsa_id'=>$id));
    		}else{
    			if ($_POST['new_flag'] == 3){
    				$save_datas['tsa_default'] = 0;
    				$this->tickets->update('shipping_address',$save_datas,array('tsa_uid'=>$uid));
    				$save_data['tsa_default'] = 1;
    			}
    			
    			$result = $this->tickets->insert('shipping_address',$save_data);
				 $this->tickets->update('shipping_address',array('tsa_default'=>0),array('tsa_uid'=>$uid));
				 $this->tickets->update('shipping_address',array('tsa_default'=>1),array('tsa_id'=>$result));//将新增的改成默认地址
						
    			if(!$uid){
    				$cookie_shipping = $this->common->_get_cookie_shipping_id_no_uid();
    				if(!$cookie_shipping){
    					setcookie('user_cookie_shipping_default',$result,time()+3600*24,'/');
    					setcookie('user_cookie_shipping',$result,time()+3600*24,'/');
    				}else{
    					$already_shipping = $cookie_shipping['user_cookie_shipping'];
    					$final_shipping = $already_shipping.','.$result;
    					
    					setcookie('user_cookie_shipping_default',$result,time()+3600*24,'/');
    					setcookie('user_cookie_shipping',$final_shipping,time()+3600*24,'/');
    				}
    			}
    			
    			setcookie('address_nickname','',time()+3600*24,'/');
    			setcookie('address_mobile','',time()+3600*24,'/');
    			setcookie('address_company','',time()+3600*24,'/');
    		}
    		
    		if($result){
    			
    			echo json_encode(array('success'=>'yes'));exit;
    		}else{
    			echo json_encode(array('success'=>'no','msg'=>'添加失败'));exit;
    		}
    	 
    }
    
	
//个人首页	
	function index(){ 
		 
		$data = $this->get_default_building();
		$data['login_flag'] = 0;
		$this->load->view('member/index',$data);
	}
	
	
	function get_default_building(){
		$uid = $this->_get_uid();
		 
		$data = $this->common->get_default_building($uid); 
		$data['login_flag'] = 0;
		
		$sys_mobile = $this->tickets->select('configs',array('tc_type'=>'jifen_config'));
		$data['sys_mobile'] = $sys_mobile[0]->tc_content;
		return $data;
	}
	function ajax_update_user_sex(){
		$tu_gender=trim($_POST["sex"]);
		$uid=$_POST["uid"];
		  $result = $this->tickets->update('users',array('tu_gender'=>$tu_gender),array('tu_id'=>$uid));
	   	if($result){
	   		echo json_encode(array('success'=>'yes','msg'=>'修改成功'));exit;
	   	}else{
	   		echo json_encode(array('success'=>'no','msg'=>'修改失败'));exit;
	   	}	
	}
	
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
	function close_order(){
		$order_id=trim($_POST["id"]);
		$close_order=$this->tickets->update("orders",array("to_status"=>"60"),array("to_id"=>$order_id));
	if($close_order){
		echo json_encode(array('success'=>'yes','msg'=>'已成功删除订单'));exit;
	}else{
		echo json_encode(array('success'=>'no','msg'=>'删除订单失败'));exit;
	}
	}
	
		
}	