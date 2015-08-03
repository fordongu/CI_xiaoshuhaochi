<?php $this->load->view('wechat/common_header');?>
 
  <div class="member_base_infos float_left">
       
       
  <!-- order_info -->
     <div  class="order_info member_base_info" style="width:100% !important;padding-left:0 !important;">
     	<div class="base_title">
          <div class="config_title float_left">
            可用积分：<?php  echo $coupon_count;?>
          </div>
          <div class="member_normal_line float_left"> 
             
          </div>
        </div>
        
  <?php if($score_data){?>    
      <ul class="wechat_coupon_ul">
       <?php foreach($score_data as $k=>$v){?> 
         <li>
            <div class="wechat_coupon_div">
               <div class="wechat_detail_first_div float_left">积分日期：<?php echo date('Y/m/d',strtotime($v->created));?></div>
               <div class="wechat_detail_div float_left">积分值：<?php echo $v->score;?></div>
               <div class="wechat_detail_div float_left">积分状态：<?php if($v->status){echo '无效';}else{echo '有效';}?></div>
            </div>
            <div class="wechat_coupon_div">
	            <div class="wechat_detail_first_div float_left">对应订单编号：<?php echo $v->order_sn;?></div>
	            <div class="wechat_detail_first_div float_left">积分明细：<?php echo $v->score_detail;?></div> 
            
            </div>       
         </li>
      <?php }?> 
      </ul> 
   <?php }?> 
     </div>
   
  <!-- order_info --> 
     
</div>
    

</div> 
</body>
</html> 