<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin extends Controller {

	function __construct()
	{
		ini_set('display_errors','On');
		parent::__construct();
	    $this->load->model("tickets");
	    $this->load->model("common");
	    define('COUPON_USED','2');
	    define('DELETE_USER','2');
	    define('VALID_COUPON','0');
	    define('ORDER_NOT_PAYED',10);
		define('ORDER_PAYED',20);
		define('ORDER_CANCELED',70);
		define('ORDER_SUCCESS',40);
		define('STOP_SERVING',2);
		
	    $this->common->_oauth_check();   
	}
	 
	
	
	//单个发放优惠券
	function coupon_send_single(){
		if($_POST){
			$uid = intval($_POST['uid']);
			$user_check = $this->tickets->api_select('users','tu_id',array('tu_id'=>$uid));
			if(!$user_check){
				echo json_encode(array('success'=>'no','msg'=>'用户不存在'));exit;
			}
			
			$coupon_count = intval($_POST['count']);
			$coupon_id = intval($_POST['coupon_id']);
			if ($coupon_count<=0){
				echo json_encode(array('success'=>'no','msg'=>'必须发放大于0张优惠券'));exit;
			}
			
			for($i=1;$i<=$coupon_count;$i++){
				$coupon_data = array(
						'tcr_uid'=>$uid,
						'tcr_tc_id'=>$coupon_id,
						'tcr_status'=>VALID_COUPON,
						'tcr_created'=>date('Y-m-d H:i:s')
						);
				$this->tickets->insert('coupons_record',$coupon_data);
			}
			echo json_encode(array('success'=>'yes'));exit;
			
			
		}else{
			//获取所有可用的优惠券类型
			$data['coupons_types'] = $this->common->coupons_types();
			$data['coupons'] = $this->tickets->select('coupons',array('tc_end_time >'=>date('Y-m-d H:i:s')));			
			$this->load->view('admin/coupon_send_single',$data);
		} 
	}
	
	
	
	
	//批量发放优惠券
	function coupon_send_multiply(){
		if($_POST){
			header("Content-type: text/html; charset=utf-8");
			if(!isset($_POST['company'])){
				echo "<script>alert('请选择公司')</script>";exit;
			}	
			
			$company = $_POST['company']; 
			$coupon_count = intval($_POST['count']);
			$coupon_id = intval($_POST['coupon_id']);
			if ($coupon_count<=0){
				echo json_encode(array('success'=>'no','msg'=>'必须发放大于0张优惠券'));exit;
			}
			
			foreach($company as $key=>$val){
				$company_address = $this->tickets->api_select('shipping_address','tsa_uid',array('tsa_company'=>$val));
				if ($company_address){
					foreach($company_address as $k=>$v){
						for($i=1;$i<=$coupon_count;$i++){
							$coupon_data = array(
									'tcr_uid'=>$v->tsa_uid,
									'tcr_tc_id'=>$coupon_id,
									'tcr_status'=>VALID_COUPON,
									'tcr_created'=>date('Y-m-d H:i:s')
									);
							$this->tickets->insert('coupons_record',$coupon_data);
						}
					}
				}
			}

			echo "<script>alert('发放成功')</script>";
			redirect('admin/coupon');
		}else{
			
			
			$data['buildings'] = $this->tickets->api_select('service_buildings','id,name',array('status !='=>STOP_SERVING));
			$data['coupons'] = $this->tickets->select('coupons',array('tc_end_time >'=>date('Y-m-d H:i:s')));
			$data['coupons_types'] = $this->common->coupons_types();
			 
			$this->load->view('admin/coupon_send_multiply',$data);
		}
	}
	
	
	
	
	function ajax_get_company_by_building(){
		$id = intval($_POST['building_id']); 
		 
		$result = $this->tickets->api_select('companys','id,name',array('service_building_id'=>$id));
		if ($result){
			echo json_encode(array('success'=>'yes','company'=>$result));exit;
		}else{
			echo json_encode(array('success'=>'no','msg'=>'暂时没有任何公司'));exit;
		}
	}
	
	

	//删除用户
	function  admin_delete(){
		$m_id = intval($_POST['m_id']);
	
		//先删除场次，再删除剧
		$delete_result = $this->tickets->delete('members',array('m_id'=>$m_id));
		if ($delete_result){
			$re = array('success'=>'yes','msg'=>'删除成功');
		}else{
			$re = array('success'=>'no','msg'=>'删除失败');
		}
	
		echo json_encode($re);exit;
	}
	
	

	//新增优惠券类型
	function admin_add(){
	
		if ($_POST){
	
			$m_id = intval($_POST['m_id']);
			$role_id = trim($_POST['role_id']);
			$username = trim($_POST['username']); 
			$password = trim($_POST['password']);	
			
			if ($m_id){
				$dat = array('username'=>$username,'role_id'=>$role_id);
				if ($password){
					$dat['password']=md5($password);
				}
				$this->tickets->update('members',$dat,array('m_id'=>$m_id));
			}else{
				$dat = array('username'=>$username,'password'=>md5($password),'role_id'=>$role_id);
				$dat['createtime']=date('Y-m-d H:i:s');
				$this->tickets->insert('members',$dat);
			}
			echo json_encode(array('success'=>'yes'));exit;
	
		}else{
			$id = $this->uri->segment(3);
			if($id){
				$member = $this->tickets->select('members',array('m_id'=>$id));
				$data['member'] = $member[0];
	
			}else{
				$data['member'] = '';
			}
				
			$data['roles'] = $this->tickets->select('admin_authority');
	
			$this->load->view('admin/admin_add',$data);
		}
	}
	
	
	
	//优惠券类型列表
	function admin_index(){
		$member_sql = "select t_members.*,t_admin_authority.role_name from t_admin_authority,t_members where t_admin_authority.id = t_members.role_id order by t_members.m_id desc";
		$members = $this->tickets->personal_select($member_sql);
		 
			
		$data['members'] = $members; 
		$this->load->view('admin/admin_index',$data);
	
	}
	
	
	
	
//数据导出
	function data_export(){
		$table = $this->uri->segment(3);
		if ($table == 'user'){
			$this->_get_user_export_data();
		}else if($table == 'supplier'){
			$this->_get_supplier_export_data();
		}else if($table == 'goods'){
			$this->_get_goods_export_data();
		}else if($table == 'category'){
			$this->_get_category_export_data();
		}else if($table == 'building'){
			$this->_get_building_export_data();
		}else if($table == 'company'){
			$this->_get_company_export_data();
		}else if($table == 'orders'){
			$this->_get_order_export_data(); 
		}
	}
	
	
//订单数据导出
   function _get_order_export_data(){
   	$order_start = $this->session->userdata('order_list_order_start');
   	$order_end = $this->session->userdata('order_list_order_end');
   	$use_start = $this->session->userdata('order_list_use_start');
   	$use_end = $this->session->userdata('order_list_use_end');
   	 $where = " t_orders.to_id=t_order_good.order_id and t_order_good.good_id = t_goods.id";
   	if ($order_start){
   		$where.=" and t_orders.to_created >= '".$order_start."'";
   	}
   	if ($order_end){
   		$where.=" and t_orders.to_created <= '".$order_end."'";
   	}
   	
   	if ($use_start){
   		$use_start = date('Y/m/d',strtotime($use_start));
   		$where.=" and t_order_good.service_date >= '".$use_start."'";
   	}
   	
   	if ($use_end){
   		$use_end = date('Y/m/d',strtotime($use_end));
   		$where.=" and t_order_good.service_date <= '".$use_end."'";
   	}
   	
     //	订单ID、订单编号、用户ID，姓名、电话、所在写字楼、配送地址（楼层及房间号）、订单来源（微信商城、网站）、下单时间、用餐日期及菜品及份数、总金额、支付方式及金额、备注
   	 $order_sql = "select t_orders.*,t_order_good.*,t_goods.title0,t_goods.title1,t_goods.title2,t_goods.title3,t_goods.title4 from t_orders,t_goods,t_order_good where ".$where." order by to_id desc";
   	 $temp_orders = $this->tickets->personal_select($order_sql);
   	 
   	 foreach($temp_orders as $k=>$v){
   	 	$address_sql = "select t_shipping_address.tsa_address,t_shipping_address.tsa_building_id from t_shipping_address where t_shipping_address.tsa_default=1 and t_shipping_address.tsa_uid=".$v->to_uid;
   	 	$temp_address = $this->tickets->personal_select($address_sql);
   	 	$address = $temp_address[0];
   	 	$temp_orders[$k]->address = $address->tsa_address;
   	 	
   	 	$building_sql = "select t_service_buildings.name from t_service_buildings,t_users where t_service_buildings.id=".$address->tsa_building_id;
   	 	$temp_building = $this->tickets->personal_select($building_sql);
   	 	$building = $temp_building[0];
   	 	$temp_orders[$k]->building = $building->name;
   	 	
   	 	$temp_orders[$k]->source = $v->to_order_type?'微信商城':'网站';
   	 	$pay_info = '';
   	 	if($v->to_coupon_id){
   	 		$coupon_sql = "select t_coupons.tc_price from t_coupons,t_coupons_record where t_coupons.tc_id=t_coupons_record.tcr_tc_id and t_coupons_record.tcr_id=".$v->to_coupon_id;
   	 		$temp_coupon = $this->tickets->personal_select($coupon_sql);
   	 		$coupon_amount = $temp_coupon[0]->tc_price;
   	 	 
   	 		$pay_info.='优惠券:'.$coupon_amount.'元';
   	 	}
   	 	if ($v->to_order_amount){
   	 		if ($v->to_pay_way == 'alipay'){
   	 			$pay_info.= '   支付宝:&nbsp;';
   	 		}else if($v->to_pay_way == 'wechat'){
   	 			$pay_info.= '   微信支付:&nbsp;';
   	 		}else if($v->to_pay_way == 'daofu'){
   	 			$pay_info.= '   货到付款:&nbsp;';
   	 		}
   	 		$pay_info.= $v->to_total_amount.'元';
   	 	}
   	 	$temp_orders[$k]->pay_info = $pay_info;
   	 	
   	 	$menu = '';
   	 	if ($v->title0){
   	 		$menu.=$v->title0.'   ';
   	 	}
   	 	if ($v->title1){
   	 		$menu.=$v->title1.'   ';
   	 	}
   	 	if ($v->title2){
   	 		$menu.=$v->title2.'   ';
   	 	}
   	 	if ($v->title3){
   	 		$menu.=$v->title3.'   ';
   	 	}
   	 	if ($v->title4){
   	 		$menu.=$v->title4.'   ';
   	 	}
   	 	$temp_orders[$k]->goods_name = $menu;
   	 	$temp_orders[$k]->sub_amount = $v->count*$v->perprice;
   	 }
   	// echo '<pre>';print_r($temp_orders);exit;
   	 $field = array(
   	 		array('field'=>'to_id','name'=>'订单ID'),
   	 		array('field'=>'to_order_sn','name'=>'订单编号'),
   	 		array('field'=>'to_uid','name'=>'用户ID'),
   	 		array('field'=>'to_receiver','name'=>'姓名'),
   	 		array('field'=>'to_mobile','name'=>'电话'),
   	 		array('field'=>'building','name'=>'所在写字楼'),
   	 		array('field'=>'address','name'=>'配送地址'),
   	 		array('field'=>'source','name'=>'订单来源'),
   	 		array('field'=>'to_created','name'=>'下单时间'),
   	 		array('field'=>'service_date','name'=>'用餐日期'),
   	 		array('field'=>'goods_name','name'=>'菜品'),
   	 		array('field'=>'count','name'=>'份数'),
   	 		array('field'=>'sub_amount','name'=>'小计'),
   	 		array('field'=>'to_total_amount','name'=>'总金额'),
   	 		array('field'=>'pay_info','name'=>'支付方式及金额'),
   	 		array('field'=>'to_comment','name'=>'备注') 
   	 );
   	 
   	 $this->_do_export('orders',$field,$temp_orders);
   }	
	
	
	
//企业客户导出

    function _get_company_export_data(){
    	$company_sql = "select t_companys.*,t_province.province,t_city.city,t_area.area from t_companys,t_province,t_city,t_area where";
    	$company_sql.= " t_companys.province_id = t_province.province_id and t_companys.city_id = t_city.city_id and t_companys.area_id = t_area.area_id ";
    	$companys = $this->tickets->personal_select($company_sql);
    	//echo '<pre>';print_r($companys);exit;
    	foreach($companys as $k=>$v){
    		$companys[$k]->status = $v->status?'供应中':'开发中';
    		$event_name = '';
    		$event_start_time = '';
    		$event_end_time = '';
    		if ($v->event_id){
    			$check_event = $this->tickets->api_select('event','name,start_time,end_time',array('id'=>$v->event_id));
    			if($check_event){
    				$event_name = $check_event[0]->name;
    				$event_start_time = $check_event[0]->start_time;
    				$event_end_time = $check_event[0]->end_time;
    			}
    		}
    		$companys[$k]->event_name = $event_name;
    		$companys[$k]->event_start_time = $event_start_time;
    		$companys[$k]->event_end_time = $event_end_time;
    		
            $order_member_count = $order_good_count = $order_amount = $order_count = $success_order_count = $failure_order_count = $cancel_order_count = 0;	
            $temp_order_sql = "select t_orders.to_uid,t_orders.to_status,t_orders.to_order_amount,t_orders.to_id,t_order_good.count,t_order_good.good_id from t_order_good,t_orders where t_order_good.order_id=t_orders.to_id ";
            $temp_order = $this->tickets->personal_select($temp_order_sql);
            $temp_order_arr = array();
            foreach ($temp_order as $j=>$m){
            	$second_sql = "select t_companys.id from t_companys,t_shipping_address where t_companys.id = t_shipping_address.tsa_company and t_shipping_address.tsa_default=1 and t_shipping_address.tsa_uid = ".$m->to_uid;           	
            	$second_sql_data = $this->tickets->personal_select($second_sql);
            	if ($second_sql_data){
            		$order_count++;
            		$order_member_count++;
            		$order_good_count+=$m->count;
            		if(!in_array($m->to_id,$temp_order_arr)){
            			$order_amount+=$m->to_order_amount;
            			$temp_order_arr[] = $m->to_id;
            		}
            		if ($m->to_status==ORDER_SUCCESS){
            			$success_order_count++;
            		}else if($m->to_status==ORDER_CANCELED){
            			$cancel_order_count++;
            		}else{
            			$failure_order_count++;
            		}
            	}
            }
            
           
            
            $companys[$k]->order_count = $order_count;
            $companys[$k]->member_count = $order_member_count;
            $companys[$k]->good_count = $order_good_count;
            $companys[$k]->order_amount = $order_amount;
            $companys[$k]->success_order_count = $success_order_count;
            $companys[$k]->cancel_order_count = $cancel_order_count;
            $companys[$k]->failure_order_count = $failure_order_count; 
            $building_name = '';
            if($v->service_building_id){
            	$temp_building = $this->tickets->api_select('service_buildings','name',array('id'=>$v->service_building_id));
            	if($temp_building){
            		$building_name = $temp_building[0]->name;
            	}
            }
            
            $companys[$k]->building_name = $building_name;
    	}
    	//	企业客户ID、企业客户标识号（唯一的）、企业客户名称、省、城市、区、所属配送区域名称、地址（XX路XX号（弄））、XX楼XX室、状态（开发中、供应中）、
    	//开发时间、活动ID、活动名称、活动开始时间、活动结束时间、累积订餐用户数、累积订餐份数、累积订餐金额、累积订单数、成功订单数、失败订单数、取消订单数、备注
    	$field = array(
    			array('field'=>'id','name'=>'企业客户ID'),
    			array('field'=>'name','name'=>'企业客户名称'),
    			array('field'=>'province','name'=>'省'),
    			array('field'=>'city','name'=>'市'),
    			array('field'=>'area','name'=>'区域'),
    			array('field'=>'building_name','name'=>'配送区域'),
    			array('field'=>'address','name'=>'地址'),
    			array('field'=>'status','name'=>'状态'),
    			array('field'=>'develop_time','name'=>'开发时间'),
    			array('field'=>'event_name','name'=>'活动名称'),
    			array('field'=>'event_start_time','name'=>'活动开始时间'),
    			array('field'=>'event_end_time','name'=>'活动结束时间'),
    			array('field'=>'member_count','name'=>'累积订餐用户数'),
    			array('field'=>'good_count','name'=>'累积订餐份数'),
    			array('field'=>'order_amount','name'=>'累积订餐金额'),
    			array('field'=>'order_count','name'=>'累积订单数'),
    			array('field'=>'success_order_count','name'=>'成功订单数'),
    			array('field'=>'failure_order_count','name'=>'失败订单数'),
    			array('field'=>'cancel_order_count','name'=>'取消订单数'),
    			array('field'=>'comment','name'=>'备注'),
    	);
    		
    	$this->_do_export('company',$field,$companys);
    	
    	
    }	
	
	
	
	
//写字楼导出

	function _get_building_export_data(){
		$building_sql = "select t_service_buildings.*,t_province.province,t_city.city,t_area.area from t_service_buildings,t_province,t_city,t_area where";
		$building_sql.= " t_service_buildings.province_id = t_province.province_id and t_service_buildings.city_id = t_city.city_id and t_service_buildings.area_id = t_area.area_id ";
		$buildings = $this->tickets->personal_select($building_sql);
		foreach($buildings as $k=>$v){
			if ($v->status == 0)
			{
				$status = '开发中';
			}
			else if($v->status == 1)
			{
				$status = '供应中';
			}
			else if($v->status == 2)
			{
				$status = '停止供应';
			}
			else if($v->status == 3)
			{
				$status = '活动写字楼';
			}else if($v->status == 4)
			{
				$status = '虚拟写字楼';
			}
			
			$buildings[$k]->status = $status;
			
			$member_count = 0;
			$order_count = 0;
			$good_count = 0;
			$order_amount = 0;
			$success_order_count = 0;
			$cancel_order_count = 0;
			$failure_order_count = 0;
			$temp_order_sql = "select t_orders.to_status,t_orders.to_order_amount,t_orders.to_id,t_order_good.count,t_order_good.good_id from t_order_good,t_orders where t_order_good.order_id=t_orders.to_id ";
			$temp_order = $this->tickets->personal_select($temp_order_sql);
			$temp_order_arr = array();
			foreach ($temp_order as $j=>$m){
				$second_sql = "select t_goods.price,t_goods.id from t_goods,t_good_supplier_buildings where t_good_supplier_buildings.good_id = t_goods.id and t_goods.id= ".$m->good_id." and t_good_supplier_buildings.building_id=".$v->id;
				$second_sql_data = $this->tickets->personal_select($second_sql);
				if ($second_sql_data){
					$member_count++;
					$good_count+=$m->count;
					if(!in_array($m->to_id,$temp_order_arr)){
						$order_amount+=$m->to_order_amount;
						$temp_order_arr[] = $m->to_id;
					}
					if ($m->to_status==ORDER_SUCCESS){
						$success_order_count++;
					}else if($m->to_status==ORDER_CANCELED){
						$cancel_order_count++;
					}else{
						$failure_order_count++;
					} 
				}
			}	
			$buildings[$k]->order_count = $order_count; 
			$buildings[$k]->member_count = $member_count;
			$buildings[$k]->good_count = $good_count;
			$buildings[$k]->order_amount = $order_amount;
			$buildings[$k]->success_order_count = $success_order_count;
			$buildings[$k]->cancel_order_count = $cancel_order_count;
			$buildings[$k]->failure_order_count = $failure_order_count;
				
		} 
			
		$field = array(
				array('field'=>'id','name'=>'区域ID'),
				array('field'=>'province','name'=>'省'),
				array('field'=>'city','name'=>'市'),
				array('field'=>'area','name'=>'区域'),
				array('field'=>'name','name'=>'写字楼名'),
				array('field'=>'address','name'=>'地址'),
				array('field'=>'status','name'=>'状态'),
				array('field'=>'develop_time','name'=>'开发时间'),
				array('field'=>'start_time','name'=>'供应开始时间'),
				array('field'=>'end_time','name'=>'供应结束时间'),
				array('field'=>'member_count','name'=>'累积订餐用户数'),
				array('field'=>'good_count','name'=>'累积订餐份数'),
				array('field'=>'order_amount','name'=>'累积订餐金额'),
				array('field'=>'order_count','name'=>'累积订单数'),
				array('field'=>'success_order_count','name'=>'成功订单数'),
				array('field'=>'failure_order_count','name'=>'失败订单数'),
				array('field'=>'cancel_order_count','name'=>'取消订单数'),
				array('field'=>'remark','name'=>'备注'),
		);
			
		$this->_do_export('building',$field,$buildings);
	 
	}
	
	
	
	
/*
 * 取出所有菜品品类
 */	
	//品类ID、品类名称、品类状态（准备、上架、下架）、只星期X显示控制开关、星期X显示、下属菜品总数、下属菜品清单及所属供应商、供应商家数、总销售金额
	/*function _get_category_export_data(){
		$cate = $this->tickets->select('categorys',array('pid !='=>0));
		foreach($cate as $k=>$v){
			$p_cate = $this->tickets->api_select('categorys','name',array('pid'=>$v->id));
			$pcate_name = $p_cate[0]->name;
			$cate[$k]->pcate_name = $pcate_name;
			
			$cate[$k]->week_switch = $v->status?'是':'否';
			$week = '';
			if ($v->status){
				$temp_week = $v->week;
				if ($temp_week){
					$temp_week = explode(',',$temp_week);
				
					$week_data = common_weeks();
					foreach ($temp_week as $j=>$m){
						$week.=$week_data[$m].',';
					}
					 
					$week = rtrim($week,',');
				} 
			}
			$cate[$k]->week = $week;
		//菜品总数
		    $cate[$k]->good_count = $this->tickets->select_count_where('goods',array('sub_cate_id'=>$v->id));
		    	
			$temp_goods = $this->tickets->api_select('goods','name,id',array('sub_cate_id'=>$v->id));
			foreach($temp_goods as $key=>$val){
				$supplier_sql = 'select t_supplier.name from t_supplier,t_supplier_good where t_supplier.id=t_supplier_good.supplier_id and t_supplier_good.good_id='.$val->id;
				$temp_supplier = $this->tickets->personal_select($supplier_sql);
				$supplier_array = array();
				$supplier = '';
				$supplier_count = 0;
				if($temp_supplier){
					foreach($temp_supplier as $key=>$val){
						if(!in_array($val->name,$supplier_array)){
							$supplier_array[] = $val->name;
							$supplier.=$val->name.',';
							$supplier_count++;
						}
					}
					$supplier = rtrim($supplier,',');
				}
					
				$temp_goods[$k]->supplier = $supplier;
			}
			
		}
		
	}
	*/
	

/*
 * 取出所有菜品数据
 */	
	function _get_goods_export_data(){
		$good_sql = "select t_goods.*,t_good_supplier_buildings.start_time,t_good_supplier_buildings.end_time,t_good_supplier_buildings.week,t_good_supplier_buildings.building_id from t_good_supplier_buildings,t_goods where t_good_supplier_buildings.good_id = t_goods.id";
		$goods = $this->tickets->personal_select($good_sql);
		 
		foreach($goods as $k=>$v){
			 
			$temp_cate = $this->tickets->api_select('categorys','name',array('id'=>$v->cate_id));
			$cate_name = '';
			if($temp_cate){
				$cate_name = $temp_cate[0]->name;
			}
			$goods[$k]->cate_name = $cate_name;
			if ($v->status == 0){
			  $status = '准备';	
			}else if($v->status == 1){
			  $status = '上架';	
			}else{
			  $status = '下架';
			}
			
		//供应商	
			$goods[$k]->status = $status;
			$supplier_sql = 'select t_supplier.name from t_supplier,t_supplier_good where t_supplier.id=t_supplier_good.supplier_id and t_supplier_good.good_id='.$v->id;
			$temp_supplier = $this->tickets->personal_select($supplier_sql);
			$supplier_array = array();
			$supplier = '';
			if($temp_supplier){
				foreach($temp_supplier as $key=>$val){
					if(!in_array($val->name,$supplier_array)){
						$supplier_array[] = $val->name;
						$supplier.=$val->name.',';
					}
				}
				$supplier = rtrim($supplier,',');
			}
			
			$goods[$k]->supplier = $supplier;
	//星期
	        $temp_week = $v->week;
	      
	        $week = '';
	        if ($temp_week){
	            $temp_week = explode(',',$temp_week); 
	           
	            $week_data = common_weeks();
	            foreach ($temp_week as $j=>$m){
	            	$week.=$week_data[$m].',';
	            }
	          
	            $week = rtrim($week,','); 
	        }
	        $goods[$k]->week = $week;

	        $temp_count = $this->tickets->select_count_where('order_good',array('good_id'=>$v->id));	         
	        $goods[$k]->sale_count = $temp_count;
	        $goods[$k]->time_area = $v->start_time.'--'.$v->end_time;
	        $temp_title =$v->name;
	        for($i=0;$i<5;$i++){$title = 'title'.$i;if($v->$title){ if($i){$temp_title.=',';}$temp_title.=$v->$title;}}
	        $goods[$k]->name = $temp_title;
	        
	        $temp_building = $this->tickets->api_select('service_buildings','name',array('id'=>$v->building_id));
	        if($temp_building){
	        	$building_name = $temp_building[0]->name;
	        }else{
	        	$building_name = '';
	        }
	        
	        $goods[$k]->building = $building_name;
		}
		
		$field = array(
				array('field'=>'id','name'=>'菜品ID'),
				array('field'=>'name','name'=>'菜品内容'),
				array('field'=>'cate_name','name'=>'菜品品类'),
				array('field'=>'status','name'=>'菜品状态'),
				array('field'=>'price','name'=>'菜品价格'),
				array('field'=>'supplier','name'=>'供应商'),
				array('field'=>'building','name'=>'写字楼'),
				array('field'=>'week','name'=>'供应时间'),
				array('field'=>'time_area','name'=>'供应时间段'),
				array('field'=>'sale_count','name'=>'累积销量'),
		);
			
		$this->_do_export('goods',$field,$goods);
		
		
	}
	
	
	
	
/*取出供应商数据
 * 
 */
   function _get_supplier_export_data(){
   	   $supplier_sql = "select t_supplier.*,t_province.province,t_city.city from t_supplier,t_province,t_city where ";
       $supplier_sql.=" t_supplier.province_id = t_province.province_id and t_supplier.city_id = t_city.city_id "; 
   	   $supplier = $this->tickets->personal_select($supplier_sql);
   	   foreach($supplier as $k=>$v){
   	   	   $supplier[$k]->address = $v->province.' '.$v->city.' '.$v->address;
   	   	   $supplier[$k]->status  = $v->status?'营业':'停业';
   	 //获取菜品 品类
   	       $cate_sql = "select t_categorys.name as cate_name,t_supplier_category.*,t_supplier.id from t_categorys,t_supplier,t_supplier_category where t_supplier_category.supplier_id =".$v->id;  	   
   	       $temp_cate = $this->tickets->personal_select($cate_sql);
   	       $supplier_cate = '';
   	       $supplier_array = array();
   	       if($temp_cate){
	   	       foreach ($temp_cate as $key=>$val){
	   	       	 if(!in_array($val->cate_name,$supplier_array)){
	   	       	   $supplier_cate.=$val->cate_name.',';
	   	       	   $supplier_array[] = $val->cate_name;
	   	       	 }
	   	       }
   	       }
   	       if ($supplier_cate){
   	       	 $supplier_cate = rtrim($supplier_cate,',');
   	       }
   	       
   	       $supplier[$k]->cate_name = $supplier_cate;
   	       
   	  //服务区
   	       $area_sql = "select t_area.area,t_supplier_area.*,t_supplier.id from t_area,t_supplier,t_supplier_area where t_supplier_area.area_id= t_area.area_id and t_supplier_area.supplier_id =".$v->id;
   	       $temp_area = $this->tickets->personal_select($area_sql);
   	       $supplier_area = '';
   	       $temp_area_array = array();
   	       if($temp_area){
   	       	foreach ($temp_area as $key=>$val){
   	       		if(!in_array($val->area,$temp_area_array)){
   	       		   $supplier_area.=$val->area.',';
   	       		   $temp_area_array[] = $val->area;
   	       		}
   	       	}
   	       }
   	       if ($supplier_area){
   	       	$supplier_area = rtrim($supplier_area,',');
   	       }
   	        
   	       $supplier[$k]->area_name = $supplier_area;
   	       
   	    //取出所有可用商品总金额
   	    
   	       $supplier_count = 0;
   	       $temp_order_sql = "select t_orders.to_id,t_order_good.count,t_order_good.good_id from t_order_good,t_orders where t_order_good.order_id=t_orders.to_id and  t_orders.to_status=".ORDER_SUCCESS;
   	       $temp_order = $this->tickets->personal_select($temp_order_sql);
   	       foreach ($temp_order as $j=>$m){
   	       	  $second_sql = "select t_goods.price from t_goods,t_good_supplier_buildings where t_good_supplier_buildings.good_id = t_goods.id and t_goods.id= ".$m->good_id." and t_good_supplier_buildings.supplier_id=".$v->id;
   	       	  $second_sql_data = $this->tickets->personal_select($second_sql);
   	       	  if ($second_sql_data){
   	       	  	$price = $second_sql_data[0]->price;
   	       	  	$supplier_count+=$price*$m->count;
   	       	  }
   	       } 
   	       
   	       $supplier[$k]->order_amount = $supplier_count; 
   	   }
   	   
   	   $field = array(
   	   		array('field'=>'id','name'=>'供应商ID'),
   	   		array('field'=>'name','name'=>'供应商名'),
   	   		array('field'=>'address','name'=>'地址'),
   	   		array('field'=>'status','name'=>'状态'),
   	   		array('field'=>'cate_name','name'=>'供应菜品品类'),
   	   		array('field'=>'open_time','name'=>'开业时间'),
   	   		array('field'=>'order_amount','name'=>'总成交额'),
   	   		array('field'=>'area_name','name'=>'服务区域')
   	   );
   	   
   	   $this->_do_export('supplier',$field,$supplier);
   	
   }     	
	
	
	
	
//获取用户导出数据
	function _get_user_export_data(){
		$user = $this->tickets->select('users');
		foreach ($user as $k=>$v){
			//写字楼
			$user_building = '';
			if($v->tu_default_building){
			  $temp_building = $this->tickets->api_select('service_buildings','name',array('id'=>$v->tu_default_building));
              if($temp_building){
			 	 $user_building = $temp_building[0]->name;
              } 
			}
			$user[$k]->tu_user_building = $user_building;
			//default_shipping_address
			$company_name = '';
			$last_address = '';
			$sql = 'select t_shipping_address.tsa_company,t_shipping_address.tsa_address,t_companys.name as company_name from t_companys,t_shipping_address where ';
			$sql.=' t_shipping_address.tsa_company = t_companys.id and t_shipping_address.tsa_default=1 and t_shipping_address.tsa_uid='.$v->tu_id;
			$shipping_address = $this->tickets->personal_select($sql);
			if ($shipping_address){
			  $address = $shipping_address[0];
			  $last_address = $address->tsa_address;
			  $company_name = $address->company_name;
			} 
			$user[$k]->tu_company_name = $company_name;
			$user[$k]->tu_last_address = $last_address;
			$score = 0;
			$user[$k]->tu_score = $score;
	//用户状态		
			$user[$k]->tu_status = $v->tu_status?'黑名单':'正常';
			 
	//用户来源
			$user[$k]->tu_source = $v->tu_source?'微信绑定':'网站注册';
	         
	//用户性别
	        $user[$k]->tu_gender = $v->tu_gender?'女':'男'; 
    //取出此人所有订单
            $order = $this->_get_user_orders($v->tu_id);
            $user[$k]->total_amount = $order['total_amount'];
            $user[$k]->alipay_amount = $order['alipay_amount'];
            $user[$k]->weipay_amount = $order['weipay_amount'];
            $user[$k]->coupon_amount = $order['coupon_amount'];
            $user[$k]->cash_amount = $order['cash_amount'];
            $user[$k]->success_order_count = $order['success_order_count'];
            $user[$k]->failure_order_count = $order['failure_order_count'];
            $user[$k]->cancel_order_count = $order['cancel_order_count'];
		}
		 
		$field = array(
						array('field'=>'tu_id','name'=>'用户ID'),
						array('field'=>'tu_nickname','name'=>'姓名'),
						array('field'=>'tu_mobile','name'=>'电话'),
						array('field'=>'tu_email','name'=>'Email'),
						array('field'=>'tu_gender','name'=>'性别'),
						array('field'=>'tu_user_building','name'=>'所在写字楼'),
						array('field'=>'tu_company_name','name'=>'公司名称'),
						array('field'=>'tu_last_address','name'=>'上次配送地址'),
						array('field'=>'tu_created','name'=>'注册时间'),
						array('field'=>'tu_score','name'=>'积分'),
						array('field'=>'tu_status','name'=>'状态'),
						array('field'=>'tu_source','name'=>'来源'),
						array('field'=>'tu_nickname','name'=>'微信名'),
						array('field'=>'total_amount','name'=>'总成交额'),
						array('field'=>'alipay_amount','name'=>'支付宝支付金额'),
						array('field'=>'weipay_amount','name'=>'微信支付金额'),
						array('field'=>'coupon_amount','name'=>'优惠券支付金额'),
						array('field'=>'cash_amount','name'=>'现金支付金额'),
						array('field'=>'success_order_count','name'=>'成功订单数'),
						array('field'=>'failure_order_count','name'=>'失败订单数'),
						array('field'=>'cancel_order_count','name'=>'取消订单数')
				);
		
		$this->_do_export('user',$field,$user);
		
	}
	
	
/* 总成交额 $total_amount，
 * 支付宝支付金额 $alipay_amount、
 * 微信支付金额 $weipay_amount、
 * 优惠券支付金额 $coupon_amount,
 * 现金支付金额 $cash_amount、
 * 成功订单数 $success_order_count、
 * 失败订单数 $failure_order_count、
 * 取消订单数	$cancel_order_count
 * 
 */
	function _get_user_orders($uid){
		$orders = $this->tickets->select('orders',array('to_uid'=>$uid));
		
		$total_amount = $alipay_amount= $weipay_amount = $coupon_amount = $cash_amount = $success_order_count = 0;
		$failure_order_count = $cancel_order_count = 0;
		if($orders){
			foreach($orders as $k=>$v){
				$total_amount+=$v->to_order_amount;
				if ($v->to_pay_way == 'alipay'){
					$alipay_amount+= $v->to_total_amount;
				}else if($v->to_pay_way == 'wechat'){
					$weipay_amount+= $v->to_total_amount;
				}else if($v->to_pay_way == 'daofu'){
					$cash_amount+= $v->to_total_amount;
				}
		  //如果用户优惠券		
				if($v->to_coupon_id){
					$coupon_sql = "select t_coupons.tc_price from t_coupons,t_coupons_record where t_coupons_record.tcr_tc_id = t_coupons.tc_id and t_coupons_record.tcr_id=".$v->to_coupon_id;
					$temp_coupon = $this->tickets->personal_select($coupon_sql);
					if($temp_coupon){
						$coupon_amount+= $temp_coupon[0]->tc_price;
					}
				} 
				
				if ($v->to_status == ORDER_SUCCESS){
					$success_order_count++;
				}else if($v->to_status == ORDER_CANCELED){
					$cancel_order_count++;
				}else{
					$failure_order_count++;
				}
			}
		}
		
		return array(
					'total_amount'=>$total_amount,
					'alipay_amount'=>$alipay_amount,
					'weipay_amount'=>$weipay_amount,
					'cash_amount'=>$cash_amount,
					'coupon_amount'=>$coupon_amount,
					'success_order_count'=>$success_order_count,
					'cancel_order_count'=>$cancel_order_count,
				    'failure_order_count'=>$failure_order_count
				);
	}
	
	
//导出方法	
	function _do_export($table,$fields,$datas){

		require_once APPPATH.'libraries/PHPExcel/PHPExcel.php';
		require_once APPPATH.'libraries/PHPExcel/PHPExcel/IOFactory.php';
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
		->setLastModifiedBy("Maarten Balliauw")
		->setTitle("Office 2007 XLSX Test Document")
		->setSubject("Office 2007 XLSX Test Document")
		->setDescription("Document for Office 2007 XLSX, generated using PHP classes.")
		->setKeywords("office 2007 openxml php")
		->setCategory("Test result file");
			
		//First sheet started
		$objPHPExcel->setActiveSheetIndex(0);
		$objRichText = new PHPExcel_RichText();
		$objRichText->createText('');
		$objPayable = $objRichText->createTextRun('PHP导出的Excel');
		 
		$cell_field = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC');
		foreach($fields as $k=>$v){
			//echo $cell_field[$k].'1<br/>';
			$objPHPExcel->getActiveSheet()->getColumnDimension($cell_field[$k])->setWidth(20);
			$objPHPExcel->getActiveSheet()->setCellValue($cell_field[$k].'1', $v['name']);
		} 
		foreach($datas as $key=>$val){
			$keys = $key+2;
			foreach($fields as $k=>$v){
 
				$objPHPExcel->getActiveSheet()->setCellValue($cell_field[$k].$keys, $val->$v['field']);
			} 
		}
		$objPHPExcel->setActiveSheetIndex(0);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		date_default_timezone_set('Asia/Chongqing');
		$name = 'uploads/'.$table.'_'.date('Y.m.d.H.i.s').'.xls';
		$name = iconv('utf-8','gb2312',$name);
		$objWriter->save($name);
		redirect('/'.$name);exit;
	}
	


	//新增用户
	function company_add(){
		if($_POST){
			$id = intval($_POST['id']);
			$sub_data = array(
					 
					'name'=>trim($_POST['name']),
					'event_id'=>trim($_POST['event_id']),
					'province_id'=>trim($_POST['province_id']),
					'city_id'=>trim($_POST['city_id']),
					'service_building_id'=>trim($_POST['service_building_id']),
					'address'=>trim($_POST['address']),
					'status'=>trim($_POST['status']),
					'develop_time'=>trim($_POST['develop_time']),
					'comment'=>trim($_POST['comment']),
					'area_id'=>trim($_POST['area_id']));
			if($id){
				$result = $this->tickets->update('companys',$sub_data,array('id'=>$id));
			}else{
				$sub_data['created'] = date('Y-m-d H:i:s');
				$result = $this->tickets->insert('companys',$sub_data);
			}
			redirect('/admin/company_index');
		}else{
			$id = $this->uri->segment(3);
			$payment = '';
			if($id){
				$company = $this->tickets->select('companys',array('id'=>$id));
				$company = $company[0];
				$data['citys'] = $this->tickets->select('city',array('father'=>$company->province_id));
				$data['areas'] = $this->tickets->select('area',array('father'=>$company->city_id)); 
			}else{
				$id = 0;
				$company = '';
			}
			$data['service_building'] = $this->tickets->select('service_buildings');
			$data['id'] = $id;
			$data['company'] = $company;
			$data['province'] = $this->tickets->select('province',array('status'=>1));
			$data['event'] = $this->tickets->select('event');
			$this->load->view('admin/company_add',$data);
		}
	}
	
	
	
	
	//管理所有的网站用户
	function company_index(){
		$companys = $this->tickets->select('companys');
		foreach($companys as $k=>$v){
			$province_temp = $this->tickets->select('province',array('province_id'=>$v->province_id));
			$city_temp = $this->tickets->select('city',array('city_id'=>$v->city_id));
			$area_temp = $this->tickets->select('area',array('area_id'=>$v->area_id));
			$companys[$k]->province = $province_temp[0]->province;
			$companys[$k]->city = $city_temp[0]->city;
			$companys[$k]->area = $area_temp[0]->area;
			
			$building_name = '';
			if($v->service_building_id){
				$temp_building = $this->tickets->api_select('service_buildings','name',array('id'=>$v->service_building_id));
				$building_name = $temp_building[0]->name;
			}
			$companys[$k]->building_name = $building_name;
		}
	
		$data['companys'] = $companys;
		$this->load->view('admin/company_list',$data);
	}
	
	
	

	//删除用户
	function user_delete(){
		$tu_id = intval($_POST['tu_id']);
	
		//先删除场次，再删除剧
		$delete_result = $this->tickets->update('users',array('tu_status'=>DELETE_USER),array('tu_id'=>$tu_id));
		if ($delete_result){
			$re = array('success'=>'yes','msg'=>'删除成功');
		}else{
			$re = array('success'=>'no','msg'=>'删除失败');
		}
	
		echo json_encode($re);exit;
	}	
	
	
	

	//新增用户
	function event_add(){
		if($_POST){
			$id = intval($_POST['id']);
			$sub_data = array(
					'name'=>trim($_POST['name']),
					'price'=>trim($_POST['price']),
					'start_time'=>trim($_POST['start_time']),
					'end_time'=>trim($_POST['end_time']),
					'desc'=>trim($_POST['desc']));
			if($id){
				$result = $this->tickets->update('event',$sub_data,array('id'=>$id));
			}else{
				$sub_data['created'] = date('Y-m-d H:i:s');
				$result = $this->tickets->insert('event',$sub_data);
			}
			redirect('admin/event_index');
			/*if($result){
				echo json_encode(array('success'=>'yes','msg'=>'操作成功'));exit;
			}else{
				echo json_encode(array('success'=>'no','msg'=>'操作失败'));exit;
			}*/
				
		}else{
			$id = $this->uri->segment(3);
			$data['id'] = $id;
			if($id){  
				
				$event = $this->tickets->select('event',array('id'=>$id));
				$data['event'] = $event[0];
			}else{
				$data['event'] = '';
			}
			$this->load->view('admin/event_add',$data);
		}
	}
	
	
	
	
	//管理所有的网站用户
	function event_index(){
		$events = $this->tickets->select('event');
		 
		$data['events'] = $events;
		$this->load->view('admin/event_list',$data);
	}
		
	
	
	
	
//新增用户
	function user_add(){
		if($_POST){
			$id = intval($_POST['tu_id']);
			$sub_data = array(
					'tu_nickname'=>trim($_POST['tu_nickname']),
					'tu_mobile'=>trim($_POST['tu_mobile']),
					'tu_email'=>trim($_POST['tu_email']),
					'tu_gender'=>trim($_POST['tu_gender']),
					'tu_default_building'=>intval($_POST['tu_service_building']));
			if($id){
				$result = $this->tickets->update('users',$sub_data,array('tu_id'=>$id));
			}else{
				$sub_data['tu_created'] = date('Y-m-d H:i:s');
				$result = $this->tickets->insert('users',$sub_data);
			}
			if($result){
				echo json_encode(array('success'=>'yes','msg'=>'操作成功'));exit;
			}else{
				echo json_encode(array('success'=>'no','msg'=>'操作失败'));exit;
			}
			
		}else{
			$id = $this->uri->segment(3);
			$payment = '';
			if($id){
				$user = $this->tickets->select('users',array('tu_id'=>$id));
				$user = $user[0];
			}else{
				$id = 0;
				$user = '';
			}
			$data['service_building'] = $this->tickets->select('service_buildings');
			$data['id'] = $id;
			$data['user'] = $user;
			$this->load->view('admin/user_add',$data);
		}
	}
	
	
	
	
//管理所有的网站用户
     function user_list(){
     	$users = $this->tickets->select('users',array('tu_status !='=>DELETE_USER));
     	foreach($users as $k=>$v){
     		$building_name = '';
     		if($v->tu_default_building){
     		  $temp_building = $this->tickets->api_select('service_buildings','name',array('id'=>$v->tu_default_building));
     		  $building_name = $temp_building[0]->name;
     		}
     		$users[$k]->building_name = $building_name;
     		
     		$default_address = $this->tickets->api_select('shipping_address','tsa_nickname',array('tsa_uid'=>$v->tu_id,'tsa_default'=>1));
     		if($default_address){
     			$users[$k]->tu_nickname = $default_address[0]->tsa_nickname;
     		}
     		
     	}
     	
     	$data['users'] = $users;
     	$this->load->view('admin/user_list',$data);
     }	
	
	
    function authority_add(){
    	
    	if($_POST){
    		$role_name = $_POST['role_name'];
    		$oauth = $_POST['oauth'];
    		$id = intval($_POST['id']);
    		$oauth = implode(',',$oauth);
    		
    		$role_data = array('role_name'=>$role_name,'authority'=>$oauth);
    		if ($id){
    			$this->tickets->update('admin_authority',$role_data,array('id'=>$id));
    		}else{
    			$this->tickets->insert('admin_authority',$role_data);
    		}
    		redirect('/admin/admin_oauth');
    		
    	}else{
    		$id = $this->uri->segment(3);
			if($id){
				$oauth = $this->tickets->select('admin_authority',array('id'=>$id));
				$oauth = $oauth[0];
				$oauth->oauth = explode(',',$oauth->authority);
				$data['oauth'] = $oauth;
	
			}else{
				$data['oauth'] = '';
			}
			$data['oauth_config'] = $this->common->module_config(); 
			$this->load->view('admin/authority_add',$data);
    	}
    } 
     
     
	
//管理员权限
    function admin_oauth(){
    	$data['oauth_config'] = $this->common->module_config();
    	$authority = $this->tickets->select('admin_authority','','','','',array('id'=>'desc'));
    	foreach($authority as $k=>$v){
    		$authority[$k]->authority = explode(',',$v->authority);
    	}
    	$data['authority'] = $authority;
    	 
    	$this->load->view('admin/admin_oauth',$data);
    }	
	
	
	
//设置优惠券
    function coupon_setting(){
    	$coupon = $this->tickets->select('coupons_setting','','','','',array('tcs_id'=>'desc'));
    	if (!$coupon){
    		$coupon = '';
    	}else{
    		foreach ($coupon as $key=>$val){
    			$total = count($this->tickets->select('coupons_record',array('tcr_tc_id'=>$val->tc_id)));
    			$total_used = $this->tickets->select_count_where('coupons_record',array('tcr_tc_id'=>$val->tc_id,'tcr_status'=>COUPON_USED));
    			$coupon[$key]->total = $total;
    			$coupon[$key]->total_used = $total_used;
    		}
    	}
    		
    	$data['coupons_setting'] = $coupon;
    	
    	$this->load->view('admin/coupon_setting',$data);
    	
    }	
	
	

	function coupon_code(){
		$tc_id = $this->uri->segment(3);
		$status = $this->uri->segment(4);
		$page = $this->uri->segment(5);
		$cond = array('tcc_tc_id '=>$tc_id);
		if ($status==1){
			$cond['tcc_status'] = INVALID_CODES;
		}else if($status == 2){
			$cond['tcc_status'] = VALID_CODES;
		}
			
		$coupon_codes = $this->tickets->select('coupons_codes',$cond);
	
		$data['coupon_code'] = $coupon_codes;
		$coupons = $this->tickets->select('coupons',array('tc_id'=>$tc_id));
		$data['coupon'] = $coupons[0];
		$data['tc_id'] = $tc_id;
		$data['status'] = $status;
		$this->load->view('admin/coupon_code',$data);
	}
	
	
	
//新增优惠券类型	
	function coupon_add(){
	
		if ($_POST){
	
			$id = intval($_POST['tc_id']);
			$title = trim($_POST['tc_title']);
			$price = trim($_POST['tc_price']);
			$desc = trim($_POST['tc_desc']);
			$start_time = trim($_POST['tc_start_time']);
			$end_time = trim($_POST['tc_end_time']);
			$tc_sale_price = trim($_POST['tc_sale_price']);
			$tc_cond_price = trim($_POST['tc_cond_price']);
			
			$dat = array('tc_price'=>$price,'tc_cond_price'=>$tc_cond_price,'tc_sale_price'=>$tc_sale_price,'tc_title'=>$title,'tc_desc'=>$desc,'tc_start_time'=>$start_time,'tc_end_time'=>$end_time,'tc_created'=>date('Y-m-d H:i:s'));
			if ($id){
				$this->tickets->update('coupons',$dat,array('tc_id'=>$id));
			}else{
				$this->tickets->insert('coupons',$dat);
			}
			echo json_encode(array('success'=>'yes'));exit;
	
		}else{
			$id = $this->uri->segment(3);
			if($id){
				$coupons = $this->tickets->select('coupons',array('tc_id'=>$id));
				$data['coupons'] = $coupons[0];
	
			}else{
				$data['coupons'] = '';
			}
			
			$data['coupons_types'] = $this->common->coupons_types();
	
			$this->load->view('admin/coupon_add',$data);
		}
	}
		


//优惠券类型列表
	function coupon(){
		$coupon = $this->tickets->select('coupons','','','','',array('tc_id'=>'desc'));
		if (!$coupon){
			$coupon = '';
		}else{
			foreach ($coupon as $key=>$val){
				$total = count($this->tickets->select('coupons_record',array('tcr_tc_id'=>$val->tc_id)));
				$total_used = $this->tickets->select_count_where('coupons_record',array('tcr_tc_id'=>$val->tc_id,'tcr_status'=>COUPON_USED));
				$coupon[$key]->total = $total;
				$coupon[$key]->total_used = $total_used;
			}
		}
			
		$data['coupons'] = $coupon;
		$data['coupons_types'] = $this->common->coupons_types();
		$this->load->view('admin/coupon_index',$data);
	
	}
	
		
//删除优惠券类型	
	function coupon_delete(){
		$tc_id = intval($_POST['tc_id']);
	
		//先删除场次，再删除剧
		$delete_result = $this->tickets->delete('coupons',array('tc_id'=>$tc_id));
		if ($delete_result){
			$re = array('success'=>'yes','msg'=>'删除成功');
		}else{
			$re = array('success'=>'no','msg'=>'删除失败');
		}
	
		echo json_encode($re);exit;
	}
	
	
	

	function payment_add(){
		if($_POST){
			$id = intval($_POST['id']);
			$sub_data = array(
					'name'=>trim($_POST['name']),
					'payname'=>trim($_POST['payname']),
					'app_id'=>trim($_POST['app_id']),
					'app_secret'=>trim($_POST['app_secret']),
					'partner_key'=>trim($_POST['partner_key']),
					'status'=>intval($_POST['status']));
			if($id){
				$result = $this->tickets->update('payment',$sub_data,array('id'=>$id));
			}else{
				$sub_data['created'] = date('Y-m-d H:i:s');
				$result = $this->tickets->insert('payment',$sub_data);
			}
			redirect('/admin/payment_index');
		}else{
			$id = $this->uri->segment(3);
			$payment = '';
			if($id){
				$payment = $this->tickets->select('payment',array('id'=>$id));
				$payment = $payment[0];
			}else{
				$id = 0;
			}
			$data['id'] = $id;
			$data['payment'] = $payment;
			$this->load->view('admin/payment_add',$data);
		}
	}
	
	
	
//支付方式开关
    function payment_index(){
    	$data['payments'] = $this->tickets->select('payment');
    	$data['payment_lang'] = $this->common->payment_config();
    	$this->load->view('admin/payment',$data);
    }
	
	
	
	function store_delete(){
		$table = trim($this->uri->segment(3));
		$id    = intval($this->uri->segment(4));
		$table_delete = $table;
		if (($table == 'category')||($table == 'company')){
			$table_delete = $table.'s';
		} 	
		$re = $this->tickets->delete($table_delete,array('id'=>$id));
		if ($re) {
			redirect('/admin/'.$table.'_index');
		}
	}
	
	
//订单商品份数	
	function order_count(){
		$this->top();
		if($_POST){
			$user = $this->session->userdata('user');
			$uid = $user[0]->m_id;
			$system_help = $this->tickets->select('configs',array('tc_type'=>'order_count'));
			$data_array = array('tc_title'=>trim($_POST['title']),'tc_content'=>trim($_POST['content']),'tc_type'=>'order_count');
	
			if ($system_help){
				$re = $this->tickets->update('configs',$data_array,array('tc_type'=>'order_count'));
	
			}else{
				$re = $this->tickets->insert('configs',$data_array);
			}
	
			if ($re){
					
				$result = array('success'=>'yes');
			}else{
				$result = array('success'=>'no');
			}
			echo json_encode($result);exit;
	
		}else{
			$configs = $this->tickets->select('configs',array('tc_type'=>'order_count'));
	
			if($configs){
				$data['configs'] = $configs[0];
			}else{
				$data['configs'] = '';
			}
	
			$this->load->view('admin/order_count',$data);
		}
	
	}
	
	
	
//积分配置比例	
	function jifen_bili_config(){
		$this->top();
		if($_POST){
			$user = $this->session->userdata('user');
			$uid = $user[0]->m_id;
			$system_help = $this->tickets->select('configs',array('tc_type'=>'jifen_config'));
			$data_array = array('tc_content'=>trim($_POST['content']),'tc_title'=>trim($_POST['title']),'tc_extra'=>trim($_POST['extra']),'tc_type'=>'jifen_config');
		
			if ($system_help){
				$re = $this->tickets->update('configs',$data_array,array('tc_type'=>'jifen_config'));
		
			}else{
				$re = $this->tickets->insert('configs',$data_array);
			}
		
			if ($re){
					
				$result = array('success'=>'yes');
			}else{
				$result = array('success'=>'no');
			}
			echo json_encode($result);exit;
		
		}else{
			$configs = $this->tickets->select('configs',array('tc_type'=>'jifen_config'));
		
			if($configs){
				$data['configs'] = $configs[0];
			}else{
				$data['configs'] = '';
			}
		
			$this->load->view('admin/jifen_bili_config',$data);
		}
	}  
	
	
	function order_time_settings(){
		$this->top();
		if($_POST){
			$user = $this->session->userdata('user');
			$uid = $user[0]->m_id;
			$system_help = $this->tickets->select('configs',array('tc_type'=>'order_time'));
			$data_array = array('tc_title'=>trim($_POST['title']),'tc_content'=>trim($_POST['content']),'tc_type'=>'order_time');
				
			if ($system_help){
				$re = $this->tickets->update('configs',$data_array,array('tc_type'=>'order_time'));
	
			}else{
				$re = $this->tickets->insert('configs',$data_array);
			}
				
			if ($re){
				 
				$result = array('success'=>'yes');
			}else{
				$result = array('success'=>'no');
			}
			echo json_encode($result);exit;
	
		}else{
			$configs = $this->tickets->select('configs',array('tc_type'=>'order_time'));
			 
			if($configs){
				$data['configs'] = $configs[0];
			}else{
				$data['configs'] = '';
			}
	
			$this->load->view('admin/order_time_settings',$data);
		}
	
	}
	
	
	
	
	function order_date(){
		$this->top();
		if($_POST){
			$user = $this->session->userdata('user');
			$uid = $user[0]->m_id;
			$system_help = $this->tickets->select('configs',array('tc_type'=>'order_date'));
			$data_array = array('tc_title'=>trim($_POST['title']),'tc_content'=>trim($_POST['content']),'tc_type'=>'order_date');
	
			if ($system_help){
				$re = $this->tickets->update('configs',$data_array,array('tc_type'=>'order_date'));
	
			}else{
				$re = $this->tickets->insert('configs',$data_array);
			}
	
			if ($re){
					
				$result = array('success'=>'yes');
			}else{
				$result = array('success'=>'no');
			}
			echo json_encode($result);exit;
	
		}else{
			$configs = $this->tickets->select('configs',array('tc_type'=>'order_date'));
			 
			if($configs){
				$data['configs'] = $configs[0];
			}else{
				$data['configs'] = '';
			}
	
			$this->load->view('admin/order_date',$data);
		}
	
	}
	
	
	
	
	function sms_config(){
		$this->top();
		if($_POST){
			$user = $this->session->userdata('user');
			$uid = $user[0]->m_id;
			$system_help = $this->tickets->select('configs',array('tc_type'=>'sms_config'));
			$data_array = array('tc_title'=>trim($_POST['title']),'tc_content'=>trim($_POST['content']),'tc_type'=>'sms_config');
	
			if ($system_help){
				$re = $this->tickets->update('configs',$data_array,array('tc_type'=>'sms_config'));
	
			}else{
				$re = $this->tickets->insert('configs',$data_array);
			}
	
			if ($re){
					
				$result = array('success'=>'yes');
			}else{
				$result = array('success'=>'no');
			}
			echo json_encode($result);exit;
	
		}else{
			$configs = $this->tickets->select('configs',array('tc_type'=>'sms_config'));
	
			if($configs){
				$data['configs'] = $configs[0];
			}else{
				$data['configs'] = '';
			}
	
			$this->load->view('admin/sms_config',$data);
		}
	
	}
	
	
	function weichat_settings(){
		$this->top();
		if($_POST){
			$user = $this->session->userdata('user');
			$uid = $user[0]->m_id;
			$system_help = $this->tickets->select('system_message',array('type'=>'weichat_config'));
			$data_array = array('field1'=>trim($_POST['field1']),'field2'=>trim($_POST['field2']),'field3'=>trim($_POST['field3']),'field4'=>trim($_POST['field4']),'field5'=>trim($_POST['field5']),'type'=>'weichat_config','m_id'=>$uid);
			
			if ($system_help){
				$re = $this->tickets->update('system_message',$data_array,array('type'=>'weichat_config'));
				
			}else{
				$re = $this->tickets->insert('system_message',$data_array);	
			}
			
			if ($re){
				$this->tickets->update('members',array('weixin_id'=>trim($_POST['field5'])),array('m_id'=>$uid));
				$result = array('success'=>'yes');
			}else{
				$result = array('success'=>'no');
			}
			echo json_encode($result);exit;
	
		}else{
			$system_help = $this->tickets->select('system_message',array('type'=>'weichat_config'));
	
			if($system_help){
				$data['system_help'] = $system_help[0];
			}else{
				$data['system_help'] = '';
			}
	
			$this->load->view('admin/weichat_settings',$data);
		}
	
	}
	

	 function get_access_token($appid,$appsecret){
		$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
		$arr = json_decode(file_get_contents($url),1);
		return $arr;
	}
	
	
	//创建自定义菜单
	public function create_menu($appid,$appsecret,$data,$url= "api.weixin.qq.com"){
		$arr = $this->get_access_token($appid,$appsecret);
		if($arr['access_token']){
			$ACCESS_TOKEN=$arr['access_token'];
			 
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://".$url."/cgi-bin/menu/create?access_token={$ACCESS_TOKEN}");
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:20.0) Gecko/20100101 Firefox/20.0');
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$tmpInfo = curl_exec($ch);
			if (curl_errno($ch)) {
				echo 'Errno'.curl_error($ch);
			}
			curl_close($ch);
			return json_decode($tmpInfo,1);
		}else{
			return $arr;
		}
	}
	
	//查询自定义菜单
	public function get_menu($appid,$appsecret){
		$arr = $this->get_access_token($appid,$appsecret);
		if($arr['access_token']){
			$ACCESS_TOKEN=$arr['access_token'];
			$url="https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".$ACCESS_TOKEN;
			$arr = json_decode(file_get_contents($url),1);
			return $arr;
		}else{
			return $arr;
		}
	}
	
	
	function menu_update(){
		$this->top();
		$user = $this->session->userdata('user');
		$uid = $user[0]->m_id;
		$menus = $this->tickets->select('menu_settings',array('tms_main_id'=>'0'));
		foreach($menus as $k=>$v){
			$data['button'][$k]['name']=urlencode($v->tms_main_menu);
			if($v->tms_main_type=='click'){
				$data['button'][$k]['type']='click';
				$data['button'][$k]['key']=urlencode($v->tms_main_key);
	
			}
				
			if($v->tms_main_type=='view'){
				$data['button'][$k]['type']='view';
				$data['button'][$k]['url']=urlencode($v->tms_main_url);
			}
				
			$list[$k]['son']=$this->tickets->select('menu_settings',array('tms_main_id'=>$v->tms_id,'tms_uid'=>$uid));
				
			foreach($list[$k]['son'] as $key=>$value){
				$data['button'][$k]['sub_button'][$key]['name']=urlencode($value->tms_sub_menu);
				if($value->tms_sub_type=='click'){
					$data['button'][$k]['sub_button'][$key]['type']='click';
					$data['button'][$k]['sub_button'][$key]['key']=urlencode($value->tms_sub_key);
				}
				if($value->tms_sub_type=='view'){
					$data['button'][$k]['sub_button'][$key]['type']='view';
					$data['button'][$k]['sub_button'][$key]['url']=urlencode($value->tms_sub_url);
				}
			}
		}
		 
		$wei_config = $this->tickets->select('system_message',array('m_id'=>$uid,'type'=>'weichat_config'));
		$weiconfig = $wei_config[0];
	 
		$appid = trim($weiconfig->field3);
		$appsecret = trim($weiconfig->field4);
		 
		$re = $this->del_menu($appid,$appsecret); 
		if($re){ 
			$return=$this->create_menu($appid,$appsecret,urldecode(json_encode($data)));
				
	
			if ($return['errmsg']=='ok'){
				$re = json_encode(array('success'=>'yes','msg'=>'Success'));
			}else{
				$re = json_encode(array('success'=>'no','msg'=>$return['errmsg']));
			}
			echo $re;
			exit;
		}
	}
	
	//删除自定义菜单
	public function del_menu($appid,$appsecret,$url= "api.weixin.qq.com"){
		$arr = $this->get_access_token($appid,$appsecret);
		if($arr['access_token']){
			$ACCESS_TOKEN=$arr['access_token'];
			$url="https://".$url."/cgi-bin/menu/delete?access_token=".$ACCESS_TOKEN;
			$arr = json_decode(file_get_contents($url),1);
			return $arr;
		}else{
			return $arr;
		}
	}
	
	
	
	
	function menu_settings_delete(){
		$id = $this->uri->segment(3);
		$this->tickets->delete('menu_settings',array('tms_main_id'=>$id));
		$this->tickets->delete('menu_settings',array('tms_id'=>$id));
		redirect('admin/menu_settings_index');
	}
	
	
	function sub_menu_settings_add(){
		$this->top();
		if ($_POST) {
			$id = intval($_POST['me_id']);
			$p_id = intval($_POST['main_id']);
			$user = $this->session->userdata('user');
			$uid = $user[0]->m_id;
				
			$da = array(
					'tms_main_menu'=>trim($_POST['main_menu']),
					'tms_main_key'=>trim($_POST['main_key']),
					'tms_sub_menu'=>trim($_POST['sub_menu']),
					'tms_sub_key'=>trim($_POST['sub_key']),
					'tms_sub_url'=>trim($_POST['sub_url']),
					'tms_sub_type'=>trim($_POST['sub_type']),
					'tms_main_id'=>$p_id,
					'tms_uid'=>$uid
			);
			if ($id){
				$re = $this->tickets->update('menu_settings',$da,array('tms_id'=>$id));
			}else{
				$re = $this->tickets->insert('menu_settings',$da);
			}
			$re = array('success'=>'yes');
			echo json_encode($re);exit;
		}else{
			$p_id = $this->uri->segment(3);
			$data = array();
			if ($p_id){
				$menu_settings = $this->tickets->select('menu_settings',array('tms_id'=>$p_id));
				$menu_settings = $menu_settings[0];
					
				if ($menu_settings->tms_main_id=='0'){
					$data['main_id'] = $menu_settings->tms_id;
					$data['me_id'] = 0;
					$data['main_menu_settings'] = $menu_settings;
				}else{
					$main_menu_settings = $this->tickets->select('menu_settings',array('tms_id'=>$menu_settings->tms_main_id));
					$data['main_id'] = $menu_settings->tms_main_id;
					$data['me_id'] = $menu_settings->tms_id;
					$data['main_menu_settings'] = $main_menu_settings[0];
				}
				$data['menu_settings'] = $menu_settings;
			}
			$this->load->view('admin/sub_menu_settings_add',$data);
		}
	}
	
	
	function menu_settings_add(){
		$this->top();
		$id = $this->uri->segment(3);
		if ($_POST){
			$user = $this->session->userdata('user');
			$uid = $user[0]->m_id;
			$main_id = intval($_POST['main_id']);
				
			$da = array(
					'tms_main_menu'=>trim($_POST['main_menu']),
					'tms_main_type'=>trim($_POST['main_type']),
					'tms_main_url'=>trim($_POST['main_url']),
					'tms_main_key'=>trim($_POST['main_key']),
					'tms_uid'=>$uid
			);
			 
			if ($main_id){
				$re = $this->tickets->update('menu_settings',$da,array('tms_id'=>$main_id));
			}else{
				$re = $this->tickets->insert('menu_settings',$da);
			}
			$re = array('success'=>'yes');
			echo json_encode($re);exit;
		}else{
			$data = array();
			if ($id){
				$menu_settings = $this->tickets->select('menu_settings',array('tms_id'=>$id));
				$menu_settings = $menu_settings[0];
				$data['menu_settings'] = $menu_settings;
			}
			$this->load->view('admin/menu_settings_add',$data);
		}
	}
	
	
	
	function menu_settings_index(){
		$this->top();
		$user = $this->session->userdata('user');
		$uid = $user[0]->m_id;
		$data['menu_settings'] = $this->tickets->select('menu_settings');
	
		$this->load->view('admin/menu_settings_index',$data);
	}
	
	
	
	
	
	
	function index(){
		$this->top();
		$user = $this->session->userdata('user');
	
		if($user!=""){
			$data['user'] = $user[0];
		}
		 
		$this->load->view('admin/main',$data);
	}
	
	
	function login(){
		if ($_POST){
			$username = trim($_POST['username']);
			$password = trim($_POST['password']); 
			$re = $this->tickets->login('members',array('username'=>$username,'password'=>md5($password)));
			if ($re){
	            $oauth_temp = $this->tickets->select('admin_authority',array('id'=>$re[0]->role_id));
	            $oauth = explode(',',$oauth_temp[0]->authority);
	            $re[0]->oauth = $oauth;
				$this->session->set_userdata('user',$re);
				$r = array('success'=>'yes');
	
			}else{
				$r = array('success'=>'no');
			}
			$user = $this->session->userdata('user');
			 
			echo json_encode($r);exit;
	
		}else{
			$this->load->view('admin/login');
		}
	}
	
	
	function logout(){
		$user = $this->session->userdata('user');
		if($user==""){
			//直接跳转到登录页面
			redirect('admin/login');exit;
		}else{
			$this->session->sess_destroy();
			redirect('admin/index');exit;
		}
	}
	
	 
	
	function top(){
		$user = $this->session->userdata('user');
		if($user==""){
			//直接跳转到登录页面
			redirect('admin/login');exit;
		}
	}
	 
}	