<?php $this->load->view('main/new_header');?>
<div class="main_member_aside">
  <!-- member_menu -->
    <?php echo $this->load->view('member/member_left');?>
  <!-- member_menu_end --> 
 
  <div class="main_member_coupons main_member_right">
       
       
  <!-- order_info -->
     <div  class="order_info_eric member_base_info_eric">
     	<div class="main_member_title">
           <span></span>
          <h4>优惠券</h4>
        </div>
     
     <table class="order_list_table_eric member_base_order_list_eric">
        <tr class="list_title_eric"><td>优惠券名称</td><td>面值</td><td>发放时间</td><td>截止时间</td><td>最低消费金额</td><td>张数</td><td>状态</td></tr>
       <?php if($valid_coupons){
              foreach($valid_coupons as $k=>$v){ ?>
          <tr class="normal_tr_eric"><td><?php echo $coupon_lang[$v->tc_title];?></td><td><?php echo $v->tc_price;?></td><td><?php echo $v->tcr_created;?></td><td><?php echo $v->tc_end_time;?></td>
          <td><?php if($v->tc_sale_price){echo $v->tc_sale_price;}else{echo '无';}?></td><td>1</td><td><?php echo $v->tc_status;?></td></tr>    
        <?php } }else{?>
       	  <tr><td colspan="6">您暂时没有任何优惠券</td></tr>
      <?php }?> 
    </table>
     </div>
   
  <!-- order_info --> 
     
</div>
 </div>   

</div>
<div class="clear"></div>
 <?php $this->load->view('main/new_footer');?>
</body>
</html> 