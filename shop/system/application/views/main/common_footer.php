
<div class="footer">
  <div class="container_width foot_div">
    <div class="footer_content">
      <a>用户协议</a>
      <a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;隐私协议&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;</a>
      <a>关于我们</a>
    </div>
    <div class="footer_second_content">
      <a>版权所有@2014</a>
      <a>上海小树好吃有限公司&nbsp;&nbsp;|&nbsp;&nbsp;</a>
      <a>ICP备案号：京ICP备15001635号-1</a>
    </div>
  </div>
 </div>
 <input type="hidden" value="" id="hidden_time" /> 
 <input type="hidden" id="login_flag" value="<?php echo $login_flag;?>" />
 <div id="black-popup" <?php if($login_flag){?>style="display: block;" <?php }?>></div>
 <div id="popup" <?php if(!$login_flag){?>style="display: none;" <?php }?>>
     <div class="close_button"><img src="/images/cancel_but.png"  class="pop_close_but cursor_pointer" /></div>
  <!-- register_left --> 
 	 <div class="register_left register_div">
       <div class="register_title">欢迎登录</div>
       <div id="third_register_div" style="display:none;">
	       <div class="register_note first_note">我已有小树好吃账号</div>
	       <div class="register_note">登陆后，享受会员专属礼遇</div>	 
	       <div class="login_right_now register_note"><span class="cursor_pointer" id="login_now">立即登录</span></div>
       </div>
       <div id="third_login_div">
          <div class="right_div form" id="mobile_email_login">
	       <input type="text" placeholder="手机号码" name="mobile_email" id="login_mobile_email"/>
	    </div>
	    <div class="right_div form" id="login_password_div">
	       <input type="password" placeholder="密码" name="mobile_email" id="login_password"/>
	    </div>
	    <div class="right_div form" id="remmeber_password_div">
	       <input type="checkbox" name="remember_login" id="remember_login" /><p class="float_left" id="remmeber_password_p">记住密码</p>
	       <p class="green_color cursor_pointer" id="forget_password_p">忘记密码</p>
	    </div>
	    <div class="third_login_input user_login_button" id="sub_login_button">
	         登录
	    </div>
       </div>
       <div class="other_login_note"><div class="line_p left_p"></div><div class="float_left note_info">您也可以用以下方式登录</div><div class="line_p"></div></div>
 	   <div class="login_img">
 	     <img src="/images/register_qq.png" class="login_qq logimg" onclick="location.href='/oauth/qqlogin'"/>
 	     <img src="/images/register_weibo.png" class="login_weibo logimg" onclick="location.href='<?php echo $code_url;?>'"/>
 	   </div>
 	 
 	 </div>
 	 
  <!-- register_left_end and register_right_start -->
   	 <div class="float_left middle_line"></div> 
	 <div class="register_right register_div">
	    <div class="register_title">欢迎注册</div>
	    <div id="register_second_div">
	      <div class="register_note first_note">我已有小树好吃账号</div>
	       <div class="register_note">登陆后，享受会员专属礼遇</div>	 
	       <div class="third_login_input" id="register_now">
	         立即注册
	       </div>
	    </div>
	    <div id="register_first_div" style="display:none;">
		    <div class="reg_title right_div">
		      <div class="title_left cursor_pointer" id="mobile_register">手机号码注册</div>
		      <div class="title_right cursor_pointer" id="email_register" style="display:none;">电子邮箱注册</div>
		    </div>
		    <input type="hidden" value='0' id="register_type"/>
		    <div class="right_div form" id="mobile_email_div">
		       <input type="text" placeholder="手机号码" name="mobile_email" id="mobile_email"/>
		    </div>
		    <div class="right_div form" id="capcha_div">
		       <input type="text" placeholder="验证码" id="captcha" name="captcha" class="capcha float_left" />
		       <div id="send_div" class="send_div"><img src="/images/send_codes.png" class="capcha_send cursor_pointer" id="get_code"/></div>
		       <div id="verify_div" class="send_div"></div>
		    </div>
		    <div class="right_div form">
		       <input type="password" placeholder="密码" name="password" id="password" />
		    </div>  
		     <div class="right_div form">
		       <input type="password" placeholder="重复密码" name="repassword" id="repassword"/>
		    </div>  
		    <div class="right_div xieyi"><img src="/images/register_selected.png" class="xieyi_check" />&nbsp;&nbsp;我已阅读同意 <span class="green_color">用户协议</span></div>
		    <div class="right_div form form_div third_login_input">
		      <img src="/images/register_button.png" class="submit_button"></img>
		    </div>
	    </div>
	    
	 </div>	 
  <!-- register_right_end -->	 
 </div>
 
 <div id="alert_controller" class="alert_controller">
		<div class="loading display-none">
			<img src="/images/icon-loading.gif" alt="" id="loading_gif"/>
			<div class="text" id="error_msg"></div>
		</div>		 
</div>
