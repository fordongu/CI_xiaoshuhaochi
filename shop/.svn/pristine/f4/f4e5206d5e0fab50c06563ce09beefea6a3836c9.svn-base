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
	<script>
	  var controller = '<?php echo $this->router->class; ?>';
	</script> 
    <script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script> 
    <script type="text/javascript" src="/js/shop_common.js"></script>
</head>
<body id="confirm_step_one_body"> 
  <img src="/images/confirm_step_one_img.png" class="confirm_one_img" />
  <input type="hidden" id="per_count_limit" value=<?php echo $per_count_limit;?> />

<input type="hidden" id="total_count_limit" value="<?php echo $total_count_limit;?>" />
  <table class="order_confirm_table">
   <thead class="confirm_step_one_title">
     <tr>
     <td class="order_confirm_step_one ">订单确认</td>
     <td></td>
     <td></td>
     <td class="empty_cart " id="empty_cart">清空</td>
     </tr>
   </thead>
   <tbody>
      <tr class="service">
       <td class="service_date" style="width:25%;">用餐日期</td>
       <td class="service_content"  style="width:15%;">菜品</td>
       <td class="service_count"  style="width:30%;" class="confirm_good_count_td">份数</td>
       <td class="service_price" class="last_td" >单价 / 份</td>
     </tr>
     <?php foreach($cart_goods as $k=>$v){  $good = $v['goods'];if($v['week_count']['count']){?> 
       <tr>
         <td><?php echo $good->date;?></td>         
         <td><?php echo $good->title0;?></td>
         <td class="confirm_buttom" data_building_id="<?php echo $v['week_count']['building_id'];?>" data_good_id="<?php echo $good->id;?>" data_week="<?php echo $v['week_count']['week'];?>" data_limit="<?php echo $good->per_count_limit;?>">
            <div class="confirm_good_button minus_goods float_left">-</div>
            <div class="confirm_order_count float_left" ><?php echo $v['week_count']['count'];?></div>
            <div class="plus_goods confirm_good_button float_left" >+</div>
         </td>
         <td>￥<a><?php echo $good->price;?></a></td>
       </tr>
     <?php }}?>
   </tbody>
  </table>
 <div class="confirm_step_one_footer">
   <div class="float_left confirm_total_count">共&nbsp;<a class="cookie_count"><?php echo $cookie_count;?></a>&nbsp;份</div>
   
   <div class="float_left confirm_total_count_amount">￥<a class="total_count"><?php echo number_format($total_count,2,'.','');?></a></div>
  
  <div class="float_right confirm_next_step" onclick="location.href='/wechat/confirm_step_two'">下一步
     <!-- <img src="/images/confirm_three_arrow.png"  class="three_next_arrow"/> -->
   </div>
 
 </div> 
  
</body>
</html>
