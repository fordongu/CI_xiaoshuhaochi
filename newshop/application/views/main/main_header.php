                                         <!-- 头部 Begin -->
<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8" />
<title>Green&Yummy</title>
<link rel="stylesheet" href="<?=$static_url?>/css/main.css"/>
<LINK href="/favicon.ico" type="<?=$static_url?>/image/x-icon" rel="icon">
<LINK href="/favicon.ico" type="<?=$static_url?>/image/x-icon" rel="shortcut icon">
</head>
  <input type="hidden" value="" class="hidden_time" />
  <input type="hidden" value="<?php echo $order_check;?>" id="order_check" />
  <input type="hidden" value="<?php echo $mobile_check;?>" id="mobile_check" />
<body onselectstart="return false">
  <div class="views_main_header">
     <ul>
      <li onclick="location.href='/main/index'"><span></span></li>
      <li>
        
		<ol>
          <li class="person_content"><span></span></li>
         
          <li class="person_name"><span></span>
             
              <?php if($mobile_check==1){?>
              <button  class="login_out">退出</button></li>
                <?php }?>
        </ol>
      
	  </li>
      <li>
        <ol>
          <li id='this_week' class="this_week"><span></span><span>本周 </span><span> <?php echo $weeks_contorl[0][0]."-".$weeks_contorl[0][1];?></span></li>
          <li id='next_week' class="next_week"><span></span><span>下周 </span><span> <?php echo $weeks_contorl[1][0]."-".$weeks_contorl[1][1];?></span></li>
          <li><span title="午餐"><i></i></span><span title="水果"><i></i></span><span title="饮料"><i></i></span><span title="点心"><i></i></span></li>
        </ol>
      </li>
      <li>
        <ol>
          <li><a href="javascript:;">F&Q</a></li>
          <li><a href="javascript:;">关于我们</a></li>
          <li><a href="javascript:;">用户协议</a></li>
          <li><a href="javascript:;">隐私协议</a></li>
        </ol>
      </li>
      <li><span></span><span></span></li>
      <li>
        <ol>
          <li>版权所有©2014</li>
          <li>上海小树好吃有限公司</li>
          <li><h5>ICP备案号:</h5></li>
          <li>京ICP备15001635号-1</li>
        </ol>
      </li>
     </ul>
 </div>
 <!-- 遮罩 Begin -->
   <div id="cover"></div>
 <!-- 遮罩 End -->
 <!-- 注册登录 Begin -->
 <div class="views_main_login_sign_one">
   <span class="delete">
      <img src="../icon/delete.png" alt="关闭"/>
   </span>
   <div class="views_main_login">
    <h3>登录</h3>
    <!--<form method="post" enctype="multipart/form-data" action=http://dev.xiaoshuhaochi.com/main/user_login>-->
     <ul>
       <li><input id="login_cell" type="text" placeholder="手机号码"/></li>
       <li><input id="login_password" type="password" placeholder="密码" <?php if ($remember_flag){?> value=<?php echo $remember_flag; }?>/></li>
       <li>
         <label>
           <input id="remember_password" type="checkbox" checked="checked" /> 记住密码
         </label>
         <a id="fogot_password">忘记密码 ？</a>
       </li>
       <li><button id="login_btn">立即登录</button></li>
       <!--<li>你也可以通过以下方式登录</li>
       <li><span></span><span></span></li>-->
     </ul>
   <!--  </form>-->
   </div>
   <div class="views_main_sign">
     <h3 id="reg">注册</h3>
     <p id="show_login_btn">我已有<a>小树好吃</a>账号</p>
     <p>登录后，享受会员专属待遇</p>
     <button id="sign_now">立即注册</button>
   </div>
 </div>

 <div class="views_main_login_sign_two">
   <span class="delete">
      <img src="../icon/delete.png" alt="关闭"/>
   </span>
   <div class="views_main_sign">
     <h3>登录</h3>
     <p>我已有<a>小树好吃</a>账号</p>
     <p>登录后，享受会员专属待遇</p>
     <ul>
         <li><button id="login_now">立即登录</button></li>
       <!--<li>你也可以通过以下方式登录</li>
       <li><span></span><span></span></li>-->
     </ul>
   </div>
   <div class="views_main_login">
    <h3>注册</h3>

     <ul>
       <li><input type="text" class="mobile_email_reg" placeholder="手机号码"/></li>
       <li>
          <input type="text" class="code" placeholder="验证码" />
          <span id="send_code" class="cursor_pointer send_code" onclick="send_code();">发送验证码</span>
           <span class="cursor_pointer send_div" style="display:none;"></span>
       </li>
       <li><input type="password" class="password_reg"  placeholder="密码"/></li>
       <li><input type="password" class="repassword_reg" placeholder="重复密码"/></li>
       <li>
         我已阅读并同意<a href="javascript:;">用户协议</a>
       </li>
       <li><button class="userRister">立即注册</button></li>
     </ul>

   </div>
 </div>

 <div class="views_main_login_sign_three">
   <span class="delete">
      <img src="../icon/delete.png" alt="关闭"/>
   </span>
   <div class="views_main_login">
    <h3>忘记密码</h3>
     <ul>
         <li><input type="text" id="mobile_email" placeholder="手机号码"/></li>
       <li>
          <input type="text" id="code" placeholder="验证码">
          <a class="send_sms" onclick="send_sms();">发送验证码</a>
          <span id="send_div" class="cursor_pointer" style="display:none;"></span>
       </li>
       <li><input type="password" id="password" placeholder="密码"/></li>
       <li><input type="password" id="repassword" placeholder="重复密码"/></li>
       <li><button id="changpass">确认修改</button></li>
     </ul>
   </div>
   <div class="views_main_sign">
     <h3>注册</h3>
     <p>我已有<a>小树好吃</a>账号</p>
     <p>登录后，享受会员专属待遇</p>
     <button class="sign_now">立即注册</button>
   </div>
 </div>
 <!-- 注册登录 End -->
                                          <!-- 头部 End -->
