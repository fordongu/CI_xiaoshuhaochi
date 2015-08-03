<?php $this->load->view('wechat/common_header');?>
<link rel="stylesheet" href="/jquery-ui/css/smoothness/jquery-ui-1.10.0.custom.min.css" media="screen" />
<link rel="stylesheet" href="/resource/css/plugin/jquery-ui-timepicker-addon.css" media="screen" />    
<script type="text/javascript" src="/resource/js/plugin/operamasks-ui.min.js"></script>
<script type="text/javascript" src="/jquery-ui/js/jquery-ui-1.10.0.custom.min.js"></script> 
<script type="text/javascript" src="/resource/js/plugin/timepicker/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="/resource/js/plugin/timepicker/jquery-ui-timepicker-zh-CN.js"></script>
<script type="text/javascript" src="/resource/js/plugin/timepicker/jquery-ui-sliderAccess.js"></script>
<script type="text/javascript" src="/js/shop_reg.js"></script>

	<?php $user_cookie = isset($_COOKIE['user_cookie'])?$_COOKIE['user_cookie']:'';
      if($user_cookie){
      	$user_cookie = unserialize($user_cookie);       
      	$user = $this->tickets->select('users',array('tu_id'=>$user_cookie->tu_id));
      	$user_cookie = $user[0];
      } 
	?>
	
   <input type="hidden" value="" class="hidden_time" />
  <div style="display:none;" class="member_base_infos ">
      <!-- base_info --> 
       <div class="member_base_info height280">
        <div class="base_title">
          <div class="config_title ">
            
          </div>
          <div class="member_normal_line  ">
          </div>
        </div>
       <div>
	   <span id="invate_code">您的邀请码:<?php echo $user_cookie->tu_invate_code;?></span>
	   </div>
       <ul id="user_info_ul">
         <li>
         <!-- 取消微信认证后此段删除 不在显示微信昵称 <div class="base_info_title ">微信昵称：</div> <div class="base_info_input ">
            <?php echo $user_cookie->tu_nickname;?>
          </div>  -->
         </li>
        <!--  <li style="margin-top:20px;">
           <div class="base_info_title ">性别：</div> <div class="base_info_input " class="user_id" data_id="<?php echo $user_cookie->tu_id;?>">
           <input type="radio" name="gender" class="gender" <?php if($user_cookie->tu_gender==0){?>checked=true<?php }?> value="0" style="margin-top:0;"/>男&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="gender" style="margin-top:0;" class="gender" value="1" <?php if($user_cookie->tu_gender==1){?>checked=true<?php }?>  />女</div>  
         </li>
         <li id="birthday_li" >
          <div class="base_info_title " style="height:45px !important;line-height:45px !important;">生日：</div>
		   
		   <div class="base_info_input " style="height:45px !important;line-height:45px !important;">
              <input type="text" name="tu_birthday" id="tu_birthday" data_id="<?php echo $user_cookie->tu_id;?>" value="<?php echo $user_cookie->tu_birthday;?>" />
              <span class="cursor_pointer" id="tu_birthday_span">保存</span><br/>-->
			手机号码：<span class="noto" id="mobile_span"><?php echo $user_cookie->tu_mobile;?></span><div class="change_cell">修改</div>
			<div class="input_cell"  style="display:none" ><input name="tu_mobile" type="text" placeholder="请输入手机号码"/><span class="save_cell">保存</span>
			<br/>
          <div class="base_info_title " style="height:40px !important;line-height:40px !important;">验证码：
		  <input type="text" id="mobile_code" placeholder="填写验证码" style="width:80px;"/>
		  </div><span id="send_code" class="cursor_pointer">发送验证码</span>
		  <span class="cursor_pointer send_div" style="display:none;"></span><div>
		   
              </div>  
			  
		  
         </li>
        <!--<li style="display:none;">
           <div class="base_info_title " style="height:45px !important;line-height:45px !important;">邮箱：</div> 
           <div style="height:45px !important;line-height:45px !important;" class="base_info_input " data_id="<?php echo $user_cookie->tu_id;?>" data_val="tu_email">
             <span class="noto"><?php echo $user_cookie->tu_email;?></span>
             &nbsp;&nbsp;&nbsp;&nbsp;<span class="click_input cursor_pointer">修改</span><span class="edit_input cursor_pointer">保存</span>
           </div>  
         </li>-->
         
        <!-- <li>
           <div class="base_info_title ">注册时间：</div> <div class="base_info_input "><?php echo date('Y年m月d日 H:i',strtotime($user_cookie->tu_created));?></div>  
         </li>-->
 
       </ul>    
      </div>    
     <!-- base_info -->
      <!-- div class="member_base_info height280">
        <div class="base_title">
          <div class="config_title ">
             修改密码
          </div>
          <div class="member_normal_line  ">
          </div>
        </div>
       
       <ul id="reset_password">
         <li>
           <div class="base_info_title ">&nbsp;</div> <div class="base_info_input "><input type="password" name="opassword" id="opassword" placeholder="请输入原密码" /><span class="error_note"></span></div>  
         </li>
         <li>
           <div class="base_info_title ">&nbsp;</div> <div class="base_info_input "><input type="password" name="new_password" id="new_password" placeholder="请输入新密码" /><span class="error_note"></span></div>  
         </li>
         <li>
           <div class="base_info_title ">&nbsp;</div> <div class="base_info_input "><input type="password" name="confirm_password" id="confirm_password" placeholder="请再次输入新密码" /><span class="error_note"></span></div>  
         </li>
         
         <li class="last_li">
           <div class="base_info_title ">&nbsp;</div> <div class="base_info_input  address_detail"><input type="button" id="save_address" value="提交"></div>  
         </li>
       </ul>    
      </div --> 
</div>
    

</div> 
<input type="hidden" class="user_id" value=<?php echo $user_cookie->tu_id;?>>
<input type="hidden" class="sex">
<div class="wechat_member_index">
  <div class="wechat_memver_index_wrapper">
    <div class="wechat_member_index_title">
      <img src="/images/icon_geren.png">
      <img class="iconfont-fanhui1" width="10px" height="10px" alt="返回" src="/images/iconfont-fanhui1.png">
      <h3>个人信息</h3>
    </div>
    <ul class="wechat_member_index_list">
      <li>
        <span class="wechat_member_index_list_left">手机号码</span>
        <span class="noto" id="mobile_span"><?php echo $user_cookie->tu_mobile;?></span>
        <span class="wechat_member_index_gt">&gt;</span>
      </li>
      <li class="wechat_member_index_mobile">
        <input type="text" class="cellphone" placeholder="请输入手机号码">
        <input class="code" type="text" placeholder="请输入验证码">
        <span type="button" class="cursor_pointer send_sms">发送验证码</span>
        <span class="cursor_pointer send_div" style="display:none;"></span>
		<input class="save_cell" type="button" value="保存">
      </li>
      <li>
        <span class="wechat_member_index_list_left">性别</span>
        <span class="wechat_member_index_sex_check"><?php if($user_cookie->tu_gender==0){echo "男";}else{echo "女";}?></span>

        <span class="wechat_member_index_gt">&gt;</span>
      </li>
      <li class="wechat_member_index_sex">
        <form>
           <input type="radio" name="Sex" <?php if($user_cookie->tu_gender==0){?>checked=checked<?php }?> value="0" />男
           <input type="radio" name="Sex" <?php if($user_cookie->tu_gender==1){?>checked=checked<?php }?> value="1" />女
		   <input type="button" class="save_sex" value="保存">
        </form>
      </li>
     <!-- <li>
        <span class="wechat_member_index_list_left">出生日期</span>
        <span></span>
        <span class="wechat_member_index_gt">&gt;</span>
      </li>-->
	  <?php if($user_cookie->tu_mobile){?>
      <li>
        <span class="wechat_member_index_list_left">修改密码</span>
        <span class="wechat_member_index_gt">&gt;</span>
      </li>
	  <?php }?>
    </ul>
    <ul class="wechat_member_index_password">
      <li><input type="password" class="opassword" placeholder="请输入原密码"></li>
      <li><input type="password" class="new_password" placeholder="请输入新密码"></li>
      <li><input type="password" class="confirm_password" placeholder="请再次输入新密码"></li>
      <li><input type="button" class="change_password" value="保 存"></li>
    </ul>
  </div>
</div>





</body>
</html> 