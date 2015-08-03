<?php $method= $this->uri->segment(2);?>
<?php $user_cookie = isset($_COOKIE['user_cookie'])?$_COOKIE['user_cookie']:'';
      if($user_cookie){
         $user_cookie = unserialize($user_cookie);       
      }else{
         redirect('/main/index');
      } 
?>
<!--
<div class="order_search_div header_img">
   <div class="container_width order_search_content">
      <img src="/images/logo.png" class="logo_img float_left cursor_pointer"  onclick="location.href='/main/index'"/>
      <div class="order_confirm_title float_left">个人中心</div> 
   </div>
</div>--> 
    <div class="main_member_left">
           <ul>
             <li><h4>个人信息管理</h4></li>
             <li onclick="location.href='/member/index'">基本信息</li>
             <li onclick="location.href='/member/shipping_address'">配送地址</li>
             <li></li>
             <li><h4>订单中心</h4></li>
             <li onclick="location.href='/member/order_list'">我的订单</li>
             <li><h4>资产中心</h4></li>
             <li onclick="location.href='/member/coupons'">优惠券</li>
             <li onclick="location.href='/member/account'">我的账户</li>
             <li onclick="location.href='/member/score'">积分</li>
           </ul>
           <div class="clear"></div>
		    <!--<li onclick="location.href='/member/password'">登录密码设置</li>-->
    </div>
