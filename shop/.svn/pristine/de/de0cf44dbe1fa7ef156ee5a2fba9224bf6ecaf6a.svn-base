<?php $this->load->view('wechat/common_header');?>
 
  <div class="member_base_infos ">
       
       
  <!-- order_info -->
     <div  class="order_info member_base_info">
     	<div class="base_title">
          <div class="config_title ">
            有效优惠券
          </div>
        </div>
  <?php if($valid_coupons){?>    
      <ul class="wechat_coupon_ul">
       <?php foreach($valid_coupons as $k=>$v){?> 
         <li>
            <div class="wechat_coupon_div">
               <div class="wechat_detail_first_div ">优惠券名称：<?php echo $coupon_lang[$v->tc_title];?></div>
               <div class="wechat_detail_div ">面值(元)：<?php echo $v->tc_price;?></div>
               <div class="wechat_detail_div ">张数：1</div>
            </div>
            <div class="wechat_coupon_div">
	            <div class="wechat_detail_first_div ">发放时间：<?php echo date('Y/m/d',strtotime($v->tcr_created));?></div>
	            <div class="wechat_detail_first_div ">有效期：<?php echo date('Y/m/d',strtotime($v->tc_end_time));?></div> 
            
            </div>
            <div class="wechat_coupon_div">
           		<div class="wechat_detail_first_div ">最低消费金额(元)：<?php if($v->tc_sale_price){echo $v->tc_sale_price;}else{echo '无';}?></div>
	            <div class="wechat_detail_first_div ">状态：<?php echo $v->tc_status;?></div> 
            
            </div>         
         </li>
      <?php }?> 
      </ul> 
   <?php }?> 
     </div>
   
  <!-- order_info --> 
     
</div>
    

</div> 
<div class="wechat_member_coupons">
  <div class="wechat_member_coupons_wrapper">
     <div class="wechat_member_coupons_title">
        <img src="/images/icon_yhq.png" />
        <img class="iconfont-fanhui1" width="10px" height="10px" alt="返回" src="/images/iconfont-fanhui1.png">
        <h3>优惠券</h3>
     </div>
	   <?php if($valid_coupons){?>   
     <ul class="wechat_member_coupons_list">
	 <?php foreach($valid_coupons as $k=>$v){?> 
       <li>
         <span class="wechat_member_coupons_left"></span>
          <dl>
            <dt>
              ¥<span><?php echo $v->tc_price;?></span>元
            </dt>
            <dd>
              <h3><?php echo $coupon_lang[$v->tc_title];?></h3>
              <span>最低消费金额:</span><?php if($v->tc_sale_price){echo $v->tc_sale_price;}else{echo '无';}?><br/>
              <span>截止日期:</span><?php echo date('Y/m/d',strtotime($v->tc_end_time));?>
            </dd>
          </dl>
          <span class="wechat_member_coupons_right"></span>
       </li>
	 <?php }?> 
     </ul>
	 <?php }?> 
  </div>
</div>




</body>
</html> 