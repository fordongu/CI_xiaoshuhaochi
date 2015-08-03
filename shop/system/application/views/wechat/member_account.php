<?php $this->load->view('wechat/common_header');?>
 <script>
 $(function(){
   $('.wechat_member_account_section input:eq(0)').click(function(){
    $('.wechat_member_account_section input').attr('class','');
    $(this).attr('class','wechat_member_account_active');
      $('.wechat_member_account_list').show();
      $('.wechat_member_sore_list').hide();
     });

     $('.wechat_member_account_section input:eq(1)').click(function(){
      $('.wechat_member_account_section input').attr('class','');
      $(this).attr('class','wechat_member_account_active');
      $('.wechat_member_sore_list').show();
       $('.wechat_member_account_list').hide();
     });
 });
 </script>
  <div class="member_base_infos float_left">
       
       
  <!-- order_info -->
     <div  class="order_info member_base_info" style="width:100% !important;padding-left:0 !important;">
     	<div class="base_title">
          <div class="config_title float_left">
            账户余额：<?php if($wallet){?>(<?php echo $wallet[0]->tw_valid_balance.'元';?>)<?php }?>
          </div>
          <div class="member_normal_line float_left"> 
             
          </div>
        </div>
        
  <?php if($wallet_data){?>    
      <ul class="wechat_coupon_ul">
       <?php foreach($wallet_data as $k=>$v){?> 
         <li>
            <div class="wechat_coupon_div">
               <div class="wechat_detail_first_div float_left">入账日期：<?php echo date('Y/m/d',strtotime($v->in_time));?></div>
               <div class="wechat_detail_div float_left">入账金额：<?php echo $v->amount.'元';?></div>
               <div class="wechat_detail_div float_left">入账原因：<?php echo $v->reason;?></div>
            </div>
            <div class="wechat_coupon_div">
	            <div class="wechat_detail_first_div float_left">对应订单编号：<?php echo $v->order_sn;?></div>
	            <div class="wechat_detail_first_div float_left">操作时间：<?php echo date('Y/m/d',strtotime($v->oper_time));?></div> 
            
            </div>
            <div class="wechat_coupon_div">
           		<div class="wechat_detail_first_div float_left">操作内容：<?php echo $v->comment;?></div>        
            </div>         
         </li>
      <?php }?> 
      </ul> 
   <?php }?> 
     </div>
   
  <!-- order_info --> 
     
</div>
    

</div> 
<div class="wechat_member_account">
   <div class="wechat_member_account_wrapper">
      <div class="wechat_member_account_title">
         <img src="/images/icon_zhanghu.png">
         <img class="iconfont-fanhui1" width="10px" height="10px" alt="返回" src="/images/iconfont-fanhui1.png">
         <h3>我的账户</h3>
      </div>
    <!--  <div class="wechat_member_account_section">
           <input class="wechat_member_account_active" type="button" value="账户余额">
           <input type="button" value="积分">
         </div>-->
      <div class="wechat_member_account_list">
        <!--
		<div class="wechat_member_list_title">
           <span>账户余额</span><span><?php if($wallet){?>(<?php echo $wallet[0]->tw_valid_balance;?>)<?php }?></span>元
        </div>
        -->
		<table>
           <thead>
               <tr>
                 <td>日期</td>
                 <td>收入/支出</td>
                 <td>说明</td>
               </tr>
           </thead>
           <?php if($wallet_data){?>    
		   <tbody>
                  <?php foreach($wallet_data as $k=>$v){?> 
            
               <tr>
                  <td><?php echo date('Y/m/d H:i:s',strtotime($v->in_time));?></td>
                  <td><?php echo $v->amount.'元';?></td>
                  <td><?php echo $v->comment;?><br/>(订单编号:<br/><?php echo $v->order_sn;?>)</td>
               </tr>
		    <?php }?>
           </tbody>
		   <?php }?>
        </table>
      </div>
      <!--
	  <div class="wechat_member_sore_list">
         <div class="wechat_member_list_title">
           积分:<span>120</span>
        </div>
        <table>
           <thead>
               <tr>
                 <td>日期</td>
                 <td>收入/支出</td>
                 <td>说明</td>
               </tr>
           </thead>
           <tbody>
               <tr>
                  <td>2015/3／5<br/>14:32:30</td>
                  <td>+ 200</td>
                  <td>新用户注册</td>
               </tr>
               <tr>
                  <td>2015/3／5<br/>14:32:30</td>
                  <td>+ 20</td>
                  <td>取消订单<br/>(订单编号:<br/>20150330122434334)</td>
               </tr>
               <tr>
                  <td>2015/3／5<br/>14:32:30</td>
                  <td>+ 20</td>
                  <td>取消订单<br/>(订单编号:<br/>20150330122434334)</td>
               </tr>
           </tbody>
        </table>
      </div>-->
   </div>
</div>




</body>
</html> 