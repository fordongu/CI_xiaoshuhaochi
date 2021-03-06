<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
	<meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport"> 
	<meta content="yes" name="apple-mobile-web-app-capable">
	<meta content="black" name="apple-mobile-web-app-status-bar-style">
	<meta content="telephone=no" name="format-detection">
	<title>Green&Yummy</title>  
	<link href="/css/wechat.css" rel="stylesheet"> 
	<link href="/css/wechat_new.css" rel="stylesheet">  
    <script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script> 
    <script type="text/javascript" src="/js/shop_common.js"></script>
    <script>
     $(document).ready(function(){

 	    $('.three_payment_ul').children('li').children('div').click(function(){
 	 	    
 	 		var comment_input = $('#comment_input').val();
 	 		var payway = $(this).attr('data_id'); 
 	 		var coupons_id = $('#coupons_id_used').val();
 	 		var submitdata = {
 	 				comment_input:comment_input,
 	 				payway:payway,
 	 				coupons_id:coupons_id
 	 		 		};
 	 		
 			$.post('/wechat/save_order',submitdata,function(data) { 
 				if (data.success == 'yes') {
 					 if(data.price == 0){
 						 window.location.href="/wechat/member_order";
 				     }else{
 						 if(data.pay_config == 'alipay'){
 						    window.location.href="/wechat/pay_order/"+data.order_sn;
 						 }else if(data.pay_config =='daofu'){
 						    window.location.href="/wechat/member_order";
 						 }else if(data.pay_config == 'wechat'){
 							 window.location.href="/index.php?c=wechat&m=wechat_pay&order_sn="+data.order_sn;
 					     }
 				     }
 				}else{
 					alert(data.msg);
 				}
 			},"json"); 	
  	   })
     })

    </script>
</head>
<body id="confirm_step_one_body"> 
   <!--<div class="confirm_step_three_header">支付</div>-->
   
   <div class="confirm_step_one_title">
     <div class="float_left shipping_address_note" style="margin-left:20px">支付</div>
   </div>
   
   <div class="confirm_step_three_content">
  <!-- 金额 --> 
      <div class="confirm_step_three_amount">
         <input type="hidden" id="hidden_order_amount" value="<?php echo $total_count;?>" />
         订单金额：￥<span id="order_total_ampount"><?php echo $total_count;?></span>
      </div>
      <input type="hidden" id="coupons_id_used" value="0" /> 
       <?php if($coupons){?>  
  <!-- 金额_end-->    
      <div class="confirm_step_three_coupon_title"><img src='/images/confirm_selected_ring.png' class="coupon_ring"/>使用优惠券抵扣</div> 
   
      <ul class="three_coupon three_coupon_ul">
        <?php foreach($coupons as $k=>$v){?>
	         <li><div class="three_coupon_normal" data_id="<?php echo $v->tcr_id;?>" data_price="<?php echo $v->tc_price;?>"><?php echo $coupon_lang[$v->tc_title];?>  <?php echo $v->tc_price;?></div></li> 
        <?php }?> 
      </ul>
    <?php }?>  
    
       <div class="three_comment"><input type="text" name="comment" id="comment_input" class="three_step_comment" placeholder='备注'/></div>
     <?php if($payment){?>  
       <ul class="three_coupon three_payment_ul">
         <?php foreach($payment as $k=>$v){?> 
         	<li><div class="three_coupon_normal" data_id="<?php echo $v->name;?>"><?php echo $payment_lang[$v->name];?></div></li>
         <?php }?> 
      </ul>
     <?php }?>  
   </div>   
</body>
</html>
