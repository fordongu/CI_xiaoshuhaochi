<?php $this->load->view('main/new_header');?>
<link rel="stylesheet" href="/jquery-ui/css/smoothness/jquery-ui-1.10.0.custom.min.css" media="screen" />
<link rel="stylesheet" href="/resource/css/plugin/jquery-ui-timepicker-addon.css" media="screen" />    
<script type="text/javascript" src="/resource/js/plugin/operamasks-ui.min.js"></script>
<script type="text/javascript" src="/jquery-ui/js/jquery-ui-1.10.0.custom.min.js"></script> 
<script type="text/javascript" src="/resource/js/plugin/timepicker/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="/resource/js/plugin/timepicker/jquery-ui-timepicker-zh-CN.js"></script>
<script type="text/javascript" src="/resource/js/plugin/timepicker/jquery-ui-sliderAccess.js"></script>
<style>
.edit_input{
	display:none;
}
</style>
<script>

function GetRTime(){
  var EndTime=$('#hidden_time').val(); 
  
  var NowTime = new Date();
  var nMS =EndTime - NowTime.getTime(); 
  var nS=Math.floor(nMS/1000) % 60;
   
    var str =nS+'秒后获取';
 
    if(nS == 0){
      $("#send_div").hide();
	$('#send_code').show();
	 $("#send_code").attr('disabled',false); 
  }else{
    $('#send_div').html(str);
  }
  setTimeout("GetRTime()",1000);
}

  $(document).ready(function(){
    /*$('#tu_birthday').datepicker({ changeMonth: true, 
        changeYear: true,});*/

    $('.click_input').click(function(){
        var name = $(this).closest('div').attr('data_val'); 
        var flag = $(this).prev('.noto').children('input').attr('name');
         
        if(flag == undefined){
          var v = $(this).closest('div').children('.noto').html();
          var uid = $(this).closest('div').attr('data_id');
          var input = "<input type='text' name='"+name+"' data_id='"+uid+"' value='"+v+"' style='width:250px;' id='"+name+"' />";
          $(this).prev('.noto').html(input);
          $(this).hide();
          $(this).next('span').show();
          $('#verify_li').show();
        }
     })

      $(".edit_input").click(function() {
              //var $input = $(this).prev('span').prev('.noto').children('input');
              var val = $("#tu_mobile").val();  
                 
              var field = "tu_mobile";
              var uid = $("#uid").val();
              var mobile_code = $("#mobile_code").val();
              if(!mobile_code){
                alert('请输入验证码',1);
                return false;
            }
          //post表单提交
              $.post("/member/ajax_update_user",{val:val,field:field,uid:uid,mobile_code:mobile_code},function(data) {
          
                  if(data.success=='yes'){
                      alert("修改成功");
              window.location.reload();
                  }else{
                   alert(data.msg,1);    
                  }
              },"json");
          }) 
          
          $("#tu_birthday_span").click(function() {
              var val = $(this).prev('input').val();     
              var field = $(this).prev('input').attr('name');
              var uid = $(this).prev('input').attr('data_id'); 
          //post表单提交
              $.post("/member/ajax_update_user",{val:val,field:field,uid:uid},function(data) {
                alert_frame(data.msg,1);
                  if(data.success=='yes'){
				  window.location.reload();
                  }
              },"json");
          }) 
      $('.gender_eric').click(function(){
      var sex = $(this).val();
      var uid = $(this).parents('div').attr('data_id');
      $.post("/member/ajax_update_user",{val:sex,field:'tu_gender',uid:uid},function(data) {
              alert_frame(data.msg,1);
                if(data.success=='yes'){
            window.location.reload();
                }
            },"json");
      }) 
          
          
//修改密码
    $('#save_address').click(function(){
        var opassword = $('#opassword').val();
        var new_password = $('#new_password').val();
        var confirm_password = $('#confirm_password').val();
        if(opassword == ''){
          $('#opassword').next('span').html('请输入原密码');
          return false;
        }else{
          $('#opassword').next('span').html('');
        }
        if(new_password == ''){
            $('#new_password').next('span').html('请输入新密码');
            return false;
          }else{
            $('#new_password').next('span').html('');
          }
        if(confirm_password == ''){
            $('#confirm_password').next('span').html('请输入确认密码');
            return false;
          }else{
            $('#confirm_password').next('span').html('');
          }
        if(confirm_password != new_password){
            $('#confirm_password').next('span').html('密码不一致');
            return false;
          }else{
            $('#confirm_password').next('span').html('');
          }
    var submit_data = {
          opassword:opassword,
          new_password:new_password
        };
        $.post("/member/ajax_update_user_password",submit_data,function(data) {
          alert_frame(data.msg,1);
             if(data.success=='yes'){
          window.location.reload();
            }
        },"json");
        
      })



      $('#send_code').click(function(){
         
           var mobile_email = $("#mobile_span").children('input').val();
          
           var url = '/main/send_mobile_sms/1';
          
          var v = /^(((13[0-9]{1})|(15[0-9]{1})|(14[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
          var submitData={
               mobile : mobile_email 
             };
            
          if(!mobile_email){
                $('#mobile_span').children('input').attr('placeholder','手机号码不能空');
                return false;
              } 
            
              if(!v.test(mobile_email)){ 
               
                 $('#mobile_span').children('input').val('请输入正确的手机号');
                   return false;
              }else{
              
                    var NowTime2 = new Date();
                var EndTime= NowTime2.getTime()+60*60*300; 
              $('#hidden_time').val(EndTime); 
               GetRTime();
              $("#send_code").hide();
               $('#send_div').show(); 
              
              } 
           $("#send_code").attr('disabled',true); 
          $.post(url,submitData,function(data){
           
             if(data.success == 'yes'){
               
             }else{
               alert_frame(data.msg,1);
              $("#send_div").hide();
              $('#send_code').show();
             }          
          },"json");
          })

            
  })
</script>

<?php $user_cookie = isset($_COOKIE['user_cookie'])?$_COOKIE['user_cookie']:'';
      if($user_cookie){
        $user_cookie = unserialize($user_cookie);       
        $user = $this->tickets->select('users',array('tu_id'=>$user_cookie->tu_id));
        $user_cookie = $user[0];
      } 
?>
  <!-- member_menu -->
<div class="main_member_aside">
    <?php echo $this->load->view('member/member_left');?>

  <!-- member_menu_end --> 
  <input type="hidden" id="uid" value="<?php echo $uid;?>">
  <input type="hidden" value="" id="hidden_time" /> 
  <div class="main_member_right main_member_index">
      <!-- base_info --> 
       <div class="member_base_info_eric main_member_content_top">
         <div class="main_member_title">
           <span></span>
          <h4>基本信息</h4>
        </div>
       
       <ul id="user_info_ul_eric">
         <li>
           <div class="base_info_title_eric float_left">性别：</div> <div class="base_info_input_eric float_left" data_id="<?php echo $user_cookie->tu_id;?>">
           <input type="radio" name="gender" class="gender_eric" <?php if($user_cookie->tu_gender==0){?>checked=true<?php }?> value="0"/>男&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="gender"  class="gender_eric" value="1" <?php if($user_cookie->tu_gender==1){?>checked=true<?php }?>  />女</div>  
         </li> 
         <!--<li style="margin-left:-60px;" id="birthday_li" >
           <div class="base_info_title_eric float_left" style="height:45px !important;line-height:45px !important;">生日：</div>
           <div class="base_info_input_eric float_left" style="height:45px !important;line-height:45px !important;">
             <input style="border-bottom:1px solid #ccc;" type="text" name="tu_birthday" id="tu_birthday" data_id="<?php echo $user_cookie->tu_id;?>" data_val="tu_birthday"  value="<?php echo $user_cookie->tu_birthday;?>" />
             <button style="color:#fff;background:#FFAF00;padding:5px 10px;border-radius:5px;"  class="cursor_pointer_eric" id="tu_birthday_span">保存</button>
             </div>  
         </li>-->
         <!--
		 <li>
           <div class="base_info_title_eric float_left">邮箱：</div> 
           <div class="base_info_input_eric float_left" data_id="<?php echo $user_cookie->tu_id;?>" data_val="tu_email">
             <span class="noto"><?php echo $user_cookie->tu_email;?></span>
             &nbsp;&nbsp;&nbsp;&nbsp;<button class="click_input cursor_pointer_eric">修改</button><button class="edit_input cursor_pointer_eric">保存</button>
           </div>  
         </li>
         -->
		 <li>
           <div class="base_info_title_eric float_left" >手机号码：</div>
             <div class="base_info_input float_left" data_id="<?php echo $user_cookie->tu_id;?>" data_val="tu_mobile">
               <span class="noto" id="mobile_span"><?php echo $user_cookie->tu_mobile;?></span>
               <button class="click_input cursor_pointer">修改</button><span  class="edit_input cursor_pointer">保存</span>
              </div>  
         </li>
         <li id="verify_li" style="display:none;">
           <div class="base_info_title_eric float_left">验证码：</div> 
           <div class="base_info_input_eric float_left">
             <input type="text" id="mobile_code" placeholder="填写验证码"/>
             &nbsp;&nbsp;<button id="send_code" class="cursor_pointer_eric">发送验证码</button>
             			<span id="send_div" class="cursor_pointer_eric"></span>
             			 
           </div>  
         </li>
         <!--<li style="margin-left:-35px;">
           <div class="base_info_title_eric float_left">注册时间：</div> <div class="base_info_input_eric float_left"><?php echo date('Y年m月d日 H:i',strtotime($user_cookie->tu_created));?></div>  
         </li>-->
        <?php if($user_cookie->tu_qq_nickname){?>  
         <li>
           <div class="base_info_title_eric float_left">QQ昵称：</div> <div class="base_info_input_eric float_left"><?php echo $user_cookie->tu_qq_nickname;?></div>  
         </li>
        <?php }?> 
       <?php if($user_cookie->tu_weibo_nickname){?> 
        <li>
           <div class="base_info_title_eric float_left">微博昵称：</div> <div class="base_info_input_eric float_left"><?php echo $user_cookie->tu_weibo_nickname;?></div>  
         </li>
       <?php }?>   
       </ul>    
      </div>    
     <!-- base_info -->
      
	  <div class="clear"></div>
  </div>
</div>   

</div>
<div class="clear"></div>
 <?php $this->load->view('main/new_footer');?>
</body>
</html> 