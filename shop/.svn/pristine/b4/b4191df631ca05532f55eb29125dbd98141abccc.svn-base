<?php $this->load->view('main/new_header');?>
<div class="main_member_aside">
  <!-- member_menu -->
    <?php echo $this->load->view('member/member_left');?>
  <!-- member_menu_end --> 
 
  <div class="main_member_score main_member_right">
       
       
  <!-- order_info -->
     <div  class="order_info_eric member_base_info_eric">
     	<div class="main_member_title">
           <span></span>
          <h4>积分</h4>
        </div>
     
     <table class="order_list_table_eric member_base_order_list_eric">
        <tr class="list_title_eric"><td>积分日期</td><td>积分额</td><td>积分状态</td><td>对应订单编号</td><td>积分明细</td></tr>
       <?php if($score_data){
              foreach($score_data as $k=>$v){ ?>
          <tr class="normal_tr_eric"><td><?php echo date('Y/m/d',strtotime($v->created));?></td><td><?php echo $v->score;?></td><td><?php if(!$v->status){echo '有效';}else{ echo '无效';}?></td><td><?php echo $v->order_sn;?></td>
          <td><?php echo $v->score_detail;?></td></tr>    
        <?php } }else{?>
       	  <tr><td colspan="5">您暂时没有任何积分记录</td></tr>
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