<?php $this->load->view('main/new_header');?>
<div class="main_member_aside">
  <!-- member_menu -->
    <?php echo $this->load->view('member/member_left');?>
  <!-- member_menu_end --> 
 
  <div class="main_member_account main_member_right">
       
       
  <!-- order_info -->
     <div  class="order_info_eric member_base_info_eric">
        <div class="main_member_title">
           <span></span>
          <h4>账户余额</h4><?php if($wallet){?>(<?php echo $wallet[0]->tw_valid_balance.'元';?>)<?php }?>
        </div>
     
     <table class="order_list_table_eric member_base_order_list_eric">
        <tr class="list_title_eric"><td>入账日期</td><td>金额</td><td>入账原因</td><td>对应订单编号</td><td>操作人</td><td>操作时间</td><td>操作内容</td><td>备注</td></tr>
       <?php if($wallet_data){
              foreach($wallet_data as $k=>$v){ ?>
          <tr class="normal_tr_eric"><td><?php echo date('Y/m/d',strtotime($v->in_time));?></td><td><?php echo $v->amount;?></td><td><?php echo $v->reason;?></td><td><?php echo $v->order_sn;?></td><td><?php echo $v->oper_username;?></td>
          <td><?php echo $v->oper_time;?></td><td><?php echo $v->oper_content;?></td><td><?php echo $v->comment;?></td></tr>    
        <?php } }else{?>
       	  <tr><td colspan="8">您暂时没有任何账户记录</td></tr>
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