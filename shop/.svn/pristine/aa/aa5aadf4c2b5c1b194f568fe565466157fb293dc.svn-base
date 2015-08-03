<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">

	<meta name="description" content="">	
	<meta property="qc:admins" content="24500242000645756441711056375" />
	<title>Green&Yummy</title>  
	<link href="/css/wechat.css" rel="stylesheet"> 
	<script>
	  var controller = '<?php echo $this->router->class; ?>';
	</script>
	<script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script> 
   <script type="text/javascript" src="/js/shop_common.js"></script>
<script>
 
</script>
</head>

<body> 
 <?php $user_cookie = isset($_COOKIE['user_cookie'])?$_COOKIE['user_cookie']:'';
      if($user_cookie){
      	$user_cookie = unserialize($user_cookie);
      }
?>
<div class="container order_container_width"> 
<script type="text/javascript" src="/js/weipay.js"></script> 
<script>
var invalid_flag = '<?php echo $invalid_flag;?>';

$(document).ready(function(){
	//切换支付方式
	 $('.wechat_payment_li').click(function(){
		 var selected_img = '<img src="/images/wechat_order_choosen.png" />';
		 $('.wechat_payment_ul .payment_selected').html('');
		 var va = $(this).attr('data_id');
		 $('#hidden_pay_config').val(va);
		 $(this).children('.payment_selected').html(selected_img);
	  })

	  $('.wechat_coupon_div').click(function(){
        
       $("#coupons").animate({
           height: 'toggle'
       }, 0);
    })

    $('#coupons li').click(function(){
    	var normal_url = '/images/li_normal.png'; 
		var select_url = '/images/li_selected.png';
		$('#coupons img').attr('src',normal_url);
		$(this).children('img').attr('src',select_url);
		var data_id = $(this).attr('data_id');
		var real_total_price = parseInt($('#real_total_amount').val());
		var price = 0;
		if(data_id !=0){
			price = parseInt($(this).children('span').html()); 
			
		}
		
		var left_price = real_total_price - price; 
		if(left_price <0){
			left_price = 0;
		}
		left_price+=".00";
		$('.coupons_price').html('￥'+price+'.00');
		$('.order_total').html('￥'+left_price);
       
		$('#coupons_id_used').val(data_id);
    })

    $('#save_order').click(function(){
 		var comment_input = $('#comment_input').val();
 		var payway = $('#hidden_pay_config').val(); 
 		var coupons_id = $('#coupons_id_used').val();
 		var submitdata = {
 				comment_input:comment_input,
 				payway:payway,
 				coupons_id:coupons_id
 		 		};
 		var shipping_address_flag = $('#shipping_address_flag').val();
 		if(shipping_address_flag != 1){
 			alert_frame('请选择配送地址',1);
 			return false;
 	 	}
 		if(invalid_flag == 1){
 			alert_frame('请选择正确的配送区域',1);
 			return false;
 		}
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
<div class="container order_container_width">
<input type="hidden" id="per_count_limit" value="<?php echo $per_count_limit;?>" />
<input type="hidden" id="total_count_limit" value="<?php echo $total_count_limit;?>" />
<input type="hidden" id="shipping_address_flag" value="<?php echo $shipping_address_flag;?>" />
<!-- shipping_adderss -->
 <div class="wechat_order_title order_confirm_padding">
   配送信息
 </div>
 <input value="<?php echo $total_count;?>" id="real_total_amount" type="hidden" />
 <input value="0" id="coupons_id_used" type="hidden" />
 <input type="hidden" id="hidden_pay_config" value="<?php echo $payment[0]->name;?>" />
 <div class="wechat_order_content order_confirm_padding">
 <?php if($shipping_address){?>
   <div class="wechat_order_contactor float_left ">
    
     <div class="wechat_order_name_mobile">
        <img src="/images/wechat_order_portrait.png" class="wechat_order_portrait float_left" />
        <div class="order_name float_left"><?php if($shipping_address){echo $shipping_address->tsa_nickname;}?>&nbsp;&nbsp;<?php if($shipping_address){echo substr($shipping_address->tsa_mobile,0,3);?>****<?php echo substr($shipping_address->tsa_mobile,7); }?></div>
        <div class="order_phone float_right"><?php if($shipping_address){echo $shipping_address->company_name; }?></div>
     </div>
     <div class="order_company compay_address"></div>
     <div class="order_address compay_address"><?php if($shipping_address){echo $shipping_address->province.$shipping_address->city.$shipping_address->area;?>&nbsp;&nbsp;&nbsp;<?php echo $shipping_address->tsa_address; }?></div>
   
   </div>
   <img src="/images/wechat_order_right_arrow.png" class="wechat_order_right_arrow float_right" onclick="location.href='/wechat/member_address'"/>
 <?php }else{?>
     <div style="font-size:16px;text-align:center;margin-top:20px;" onclick="location.href='/wechat/member_address/add'">新增快递地址</div>   
   <?php }?>
 </div>
<!-- shipping_address_end -->
 
<!-- order_payment --> 
 <div class="wechat_order_title order_confirm_padding">
   选择支付方式
 </div>
 
 <ul class="wechat_payment_ul">
  <?php if($payment){
     	  foreach($payment as $k=>$v){	
  			 if($v->name == 'alipay'){
     	?> 
       <li data_id="<?php echo $v->name;?>" class="wechat_payment_li "><img src="/images/wechat_alipay_icon.png"  class="float_left payment_icon"/>支付宝 <div class="payment_selected float_right"><?php if($k==0){?><img src="/images/wechat_order_choosen.png" /><?php }?></div></li> 
   <?php }else if($v->name == 'wechat'){?>
       <li data_id="<?php echo $v->name;?>" class="wechat_payment_li"><img src="/images/wechat_order_wechat.png"  class="float_left payment_icon" />微信支付 <div class="payment_selected float_right"><?php if($k==0){?><img src="/images/wechat_order_choosen.png" /><?php }?></div></li> 
   <?php }else{?>
     	<li data_id="<?php echo $v->name;?>" class="wechat_payment_li"><img src="/images/daofu.png"  class="float_left payment_icon" />货到付款 <div class="payment_selected float_right"><?php if($k==0){?><img src="/images/wechat_order_choosen.png" /><?php }?></div></li> 
    <?php }}}
    ?>   
   
 </ul> 
<!-- order_payment_end --> 
 
<!-- order_goods -->
  <div class="wechat_order_title order_confirm_padding">
   订购清单
 </div>
 <div class="wechat_order_detail order_confirm_padding">
<?php foreach($cart_goods as $k=>$v){  $good = $v['goods'];if($v['week_count']['count']){?> 
  <div class="wechat_good_cate">
    <span class="server_date float_left">用餐日期:<?php echo $good->date;?></span>
    <span class="wechat_order_event  float_right">【<?php echo $good->event_name;?>】</span>
  </div> 
  <div class="wechat_good_count">
     <div class="wechat_good_detail float_left"><?php for($i=0;$i<5;$i++){$title = 'title'.$i;if($good->$title){ if($i){echo '+';}echo $good->$title;}}?></div> 
     <div class="wechat_good_count_price float_right" data_good_id="<?php echo $good->id;?>" data_week="<?php echo $v['week_count']['week'];?>">
       <div class="float_left" style="width:48%;margin-right:2%;">￥<?php echo $good->price;?>/份</div>
       <div class="minus good_button minus_goods float_left" style="margin:3px 3px 0 3px;width:10%;height:12px;line-height:12px;">-</div>
       <div class="float_left" style="border:0;margin:0 2%;"><span class="good_count" style="border:0;"><?php echo $v['week_count']['count'];?> </span></div>
       <div class="plus plus_goods good_button high_but float_left" style="margin:3px 0 0 3px;width:10%;height:12px;line-height:12px;">+</div>
     </div>
  </div>
  <!-- div class="wechat_order_event order_event_date">【<?php echo $good->event_name;?>】</div-->
   
<?php } }?>  
  <div class="wechat_comment">备注：<input type="text" name="" class="wechat_comment_input" id="comment_input" /></div>
 </div>
<!-- order_goods_end --> 
 
<!-- wechat_order_sum --> 
 <div class="wechat_order_cacu order_confirm_padding">
  <ul class="cacu_ul">
    <li>
      <div class="float_left cacu_left"><span class="green_color"><?php echo $cookie_count;?>&nbsp;</span>份，原价总金额：</div>
      <div class="float_right cacu_right">￥<?php echo number_format($orignal_amount,2,'.','');?></div>
    </li> 
    <li>
      <div class="float_left cacu_left">优惠后总金额：</div>
      <div class="float_right cacu_right order_total">￥<?php echo number_format($total_count,2,'.','');?></div>
    </li> 
    <li>
      <div class="float_left cacu_left">优惠券抵扣金额：</div>
      <div class="float_right cacu_right coupons_price">￥0.00</div>
    </li>
    <li>
      <div class="float_left cacu_left">应付金额：</div>
      <div class="float_right cacu_right order_total">￥<?php echo number_format($total_count,2,'.','');?></div>
    </li>
  </ul>   
 <?php if(!$event){?>  
    <div class="wechat_coupon_div"><img src="/images/plus_button.png" class="wechat_coupon_img float_left" /><p class="green_color wechat_coupon_note float_left">使用优惠券抵扣</p></div> 
  <ul id="coupons" style="display:none;">
  	    <li data_id='0'><img src="/images/li_normal.png" class="li_selected float_left" />
            &nbsp;&nbsp;<span>不使用任何优惠券</span>
        </li>
     <?php if($coupons){
           foreach($coupons as $k=>$v){
     	 ?>
        <li data_id='<?php echo $v->tcr_id;?>' ><img src="/images/li_normal.png" class="float_left" />
            &nbsp;&nbsp;<span><?php echo $v->tc_price;?></span>元  
        </li>	  
     <?php }}else{?>
      <li>您暂时没有任何优惠券可以使用</li> 	
     <?php }?>
  </ul>
 <?php }?> 
 </div>
<!-- wechat_order_sum_end -->  
  <div class="wechat_submit_div order_confirm_padding" >
    <div class="wechat_submit_note float_left">实付款：<span class="green_color cacu_right order_total">￥<?php echo number_format($total_count,2,'.','');?></span></div>
    <div class="wechat_submit_button float_right"><img src="/images/wechat_order_sum.png"  class="wechat_sub_button" id="save_order" /></div>
  </div> 
 
</div>
<div id="alert_controller" class="alert_controller">
		<div class="loading display-none">
			<img src="/images/icon-loading.gif" alt="" id="loading_gif"/>
			<div class="text" id="error_msg"></div>
		</div>		 
</div>
</body>
</html> 