<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class check extends Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('zip');
        $this->load->model('tickets');
        $this->load->model('common');
        $this->load->model('shopproduct');
        
        define('COUPON_USED', '2');
        define('VALID_CODES', '0');
        define('INVALID_CODES', '1');
        define('UNREADED', '0');
        define('VALID_STATUS', 1);
        define('DEFAULT_ADDRESS', 1);
        define('ORDER_NOT_PAYED', 10);
        define('ORDER_PAYED', 20);
        define('COUPON_NOT_USED', 0);
        define('COUPON_FREEZED', 1);
        define('WECHAT_ORDER', 1);
        ini_set('display_errors', 'On');
        define('EVENT_BUILDING', 3);
    }

    function check_id() {
     	$wechat_config_temp = $this->tickets->select('payment',array('name'=>'wechat'));
			$weipay = $wechat_config_temp[0];
			print_r($weipay);

        // $sql="update t_good_supplier_buildings set stock=100 where id=395";
        // $this->db->update('good_supplier_buildings',array('stock'=>100),array('id'=>395));
    }

    function orderdate() {
        $event_building_check = $this->tickets->api_select('service_buildings','id',array('status'=>3));
        print_r($event_building_check);

    }
	
	function check_cookie(){
		$temp_cart = isset($_COOKIE['goods_cart'])?$_COOKIE['goods_cart']:'';
					$temp_cart = unserialize($temp_cart);
			//print_r($temp_cart);
	}
             function _get_uid(){
                    //this function is come from main.php
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
        
      function find_uid(){
           $uid= $this->get_uid('/wechat/index');
             print_r($uid);
      }
      
      
      
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
        
        
        function text(){
                $find_id="tu_uid=828";
                $v['tu_username'] = asdasdasd;
		$v['tu_nickname'] = asdasdasd;
		$v['tu_portrait'] = 1111;
		$v['tu_birthday'] = '1990-01-01';
		$v['tu_gender'] = 女;
		$v['tu_weixin'] = 9;
		$v['tu_source'] = '1';
		$v['tu_created'] = date('Y-m-d H:i:s');     
            //    $result = $this->tickets->update('orders',array('to_status'=>20),array('to_prepay_id'=>$order_sn));
                $tem_uid=$this->tickets->update("users",$v,array("tu_id"=>"828"));   
                
                if($tem_uid){
                    echo 123;
                }else{
                    echo 456;
                }
        }
        
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
		//查看COOKIE里是否纪录有id
                $find_id=$this->_get_uid();	
                if($find_id){
                $v['tu_username'] = $result2->openid;
		$v['tu_nickname'] = $result2->nickname;
		$v['tu_portrait'] = $image['save_path'];
		$v['tu_birthday'] = '1990-01-01';
		$v['tu_gender'] = $gender;
		$v['tu_weixin'] = 9;
		$v['tu_source'] = '1';
		$v['tu_created'] = date('Y-m-d H:i:s');
              
                $tem_uid=$this->tickets->update("users",$v,$find_id);
                    
                    
                    
                }else{
                $v['tu_username'] = $result2->openid;
		$v['tu_nickname'] = $result2->nickname;
		$v['tu_portrait'] = $image['save_path'];
		$v['tu_birthday'] = '1990-01-01';
		$v['tu_gender'] = $gender;
		$v['tu_weixin'] = 9;
		$v['tu_source'] = '1';
		$v['tu_created'] = date('Y-m-d H:i:s');
		$tem_uid = $this->tickets->insert('users',$v);  
                    
                }	
		return $tem_uid;
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
	function tee(){ 
            header("Content-type: text/html; charset=utf-8");
     $goods = $this->common->_get_cookie_good_detail('wechat',array());
                $cart_goods=$goods['cart_goods'];
                 foreach($cart_goods as $key => $val){  
              // $count=$val[4]["count"];       
                       if($val["goods"]->id==46&&$val["week_count"]["week"]==0)
                            {
                              $Monday_tea= $Monday_tea+$val[0]["count"]; 
                              continue; 
                            }
                             if($val["goods"]->id==46&&$val["week_count"]["week"]==1)
                            {
                              $Tuesday_tea= $Tuesday_tea+$val[1]["count"];  
                             continue;
                            }
                             if($val["goods"]->id==46&&$val["week_count"]["week"]==2)
                            {
                              $Wednesday_tea= $Wednesday_tea+$val[2]["count"];
                              continue;
                            }
                             if($val["goods"]->id==46&&$val["week_count"]["week"]==3)
                            {
                              $Thursday_tea=$Thursday_tea+$val[3]["count"]; 
                              continue;
                            }
                             if($val["goods"]->id==46&&$val["week_count"]["week"]==4)
                            {
                             $Friday_tea= $Friday_tea+$val[4]["count"];
                             continue;
                            }
                             
            if($val["goods"]->cate_id==9&&$val["week_count"]["week"]==0){
                 $Monday_promote=$Monday_promote+$val[0]["count"];
             }else{
                  $Monday_product= $Monday_product+$val[0]["count"];
             }
              if($val["goods"]->cate_id==9&&$val["week_count"]["week"]==1){
                 $Tuesday_promote=$Tuesday_promote+$val[1]["count"];
             }else{
                  $Tuesday_product= $Tuesday_product+$val[1]["count"];
             }
              if($val["goods"]->cate_id==9&&$val["week_count"]["week"]==2){
                 $Wednesday_promote=$Wednesday_promote+$val[2]["count"];
             }else{ 
                  $Wednesday_product= $Wednesday_product+$val[2]["count"];
             }
              if($val["goods"]->cate_id==9&&$val["week_count"]["week"]==3){
                 $Thursday_promote=$Thursday_promote+$val[3]["count"];
             }else{
                  $Thursday_product= $Thursday_product+$val[3]["count"];
             }
                 
             
              if($val["goods"]->cate_id==9&&$val["week_count"]["week"]==4){
                 $Friday_promote=$Friday_promote+$val[4]["count"];
             }else{
                  $Friday_product= $Friday_product+$val[4]["count"];
             }
                                      
            }
           //1
            
			if($Monday_product>=$Monday_promote){
				$Monday_count=$Monday_promote;
			}else{
				$Monday_count=$Monday_product;
			}
			//2
			if($Tuesday_product>=$Tuesday_promote){
				$Tuesday_count=$Tuesday_promote;
			}else{
				$Tuesday_count=$Tuesday_product;
			}
			//3
			if($Wednesday_product>=$Wednesday_promote){
				$Wednesday_count=$Wednesday_promote;
			}else{
				$Wednesday_count=$Wednesday_product;
			}
			//4
			if($Thursday_product>=$Thursday_promote){
				$Thursday_count=$Thursday_promote;
			}else{
				$Thursday_count=$Thursday_product;
			}
			//5
			if($Friday_product>=$Friday_promote){
				$Friday_count=$Friday_promote;
			}else{
				$Friday_count=$Friday_product;
			}
                        //
                        //
                    $Monday_left=$Monday_product-$Monday_promote;
                   if($Monday_left>0&&($Monday_left>=$Monday_tea)){
                        $tea1=$Monday_tea;
                   }else if($Monday_left>0&&($Monday_left<$Monday_tea)){
                       $tea1= $Monday_left;
                   }
                    $Tuesday_left=$Tuesday_product-$Tuesday_promote;
                   if($Tuesday_left>0&&($Tuesday_left>=$Tuesday_tea)){
                       $tea2=$Tuesday_tea;
                   }else if($Tuesday_left>0&&($Tuesday_left<$Tuesday_tea)){
                       $tea2= $Tuesday_left;
                   }
                  $Wednesday_left=$Wednesday_product-$Wednesday_promote;
                   if($Wednesday_left>0&&($Wednesday_left>=$Wednesday_tea)){
                       $tea3=$Wednesday_tea;
                   }else if($Wednesday_left>0&&($Wednesday_left<$Wednesday_tea)){
                       $tea3= $Wednesday_left;
                   }
		$Thursday_left=$Thursday_product-$Thursday_promote;
                   if($Thursday_left>0&&($Thursday_left>=$Thursday_tea)){
                       $tea4=$Thursday_tea;
                   }else if($Thursday_left>0&&($Thursday_left<$Thursday_tea)){
                       $tea4= $Thursday_left;
                   }
                   $Friday_left=$Friday_product-$Friday_promote;
                   if($Friday_left>0&&($Friday_left>=$Friday_tea)){
                      $tea5=$Friday_tea;
                   }else if($Friday_left>0&&($Friday_left<$Friday_tea)){
                       $tea5= $Friday_left;
                   }
             $tea=$tea1+$tea2+$tea3+$tea4+$tea5;  
      
       // echo "<br/>";
        //echo $Monday_promote;
		}
		function order(){
			header("Content-Type:text/html;charset=utf-8"); 
			$order = $this->tickets->select('orders',array('to_uid'=>2923,"to_status"=>10),'','','',array('to_id'=>'desc'));
			if($order){
	   		foreach($order as $k=>$v){
	   			$temp_order = $this->common->_get_order_detail(2923,$v->to_id);  			
	   			//获得最小用餐日期
	   			$service_date = array();
	   			foreach($temp_order as $key=>$val){
	   				$service_date[] = strtotime($val->service_date);
	   			}
	   			sort($service_date);
	   			$order[$k]->first_server_date = $service_date[0]; 
				$usetime=$order[$k]->first_server_date;
				$nowday=date("Y-m-d",strtotime());
				print_r($temp_order);
				if($usetime>$nowday){
					$order[$k]->order_detail = $temp_order;
					//print_r($order[$k]->order_detail);
				}
	   				
	   			
				
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
	   			
	   	
	   		}
	   	}else{
	   		$order = '';
	   	}
	
	   	//$data['orders'] = $order;
			}
			
            function week(){
                $now_time="2015-06-06 00:00:00";
                $price_lower=0;
                $price_limit=100;
                $service_buildings = $this->tickets->personal_select($building_sql);
               	$where = '1=1';
	    	  
	    	if($default_building_id){
	    		$where.=" and id = ".$default_building_id." ";
	    	}
	    	
	    	$building_sql = "select name,id,start_time,end_time from t_service_buildings where ".$where;
	   
	    	$service_buildings = $this->tickets->personal_select($building_sql);
	    	 
		    $now_time = date('Y-m-d H:i:s');
                    //价格筛选
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
		    foreach($service_buildings as $k=>$v){
	    	   $sql = "select t_goods.*,t_good_supplier_buildings.*,t_supplier.name as supplier_name,t_supplier_good.*  from t_good_supplier_buildings,t_goods,t_supplier,t_supplier_good where
				 t_good_supplier_buildings.end_time > '".$now_time."' and t_goods.price>=0 and t_goods.price<1 and t_good_supplier_buildings.good_id= t_goods.id and t_goods.id=t_supplier_good.good_id and t_supplier_good.supplier_id = t_supplier.id and t_good_supplier_buildings.building_id = ".$v->id." order by t_goods.price desc,t_goods.cate_id asc" ;
			
		    	$goods = $this->tickets->personal_select($sql);
		    	 
		    	if(!$goods){
		    			unset($service_buildings[$k]);
		    	}else{
		    		foreach($goods as $key=>$val){
			    		$goods[$key]->week = explode(',',$val->week);
				    }
				    $service_buildings[$k]->temp_goods = $goods;
				}
			}
          
		    
                        print_r($goods);
               }
               function find_goods(){
                   header("Content-Type:text/html;charset=utf-8"); 
             $service_datas = $this->common->_get_all_valid_buildings(43);
             $now_time=date("Y-m-d H:i:s"); 
          
             $sql="select t_activity_stock.*,t_favourable_activity.*,t_users_group.*,t_users_rank.*,t_users.* from t_activity_stock,t_favourable_activity,t_users_group,t_users_rank,t_users where t_activity_stock.act_id=t_favourable_activity.act_id and t_favourable_activity.user_type_ext=t_users_group.group_id and
                  t_users_group.group_id=t_users.tu_groupid and t_users.tu_rankid=t_users.tu_rankid";
          
                       /*  $sql="select t_users.groupid t_favourable_activity.*,t_users_group.*,t_users_rank.* from 
                                        t_favourable_activity,t_users_group,t_users_rank,t_users";*/
                                   //$price_promote=
                                  
                      
             foreach($service_datas as $k=>$v){
			$sql = "select t_goods.*,t_good_supplier_buildings.*,t_supplier.name as supplier_name,t_supplier_good.*  from t_good_supplier_buildings,t_goods,t_supplier,t_supplier_good where
				 t_good_supplier_buildings.end_time > '".$now_time."' and t_good_supplier_buildings.good_id= t_goods.id and t_goods.id=t_supplier_good.good_id and t_supplier_good.supplier_id = t_supplier.id and t_good_supplier_buildings.building_id = 43 order by t_goods.price desc,t_goods.cate_id asc" ;
			
		    	$goods = $this->tickets->personal_select($sql);
                        foreach($goods as $key=>$val){
                          // $val->promote_price=
                            
                                       
			    		//$goods[$key]->week = explode(',',$val->week);
				    }
			}
			// print_r($service_datas);
                           
               }
                function check_good(){
                          header("Content-Type:text/html;charset=utf-8"); 
                      $data['return_url'] = base_url();
                echo base_url();}
                function setcookie(){
                 
                    setcookie("abc","1111",0);
                         echo $_COOKIE['abc'];
                       
                }
                function go(){
                     $user_check = $this->db->select('users',array('tu_mobile'=>18516244053))->row();
        print_r($user_check);
                }
		
   }