<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<link rel="stylesheet" href="<?php echo base_url();?>/bootstrap/css/bootstrap.min.css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>/resource/css/admin/admin.css" media="screen" />   
<script type="text/javascript" src="<?php echo base_url();?>/resource/js/jquery-1.7.2.min.js"></script>  
<script type="text/javascript" src="<?php echo base_url();?>resource/js/plugin/operamasks-ui.min.js"></script> 
<title>代金券设置</title>

<script type="text/javascript">
$(function(){ 
	var $btn=$("#save_btn");
var $form=$("#changpwdform");
//验证表单
$validator=$form.validate({
	rules:{
		role_id:{required:true},
		username:{required:true}  
	},
	messages:{
		role_id:{required:"角色必选"},
		username:{required:"用户名必填"} 
	}, 
	 submitHandler:function(){
	   var m_id = $("input[name='m_id']",$form).val();
	   var password = $.trim($("input[name='password']",$form).val());
	   var repassword = $.trim($("input[name='repassword']",$form).val());
	   if(m_id !=0){
		  
		  if(password != ''){ 
			 
			  if(repassword == ''){
					alert('请输入重复密码');return false;
				  }
			
			  if(password != repassword){
				  alert('密码不一致');return false;
			  }
		  }
	   }else{
		   if(password == ''){
				alert('请输入密码');return false;
			 }

		  
			  if(repassword == ''){
				  alert('请输入重复密码');return false;
				  }
			
			  if(password != repassword){
				  alert('密码不一致');return false;
			  }
	   }	 
		var submitData={
			role_id:$("select[name='role_id']",$form).val(),
			username:$("input[name='username']",$form).val(),
			password:$("input[name='password']",$form).val(), 
			m_id:$("input[name='m_id']",$form).val()
		};
		$btn.addClass("disabled"); 
		
		 $.post('/admin/admin_add',submitData,function(data){
			 window.location.href="/admin/admin_index";
		},"json");
		return false;			
	}
}); 
	});
	
</script>
</head>
<body>
<style type="text/css">
.error {
    color: red;
}
</style>
<br /><br />
<form id="changpwdform" class="form-horizontal" action="#">
<input type="hidden" id="m_id" name="m_id" value="<?php if ($member){ echo $member->m_id; }else{?>0<?php }?>" />
<div class="control-group">
	<label class="control-label"  for="keyword">角色：</label>
	<div class="controls">
	    <select name="role_id" id="role_id">
	       <?php foreach($roles as $k=>$v){?>
	          <option value="<?php echo $v->id;?>" <?php if ($member&&($member->role_id == $v->id)){?>selected=true <?php }?>><?php echo $v->role_name;?></option>
	       <?php }?>
	    </select> 
	    
	</div>
</div>

<div class="control-group">
	<label class="control-label"  for="keyword">用户名：</label>
	<div class="controls">
	   <input id="username" type="text" value="<?php if ($member){ echo $member->username; }?>"  name="username">
	</div>
</div>
 
<div class="control-group">
	<label class="control-label"  for="keyword">密码：</label>
	<div class="controls">
	   <input id="password" type="text" value=""  name="password">
	</div>
</div>

<div class="control-group">
	<label class="control-label"  for="keyword">重复密码：</label>
	<div class="controls">
	   <input id="repassword" type="text" value=""  name="repassword">
	</div>
</div>
 

<div class="control-group">
	<div class="controls">
	   <button id="save_btn" class="btn btn-primary btn-large" type="submit">保存</button>
	</div>
</div>
</form>
</body>
</html>