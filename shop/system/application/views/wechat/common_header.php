<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">

	<meta name="description" content="">	
	<meta property="qc:admins" content="24500242000645756441711056375" />
	<title>Green&Yummy</title>  
	<link href="/css/wechat_new.css" rel="stylesheet"> 
	<script>
	  var controller = '<?php echo $this->router->class; ?>';
	</script>
	<script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script> 
   <script type="text/javascript" src="/js/shop_common.js"></script>
<script>
 
</script>
</head>

<body onselectstart="return:false;"> 
 <?php $user_cookie = isset($_COOKIE['user_cookie'])?$_COOKIE['user_cookie']:'';
      if($user_cookie){
      	$user_cookie = unserialize($user_cookie);
      }
?>
<div style="display:none;" class="container order_container_width">
<!-- member_center_title -->
  <div class="center_title order_confirm_padding">
     <img src="/images/wechat_warning.png" class="float_left wechat_warning"/>
     <div class="title_desc float_left">您有<span class="green_color">&nbsp;<?php echo $order_count;?>&nbsp;</span>个订单未支付，有<span class="green_color">&nbsp;<?php echo $coupon_count;?>&nbsp;</span>张优惠券可用</div>
  </div>