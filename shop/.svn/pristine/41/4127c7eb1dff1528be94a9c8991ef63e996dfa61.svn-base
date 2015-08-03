<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/admin.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery-ui-1.10.0.custom.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery-ui-timepicker-addon.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/appmsg.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/coupon-setting.css" />
<link rel="stylesheet" href="<?php echo base_url();?>jquery-ui/css/uploadify.css" media="screen" />
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>jquery-ui/js/jquery.uploadify.min.js"></script><script type="text/javascript" src="<?php echo base_url();?>resource/js/plugin/operamasks-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>resource/js/plugin/operamasks-ui.min.js"></script>
<title>修改密码</title>
</head>
<body>
<style type="text/css">
.error {
    color: red;
}
</style>
<br /><br />
<form id="changpwdform" class="form-horizontal" action="#">
<div class="control-group">
<label class="control-label"  for="keyword">用户名：</label>
<div class="controls">
<input id="username" type="text" value="<?php echo $user->username; ?>" readonly="" name="username">
</div>
</div>
<div class="control-group">
<label class="control-label" for="keyword">原始密码：</label>
<div class="controls">
<input id="password" type="password"  name="password">
</div>
</div>
<div class="control-group">
<label class="control-label" for="keyword">新密码：</label>
<div class="controls">
<input id="newpassword" type="password"  name="newpassword">
</div>
</div>

<div class="control-group">
<div class="controls">
<button id="save_btn" class="btn btn-primary btn-large" type="submit">保存修改</button>
</div>
</div>
</form>

<script type="text/javascript">
$(function(){
		var $btn=$("#save_btn");
	var $form=$("#changpwdform");
	//验证表单
	$validator=$form.validate({
		rules:{
			password:{required:true},
			newpassword:{required:true}
		},
		messages:{
			password:{required:"请输入您原始注册的密码"},
			newpassword:{required:"请输入您的新密码",}	
		},
		 
	 submitHandler:function(){
		var submitData={
			password:$("input[name='password']",$form).val(),
			newpassword:$("input[name='newpassword']",$form).val(),	
		};
		$btn.addClass("disabled"); 
		 $.post('/main/reset_password/',submitData,function(data){
			$btn.removeClass("disabled");
			if(data.success=="yes"){
				alert("修改密码成功请记住您的新密码"+$("input[name='newpassword']",$form).val());
				window.location.reload();
			}else{
			    alert("原始密码错误");
			}
		},"json");
			return false;
			}
			}); 
});
	
</script>
</body>
</html>