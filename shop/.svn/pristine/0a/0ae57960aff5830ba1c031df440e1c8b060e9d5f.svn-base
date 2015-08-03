<?php
class tickets extends Model {

	function xml_to_array($xml){
		$reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
		if(preg_match_all($reg, $xml, $matches)){
			$count = count($matches[0]);
			for($i = 0; $i < $count; $i++){
				$subxml= $matches[2][$i];
				$key = $matches[1][$i];
				if(preg_match( $reg, $subxml )){
					$arr[$key] = xml_to_array( $subxml );
				}else{
					$arr[$key] = $subxml;
				}
			}
		}
		return $arr;
	}
	
	
	function translate_begin(){
		$this->db->trans_begin();
	}
	
	function translate_commit(){
		$this->db->trans_commit();
	}
	
	function translate_rollback(){
		$this->db->trans_rollback();
	} 
	
	 
	
	
	function refund_order($order,$coupon_record_id){
		$uid = $order->to_uid;
		$wallet_check = $this->select('wallet',array('tw_uid'=>$uid));
		$order_amount = $order->to_wallet_amount+$order->to_total_amount;
		
		$this->db->trans_begin();
		
		if ($coupon_record_id){
			$this->db->query("update t_coupons_record set tcr_status=0 where tcr_id=".$coupon_record_id);
		}
		if ($wallet_check) {
			$wallet_check = $wallet_check[0];
			$valid_balance = $wallet_check->tw_valid_balance;
			$balance = $valid_balance+$order_amount;
			$this->db->query("update t_wallet set tw_valid_balance=".$balance." where tw_uid=".$uid);
		}else{
			$this->db->query("insert into t_wallet (tw_uid,tw_valid_balance) values(".$uid.",".$order_amount.")"); 
		}
		
		    $this->db->query("insert into t_wallet_history(twh_uid,twh_mobile,twh_type,twh_event_id,twh_schedule_id,twh_amount,twh_sn,twh_created)values(
		    		".$uid.",'".$order->to_mobile."',4,".$order->to_event_id.",".$order->to_schedule_id.",".$order_amount.",'".$order->to_order_sn."','".date('Y-m-d H:i:s')."')");
		if ($this->db->trans_status() === TRUE)
		{
			$this->db->trans_commit();
			return true;
		
		}
		else
		{
			$this->db->trans_rollback();
			exit;
		}
		
	}
	
	
	function update_wallet_cash_status($history){
		$this->db->trans_begin();
		$uid = $history->twh_uid;
		
		$wallet_check = $this->select('wallet',array('tw_uid'=>$uid));
		$twh_amount = $history->twh_amount;
		//如果有记录，则更新，否则新增
		 
		$freeze_count = $wallet_check[0]->tw_freeze;
		if($history->twh_type == 2){
			$this->db->query('update t_wallet_history set twh_status = 1 where twh_id='.$history->twh_id); 
			$freeze_count = $freeze_count-$twh_amount;
		}  
		$this->db->query('update t_wallet set tw_freeze='.$freeze_count.' where tw_uid ='.$uid);
		
		if ($this->db->trans_status() === TRUE)
		{
			$this->db->trans_commit();
			return true;
				
		}
		else
		{
			$this->db->trans_rollback();
			exit;
		}
	}
	
	
	
	function app_update_order_status($order){
		$this->db->trans_begin();
 
		//$re = $this->tickets->update('orders',array('to_status'=>PAYED_SUCCESS),array('to_order_sn'=>$order[0]->to_order_sn));
	    $this->db->query("update t_orders set to_status = 20 where to_order_sn = '".$order->to_order_sn."'");
		$cond = array('tw_uid'=>$order->to_uid);
		//如果使用了钱包支付，则更新钱包
		$wallet_amount = $order->to_wallet_amount;
		$wallet = $this->select('wallet',$cond);

		if ($wallet_amount){
				
			$freeze_account= $wallet[0]->tw_freeze-$wallet_amount;
			$this->db->query("update t_wallet set tw_freeze = ".$freeze_account." where tw_uid = '".$order->to_uid."'");
			
			//$this->tickets->update('wallet',array('tw_freeze'=>$freeze_account),$cond);
			$this->db->query("update t_wallet_history set twh_status = 1 where twh_sn = '".$order->to_order_sn."'");
			//$this->tickets->update('wallet_history',array('twh_status'=>1),array('twh_sn'=>$r->to_order_sn));
		}
		
		if($order->to_tm_id != 'first_pay'){
			//如果是本地库存，则处理本地库存
			$stock = $this->select('tickets',array('tt_schedule_id'=>$order->to_schedule_id,'tt_price'=>$order->to_perprice));
			if ($stock){
				$s = $stock[0]->tt_stock;
				$s = $s-1;
				$this->db->query("update t_tickets set tt_stock = ".$s." where tt_schedule_id = '".$order->to_schedule_id."' and tt_price='".$order->to_perprice."'");
				//$this->tickets->update('tickets',array('tt_stock'=>--$s),array('tt_schedule_id'=>$r->to_schedule_id,'tt_price'=>$r->to_perprice));
			}
		}
		
			
		if ($this->db->trans_status() === TRUE)
		{
			$this->db->trans_commit();
			return true;
				
		}
		else
		{
			$this->db->trans_rollback();
			exit;
		}
	}
	
	
	
	
	function update_wallet_status($history){ 
		$this->db->trans_begin();
		$uid = $history->twh_uid;
		
		$wallet_check = $this->select('wallet',array('tw_uid'=>$uid)); 
		$twh_amount = $history->twh_amount;
//如果有记录，则更新，否则新增		
		if($wallet_check){
			$already_count = $wallet_check[0]->tw_valid_balance;
			$freeze_count = $wallet_check[0]->tw_freeze;
			if($history->twh_type == 2){
				$valid_balance = $already_count-$twh_amount;
				$freeze_count = $freeze_count+$twh_amount;
			}else{
				$this->db->query('update t_wallet_history set twh_status = 1 where twh_id='.$history->twh_id);
			   $valid_balance = $already_count+$twh_amount;
			}
			$this->db->query('update t_wallet set tw_valid_balance = '.$valid_balance.' ,tw_freeze='.$freeze_count.' where tw_uid ='.$uid); 
		}else{
			$this->db->query("insert into t_wallet(tw_uid,tw_valid_balance,tw_updated) values ('".$uid."','".$twh_amount."','".date('Y-m-d H:i:s')."')");  
		}
		if ($this->db->trans_status() === TRUE)
		{
			$this->db->trans_commit();
			return true;
			
		}
		else
		{
			$this->db->trans_rollback();
			exit;
		}
	}
	 
	
	
/**
 * SMS phone
 */
	function send_sms($phone,$content,$user='cf_xcwl',$pwd='hsG2u4'){
		
		$url="http://106.ihuyi.com/webservice/sms.php?method=Submit&account=".$user."&password=".$pwd."&mobile=".$phone."&content=".rawurlencode($content);
		 
		$result = file_get_contents($url);
		$array = json_decode(json_encode(simplexml_load_string($result)),TRUE);
		 
		return $array;
	} 
	
	
	function select_count_where($table,$cond){
		$this->db->where($cond);
		$query = $this->db->from($table);
		$result= $query->count_all_results();  
		return $result;
	}
	
	function personal_select($sql){
		$query = $this->db->query($sql);
		$result= $query->result();
		return $result;
	}
	
	
	function select_sum_avg($table,$cond,$field,$type='avg'){
		if ($type == "sum"){
			$this->db->select_sum($field);
		}else{
		   $this->db->select_avg($field);
		}
		$this->db->where($cond);
		$query = $this->db->get($table);
		$result= $query->result();
		return $result;
	}
	 
	
    function insert($table,$data){
       $result = $this->db->insert($table,$data);
       $id = $this->db->insert_id();
      // echo $this->db->last_query()."<br/>";
       return $id;
    }
     
	function login($table,$array){
		$this->db->where($array);
		$query = $this->db->get($table);
		$result= $query->result();
		return $result;
	}
    
	 

	function select_member($table,$cond="",$num="",$offset="",$like='',$not_like='',$order=''){
		if($num){
			$this->db->limit($num,$offset);
		}
		if ($cond){
			$this->db->where($cond);
		}
		if (!empty($like)){
			$this->db->like($like);
		}
		if (!empty($not_like)){
			$this->db->or_like($not_like);
		}
		
		if($order){
			foreach($order as $key=>$val){
				$this->db->order_by($key,$val);
			}
		}
		 
		$query = $this->db->get($table);
		$result = $query->result();
		 // echo $this->db->last_query()."<br/>";
		return $result;
	}
	
	
    function select($table,$cond="",$num="",$offset="",$like='',$order='',$where_in='',$or_where=''){
       if($num){
          $this->db->limit($num,$offset);	   
       }    
       if ($cond){
          $this->db->where($cond);     
       }
       
       if ($or_where){
       	  $this->db->or_where($or_where);
       }
       
       if($where_in){
       	  foreach($where_in as $key=>$v){
             $this->db->where_in($key,$v);	
         }
       }
       
       if (!empty($like)){
       	  $this->db->like($like);
       }
       if($order){
       	  foreach($order as $key=>$val){
       	     $this->db->order_by($key,$val);
       	  }
       }
       
       $query = $this->db->get($table);
       $result = $query->result();  
     //  echo $this->db->last_query()."<br/>";
    
       return $result;
    }
    
    
    function api_select($table,$fields="*",$cond="",$num="",$offset="",$like='',$order=''){
    	
    	$this->db->select($fields);
    	
    	if($num){
    		$this->db->limit($num,$offset);
    	}
    	if ($cond){
    		$this->db->where($cond);
    	}
    	if (!empty($like)){
    		$this->db->like($like);
    	}
    	if($table == "materials"){
    		$order = array('tm_createtime'=>'desc');
    	}
    	
    	if($order){
    		foreach($order as $key=>$val){
    			$this->db->order_by($key,$val);
    		}
    	}
    	 
    	$query = $this->db->get($table);
    	$result = $query->result();
    	//echo $this->db->last_query()."<br/>";
    	return $result;
    }
    
    
    function update($table,$data,$cond){
       $result = $this->db->update($table,$data,$cond);
    //   echo $this->db->last_query()."<br/>";
        
       return $result;
    }
    
    function delete($table,$cond){
       $result = $this->db->delete($table,$cond);
       return $result;
    }
}
?>