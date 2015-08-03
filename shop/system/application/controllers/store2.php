<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class store extends Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model("tickets");
		$this->load->model("common");
		$this->top();
		define('DELETE_ORDER','60');
		define('CANCEL_ORDER','70');
		define('ORDER_FINISHED','40');

		define('ORDER_NOT_PAYED',10);
		define('ORDER_PAYED',20);
		$this->common->_oauth_check();
		ini_set('display_errors','On');
	}




	//处理未支付的订单
	function deal_not_payed_order(){
		$valid_time = date('Y-m-d H:i:s',strtotime('-15 minutes'));
		$temp_order = $this->tickets->api_select('orders','to_id,to_shipping_id',array('to_status'=>ORDER_NOT_PAYED,'to_created <='=>$valid_time));
		foreach($temp_order as $k=>$v){
			$temp_building = $this->tickets->api_select('shipping_address','tsa_building_id',array('tsa_id'=>$v->to_shipping_id));
			$building_id = $temp_building[0]->tsa_building_id;

			$order_good = $this->tickets->select('order_good',array('order_id'=>$v->to_id));
			foreach ($order_good as $key=>$val){
				$order_count = $val->count;

				$temp_stock = $this->tickets->api_select('good_supplier_buildings','id,stock',array('good_id'=>$val->good_id,'building_id'=>$building_id));
				$stock = $temp_stock[0];

				$final_stock = $stock->stock+$order_count;
				$this->tickets->update('good_supplier_buildings',array('stock'=>$final_stock),array('id'=>$stock->id));

			}
			 $this->tickets->update('order_good',array('order_status'=>CANCEL_ORDER),array('order_id'=>$v->to_id));

			 $this->tickets->update('orders',array('to_status'=>CANCEL_ORDER),array('to_id'=>$v->to_id));
		}
	}




	function index(){

	}


//异步更新订单
    function ajax_update_order(){
    	$user = $this->session->userdata('user');
    	$login_user = $user[0];
    	$change_data['username'] = $login_user->username;
    	$change_data['uid'] = $login_user->m_id;
    	$change_data['created'] = date('Y-m-d H:i:s');

    	$val = $_POST['val'];
    	$o_val = $_POST['o_val'];
    	$field = $_POST['field'];
    	$og_id = $_POST['og_id'];
    	$order_id = $_POST['order_id'];
    	$price = $_POST['price'];
    	$order_price = $_POST['order_price'];
    	$order_check = $this->tickets->api_select('orders','to_status,to_change_amount,to_total_amount,to_order_amount',array('to_id'=>$order_id));
    	if(!$order_check){

    		echo json_encode(array('success'=>'no','msg'=>'订单不存在'));exit;
    	}else{
    		$order_status = $order_check[0]->to_status;
    		if(($order_status != ORDER_NOT_PAYED)&&($order_status != ORDER_PAYED)){
    			echo json_encode(array('success'=>'no','msg'=>'此订单不能修改'));exit;
    		}
    	}
    	$order = $order_check[0];
    	$change_data['original_val'] = $o_val;
    	$change_data['now_val'] = $val;
    	$change_data['order_id'] = $order_id;
    	$change_data['order_good_id'] = $og_id;
    	if(($field == 'count')&&(floor($val)!=$val)){
    		echo json_encode(array('success'=>'no','msg'=>'份数必须是整数'));exit;
    	}
    	//增加一个“订单修改记录”字段：用于记录订单修改的动作，包括修改的字段、字段的原值、字段修改后的值、修改时间、修改操作人账号、备注内容。多次修改的，按时间倒序排列，最新的在最前面。
    	if ($field == 'count'){
    		$original_order = $this->tickets->api_select('order_good','perprice',array('id'=>$og_id));
    		$change_val = ($val-$o_val)*$original_order[0]->perprice;
    		$change_val+=0;
    		$order_real_amount = $order_price+$change_val;
    		$change_amount = $order_real_amount-$order->to_order_amount;
    		$update_field = array('to_change_amount'=>$change_amount,'to_total_amount'=>$order_real_amount);
    		$this->tickets->update('order_good',array($field=>$val),array('id'=>$og_id));

    		$change_data['field'] = '数量';
    	}else if($field=='perprice'){
    		$original_order = $this->tickets->api_select('order_good','count',array('id'=>$og_id));
    		$change_val = ($val-$o_val)*$original_order[0]->count;
    		$change_val+=0;
    		$order_real_amount = $order_price+$change_val;
    		$change_amount = $order_real_amount-$order->to_order_amount;
    		$update_field = array('to_change_amount'=>$change_amount,'to_total_amount'=>$order_real_amount);
    		$this->tickets->update('order_good',array($field=>$val),array('id'=>$og_id));

    		$change_data['field'] = '单价';

    	}else if (($field == 'to_mobile')||($field == 'to_receiver')){
    		$update_field = array($field=>$val);

    		if($field == 'to_mobile'){
    			$change_data['field'] = '收货人手机';
    		}else{
    			$change_data['field'] = '收货人';
    		}
    	}

    	$this->tickets->insert('orders_change_history',$change_data);
    	$this->tickets->update('orders',$update_field,array('to_id'=>$order_id));
    	echo json_encode(array('success'=>'yes','msg'=>'修改成功'));exit;
    }



//查看订单
    function order_review(){

    	ini_set('display_errors','On');
    	$order_id = $this->uri->segment(3);
        $order = $this->common->get_order_detail($order_id);
    //优惠券信息

        foreach($order as $k=>$v){
        	if($v->to_coupon_id){
        		$coupon_sql = "select t_coupons_record.*,t_coupons.tc_price from t_coupons,t_coupons_record where t_coupons.tc_id=t_coupons_record.tcr_tc_id  and t_coupons_record.tcr_id=".$v->to_coupon_id;
		        $coupon_check = $this->tickets->personal_select($coupon_sql);
        		$order[$k]->coupon_price = $coupon_check[0]->tc_price;
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
        $data['order'] = $order;
        $data['order_status']= $this->common->get_order_stauts_config();
        $data['default_order'] = $order[0];
        $default_company = $this->tickets->api_select('companys','name',array('id'=>$order[0]->to_company));
        $data['default_company'] = $default_company[0];
        $data['payment_config'] = $this->common->payment_config();
   //取出此订单修改记录
        $data['change_history'] = $this->tickets->select('orders_change_history',array('order_id'=>$order_id),'','','',array('id'=>'desc'));


        $this->load->view('store/order_review',$data);
    }



//订单列表
	function order_index(){
		$page = $this->uri->segment(3);
		$perpage = 10;
		if($page==""){
			$page=1;
		}

		if ($_POST){
			$nickname = $_POST['nickname'];
			$search_mobile = $_POST['search_mobile'];
			$order_start = $_POST['order_start'];
			$order_end = $_POST['order_end'];
			$use_start = $_POST['use_start'];
			$use_end = $_POST['use_end'];
			$this->session->set_userdata('order_list_nickname',$nickname);
			$this->session->set_userdata('order_list_order_start',$order_start);
			$this->session->set_userdata('order_list_order_end',$order_end);
			$this->session->set_userdata('order_list_use_start',$use_start);
			$this->session->set_userdata('order_list_use_end',$use_end);
			$this->session->set_userdata('order_list_search_mobile',$search_mobile);
			echo json_encode(array('success'=>'yes'));exit;
		}

		$nickname = $this->session->userdata('order_list_nickname');
		$order_start = $this->session->userdata('order_list_order_start');
		$order_end = $this->session->userdata('order_list_order_end');
		$use_start = $this->session->userdata('order_list_use_start');
		$use_end = $this->session->userdata('order_list_use_end');
		$search_mobile = $this->session->userdata('order_list_search_mobile');

		$data['order_start'] = $order_start;
		$data['order_end'] = $order_end;
		$data['use_start'] = $use_start;
		$data['use_end'] = $use_end;
		$data['nickname'] = $nickname;
		$data['search_mobile'] = $search_mobile;

		$data['order_status']= $this->common->get_order_stauts_config();

		$like = array();
		if ($nickname){
			$like['to_receiver'] = $nickname;
		}

		if($search_mobile){
			$like['to_mobile'] = $search_mobile;
		}
		$start = ($page-1)*$perpage;
		$order = array('to_id'=>'desc');

		$cond = array();
		if ($order_start){
		    $cond['to_created >='] = $order_start;
		}
		if($order_end){
			$cond['to_created <='] = $order_end;
		}

		$orders = $this->tickets->select('orders',$cond,'','',$like,$order);

		$total = count($orders);
		$data['total_count'] = $total;
		$data['total'] = ceil($total/$perpage);
		$data['start']=$start;
		$orders = $this->tickets->select('orders',$cond,$perpage,$start,$like,$order);
		$data['total_amount'] = count($orders);


		$data['orders'] = $orders;
		$data['current_page'] = $page;
		$data['payment_config'] = $this->common->payment_config();
		$this->load->view('store/order_index',$data);
	}




//更改订单状态
    function order_update(){

    	$user = $this->session->userdata('user');
    	$login_user = $user[0];

    	$order_id = $_POST['id'];
    	$status   = $_POST['status'];
    	$order_check = $this->tickets->select('orders',array('to_id'=>$order_id));
    	if (!$order_check){
    		echo json_encode(array('success'=>'no','msg'=>'订单不存在'));exit;
    	}
    	$order = $order_check[0];

    	$this->tickets->translate_begin();
    	$result1=  $this->tickets->update('orders',array('to_status'=>$status),array('to_id'=>$order_id));
    	$socre_detail = '';
    	if ($order->to_order_amount){
    		if ($order->to_pay_way == 'alipay'){
    			$socre_detail = '&nbsp;&nbsp;支付宝:&nbsp;';
    		}else if($order->to_pay_way == 'wechat'){
    			$socre_detail = '&nbsp;&nbsp;微信支付:&nbsp;';
    		}else if($order->to_pay_way == 'daofu'){
    			$socre_detail = '&nbsp;&nbsp;货到付款:&nbsp;';
    		}
    		$socre_detail .= $order->to_order_amount.'元';
    	}

    	if ($order->to_coupon_id){
    		$coupon_sql = "select t_coupons.tc_price from t_coupons,t_coupons_record where t_coupons.tc_id=t_coupons_record.tcr_tc_id and t_coupons_record.tcr_id=".$order->to_coupon_id;
    		$temp_coupon = $this->tickets->personal_select($coupon_sql);
    		$coupon_amount = $temp_coupon[0]->tc_price;

    		$socre_detail .= '+优惠券:'.$coupon_amount.'元';
    	}

    	if (($status == DELETE_ORDER)||($status == CANCEL_ORDER)){
   //如果有优惠券，要归还给用户
            if ($status == CANCEL_ORDER){
            	if($order->to_coupon_id){
            		$this->tickets->update('coupons_record',array('tcr_status'=>0),array('tcr_id'=>$order->to_coupon_id));
            	}

	            if($order->to_status == ORDER_PAYED){
	            	$order_amount = $order->to_total_amount;
	         //将订单里支付的余额，返回给用户
	            	$wallet_check = $this->tickets->api_select('wallet','tw_valid_balance',array('tw_uid'=>$order->to_uid));
	            	if (!$wallet_check){
	            		$wallet_data = array('tw_uid'=>$order->to_uid,'tw_valid_balance'=>$order_amount,'tw_updated'=>date('Y-m-d H:i:s'),'tw_created'=>date('Y-m-d H:i:s'));

	            		$result2 = $this->tickets->insert('wallet',$wallet_data);
	            	}else{
	            		$still_amount = $wallet_check[0]->tw_valid_balance;
	            		$left_amout = $still_amount+$order_amount;
	            		$update_data = array('tw_valid_balance'=>$left_amout);
	            		$result2 = $this->tickets->update('wallet',$update_data,array('tw_uid'=>$order->to_uid));
	            	}

	            	$wallet_history_data = array(
	            				'amount'=>$order_amount,
	            			    'reason'=>'订单取消',
	            			    'order_sn'=>$order->to_order_sn,
	            			    'order_uid'=>$order->to_uid,
	            				'oper_uid'=>$login_user->m_id,
	            			    'oper_username'=>$login_user->username,
	            			    'oper_time'=>date('Y-m-d H:i:s'),
	            			    'oper_content'=>'取消订单，退还'.$socre_detail,
	            				'comment'=>'',
	            				'in_time'=>date('Y-m-d H:i:s')
	            			);
	            	$this->tickets->insert('wallet_history',$wallet_history_data);

	            }


            	$temp_building = $this->tickets->api_select('shipping_address','tsa_building_id',array('tsa_id'=>$order->to_shipping_id));
            	$building_id = $temp_building[0]->tsa_building_id;
            	$order_good = $this->tickets->select('order_good',array('order_id'=>$order_id));
            	foreach ($order_good as $key=>$val){
            		$order_count = $val->count;

            		$temp_stock = $this->tickets->api_select('good_supplier_buildings','id,stock',array('good_id'=>$val->good_id,'building_id'=>$building_id));
            		$stock = $temp_stock[0];

            		$final_stock = $stock->stock+$order_count;
            		$this->tickets->update('good_supplier_buildings',array('stock'=>$final_stock),array('id'=>$stock->id));

            	}

            }


      		$result2 = true;
    	}else if ($status == ORDER_FINISHED){
   //订单成功，发放积分
    		$jifen_config = $this->tickets->select('configs',array('tc_type'=>'jifen_config'));
    		$score_rate = $jifen_config[0]->tc_title;
    		$coupon_score_rate = $jifen_config[0]->tc_extra;
	         if($order->to_coupon_id){
	 //如果使用了优惠券，则更新优惠券状态，并且发放优惠券积分
	         	$this->tickets->update('coupons_record',array('tcr_status'=>2),array('tcr_id'=>$order->to_coupon_id));
	         	$coupon_score_count = $coupon_amount*$coupon_score_rate;
	         	$coupon_score_data = array(
	         			'score'=>$coupon_score_count,
	         			'oper_uid'=>$login_user->m_id,
	         			'created'=>date('Y-m-d H:i:s'),
	         			'order_id'=>$order_id,
	         			'uid'=>$order->to_uid,
	         			'order_sn'=>$order->to_order_sn,
	         			'score_detail'=>$socre_detail,
	         			'status'=>0
	         	);
	         	$this->tickets->insert('score_data',$coupon_score_data);

	         }
    		$score_count = $score_rate*$order->to_total_amount;
    		$score_data = array(
    						'score'=>$score_count,
    				 		'oper_uid'=>$login_user->m_id,
    						'created'=>date('Y-m-d H:i:s'),
    				 		'order_id'=>$order_id,
    						'uid'=>$order->to_uid,
    						'order_sn'=>$order->to_order_sn,
    						'score_detail'=>$socre_detail,
    						'status'=>0
    				);
    		$this->tickets->insert('score_data',$score_data);

    //处理钱包的记录
    		$wallet_check = $this->tickets->api_select('wallet','tw_score',array('tw_uid'=>$order->to_uid));
    		if (!$wallet_check){
    			$wallet_data = array('tw_uid'=>$order->to_uid,'tw_valid_balance'=>0,'tw_score'=>$score_count,'tw_updated'=>date('Y-m-d H:i:s'),'tw_created'=>date('Y-m-d H:i:s'));
    			$result2 = $this->tickets->insert('wallet',$wallet_data);
    		}else{
    			$still_score = $wallet_check[0]->tw_score;
    			$left_score = $still_score+$score_count;
    			$update_data = array('tw_score'=>$left_score);
    			$result2 = $this->tickets->update('wallet',$update_data,array('tw_uid'=>$order->to_uid));
    		}

    	}else{
    		$result2 = true;
    	}

    	$result3 = $this->tickets->update('order_good',array('order_status'=>$status),array('order_id'=>$order_id));


    	if($result1 && $result2 && $result3){
    		$this->tickets->translate_commit();
    		echo json_encode(array('success'=>'yes','msg'=>'操作成功'));exit;
    	}else{
    		$this->tickets->translate_rollback();
    		echo json_encode(array('success'=>'no','msg'=>'操作失败'));exit;
    	}

    }

	function ajax_change_data(){
		$table = trim($_POST['table']);
		$field = trim($_POST['field']);
		$value = trim($_POST['value']);
		$id    = intval($_POST['id']);

		if ($table == 'users'){
			$cond = array('tu_id'=>$id);
		}else if($table =='coupons'){
			$cond = array('tc_id'=>$id);
		}else{
			$cond = array('id'=>$id);
		}
		$result = $this->tickets->update($table,array($field=>$value),$cond);
		if($result){
			echo json_encode(array('success'=>'yes','msg'=>'操作成功'));exit;
		}else{
			echo json_encode(array('success'=>'no','msg'=>'操作失败'));exit;
		}
	}




//配送写字楼
    function service_buildings_index(){
    	$user = $this->session->userdata('user');
    	$uid = $user[0]->m_id;

    	$cond = array();
    	$records = $this->tickets->select('service_buildings',$cond);
    	$page = $this->uri->segment(3);

    	$perpage = 10;
    	if($page==""){
    		$page=1;
    	}
    	$start = ($page-1)*$perpage;
    	$total = count($records);
    	$data['total_amount'] = $total;
    	$data['total'] = ceil($total/$perpage);
    	$data['start']=$start;

    	$service_buildings = $this->tickets->select('service_buildings',$cond,'','');
    	foreach($service_buildings as $k=>$v){
    		 $province_temp = $this->tickets->select('province',array('province_id'=>$v->province_id));
    		 $city_temp = $this->tickets->select('city',array('city_id'=>$v->city_id));
    		 $area_temp = $this->tickets->select('area',array('area_id'=>$v->area_id));
    		 $service_buildings[$k]->province = $province_temp[0]->province;
    		 $service_buildings[$k]->city = $city_temp[0]->city;
    		 $service_buildings[$k]->area = $area_temp[0]->area;
    	}
    	$data['service_buildings'] = $service_buildings;
    	$data['current_page'] = $page;

    	$this->load->view('store/service_buildings_index',$data);

    }



//新增和修改写字楼
    function service_buildings_add(){

    	$user = $this->session->userdata('user');
    	$uid = $user[0]->m_id;
    	if ($_POST){
            $id = intval($_POST['id']);
    		$insert_data = array('name'=>trim($_POST['name']),
    				'province_id'=>trim($_POST['province_id']),
    				'city_id'=>trim($_POST['city_id']),
    				'area_id'=>trim($_POST['area_id']),
    				'status'=>trim($_POST['status']),
    				'address'=>trim($_POST['address']),
    				'develop_time'=>trim($_POST['develop_time']),
    				'start_time'=>trim($_POST['start_time']),
    				'end_time'=>trim($_POST['end_time']),
    				'created'=>date('Y-m-d H:i:s'),
    				'uid'=>$uid);
    		if ($id) {

    			$re = $this->tickets->update('service_buildings',$insert_data,array('id'=>$id));
    		}else{
    			$re = $this->tickets->insert('service_buildings',$insert_data);
    		}

    		if ($re){
    			echo json_encode(array('success'=>'yes','msg'=>'操作成功'));exit;
    		}else{
    			echo json_encode(array('success'=>'no','msg'=>'操作失败'));exit;
    		}

    	}else{
    		$id = $this->uri->segment(3);
    		$data['province'] = $this->tickets->select('province',array('status'=>1));
    		if ($id){
    			$building = $this->tickets->select('service_buildings',array('id'=>$id));
    			$data['building'] = $building[0];
    			$data['citys'] = $this->tickets->select('city',array('father'=>$building[0]->province_id));
    			$data['areas'] = $this->tickets->select('area',array('father'=>$building[0]->city_id));
    		}else{
    			$data['building'] = '';
    		}
    		$data['id']  = $id;
    		$this->load->view('store/service_buildings_add',$data);
    	}
    }





//配送区域管理
    function areas(){
    	$father_id = '';
    	$data['area'] = $this->tickets->select('area',array('father'=>'310100'));
    	$data['area2'] = $this->tickets->select('area',array('father'=>'310200'));
    	$this->load->view('store/areas',$data);
    }



  //异步过去城市或区域
    function ajax_get_city_area(){
    	$id = intval($_POST['id']);
    	$type = trim($_POST['type']);

    	$result = $this->tickets->select($type,array('father'=>$id));
    	if ($result){
    		echo json_encode(array('success'=>'yes','msg'=>$result));exit;
    	}else{
    		echo json_encode(array('success'=>'no'));exit;
    	}
    }


    function ajax_get_service_building(){
    	$id = intval($_POST['id']);
    	$result = $this->tickets->api_select('service_buildings','id,name',array('area_id'=>$id));
    	if ($result){
    		echo json_encode(array('success'=>'yes','msg'=>$result));exit;
    	}else{
    		echo json_encode(array('success'=>'no'));exit;
    	}
    }



	function ajax_update_category(){
		$id = intval($_POST['id']);
		$status = intval($_POST['status']);
		$type = trim($_POST['type']);


		$result = $this->tickets->update($type,array('status'=>$status),array('id'=>$id));
		if ($result){
			echo json_encode(array('success'=>'yes'));exit;
		}else{
			echo json_encode(array('success'=>'no'));exit;
		}
	}


//类别列表
	function category_index(){
		$user = $this->session->userdata('user');
		$uid = $user[0]->m_id;
		$categorys = $this->tickets->select('categorys',array());
		$common_weeks = common_weeks();
		if ($categorys){
			foreach($categorys as $key=>$val){
				$pname = '';
				if ($val->pid !=0){
					$category = $this->tickets->select('categorys',array('id'=>$val->pid));
					if ($category){
						$pname = $category[0]->name;
					}
				}
				$categorys[$key]->pname = $pname;
				$temp_week = '';
				if ($val->weeks!=''){
					$temp_weeks = explode(',',$val->weeks);
					foreach($temp_weeks as $k=>$v){
						$temp_week.= $common_weeks[$v].',';
					}
					$temp_week = rtrim($temp_week,',');
				}
				$categorys[$key]->weeks = $temp_week;
			}
		}else{
			$categorys = '';
		}
		$data['categorys'] = $categorys;

		$this->load->view('store/category_index',$data);
	}



//新增和修改类别
	function category_add(){
		$pid = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		$user = $this->session->userdata('user');
		$uid = $user[0]->m_id;
		if ($_POST){
			$weeks = '';

	 		if (isset($_POST['weeks'])){
	 			$weeks = implode(',',$_POST['weeks']);
	 		}
			$insert_data = array('name'=>trim($_POST['name']),'weeks'=>$weeks,'pid'=>$pid,'coverurl'=>trim($_POST['coverurl']),'descriptions'=>trim($_POST['descriptions']));
			if ($id) {

				$re = $this->tickets->update('categorys',$insert_data,array('id'=>$id));
			}else{
				$re = $this->tickets->insert('categorys',$insert_data);
			}

			redirect('/store/category_index');

		}else{
			$data['valid_weeks'] = '';
			if ($id){
				$cate = $this->tickets->select('categorys',array('id'=>$id));
				$cate_temp = $cate[0];
				if ($cate_temp->weeks!=''){
					$data['valid_weeks'] = explode(',',$cate_temp->weeks);
				}
				$data['cate'] = $cate_temp;
			}else{
				$data['cate'] = '';
			}
			$data['id']  = $id;
			$data['pid'] = $pid;

			if ($pid){
				$data['pcate'] = $this->tickets->select('categorys',array('pid'=>0));
			}
			$data['weeks'] = common_weeks();
			$this->load->view('store/category_add',$data);
		}
	}



// 商品列表
	function good_index(){

		$user = $this->session->userdata('user');
		$uid = $user[0]->m_id;

		$cond = array();
		$goods = $this->tickets->select('goods',$cond);

		$total = count($goods);
		$data['total_amount'] = $total;
		foreach($goods as $k=>$v){
			$cate = $this->tickets->select('categorys',array('id'=>$v->cate_id));
			$sub_cate = $this->tickets->select('categorys',array('id'=>$v->sub_cate_id));
			$tem = $this->tickets->select('supplier_good',array('good_id'=>$v->id));

			$supplier_name = $this->tickets->api_select('supplier','name',array('id'=>$tem[0]->supplier_id));

			$goods[$k]->cate_name = $cate[0]->name;
			$goods[$k]->sub_cate_name = $sub_cate[0]->name;
			$goods[$k]->supplier_name = $supplier_name[0]->name;
		}
		$data['goods'] = $goods;
		$this->load->view('store/good_index',$data);

	}



//新增商品
    function good_add(){

    	$user = $this->session->userdata('user');
    	$uid = $user[0]->m_id;

    	if ($_POST){
    		$pos = json_decode($_POST['jsonData']);
    		$tm_id = intval($_POST['tm_id']);
    		$good_data['price'] = trim($_POST['price']);
    		$good_data['status']= trim($_POST['status']);
    		$good_data['cate_id']= intval($_POST['cate_id']);
    		$good_data['sub_cate_id']= intval($_POST['sub_cate_id']);
    		$good_data['uid']= $uid;
    		$good_data['name'] = trim($_POST['name']);
    		$good_data['createtime']= date('Y-m-d H:i:s');
    		foreach ($pos as $k=>$val){
    			$post = (array)$val;
    			$good_data['title'.$k] = trim($post['title']);
    			/*if ($k==0){
    				preg_match_all('/<p>([\s\S]*?)<\/p>/', trim($post['content']), $desc_temp);
    				$good_data['desc'.$k] = $desc_temp[1][0];

    			}else{
    				$good_data['desc'.$k] = trim($post['content']);
    			}*/
                $good_data['desc'.$k] = $post['content'];
    			$good_data['coverurl'.$k] = trim($post['cover']);
    		}
    		 if($tm_id){
    		   $good_id = $tm_id;
    		   $this->tickets->update('goods',$good_data,array('id'=>$tm_id));
    		 }else{
    		   $good_id = $this->tickets->insert('goods',$good_data);
    		 }
    		if ($good_id){
    			$supplier = rtrim($_POST['suppliers'],',');
    			$this->tickets->delete('supplier_good',array('good_id'=>$good_id));
    			$supplier = explode(',',$supplier);
    			foreach($supplier as $k=>$v){
    				$temp_data = array('good_id'=>$good_id,'supplier_id'=>$v);
    				$this->tickets->insert('supplier_good',$temp_data);
    			}
    			$r = array('success'=>'yes','msg'=>$good_id);
    		}else{
    			$r = array('success'=>'no','msg'=>'操作失败');
    		}
    		 echo json_encode($r);exit;

    	}else{
    		$tm_id = $this->uri->segment(3);
    		$cond = array();
    		if ($tm_id){
    			$co = $this->tickets->select('goods',array('id'=>$tm_id));
    			$good = $co[0];
    			$data['sub_cates'] = $this->tickets->select('categorys',array('pid'=>$good->cate_id));

    			$sql = "select t_supplier.name,t_supplier.id from t_supplier_category right join t_supplier on t_supplier.id = t_supplier_category.supplier_id where t_supplier_category.cate_id=".$good->sub_cate_id;
    			$supplier = $this->tickets->personal_select($sql);
    			$data['supplier'] = $supplier;

    			$good_supplier = $this->tickets->select('supplier_good',array('good_id'=>$tm_id));
    			$supplier_valid = array();
    			if($good_supplier){
    				foreach($good_supplier as $k=>$v){
    					$supplier_valid[] = $v->supplier_id;
    				}
    			}
    			$data['supplier_valid'] = $supplier_valid;
    		}else{
    			$good = '';
    		}
    		$data['good'] = $good;

    		$data['province'] = $this->tickets->select('province',array('status'=>1));
    		$data['cates'] = $this->tickets->select('categorys',array('pid'=>0));
    		$this->load->view('store/good_add',$data);
    	}
    }



    function good_extra(){
    	    ini_set('display_errors','On');
	    	$good_id = $this->uri->segment(3);
	    	$supplier = $this->tickets->select('supplier_good',array('good_id'=>$good_id));
	    	if ($_POST){

	    		$this->tickets->delete('good_supplier_buildings',array('good_id'=>$good_id));
	    	}
	        foreach($supplier as $k=>$v){
	        	$temp_supplier = $this->tickets->api_select('supplier','name',array('id'=>$v->supplier_id));
	        	$supplier[$k]->name = $temp_supplier[0]->name;
	        	$supplier_temp = $this->tickets->select('supplier_area',array('supplier_id'=>$v->supplier_id));
	        	if ($supplier_temp){
	        		$area_ids = '';
	        		foreach ($supplier_temp as $key=>$val){
	        			$area_ids.=$val->area_id.',';
	        		}
	        		$area_ids = rtrim($area_ids,',');
	        		$buildings = '';
	        		$sql = "select t_service_buildings.name,t_service_buildings.id from t_service_buildings where t_service_buildings.area_id in (".$area_ids.") and t_service_buildings.status=4";
	        		$buildings_temp = $this->tickets->personal_select($sql);
	        		if ($buildings_temp){
	        			$buildings = $buildings_temp;
	        			if ($_POST&&$buildings){

	        				foreach($buildings as $key=>$val){
	        					if(isset($_POST['weeks_'.$v->supplier_id.'_'.$val->id])){
		        					$temp_week = $_POST['weeks_'.$v->supplier_id.'_'.$val->id];
		        					$week = implode(',',$temp_week);
			        				$post_data = array(
			        						'good_id'=>$good_id,
			        						'supplier_id'=>$v->supplier_id,
			        						'building_id'=>$val->id,
			        						'start_time'=>$_POST['start_time_'.$v->supplier_id][$key],
			        						'end_time'=>$_POST['end_time_'.$v->supplier_id][$key],
			        						'stock'=>$_POST['stock_'.$v->supplier_id][$key],
			        						'week'=>$week
			        						);
			        				$this->tickets->insert('good_supplier_buildings',$post_data);
	        					}
	        				}
	        				redirect('/store/good_index');
	        			}
	        		}

	        		$supplier[$k]->buildings = $buildings;
	        	}
	        }
	        $data['good_id'] = $good_id;
	        $data['weeks'] = common_weeks();
	        $data['supplier'] = $supplier;
	    //取出已经存在的信息
	        $end_data = array();
	        $supplier_buildings = $this->tickets->select('good_supplier_buildings',array('good_id'=>$good_id));
	        if($supplier_buildings){

	        	foreach($supplier_buildings as $k=>$v){
	        		$week_tem = explode(',',$v->week);
	        		$end_data[$v->supplier_id][$v->building_id] = array('start_time'=>$v->start_time,'end_time'=>$v->end_time,'weeks'=>$week_tem,'stock'=>$v->stock);
	        	}
	        }

	        $data['end_data'] = $end_data;
	        $this->load->view('store/good_extra',$data);

    }



    function ajax_get_supplier_from_category(){

    	$cate_id = intval($_POST['cate_id']);
    	$sub_cate =  $this->tickets->select('categorys',array('pid '=>$cate_id));
    	$cate_ids = '';
    	if($sub_cate){
    		foreach($sub_cate as $k=>$v){
    			$cate_ids.=$v->id.',';
    		}
    	}
    	$cate_ids.=$cate_id;
    	if ($cate_id){
    		$sql = "select t_supplier.name,t_supplier.id from t_supplier_category right join t_supplier on t_supplier.id = t_supplier_category.supplier_id where t_supplier_category.cate_id in (".$cate_ids.")";
    		$supplier = $this->tickets->personal_select($sql);
    //把没有写字楼的都过滤掉
    		$final_supplier = array();
    		$temp_su_ids = array();
    		foreach($supplier as $k=>$v){
    		    $area_temp= $this->tickets->select('supplier_area',array('supplier_id'=>$v->id));
    			foreach($area_temp as $key=>$val){
    				$building = $this->tickets->select('service_buildings',array('area_id'=>$val->area_id));
    				if($building &&(!in_array($v->id,$temp_su_ids))){
    					$final_supplier[] = $v;
    					$temp_su_ids[]=$v->id;
    				}
    			}
    		}

    		$supplier = $final_supplier;

    	}else{
    		$supplier = '';
    	}
    	//return $supplier;
    	if ($supplier) {
    		echo json_encode(array('success'=>'yes','msg'=>$supplier));exit;
    	}else{
    		echo json_encode(array('success'=>'no','msg'=>'没有供应商'));exit;
    	}
    }




 //异步过去供应商
   function ajax_get_supplier(){
   	    $area_id = intval($_POST['area_id']);
   	    $user = $this->session->userdata('user');
   	    $uid = $user[0]->m_id;
   	    if ($pid){
   	    	$sub_category = $this->tickets->select('supplier',array('pid'=>$pid));
   	    }else{
   	    	$sub_category = '';
   	    }
   	    if ($sub_category) {
   	    	echo json_encode(array('success'=>'yes','msg'=>$sub_category));exit;
   	    }else{
   	    	echo json_encode(array('success'=>'no','msg'=>'没有小分类'));exit;
   	    }
   }


 //异步获取子分类
   function  ajax_get_sub_category(){
   		$pid = intval($_POST['pid']);
   		$user = $this->session->userdata('user');
   		$uid = $user[0]->m_id;
   		if ($pid){
   		  $sub_category = $this->tickets->select('categorys',array('pid'=>$pid));
   		}else{
   		  $sub_category = '';
   		}
   		if ($sub_category) {
   			//$suppliers = $this->ajax_get_supplier_from_category($pid);
   			echo json_encode(array('success'=>'yes','msg'=>$sub_category));exit;
   		}else{
   			echo json_encode(array('success'=>'no','msg'=>'没有小分类'));exit;
   		}
   }




//删除数据
	function store_delete(){
		$table = trim($this->uri->segment(3));
		$id    = intval($this->uri->segment(4));

		$table_delete = $table;
		if (($table == 'category')||($table=="good")){
			$table_delete = $table.'s';
		}
		$re = $this->tickets->delete($table_delete,array('id'=>$id));

		if ($re) {
			redirect('/store/'.$table.'_index');
		}
	}



//供应商列表
	function supplier_index(){

		$user = $this->session->userdata('user');
		$uid = $user[0]->m_id;

		$cond = array();
		$records = $this->tickets->select('supplier','','','','','',array('status'=>'1,2'));
		$total = count($records);
		$data['total_amount'] = $total;
		foreach($records as $key=>$val){
			$sql = "select t_categorys.name,t_supplier_category.* from t_supplier_category right join t_categorys on t_supplier_category.cate_id = t_categorys.id where t_supplier_category.supplier_id=".$val->id;
			$cates = $this->tickets->personal_select($sql);
			$temp_cate = '';
			if ($cates){
				foreach($cates as $k=>$v){
					$temp_cate.= $v->name.',';
				}
				$temp_cate = rtrim($temp_cate,',');
			}
			$records[$key]->cates = $temp_cate;
		}
		$data['supplier'] = $records;
		$this->load->view('store/supplier_index',$data);
	}



//新增和修改供应商
	function supplier_add(){
		$id = $this->uri->segment(3);
		$user = $this->session->userdata('user');
		$uid = $user[0]->m_id;
		$this->top();
		if ($_POST){

			$insert_data = array('name'=>trim($_POST['name']),
					'open_time'=>trim($_POST['open_time']),
					'uid'=>$uid,
					'province_id'=>trim($_POST['province_id']),
					'city_id'=>trim($_POST['city_id']),
					'status'=>trim($_POST['status']),
					'address'=>trim($_POST['address']),
                                        'summary'=>trim($_POST['summary']),
                                        'descr'=>trim($_POST['descr'])
					);
			if ($id) {
                         $this->tickets->update('supplier',$insert_data,array('id'=>$id));

                         $this->upload_img($id,'update',$_POST['pic0'],$_POST['pic1'],$_POST['pic2'],$_POST['pic3'],$_POST['pic4']);
			}else{
                            $id = $this->tickets->insert('supplier',$insert_data);
                             $this->upload_img($id,'insert',$_POST['pic0'],$_POST['pic1'],$_POST['pic2'],$_POST['pic3'],$_POST['pic4']);
                        }
	//先删除所有的菜品品类和供应商的关系
	        $this->tickets->delete('supplier_category',array('supplier_id'=>$id));
	        if(isset($_POST['cates'])){
	        	foreach($_POST['cates'] as $k=>$v){
	        		$cates_data = array('supplier_id'=>$id,'cate_id'=>$v);
	        		$this->tickets->insert('supplier_category',$cates_data);
	        	}
	        }

	        $this->tickets->delete('supplier_area',array('supplier_id'=>$id));
	        if(isset($_POST['areas'])){
	        	foreach($_POST['areas'] as $k=>$v){
	        		$cates_data = array('supplier_id'=>$id,'area_id'=>$v);
	        		$this->tickets->insert('supplier_area',$cates_data);
	        	}
	        }

			redirect('/store/supplier_index');

		}else{

			$data['valid_cates'] = '';
			$cates_supplier = $this->tickets->select('supplier_category',array('supplier_id'=>$id));
			if ($cates_supplier){
				$cates = array();
				foreach($cates_supplier as $k=>$v){
					$cates[] = $v->cate_id;
				}
				$data['valid_cates'] = $cates;
			}

			$data['valid_areas'] = '';
			$areas_supplier = $this->tickets->select('supplier_area',array('supplier_id'=>$id));
			if ($areas_supplier){
				$areas = array();
				foreach($areas_supplier as $k=>$v){
					$areas[] = $v->area_id;
				}
				$data['valid_areas'] = $areas;
			}

			if ($id){

                                $sql="select t_supplier.*,t_supplier_image.* from t_supplier,t_supplier_image where t_supplier.id=t_supplier_image.supplier_id and t_supplier.id='$id'";
				$supplier=$this->tickets->personal_select($sql);
                                if(!$supplier[0]->id){
                                    //前期如果没有设置图片
                                   $supplier = $this->tickets->select('supplier',array('id'=>$id));
                                }
                                $data['supplier'] = $supplier[0];
				$data['citys'] = $this->tickets->select('city',array('father'=>$supplier[0]->province_id));
				$data['areas'] = $this->tickets->select('area',array('father'=>$supplier[0]->city_id));
			}else{
				$data['supplier'] = '';
			}
			$data['province'] = $this->tickets->select('province',array('status'=>1));
			$data['cates'] = $this->tickets->select('categorys',array('pid !='=>0));
			$cate_temp = $this->tickets->select('categorys',array('pid '=>0));
			if($cate_temp){
				foreach($cate_temp as $k=>$v){
					$sub_check = $this->tickets->select('categorys',array('pid '=>$v->id));
					if($sub_check){
						unset($cate_temp[$k]);
					}
				}
			}else{
				$cate_temp = '';
			}
			$data['p_cates'] = $cate_temp;
			$data['id']  = $id;
			$this->load->view('store/supplier_add',$data);
		}
	}



	function top(){
		$user = $this->session->userdata('user');
		if($user==""){
			//直接跳转到登录页面
			redirect('/admin/login');exit;
		}
	}

        function upload_img($id,$keywords,$pic1,$pic2,$pic3,$pic4,$pic5){
     // print_r($_POST);exit;
      //初始化
            $this->load->library('upload', $config);
            $pic1=$pic1?$pic1:"";
             $pic2=$pic2?$pic2:"";
              $pic3=$pic3?$pic3:"";
               $pic4=$pic4?$pic4:"";
                $pic5=$pic5?$pic5:"";
      $_POST['pic0']=$pic1;$_POST['pic1']=$pic2;$_POST['pic2']=$pic3;$_POST['pic3']=$pic4;$_POST['pic4']=$pic5;
      $config['upload_path'] = '/data/www/xshc/shop/api_images/suppliers';
      $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
      $config['encrypt_name'] = TRUE;
      $config['remove_spaces'] = TRUE;
      $config['max_size']  = '0';
      $config['max_width']  = '0';
      $config['max_height']  = '0';

      

      //170*170图片
      $configThumb = array();
      $configThumb['image_library'] = 'gd2';
      $configThumb['source_image'] = '';
      $configThumb['create_thumb'] = TRUE;
      $configThumb['maintain_ratio'] = TRUE; //保持图片比例
      $configThumb['new_image'] = '/data/www/xshc/shop/api_images/suppliers_thum';
      $configThumb['width'] = 170;
      $configThumb['height'] = 170;

      $this->load->library('image_lib');

      for($i = 0; $i < 5; $i++) {
       if(!$this->upload->do_upload("pic".$i)) {
                echo $this->upload->display_errors();
        }else{
            $data = $this->upload->data();//返回上传文件的所有相关信息的数组
        $uid = $this->session->userdata('uid');
        $uploadedFiles[$i] = $data;
        }

       // if($upload === FALSE) continue;


        if($data['is_image'] == 1) {
          //初始化170*170
          $configThumb['source_image'] = $data['full_path']; //文件路径带文件名
          $this->image_lib->initialize($configThumb);
          $this->image_lib->resize();
             $tmp = explode('.', $data['full_path']);
             $ext = $tmp[count($tmp) - 1];//获取文件后缀
          $raw_name[$i]=$data['raw_name'].".".$ext;

        }
           }
             print_r($data);
                exit;
        //插入图片信息到album表,插入的文件名为source目录文件名
        $this->load->model('picup');
        if($keywords=="insert"){
             $picture = array(
                            'supplier_id'=>$id,
                            "image0_url"=>$raw_name[0],
                            "image1_url"=>$raw_name[1],
                            "image2_url"=>$raw_name[2],
                            "image3_url"=>$raw_name[3],
                            "image4_url"=>$raw_name[4]
        );
        }else if($keywords=="update"){
            $picture = array(
                            "image0_url"=>$raw_name[0],
                            "image1_url"=>$raw_name[1],
                            "image2_url"=>$raw_name[2],
                            "image3_url"=>$raw_name[3],
                            "image4_url"=>$raw_name[4]
        );
        }
      

        $this->picup->addpic($picture,$keywords,$id);
       // $picture = array();



    /* 转出 */
    //$albumID = $this->uri->segment(4);
 //   $backurl = site_url() . '/admin/';
 //   $this->session->set_flashdata('msg','保存成功.');
  //  redirect($backurl,'refresh');
 }


  function supplier_delete(){
            //不是真的删除
            $id=$this->input->post("id");
           $result=$this->tickets->update("supplier",array("status"=>"3"),array("id"=>$id));
           if($result){
               echo json_encode(array('success'=>'yes',"msg"=>"删除成功"));exit;
           }
        }

}
