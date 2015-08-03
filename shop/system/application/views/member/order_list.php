<?php $this->load->view('main/new_header');?>
<div class="main_member_aside">
  <!-- member_menu -->
    <?php echo $this->load->view('member/member_left');?>
  <!-- member_menu_end --> 
 
  <div class="main_member_order_list main_member_right">
     
  <!-- order_info -->
     	<div class="main_member_title">
             <span></span><h4>我的订单</h4>
      </div>
          <!--  img src="/images/search.png" class="order_search_button float_right"/>
             <input type="text" name="search_keywords" placeholder="商品名称，商品编号，订单编号" class="search_keywords float_right"/ -->              
          
  <?php if($orders){
  			foreach($orders as $key=>$val){
  	?> 
    <div class="main_member_content">     
      <div class="main_member_order_list_title">
          <ul>
             <li><?php echo $val->to_created;?></li>
             <li>
			 <span>
			 订单编号：<?php echo $val->to_order_sn;?>
			 </span>
			     <span class="main_member_order_list_address receiver_address_eric">
             <?php ?><?php $current_time=date('H:i:s');$current_date = strtotime(date('Y-m-d')); if(($val->to_status == 10)&&($val->to_pay_way != 'daofu')&&(($val->first_server_date > $current_date)||(($val->first_server_date == $current_date)&&($current_time < $order_time->tc_title)))){?>
                 <!-- <button class="extra_span_eric pay_now_eric" data_sn="<?php echo $val->to_order_sn;?>" data_pay_way="<?php echo $val->to_pay_way;?>">去付款</button>-->
           <?php }?>  
         </span>
                 <div class="change_pay_div" style="display: none;">
                     支付宝：<input type="radio" name="pay_way<?php echo $val->to_order_sn;?>" id="alipay_order" value="alipay" data_pay_way="alipay"><br/>
                     微  信：<input type="radio" name="pay_way<?php echo $val->to_order_sn;?>" id="wechat_order" value="wechat" data_pay_way="wechat" ><br/>
                     <button class="pay_now" data_sn="<?php echo $val->to_order_sn;?>" data_pay_way="<?php echo $val->to_pay_way;?>">去支付</button>
                 </div>
                 
			 </li>
			   
          </ul> 
          <ol>
          
			<li><img src="/images/jiage.png" class="pay_now_eric" data_sn="<?php echo $val->to_order_sn;?>" data_pay_way="<?php echo $val->to_pay_way;?>"></li>
            <li><img src="/images/xiangqing.png"></li>
            <li><img src="/images/wx_delete_h.png" class="close_order" data_id=<?php echo $val->to_id;?>></li>
          </ol>
      </div>  
     <table class="order_list_table_eric member_base_order_list_eric" cellpadding="0" cellspacing="0">
      <thead>
       <tr class="list_title_eric">
         <td>用餐日期</td>
         <td>菜品</td>
         <td>单价(元)</td>
         <td>份数</td>
         <td>合计</td>
       </tr>
      </thead> 
       <?php $temp_count = count($val->order_detail);foreach($val->order_detail as $k=>$v){
       		 
       	?>
       <tr>
         <td><?php echo $v->service_date;?></td>
         <td><?php for($i=0;$i<5;$i++){$title = 'title'.$i;if($v->$title){ if($i){echo '+';}echo $v->$title;}}?></td>
         <td><?php echo $v->now_price;?></td>
         <td><?php if($val->event){echo $v->count;}else{echo $v->count;}?></td><?php }?>
         <td><?php if($val->coupon_amount){

           	echo '优惠券:'.$val->coupon_amount.'元';
           }
           if ($val->to_order_amount){
               if ($val->to_pay_way == 'alipay'){
               	echo '&nbsp;&nbsp;支付宝:&nbsp;';
               }else if($val->to_pay_way == 'wechat'){
               	echo '&nbsp;&nbsp;微信支付:&nbsp;';
               }else if($val->to_pay_way == 'daofu'){
               	echo '&nbsp;&nbsp;货到付款:&nbsp;';
               }
               echo $val->to_order_amount.'元';      	
           }
           ?>   
         </td>
       </tr>
    </table>
    <div class="order_shipping_info_eric">
        <ul class="receiver_info_eric">
          <li><h5>收货人:</h5><?php echo $val->to_receiver;?></li>
          <li><h5>电话:</h5><?php echo $val->to_mobile;?></li>
          <li><h5>订单来源:</h5><?php if ($val->to_order_type){echo '微信订单';}else{ echo '网站订单';}?></li>
          <li><h5>订单状态:</h5><?php echo $order_status[$val->to_status];?></li>
		  
          <li><h5>地址:</h5>地址:<?php echo $val->to_address;?></li>
        </ul>
    
         
     </div> 
   </div>  
   <?php 
     }
}?> 
  </div>
  
  <!-- order_info --> 
     
</div>
    
</div>
</div>
<div class="clear"></div>
 <?php $this->load->view('main/new_footer');?>
</body>
</html> 