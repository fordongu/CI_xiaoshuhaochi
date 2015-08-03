<?php
class common extends Model {


	function _oauth_check(){
		$current_method = $this->router->method;
		$login_user = $this->session->userdata('user');
		$oauth = $login_user[0]->oauth;
		//echo '<pre>';

		if (in_array($current_method,$this->all_menu()) && (!in_array($current_method,$oauth))){
			header("Content-type: text/html; charset=utf-8");
			echo "<script>alert('您没有权限访问此菜单，请联系管理员！')</script>";exit;
		}
	}


	function _get_cookie_shipping_id_no_uid(){
		$user_cookie_shipping = isset($_COOKIE['user_cookie_shipping'])?$_COOKIE['user_cookie_shipping']:'';
		$user_cookie_shipping_default = isset($_COOKIE['user_cookie_shipping_default'])?$_COOKIE['user_cookie_shipping_default']:'';

		if($user_cookie_shipping_default){

			return array('user_cookie_shipping'=>$user_cookie_shipping,'user_cookie_shipping_default'=>$user_cookie_shipping_default);
		}else{

			return 0;
		}
	}




	function all_menu(){
		return array('auto_service',
				'single_list',
				'category_index',
				'supplier_index',
				'areas',
				'service_buildings_index',
				'good_index',
				'order_index',
				'coupon',
				'admin_oauth',
				'admin_index',
				'user_list',
				'company_index',
				'event_index',
				'sms_config',
				'jifen_bili_config',
				'payment_index',
				'reset_password',
				'menu_settings_index',
				'weichat_settings',
				'order_time_settings',
				'order_date',
				'order_count'
		);
	}


	function module_config(){
		return array('auto_service'=>'首次关注微信回复',
				'single_list'=>'图文回复',
				'category_index'=>'菜品品类管理',
				'supplier_index'=>'供应商管理',
				'areas'=>'省市区管理',
				'service_buildings_index'=>'配送区域管理',
				'good_index'=>'菜品管理',
				'order_index'=>'订单管理',
				'coupon'=>'优惠券管理',
				'admin_oauth'=>'角色权限管理',
				'admin_index'=>'后台用户管理',
				'user_list'=>'用户列表',
				'company_index'=>'企业用户列表',
				'event_index'=>'活动列表',
				'sms_config'=>'短信配置',
				'jifen_bili_config'=>'积分比例配置',
				'payment_index'=>'支付开关',
				'reset_password'=>'修改密码',
				'menu_settings_index'=>'自定义菜单配置',
				'weichat_settings'=>'微信账号相关配置',
				'order_time_settings'=>'下单时间配置',
				'order_date'=>'下单提前天数管理',
				'order_count'=>'订单商品份数管理'
				);
	}


	function get_order_stauts_config(){
		return array('10'=>'未付款','20'=>'已付款未处理','30'=>'已确认','40'=>'成功订单','50'=>'过期无效订单','60'=>'用户删除','70'=>'已取消');
	}

    function get_valid_event($uid){
    	$event = array();
    	$current_time = date('Y-m-d');
    	$default_shipping_address = $this->tickets->api_select('shipping_address','tsa_company',array('tsa_uid'=>$uid,'tsa_default'=>1));
    	if ($default_shipping_address&&$default_shipping_address[0]->tsa_company){
    		$sql_event = "select t_event.price,t_event.name from t_event,t_companys where t_companys.event_id = t_event.id and t_event.start_time <= '".$current_time."' and t_event.end_time >= '".$current_time."'  and t_companys.id=".$default_shipping_address[0]->tsa_company;
    		$temp_event = $this->tickets->personal_select($sql_event);
    		if ($temp_event){
    			$event = $temp_event[0];
    		}
    	}
    	return $event;
    }


    function get_order_detail($order_id){
    	$order_sql = "select t_goods.*,t_goods.id as g_id,t_orders.*,t_order_good.*,t_categorys.name as cate_name from t_orders,t_order_good,t_categorys,t_goods";
    	$order_sql.=" where t_orders.to_id = t_order_good.order_id and t_order_good.good_id = t_goods.id and t_goods.cate_id = t_categorys.id and t_orders.to_id=".$order_id;
    	return $this->tickets->personal_select($order_sql);

    }

	//获取订单详情
	function _get_order_detail($uid,$order_id){
		$sql ="select t_orders.*,t_categorys.name as cate_name,t_orders.to_uid,t_order_good.perprice as now_price,t_order_good.good_id,t_order_good.service_date,t_order_good.count,t_goods.* from t_categorys,t_orders,t_order_good,t_goods";
		$sql.=" where t_orders.to_id = t_order_good.order_id and t_order_good.good_id=t_goods.id and t_goods.cate_id=t_categorys.id and t_orders.to_uid=".$uid." and t_orders.to_id=".$order_id;
		$temp_order = $this->tickets->personal_select($sql);
		return $temp_order;
	}




	function coupons_types(){
		return array('follow'=>'首次关注','first_order'=>'首次消费','total_amount'=>'累计消费额满',
				'per_order'=>'单笔订单额满','order_amount'=>'累计订餐次数','buchang'=>'补偿用户');
	}




	function send_sms($mobile,$content){
		require_once APPPATH.'libraries/sms/Client.php';
		$sms_config = $this->tickets->select('configs',array('tc_type'=>'sms_config'));
		if (!$sms_config){
			return false;
		}else{
			$config = $sms_config[0];
		}
		/**
		 * 网关地址
		 */
		$gwUrl = 'http://sdk4report.eucp.b2m.cn:8080/sdk/SDKService';

		/**
		 * 序列号,请通过亿美销售人员获取
		 */
		$serialNumber = $config->tc_title;//'6SDK-EMY-6688-KGZSP';

		/**
		 * 密码,请通过亿美销售人员获取
		 */
		$password = $config->tc_content;//'845379';

		/**
		 * 登录后所持有的SESSION KEY，即可通过login方法时创建
		 */
		$sessionKey = '123456';

		/**
		 * 连接超时时间，单位为秒
		 */
		$connectTimeOut = 2;

		/**
		 * 远程信息读取超时时间，单位为秒
		 */
		$readTimeOut = 10;

		$proxyhost = false;
		$proxyport = false;
		$proxyusername = false;
		$proxypassword = false;

		$client = new Client($gwUrl,$serialNumber,$password,$sessionKey,$proxyhost,$proxyport,$proxyusername,$proxypassword,$connectTimeOut,$readTimeOut);
		/**
		 * 发送向服务端的编码，如果本页面的编码为GBK，请使用GBK
		*/
		$client->setOutgoingEncoding("utf8");
		$statusCode = $client->login();
		$statusCode = $client->sendSMS(array($mobile),$content);
		if ($statusCode==0){
			return true;
		}else{
			return false;
		}

	}



	//改变订单状态
	function change_order_status($order_sn,$wechat=''){
		$this->tickets->translate_begin();



		if($wechat){
			$temp_order = $this->tickets->select('orders',array('to_prepay_id'=>$order_sn));
			error_log(print_r($temp_order[0],true),3,'/data/www/wechat.txt');
			$result = $this->tickets->update('orders',array('to_status'=>20 ,'to_pay_status'=>1),array('to_prepay_id'=>$order_sn));
		}else{
			$temp_order = $this->tickets->select('orders',array('to_order_sn'=>$order_sn));
			error_log(print_r($temp_order[0],true),3,'/data/www/main.txt');
		    if($temp_order[0]->to_status == 10){
				$result = $this->tickets->update('orders',array('to_status'=>20,'to_pay_status'=>1),array('to_order_sn'=>$order_sn));
		    }
		}
		if($result){
			$this->tickets->translate_commit();
			return true;
		}else{
			$this->tickets->translate_rollback();
			return false;
		}

	}





	function payment_config(){
		return array('alipay'=>'支付宝','wechat'=>'微信支付','daofu'=>'货到付款');
	}


	function pay_order($order_sn,$folder,$c){
		require_once($folder."/alipay.config.php");
		require_once($folder."/lib/alipay_submit.class.php");

		$alipay_config_temp = $this->tickets->select('payment',array('name'=>'alipay'));
		$alipay_con = $alipay_config_temp[0];
		//支付类型
		$payment_type = "1";
		//必填，不能修改
		//服务器异步通知页面路径

		$notify_url = base_url().$c."/notify_url";
		//需http://格式的完整路径，不允许加?id=123这类自定义参数

		//页面跳转同步通知页面路径
		$return_url = base_url()."return_url.php";
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
				//必填

				//付款金额
				$total_fee = $o[0]->to_order_amount;
				//必填

				//订单描述

				$body = $o[0]->to_receiver.'新订单';
				//商品展示地址
				$show_url = '';
				//需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html

				//防钓鱼时间戳
				$anti_phishing_key = time();
				//若要使用请调用类文件submit中的query_timestamp函数

				//客户端的IP地址
				$exter_invoke_ip = "";
				//非局域网的外网IP地址，如：221.0.0.1


				/************************************************************/
				$alipay_config['partner'] = $alipay_con->app_id;
				$alipay_config['key'] = $alipay_con->app_secret;
				//构造要请求的参数数组，无需改动
				$parameter = array(
				"service" => "create_direct_pay_by_user",
				"partner" => trim($alipay_config['partner']),
				"payment_type"	=> $payment_type,
				"notify_url"	=> $notify_url,
				"return_url"	=> $return_url,
				"seller_email"	=> $seller_email,
				"out_trade_no"	=> $out_trade_no,
				"subject"	=> $subject,
				"total_fee"	=> $total_fee,
				"body"	=> $body,
				"show_url"	=> $show_url,
				"anti_phishing_key"	=> $anti_phishing_key,
				"exter_invoke_ip"	=> $exter_invoke_ip,
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		);

				//建立请求
				$alipaySubmit = new AlipaySubmit($alipay_config);;
				$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");

				$data['text'] = $html_text;
				return $data;
	}

	function save_order($uid,$order_type,$c,$event=array(),$invate_code){
		$pay_config = trim($_POST['payway']);
		$comment    = trim($_POST['comment_input']);

		if($uid){
		$sql="SELECT t_shipping_address.*,t_service_buildings.address as building_address, t_companys.event_id,t_companys.id,t_companys.name as company_name,t_companys.address as company_address, t_province.province, t_city.city, t_area.area FROM t_companys,t_shipping_address, t_city, t_province, t_service_buildings,t_area WHERE t_shipping_address.tsa_company= t_companys.id and t_shipping_address.tsa_province = t_province.province_id
AND t_shipping_address.tsa_city = t_city.city_id
and t_shipping_address.tsa_building_id = t_service_buildings.id
AND t_shipping_address.tsa_district = t_area.area_id and t_shipping_address.tsa_uid=".$uid;
		$default_address = $this->tickets->personal_select($sql." and t_shipping_address.tsa_default=1");
		}
		$building_id = $default_address[0]->tsa_building_id;

		if(!$default_address){
			echo json_encode(array('success'=>'no','msg'=>'请选择配送地址'));exit;
		}
		$address = $default_address[0];


		$goods = $this->_get_cookie_good_detail($c,$event);

		if ($goods['cart_goods']){
	//判断库存



			foreach ($goods['cart_goods'] as $k=>$v){
				if($v['week_count']['count']){
					 if($_COOKIE["set_building"]==143){
						 $id=143;
					 }else{
						$id=43;
					 }

					//更新库存
					$temp_stock = $this->tickets->api_select('good_supplier_buildings','id,stock',array('good_id'=>$v['goods']->id,'building_id'=>$id));//$v['week_count']['building_id']
					$stock = $temp_stock[0];

					$final_stock = $stock->stock-$v['week_count']['count'];
					if ($final_stock <0){
						$temp_goods = $this->tickets->api_select('goods','name',array('id'=>$v['goods']->id));
						if ($temp_goods){
							$good_name = $temp_goods[0]->name;

							echo json_encode(array('success'=>'no','msg'=>$good_name.'库存不足,剩余'.$stock->stock.'份'));exit;
						}
					}
				}
			}
			//邀请码活动
				if(!empty($invate_code)){
				  $code=strtolower($invate_code);//邀请码
				  $invate_code=$this->tickets->select("users",array("tu_invate_code"=>$code));
				  $tu_id=$invate_code[0]->tu_id;//邀请人的ID
		//$uid自己的ID
				  $arr['in_tu_id'] = $tu_id;//邀请人的ID
				  $arr['in_self_id'] = $uid;//自己的ID
				  $arr['in_invate_code'] = $code;//邀请码
				  $arr['in_used'] = date('Y-m-d H:i:s', time());//使用时间
				  $id=$this->tickets->insert("invate_code",$arr);
				  if($id){
					  $price=15;
				  }else{
					  $price=0;
				  }
			//以上是在今日增加使用邀请码
				  $cut_down=$goods['cookie_count']*15;//有多少份就减少多少个15元
				}
			$promote_price=$this->promote_price();


			$total_count = $goods['cookie_count'];
			$total_price = $goods['total_count']-$cut_down-$promote_price;
			$orignal_amount = $goods['orignal_amount'];

			$coupons_id = $_POST['coupons_id'];
			$coupon_price = 0;
			if($coupons_id){
				$sq = "select t_coupons_record.*,t_coupons.tc_price from t_coupons,t_coupons_record where t_coupons_record.tcr_id=".$coupons_id." and t_coupons.tc_id=t_coupons_record.tcr_tc_id and t_coupons_record.tcr_status= 0 and t_coupons_record.tcr_uid=".$uid;

				$coupon_check = $this->tickets->personal_select($sq);
				if(!$coupon_check){
					echo json_encode(array('success'=>'no','msg'=>'此优惠券无效，请核对'));exit;
				}else{
					$coupon_price = $coupon_check[0]->tc_price;
				}
			}

			$order_sn = 'S'.date('YmdHis').$this->_generate_code(4);
			$real_pay_price = $total_price-$coupon_price;
			$order_status = 10;
			if($real_pay_price <= 0){
				$real_pay_price = 0;
				$order_status = 20;

			}
		//判断活动的可用性
			$current_time = date('Y-m-d');
		    $event_check = $this->tickets->api_select('event','',array('start_time >='=>$current_time,'end_time <='=>$current_time,'id'=>$address->event_id));
		    if($event_check){
		    	$event_id = $address->event_id;
		    }else{
		    	$event_id = 0;
		    }


			$order_data = array(
					'to_comment'=>$comment,
					'to_event_id'=>$event_id,
					'to_company'=>$address->tsa_company,
					'to_receiver'=>$address->tsa_nickname,
					'to_mobile'=>$address->tsa_mobile,
					//'to_address'=>$address->province.' '.$address->city.' '.$address->area.' '.$address->tsa_address.' '.$address->building_address.' '.$address->company_address,
					'to_address'=>$address->province.' '.$address->city.' '.$address->area.' '.$address->building_address.' '.$address->company_address,
					'to_order_sn'=>$order_sn,
					'to_pay_way'=>$pay_config,
					'to_created'=>date('Y-m-d H:i:s'),
					'to_uid'=>$uid,
					'to_order_type'=>$order_type,
					'to_order_amount'=>$real_pay_price,
					'to_total_amount'=>$total_price,
					'to_orignal_amount'=>$orignal_amount,
					'to_coupon_id'=>$coupons_id,
					'to_shipping_id'=>$address->tsa_id,
					'to_status'=>$order_status
			);

			$temp_valid_date = $this->tickets->select('configs',array('tc_type'=>'order_date'));
			$valid_time = $temp_valid_date[0]->tc_title;
			$current_time = date('H:i');
		    $current_date = date('Y/m/d');

			$order_id = $this->tickets->insert('orders',$order_data);
			if ($order_status == 20){

				error_log(print_r($order_data,true),3,'/data/www/orginal_main_price.txt');
			}

			if ($order_id){


				foreach ($goods['cart_goods'] as $k=>$v){
					if($v['week_count']['count']){
							$temp_date = array(
									'service_date'=>$v['goods']->date,
									'good_id'=>$v['goods']->id,
									'o_count'=>$v['week_count']['count'],
									'o_perprice'=>$v['goods']->price,
									'count'=>$v['week_count']['count'],
									'perprice'=>$v['goods']->price-$price,//$price是邀请码活动的价格$promote_price是饮料组合减少的价格
									'order_id'=>$order_id,
									'order_status'=>10,
									'created'=>date('Y-m-d H:i:s'));
							$this->tickets->insert('order_good',$temp_date);
		//更新库存
		 			  $temp_stock = $this->tickets->api_select('good_supplier_buildings','id,stock',array('good_id'=>$v['goods']->id,'building_id'=>$v['week_count']['building_id']));
					  $stock = $temp_stock[0];

					  $final_stock = $stock->stock-$v['week_count']['count'];
					  if ($final_stock >=0){
					  	  $this->tickets->update('good_supplier_buildings',array('stock'=>$final_stock),array('id'=>$stock->id));
					  }
					}
				}
				//如果有使用优惠券,则冻结此优惠券
				if($coupons_id){
					$this->tickets->update('coupons_record',array('tcr_status'=>1,'tcr_updated'=>date('Y-m-d H:i:s')),array('tcr_id'=>$coupons_id));
				}
				setcookie('goods_cart','',time()+3600*24,'/');
				echo json_encode(array('success'=>'yes','order_sn'=>$order_sn,'pay_config'=>$pay_config,'order_price'=>$real_pay_price));exit;
			}
		}
	}

	function save_order_new($uid,$order_type,$c,$event=array(),$invate_code){
		$pay_config = trim($_POST['payway']);
		$comment    = trim($_POST['comment_input']);

		if($uid){
		$sql="SELECT t_shipping_address.*,t_service_buildings.address as building_address, t_companys.event_id,t_companys.id,t_companys.name as company_name,t_companys.address as company_address, t_province.province, t_city.city, t_area.area FROM t_companys,t_shipping_address, t_city, t_province, t_service_buildings,t_area WHERE t_shipping_address.tsa_company= t_companys.id and t_shipping_address.tsa_province = t_province.province_id
AND t_shipping_address.tsa_city = t_city.city_id
and t_shipping_address.tsa_building_id = t_service_buildings.id
AND t_shipping_address.tsa_district = t_area.area_id and t_shipping_address.tsa_uid=".$uid;
		$default_address = $this->tickets->personal_select($sql." and t_shipping_address.tsa_default=1");
		}
		$building_id = $default_address[0]->tsa_building_id;

		if(!$default_address){
			echo json_encode(array('success'=>'no','msg'=>'请选择配送地址'));exit;
		}
		$address = $default_address[0];

		//$goods = $this->_get_cookie_good_detail($c,$event);
		$new_website = $this->config->item('new_website');
		$this->load->helper('curl');
		$goods_json = vget($new_website."/cart/getCart",array('Cookie:this_week_cart='.$_COOKIE['this_week_cart'].';next_week_cart='.$_COOKIE['next_week_cart']));
		$goods = json_decode($goods_json, TRUE);
		//$this->load->model('cart_model');
		//$goods = $this->cart_model->getCartInfo();
		if (empty($goods['cart_goods'][0]) && empty($goods['cart_goods'][1])) {
			echo json_encode(array('success'=>'no','msg'=>'商品过期或者购物车没商品'));exit;
		}

		if ($goods['cart_goods'][0] || $goods['cart_goods'][1]){
	//判断库存
			$cart_goods_list = array_merge($goods['cart_goods'][0], $goods['cart_goods'][1]);

			if($_COOKIE["set_building"]==143){
				$building_id=143;
			}else{
				$building_id=43;
			}
			foreach ($cart_goods_list as $k=>$v){
				//if($v['week_count']['count']){
					//更新库存
					$temp_stock = $this->tickets->api_select('good_supplier_buildings','id,stock',array('good_id'=>$v['goods_id'],'building_id'=>$building_id));
					$stock = $temp_stock[0];

					$final_stock = $stock->stock-$v['goods_num'];
					if ($final_stock <0){
						$temp_goods = $this->tickets->api_select('goods','name',array('id'=>$v['goods_id']));
						if ($temp_goods){
							$good_name = $temp_goods[0]->name;

							echo json_encode(array('success'=>'no','msg'=>$good_name.'库存不足,剩余'.$stock->stock.'份'));exit;
						}
					}
				//}
			}
			//邀请码活动
				if(!empty($invate_code)){
				  $code=strtolower($invate_code);//邀请码
				  echo 5555;exit;
				  $invate_code=$this->tickets->select("users",array("tu_invate_code"=>$code));
				  $tu_id=$invate_code[0]->tu_id;//邀请人的ID
		//$uid自己的ID
				  $arr['in_tu_id'] = $tu_id;//邀请人的ID
				  $arr['in_self_id'] = $uid;//自己的ID
				  $arr['in_invate_code'] = $code;//邀请码
				  $arr['in_used'] = date('Y-m-d H:i:s', time());//使用时间
				  $id=$this->tickets->insert("invate_code",$arr);
				  if($id){
					  $price=15;
				  }else{
					  $price=0;
				  }
			//以上是在今日增加使用邀请码
				  $cut_down=$goods['goods_count']*15;//有多少份就减少多少个15元
				}
			//$promote_price=$this->promote_price();
			$promote_price= 0;//2015/5/4暂时不用组合价格

			$total_count = $goods['goods_count'];
			$total_price = $goods['total_price']-$cut_down-$promote_price;
			$orignal_amount = $goods['total_price'];

			$coupons_id = $_POST['coupons_id'];
			$coupon_price = 0;
			if($coupons_id){
				$sq = "select t_coupons_record.*,t_coupons.tc_price from t_coupons,t_coupons_record where t_coupons_record.tcr_id=".$coupons_id." and t_coupons.tc_id=t_coupons_record.tcr_tc_id and t_coupons_record.tcr_status= 0 and t_coupons_record.tcr_uid=".$uid;

				$coupon_check = $this->tickets->personal_select($sq);
				if(!$coupon_check){
					echo json_encode(array('success'=>'no','msg'=>'此优惠券无效，请核对'));exit;
				}else{
					$coupon_price = $coupon_check[0]->tc_price;
				}
			}

			$order_sn = 'S'.date('YmdHis').$this->_generate_code(4);
			$real_pay_price = $total_price-$coupon_price;
			$order_status = 10;
			if($real_pay_price <= 0){
				$real_pay_price = 0;
				$order_status = 20;

			}
		//判断活动的可用性
			$current_time = date('Y-m-d');
		    $event_check = $this->tickets->api_select('event','',array('start_time >='=>$current_time,'end_time <='=>$current_time,'id'=>$address->event_id));
		    if($event_check){
		    	$event_id = $address->event_id;
		    }else{
		    	$event_id = 0;
		    }

			$order_data = array(
					'to_comment'=>$comment,
					'to_event_id'=>$event_id,
					'to_company'=>$address->tsa_company,
					'to_receiver'=>$address->tsa_nickname,
					'to_mobile'=>$address->tsa_mobile,
					//'to_address'=>$address->province.' '.$address->city.' '.$address->area.' '.$address->tsa_address.' '.$address->building_address.' '.$address->company_address,
					'to_address'=>$address->province.' '.$address->city.' '.$address->area.' '.$address->building_address.' '.$address->company_address,
					'to_order_sn'=>$order_sn,
					'to_pay_way'=>$pay_config,
					'to_created'=>date('Y-m-d H:i:s'),
					'to_uid'=>$uid,
					'to_order_type'=>$order_type,
					'to_order_amount'=>$real_pay_price,
					'to_total_amount'=>$total_price,
					'to_orignal_amount'=>$orignal_amount,
					'to_coupon_id'=>$coupons_id,
					'to_shipping_id'=>$address->tsa_id,
					'to_status'=>$order_status
			);

			$temp_valid_date = $this->tickets->select('configs',array('tc_type'=>'order_date'));
			$valid_time = $temp_valid_date[0]->tc_title;
			$current_time = date('H:i');
		    $current_date = date('Y/m/d');

			$order_id = $this->tickets->insert('orders',$order_data);
			if ($order_status == 20){

				error_log(print_r($order_data,true),3,'/data/www/orginal_main_price.txt');
			}

			if ($order_id){


				foreach ($cart_goods_list as $k=>$v){
					//if($v['week_count']['count']){
							$temp_date = array(
									'service_date'=>$v['date'],
									'good_id'=>$v['goods_id'],
									'o_count'=>$v['goods_num'],
									'o_perprice'=>$v['price'],
									'count'=>$v['goods_num'],
									'perprice'=>$v['price']-$price,//$price是邀请码活动的价格$promote_price是饮料组合减少的价格
									'order_id'=>$order_id,
									'order_status'=>10,
									'created'=>date('Y-m-d H:i:s'));
							$this->tickets->insert('order_good',$temp_date);
		//更新库存
		 			  $temp_stock = $this->tickets->api_select('good_supplier_buildings','id,stock',array('good_id'=>$v['goods_id'],'building_id'=>$building_id));
					  $stock = $temp_stock[0];

					  $final_stock = $stock->stock-$v['goods_num'];
					  if ($final_stock >=0){
					  	  $this->tickets->update('good_supplier_buildings',array('stock'=>$final_stock),array('id'=>$stock->id));
					  }
					//}
				}
				//如果有使用优惠券,则冻结此优惠券
				if($coupons_id){
					$this->tickets->update('coupons_record',array('tcr_status'=>1,'tcr_updated'=>date('Y-m-d H:i:s')),array('tcr_id'=>$coupons_id));
				}
				//setcookie('goods_cart','',time()+3600*24,'/');
				$this->load->helper('cookie');
				delete_cookie('this_week_cart');
				delete_cookie('next_week_cart');
				//setcookie('next_week_cart','',time()+3600*24,'/');
				echo json_encode(array('success'=>'yes','order_sn'=>$order_sn,'pay_config'=>$pay_config,'order_price'=>$real_pay_price));exit;
			}
		}
	}


	function get_default_building($uid=0){
	    $cond = array();
		if($uid){
		$default_building_id = 0;
		$order_check = $this->tickets->api_select('orders','to_company',array('to_uid'=>$uid),'','','',array('to_id'=>'desc'));
		if ($order_check){
			$company_id = $order_check[0]->to_company;
			$company_check = $this->tickets->api_select('companys','service_building_id',array('id'=>$company_id));
			if ($company_check&&$company_check[0]->service_building_id){
				$default_building_id = $company_check[0]->service_building_id;
			}
		}

		if (!$default_building_id){
		  $temp_user = $this->tickets->api_select('users','tu_default_building',array('tu_id'=>$uid));
		  if($temp_user[0]->tu_default_building){
		  	$default_building_id = $temp_user[0]->tu_default_building;
		  }

		}
			$cond = array('id'=>$default_building_id);
		    $building = $this->tickets->api_select('service_buildings','name',$cond);
		    if ($building){
		    	$data['service_buildings'] = $building[0]->name;
		    }else{
		    	$data['service_buildings'] = '';
		    }
		}else{
			$service_datas = $this->common->_get_all_valid_buildings();
			$data['service_buildings'] = $service_datas['final_buildings'][0]['name'];
		}

		$sys_mobile = $this->tickets->select('configs',array('tc_type'=>'jifen_config'));
		$data['sys_mobile'] = $sys_mobile[0]->tc_content;
		return $data;
	}



	function _generate_code($len = 20)
	{
		if($len==12){
			$chars = '0123456789';
		}else{
			$chars = '0123456789';
		}
		for ($i = 0, $count = strlen($chars); $i < $count; $i++)
		{
		$arr[$i] = $chars[$i];
		}

		mt_srand((double) microtime() * 1000000);
		shuffle($arr);
		$code = substr(implode('', $arr),0 , $len);
				return $code;
	}


	//_get_cookie_good_detail
	function _get_cookie_good_detail($c,$event=array(),$value=null){

		$cookie_cart = $this->_get_cookie_cart();
		$cart_goods = $cookie_cart['cookie_cart'];

		if(!$cart_goods&&$value=null){
			redirect('/'.$c.'/index');exit;
		}
		$total_count = 0;
		$orignal_amount = 0;
		$future_date = $this->_get_valid_weeks();
                if($cart_goods){
                    foreach($cart_goods as $k=>$i){
			foreach($i as $j=>$v){
				$sql_good = "select t_goods.*,t_categorys.name as cate_name from t_goods,t_categorys where t_goods.cate_id = t_categorys.id and t_goods.id=".$v['id'];
				$temp_good = $this->tickets->personal_select($sql_good);
				$temp_goods = $temp_good[0];
				$orignal_amount+=$v['count']*$temp_goods->price;
				if(count($event)>0){
					$temp_goods->event_name = $event->name;

					$total_count+=$v['count']*$event->price;
				}else{
					$total_count+=$v['count']*$temp_goods->price;
					$temp_goods->event_name = '无';
				}
				$temp_goods->date = date('Y/m/d',strtotime($future_date[$j]));
				$cart_goods[$k]['goods'] = $temp_goods;
				$v['week'] = $j;
				$cart_goods[$k]['week_count'] = $v;
			//取出此才的 写字楼id


			}


		}
                }

		return array('orignal_amount'=>$orignal_amount,'total_count'=>$total_count,'cart_goods'=>$cart_goods,'cookie_count'=>$cookie_cart['cookie_count']);
	}

	//
	function _get_cookie_cart(){
		$temp_cart = isset($_COOKIE['goods_cart'])?$_COOKIE['goods_cart']:'';

			if ($temp_cart){
				$temp_cart = unserialize($temp_cart);

				$temp_good = array();
				$count = 0;
			    $week_array = $this->_get_valid_weeks();

				foreach($temp_cart as $k=>$v){
					$temp_k = explode('_',$k);

						$temp_good[] = array($temp_k[1]=>array('id'=>$temp_k[0],'count'=>$v['count'],'building_id'=>$v['building_id']));
						$count+=$v['count'];
				}
				return array('cookie_cart'=>$temp_good,'cookie_count'=>$count);
			}else{
				return array('cookie_cart'=>'','cookie_count'=>0);
			}
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
				return 0;//redirect('/main/default_index');
			}
		}


    function cookie_cart($good_id,$count,$building_id=0){
    	    if ($building_id){
           	    $cookie_building_id = $building_id;
    	    }else{
    	    	$cookie_building_id = $this->_get_cookie_building();
    	    }
			$temp_cart = isset($_COOKIE['goods_cart'])?$_COOKIE['goods_cart']:'';
			if ($temp_cart){
					$temp_cart = unserialize($temp_cart);

					foreach($temp_cart as $k=>$v){
						if($k == $good_id){
							if($count == 0){
							   unset($temp_cart[$k]);
							}else{
								$temp_cart[$k]['count'] = $count;
							}
						}else{
							$temp_cart[$good_id]=array('count'=>$count,'building_id'=>$cookie_building_id);
						}
					}

				}else{
						$temp_cart[$good_id]=array('count'=>$count,'building_id'=>$cookie_building_id);
				}
					$temp_count = 0;

				foreach($temp_cart as $k=>$v){
				   $temp_count+=$v['count'];
			    }
			if ($temp_count ==0){
				setcookie('goods_cart','',time()+3600*24,'/');
			}else{

                                if(setcookie('goods_cart',serialize($temp_cart),time()+3600*24,'/')){
                                    
                                }
			}
	       echo json_encode(array('success'=>'yes','count'=>$temp_count));exit;

	}


	function _get_valid_weeks(){
			$temp_valid_date = $this->tickets->select('configs',array('tc_type'=>'order_date'));
		$valid_time = $temp_valid_date[0]->tc_title;
		$current_time = date('H:i:s');
		$current_week = date("N",time());
		$today_flag = 0;
		if($current_time < $temp_valid_date[0]->tc_title){
			$today_flag = 1;
		}
               
                       
	     if(date("N")==5){
			if($current_time > $temp_valid_date[0]->tc_title){

				$current_week = 5;
			}else{
				$current_week = 10;
			}

		}
                /*
                if($current_week==7&&$current_time > $temp_valid_date[0]->tc_title){
                    $week = array(
                                        0=>date('Y-m-d',strtotime(' +1 days')),
					1=>date('Y-m-d',strtotime(' +2 days')),
					2=>date('Y-m-d',strtotime(' +3 days')),
					3=>date('Y-m-d',strtotime(' +4 days')),
					4=>date('Y-m-d',strtotime(' +5 days')),
                                        5=>date('Y-m-d',strtotime(' +8 days')),
					6=>date('Y-m-d',strtotime(' +9 days')),
					7=>date('Y-m-d',strtotime(' +10 days')),
					8=>date('Y-m-d',strtotime(' +11 days')),
					9=>date('Y-m-d',strtotime(' +12 days'))
                        
                        
                        
                    );
                }

		else*/ if(($current_week == 6)||($current_week == 7)||($current_week == 5)){
			$week = array(

				0=>date('Y-m-d',strtotime(' -'.($current_week-1).' days')),
				1=>date('Y-m-d',strtotime(' -'.($current_week-2).' days')),
				2=>date('Y-m-d',strtotime(' -'.($current_week-3).' days')),
				3=>date('Y-m-d',strtotime(' -'.($current_week-4).' days')),
				4=>date('Y-m-d',strtotime(' -'.($current_week-5).' days')),
                                5=>date('Y-m-d',strtotime(' +'.(8-$current_week).' days')),
                                6=>date('Y-m-d',strtotime(' +'.(9-$current_week).' days')),
                                7=>date('Y-m-d',strtotime(' +'.(10-$current_week).' days')),
                                8=>date('Y-m-d',strtotime(' +'.(11-$current_week).' days')),
                                9=>date('Y-m-d',strtotime(' +'.(12-$current_week).' days'))


			);
		}else if($current_week == 1){

				$week = array(

					0=>date('Y-m-d',strtotime(' +0 days')),
					1=>date('Y-m-d',strtotime(' +1 days')),
					2=>date('Y-m-d',strtotime(' +2 days')),
					3=>date('Y-m-d',strtotime(' +3 days')),
					4=>date('Y-m-d',strtotime(' +4 days')),
                                        5=>date('Y-m-d',strtotime(' +7 days')),
					6=>date('Y-m-d',strtotime(' +8 days')),
					7=>date('Y-m-d',strtotime(' +9 days')),
					8=>date('Y-m-d',strtotime(' +10 days')),
					9=>date('Y-m-d',strtotime(' +11 days'))
				);
			//}
		}else if($current_week == 2){


			      $week = array(

				        0=>date('Y-m-d',strtotime(' -1 days')),
				        1=>date('Y-m-d',strtotime(' +0 days')),
			      		2=>date('Y-m-d',strtotime(' +1 days')),
			      		3=>date('Y-m-d',strtotime(' +2 days')),
			      		4=>date('Y-m-d',strtotime(' +3 days')),
                                        5=>date('Y-m-d',strtotime(' +6 days')),
				        6=>date('Y-m-d',strtotime(' +7 days')),
			      		7=>date('Y-m-d',strtotime(' +8 days')),
			      		8=>date('Y-m-d',strtotime(' +9 days')),
			      		9=>date('Y-m-d',strtotime(' +10 days'))
					);

                                            }else if($current_week == 3){

				$week = array(
						0=>date('Y-m-d',strtotime(' -2 days')),
						1=>date('Y-m-d',strtotime(' -1 days')),
						2=>date('Y-m-d',strtotime(' +0 days')),
						3=>date('Y-m-d',strtotime(' +1 days')),
						4=>date('Y-m-d',strtotime(' +2 days')),
                                                5=>date('Y-m-d',strtotime(' +5 days')),
						6=>date('Y-m-d',strtotime(' +6 days')),
						7=>date('Y-m-d',strtotime(' +7 days')),
						8=>date('Y-m-d',strtotime(' +8 days')),
						9=>date('Y-m-d',strtotime(' +9 days'))
                                    );

		}else if($current_week == 4){

				$week = array(
						0=>date('Y-m-d',strtotime(' -3 days')),
						1=>date('Y-m-d',strtotime(' -2 days')),
						2=>date('Y-m-d',strtotime(' -1 days')),
						3=>date('Y-m-d',strtotime(' +0 days')),
						4=>date('Y-m-d',strtotime(' +1 days')),
                                                5=>date('Y-m-d',strtotime(' +4 days')),
						6=>date('Y-m-d',strtotime(' +5 days')),
						7=>date('Y-m-d',strtotime(' +6 days')),
						8=>date('Y-m-d',strtotime(' +7 days')),
						9=>date('Y-m-d',strtotime(' +8 days')),
                                    );

		}else if($current_week == 10){
		//10是正常的周五10点前
				$week = array(
						0=>date('Y-m-d',strtotime(' -4 days')),
						1=>date('Y-m-d',strtotime(' -3 days')),
						2=>date('Y-m-d',strtotime(' -2 days')),
						3=>date('Y-m-d',strtotime(' -1 days')),
						4=>date('Y-m-d',strtotime(' +0 days')),
                                                5=>date('Y-m-d',strtotime(' +3 days')),
						6=>date('Y-m-d',strtotime(' +4 days')),
						7=>date('Y-m-d',strtotime(' +5 days')),
						8=>date('Y-m-d',strtotime(' +6 days')),
						9=>date('Y-m-d',strtotime(' +7 days')),
                                    );

		}
		return $week;


        }



		//获取所有可用写字楼
		function _get_all_valid_buildings($default_building_id=0,$uid = '',$main_index=0){

	    	$where = '1=1';


	    	if($default_building_id){
	    		$where.=" and id = ".$default_building_id." ";
	    	}

	    	$building_sql = "select name,id,start_time,end_time from t_service_buildings where ".$where;

	    	$service_buildings = $this->tickets->personal_select($building_sql);

		    $now_time = date('Y-m-d H:i:s');
                    //价格筛选

                    $sql="select tu_groupid from t_users where tu_id='$uid'";
		    foreach($service_buildings as $k=>$v){
	    		$sql = "select t_goods.*,t_good_supplier_buildings.*,t_supplier.name as supplier_name,t_supplier_good.*  from t_good_supplier_buildings,t_goods,t_supplier,t_supplier_good where
				 t_good_supplier_buildings.end_time > '".$now_time."' and t_good_supplier_buildings.good_id= t_goods.id and t_goods.id=t_supplier_good.good_id and t_supplier_good.supplier_id = t_supplier.id and t_good_supplier_buildings.building_id = ".$v->id." order by t_goods.price desc,t_good_supplier_buildings.start_time asc,t_goods.cate_id asc" ;

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

			$final_data = array();
				$final_buildings = array();
					foreach($service_buildings as $k=>$v){
							$final_buildings[] = array('id'=>$v->id,'name'=>$v->name,'start_time'=>$v->start_time,'end_time'=>$v->end_time);
							$final_data[] = $v;
			}

			$sys_mobile = $this->tickets->select('configs',array('tc_type'=>'jifen_config'));
			$sys_mobile = $sys_mobile[0]->tc_content;

			return array('final_goods'=>$final_data,'final_buildings'=>$final_buildings,'sys_mobile'=>$sys_mobile);
		}
                 function promote_price(){
                     //算法的精髓是饮料与饭分开，由于后来加入了冬瓜茶 单独的做了冬瓜茶的算法，计算出每天可优惠的商品1,2,3,4，5
                     //饮料套餐的算法
           header("Content-type: text/html; charset=utf-8");
		$goods = $this->common->_get_cookie_good_detail('wechat',array());
                $cart_goods=$goods['cart_goods'];

                         $Monday_promote=0;
			 $Tuesday_promote=0;
			 $Wednesday_promote=0;
			 $Thursday_promote=0;
			 $Friday_promote=0;
			 $Monday_product=0;
			 $Tuesday_product=0;
			 $Wednesday_product=0;
			 $Thursday_product=0;
			 $Friday_product=0;
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
                        //周1
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
                        //
            $total_count=$Monday_count+$Tuesday_count+$Wednesday_count+$Thursday_count+$Friday_count;
            $price=$total_count*6+$tea*3;
              return $price;
		}

}
