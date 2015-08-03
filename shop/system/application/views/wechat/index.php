<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" >
<!--<meta content="IE=edge" http-equiv="X-UA-Compatible">-->
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" >
<!--<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta content="telephone=no" name="format-detection">-->
  <title>Green&Yummy</title>
  <link  rel="stylesheet" href="/css/wechat_new.css">
  <link  rel="stylesheet" href="/css/wechat_new_eric.css">
   <link rel="stylesheet" type="text/css" href="/css/swiper.min.css">
    <script type="text/javascript" src="/js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="/js/swiper.min.js"></script>
   <!-- <script src="/js/fastclick.js" type="text/javascript"></script> -->
    <script type="text/javascript" src="/js/shop_common.js"></script>
   <script type="text/javascript" src="/js/con_index.js"></script>
      <script type="text/javascript" src="/js/shop_reg.js"></script>
     <script type="text/javascript" src="/js/wechat_index.js"></script>
           <script type="text/javascript" src="/js/cart_wechat.js"></script> 
      <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"> </script>

</head>
 <input type="hidden" name="signature" value="<?php echo $signature;?>" id="signature"/>

     <script type="text/javascript" src="/js/wechat_share.js"></script>

<script type="text/javascript">
   $(function(){
   
   //已售罄放到底部 Begin
   $('.good_detail_img_div').has('.prev_wx').appendTo($('.wechat_bottom_content:eq(0)'));
   $('.good_detail_img_div').has('.next_wx').appendTo($('.wechat_bottom_content:eq(1)'));
  //已售罄放到底部 End

    
        
    $('.wechat_bottom_content').append($('.now_week').parents('.good_detail_img_div'));
    $('.wechat_bottom_content').append($('.next_week').parents('.good_detail_img_div'));
             
        if($('.now_week').length>0){
                 $('.now_week:eq(1),.now_week:eq(3)').parents('.good_detail_img_div').remove();
             }
          
              if($('.next_week').length>0&&$("#day_now").val()=="1"){
                      $('.next_week:eq(1),.next_week:eq(3)').parents('.good_detail_img_div').remove();
             }
   $(".add_cart_wechat").click(function(){

      var pic=$(this).parents(".good_detail_img_div").children(".good_detail_img_div_sub").children(".good_detail_img");
   var flyElm = $(pic).clone();
     flyElm.css({
     'z-index': 9000,
      'display': 'block',
      'position': 'absolute',
      'top': $(this).parents(".good_detail_img_div").children(".good_detail_img_div_sub").children(".good_detail_img").offset().top +'px',
      'left': $(this).parents(".good_detail_img_div").children(".good_detail_img_div_sub").children(".good_detail_img").offset().left +'px',
      'width': $(this).parents(".good_detail_img_div").children(".good_detail_img_div_sub").children(".good_detail_img").width() +'px',
      'height': $(this).parents(".good_detail_img_div").children(".good_detail_img_div_sub").children(".good_detail_img").height() +'px'
     })
    $('body').append(flyElm);
  flyElm.animate({
      top:$('.cart_icon').offset().top,
      left:$('.cart_icon').offset().left,
      width:35+'px',
      height:35+'px',
    });

  setTimeout(function(){$(flyElm).remove();},400);
  })
  showCount();
   })
         
       
  </script>


<body>

<input type="hidden" id="user_order" value="<?php echo $user_order?>">
<input type="hidden" id="tu_mobile" value="<?php echo $tu_mobile?>">
<input type="hidden" id="day_now" value="<?php echo $day_now?>">
<input type="hidden" id="pic_chan">
<input type="hidden" id="choose_pic" value="<?php echo $day_choose;?>">
<input type="hidden" id="user_id" value="<?php echo $uid?>">
<input type="hidden" value="" id="hidden_time" />
<input type="hidden" value="" class="hidden_time" />
<input type="hidden" value="" id="hidden_weeks" />
<input type="hidden" id="per_count_limit" value="<?php echo $per_count_limit;?>" />
<input type="hidden" id="total_count_limit" value="<?php echo $total_count_limit;?>" />
<input type="hidden" id="weeks_choose" this_mon="<?php echo $weeks_contorl[0][0];?>" this_fri="<?php echo $weeks_contorl[0][1];?>" next_mon="<?php echo date("Y/m/d",strtotime($weeks_contorl[1][0]));?>" next_fri="<?php echo $weeks_contorl[1][1];?>"/>

<div class="views_wechat_title">
           <ul>
             <li id="this_week_btn"><h5>本周</h5></li>
             <li id="next_week_btn"><h5>下周</h5></li>
           </ul>

 </div>



<div class="wechat_index_goods swiper-container" id="wechat_index_goods">
<div class="swiper-wrapper">

<?php

$current_date = date('Y-m-d');
$date_no = 0;
 
foreach($week_orders as $key=>$val){

    if($key<=4){
        $now_week="now_week";
    }else{
        $now_week="new_week";
    }
  $val=str_replace("-","/",$val);
  $date_no++;
   if($key==$day_choose-1||$key==5){

  ?>
   <div class="wechat_goods_detail_div <?php echo $now_week;?> swiper-slide">
         <div style="display:none;" class="detail_week"  data_date="<?php echo $val;?>" data_week="<?php echo $key;?>"><?php echo $weeks[$key];?><?php echo " \n"; ?><?php echo $val;?>
     </div>

     <!-- first_good -->

     <?php foreach($goods as $j=>$good){
          foreach($good->temp_goods as $k=>$v){

            $end_time=$v->end_time;
              $val_time=str_replace("/", "-",date($val." 23:59:59"));
            if($val_time<$end_time&&$val_time>=$v->start_time){
             //不显示过期菜//

       ?>
<div class="good_detail_img_div " data_good_price=<?php echo $v->price;?> data_good_name=<?php echo $v->name;?> data_date="2015/05/14" data_week="<?php echo $key;?>" data_building_id="<?php echo $v->building_id;?>" data_good_id="<?php echo $v->good_id;?>">

    <div class="good_detail_img_div_sub">
       <?php


     if((strtotime($val) < strtotime($current_date))||
      (strtotime($current_time) > strtotime($valid_time))&&(strtotime($val)==strtotime($current_date))){

    ?><!--已售罄-->
       <img src="<?php echo $v->coverurl0;?>" class="good_detail_img"/>
                   <img src="/images/wx_sq.png" class="wx_sq <?php if($key<=4){echo "now_week_delete";}else{echo "next_week_delete";}?>"/>
       <?php }else{

                       ?>
       <!--有货-->
       <!--
       <?php if($v->cate_id!=="9"&&$v->cate_id!=="15"){?>
                   <div class="soffer_notice">美食搭配饮料，每份饮料享优惠特价！

       </div>
                   <?php }?>
      -->
      
  
      
       <img src="<?php echo $v->coverurl0;?>" class="good_detail_img"/>
     <?php if($v->stock=="0"){         
             ?>
          <img src="/images/wx_sq.png" class="wx_sq <?php if($key<=4){echo "prev_wx";}else{echo "next_wx";}?>"/>
         <?php }?>
       
       
       
       
       <?php }?>
           </div>
       <!--
       <div class="date_week_top">
          <span data_week="<?php echo $key;?>"><?php echo $weeks[$key];?></span>
          <span data_date="<?php echo $val;?>"><?php echo $val;?></span>
           </div>
           -->
            <!--<ul>-->
             <!--<li class="good_name_icon">菜名</li> -->
              <!--<?php if($v->title0){?><li class="normal_icon"><?php echo $v->title0;?></li> <?php }?>
              <?php if($v->title1){?><li class="normal_icon"><?php echo $v->title1;?></li> <?php }?>
              <?php if($v->title2){?><li class="normal_icon"><?php echo $v->title2;?></li> <?php }?>
            </ul>-->
            <div class="wechat_good_detail_price_count">
           <div class="good_detail_title "><?php echo $v->name;
            if($v->building_id=="8"){
                    echo "(剩余".$v->stock."份)";
                }
            ?>

              </div>
              <div class="wechat_good_address">来自:
                  <?php echo $v->supplier_name;?></div>
                 <div class="wechat_good_price ">

                 ￥<span><?php
                 echo $v->price;
                 ?></span>
         <del><?php if(!empty($v->old_price)&&intval($v->old_price)!==0){
      echo "原价:¥ ".$v->old_price."";

        }
        ?>

            </del>
               </div>
                 <div class="wechat_good_buy_button">
                   <!--
           <div class="wechat_minus_good wechat_buy_icon float_left minus_good" cate_id="<?php echo $v->cate_id;?>" data_info=0>-</div>  -->
                   <div  class="float_left buy_good_count" style="display: none;">
                   <!--  <?php if($cookie_good){
                            $count = 0;

                               foreach($cookie_good as $m=>$j){
                      foreach($j as $l=>$n){
                        if(($l==$key)&&($n['id']==$v->good_id)){
                        $count =  $n['count'];
                                   }
                                 }
                  }
                  echo $count;
                           }else{ echo 0;}

                   ?>-->
                   1
                   </div>
                  <!-- <div style="float:left;margin-right:10px;">
                 <select class="dinner_time_this_week" style="display:block;">
                        
                       <option value="0" selected="selected">请选择用餐时间</option>
                       <option value="<?php echo date("Y/m/d",  strtotime($week_orders[0]));?>"><?php echo $week_orders[0];?></option>
                       <option value="<?php echo date("Y/m/d",  strtotime($week_orders[1]));?>"><?php echo $week_orders[1];?></option>
                       <option value="<?php echo date("Y/m/d",  strtotime($week_orders[2]));?>"><?php echo $week_orders[2];?></option>
                       <option value="<?php echo date("Y/m/d",  strtotime($week_orders[3]));?>"><?php echo $week_orders[3];?></option>
                       <option value="<?php echo date("Y/m/d",  strtotime($week_orders[4]));?>"><?php echo $week_orders[4];?></option>
                     </select>
                      
                       <select class="dinner_time_last_week" style="display:none;">
                       <option value="0" selected="selected">请选择用餐时间</option>
                       <option value="<?php echo date("Y/m/d",  strtotime($week_orders[5]));?>"><?php echo $week_orders[5];?></option>
                       <option value="<?php echo date("Y/m/d",  strtotime($week_orders[6]));?>"><?php echo $week_orders[6];?></option>
                       <option value="<?php echo date("Y/m/d",  strtotime($week_orders[7]));?>"><?php echo $week_orders[7];?></option>
                       <option value="<?php echo date("Y/m/d",  strtotime($week_orders[8]));?>"><?php echo $week_orders[8];?></option>
                       <option value="<?php echo date("Y/m/d",  strtotime($week_orders[9]));?>"><?php echo $week_orders[9];?></option>
                     </select>
                   </div>-->
                    <?php if((strtotime($current_time) < strtotime($valid_time))&&(strtotime($val)==strtotime($current_date))){?>
                         <div class="wechat_plus_good wechat_buy_icon float_left add_cart_wechat" cate_id="<?php echo $v->cate_id;?>" data_info=0 >点餐</div>
                    <?php }else if(strtotime($val) > strtotime($current_date)){?>
                         <div class="wechat_plus_good wechat_buy_icon float_left add_cart_wechat" cate_id="<?php echo $v->cate_id;?>" data_info=0 >点餐</div>
                    <?php }else{?>
                       <div class="wechat_buy_icon_invalid float_left" >点餐</div>
                    <?php }?>
               </div>

      </div>

      <div class="clear"></div>
       <input type="hidden" class="stok_left" value="<?php echo $v->stock;?>">

         </div>

<?php }}}?>
     <!-- first_good_end -->

     <div class="wechat_bottom_content"></div>
    </div>
   
  <?php }?>

<?php }?>

</div>
</div>
<!--<div class="clear"></div>-->


<!--
<div class="clear"></div>
</div>
-->
<div style="display:none;"  class="loginBar_eric">
  <div>
   <div class="loginTitle_eric">
      <h3 class="fl">用户登录</h3>
      <img class="pop_close_but cursor_pointer" src="/images/cancel_but.png">
   </div>
   <div style="display:block;">
  <ul>
      <li>
      <input class="cellphone_login" type="text" placeholder="手机号" />
    </li>
    <li>
      <input class="password_login" type="password" placeholder="填写密码" />
      </li>
    <li>
    <input class="loginButton_eric loginButton" type="button" value="登 录" />
    </li>
    <li>
    <a class="forget_passwd_eric" href="#">忘记登录密码?</a>
      </li>
      <li class="forget_sign">如果没有小树好吃账号，<a href="javascript:">立即注册</a></li>
    </ul>
   </div>
  </div>
</div>
<div style="display:none;" class="signupBar_eric">
    <div>
      <div class="loginTitle_eric">
        <span class="fl">欢迎注册</span>
        <img class="pop_close_but cursor_pointer" src="/images/cancel_but.png">
      </div>
      <ul>
          <li>
         <input class="cellphone_reg" id="cellphone" type="cellphone" placeholder="请输入手机号码" autofocus="autofocus" required="required" />
          </li>
        <li>
               <span>
         <input class="validcode_reg" type="text" id="mobile_code" placeholder="填写验证码" />
         </span>
         <span>
         <button id="send_code" class="send_code_eric cursor_pointer code_eric">发送验证码</button>
         <span id="send_div" class="display_code_eric" style="display:none;"></span>
          </span>
        </li>
         <li>
         <input class="password_reg" id="pass" type="password" placeholder="请输入密码" required="required" />
         </li>
                <li><input class="password_reg" id="surePass" type="password" placeholder="再次输入密码" required="required"/>
        </li>
        <li class="agree_eric">
           <input id="checkbox" type="checkbox" checked="checked" />
            <span >我已阅读并同意</span><a href='javascript:'>用户协议 </a>
          </li>
              <li>
          <input id="signupBtn_eric" type="submit" value="注  册" />
              </li>
              <li class="wechat_index_btn">
                如果已有小树好吃账户，请 <a href="javascript:"> 立即登录</a>
              </li>
             </ul>
         </div>
      </div>
<div style="display:none;" class="forgot_pass">
<div>
  <span class="fl">重置密码</span>
  <img class="pop_close_but cursor_pointer" src="/images/cancel_but.png">
</div>

 <ul>
   <li><input class="cellphone" type="text" class="cellphone" placeholder="请输入手机号码"></li>
   <li><input class="sms_code" type="text" placeholder="短信验证码" /><span id="send_code" class="send_code_eric cursor_pointer send_sms_eric" >发送验证码</span>
        <!--<button id="send_code" class="send_code_eric cursor_pointer">发送验证码</button>-->
         <span class="display_code_eric send_div" style="display:none;"></span>
   </li>
   <li><input class="password_forgot" type="password" placeholder="请输新密码" /></li>
   <li><input class="repassword_forgot" type="password" placeholder="确认密码" /></li>
   <!--<li><span class="send_div" style="display:none;"></span> </li>-->
    <li> <button class="comfirm">确认修改</button></li>
 </ul>
</div>

<!--
<div  id="confirm_step_one_body" >
  <input type="hidden" id="per_count_limit" value=<?php echo $per_count_limit;?> />
<input type="text" style="display:none;" id="find_goods" value="">
<input type="hidden" id="total_count_limit" value="<?php echo $total_count_limit;?>" />

<div class="wechat_new_title">



<div style="display:none;" class="loginBar">
  <div class="loginBar-item width auto">
   <div class="loginTitle">
      <h3 class="fl">用户登录</h3>

   </div>

  </div>
</div>
 <div class="wechat_buildings_name float_left click_popup" >
      <?php echo $default_building;?>&nbsp;
 </div>
   <img src="/images/wechat_new_arrow.png" class="float_left down_arrow click_popup" />


</div>

</div>
-->




<div <?php if(!$cookie_count){?>style='display: block;'<?php }?> class="index_confirm_bottom">
   <div class="person_icon_div">
      <img src="/images/wechat_avatar.png" class="person_icon" />
  </div>
    <!--<a href="http://demo.xiaoshuhaochi.com/weixinpay/index">11111</a>-->
      <div class="cart_count_div" class="cart_icons" onclick="location='<?php echo base_url();?>wechat/confirm_step_two '">
         <span class="cart_count cart_icon" <?php if(!$cookie_count){?>style='display: none;'<?php }?>><?php echo $cookie_count;?></span>
         <img src="/images/wechat_gwc_h.png" />
      </div>
  <!--<div id="views_wechat_side"><span></span></div>-->
    <!--
<table class="order_confirm_table" style="display:none;">
   <thead class="confirm_step_one_title">
     <tr>
     <td class="order_confirm_step_one ">订单确认</td>
     <td></td>
     <td class="icon_bottom"></td>
     <td id="empty_cart">清空</td>
     </tr>
   </thead>
   <tbody>

      <tr class="service">
       <td class="service_date good_date"  >用餐日期</td>
       <td class="service_content">菜品</td>
       <td class="service_count" class="confirm_good_count_td">份数</td>
       <td class="service_price" class="last_td" >单价 / 份</td>
     </tr>
     <?php foreach($cart_goods as $k=>$v){  $good = $v['goods'];if($v['week_count']['count']){
         
  ?>
       <tr>
         <td class="good_date" data_week="<?php echo $v['week_count']['week'];?>"  cate_id="<?php echo $good->cate_id;?>" data_good_id="<?php echo $good->id;?>"><?php echo $good->date ;?></td>
         <td><?php echo $good->name;?></td>
         <td class="confirm_buttom" data_building_id="<?php echo $v['week_count']['building_id'];?>" data_good_id="<?php echo $good->id;?>" data_week="<?php echo $v['week_count']['week'];?>" data_limit="<?php echo $good->per_count_limit;?>">
            <div class="confirm_good_button minus_goods float_left" data_info=0>-</div>
            <div class="confirm_order_count float_left" ><?php echo $v['week_count']['count'];?></div>
            <div class="plus_goods confirm_good_button float_left" data_info=0>+</div>
         </td>
         <td>￥<a class="single_price"><?php echo $good->price;?></a></td>
       </tr>
     <?php }}?>
         <tr class="confirm_total_list">
             <td class="confirm_total_count">共&nbsp;<span class="cookie_count">0</span>&nbsp;份</td>
             <td class="confirm_total_count_amount">原价:￥<span class="total_count">0</span>元</td>
            <td class="onsell_total_count_amount">优惠价:￥<span class="onsell">0</span>元</td>
             <td class="confirm_next_step"><span>下一步</span></td>
         </tr>
   </tbody>
  </table>-->
     <!-- <div class="confirm_next_step"><span>下一步</span>
         <img src="/images/confirm_three_arrow.png"  class="three_next_arrow"/>
     </div> -->
</div>



      <!--body-->


<!--
  </div>

</div>
-->

<?php if($order_detail){ ?>
<div class="order_detail_float">
<div><img src="/images/cancel_but.png" class="pop_close_but cursor_pointer" /></div>
<div style="margin-left:10px;margin-top:10px;">您有以下订单:</div>

<?php foreach($order_detail as $key=>$val){
  //$snnum=$val["sn"];

  array_pop($val);
  ?>
<div>

<!--
<?php foreach($val as $k=>$v){
?>

<span>下单时间:<?php echo $v->to_created;?>
</span>
<span>用餐日期:<?php echo $v->service_date;?>
</span>

<?php }?>
-->

<div style="margin-left:10px; font-size:12px;">下单时间:<?php echo $val[0]->to_created;?>
</div>

<div style="margin-left:10px;margin-bottom:10px;font-size:12px;">
<span>订单编号:<?php echo $val[0]->to_order_sn;?></span>
<?php if($val[0]->to_pay_status==0){echo "(未支付)";}else if($val[0]->to_pay_status==1){echo "(已支付)";}?>
<a style="margin-left:10px;color:#00d329;"href="/wechat/member_order" >去查看</a>
</div>


</div>
<?php }?>
</div>

<?php }?>

 </div>



<script type="text/javascript">
  $(".dinner_time").change(function(){
  //var val = $(this).val();
    //alert(val);
   // $(this).parents(".good_detail_img_div").attr("data_date", val);
});



</script>

<?php if (!$notice) {?>
<div class="general_notice">
     <span class="delete"><img src="<?=$static_url?>/icon/delete.png" alt="关闭" /></span>
     <ul>
       <li>为了您能准时收到您订购的美食，<br/>请您在用餐日期前或当天<big>10:00</big>前进行预订。</li>
       <li>我们的配送时间为：<big>11:00AM</big> - <big>12:00AM</big>!</li>
       <li>您可以提前预订本周和下周的美食!</li>
     </ul>
</div>
<?php }?>

</body>

</html>
