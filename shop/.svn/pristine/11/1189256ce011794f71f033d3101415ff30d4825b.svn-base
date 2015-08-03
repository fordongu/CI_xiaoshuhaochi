<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css" media="screen" />
<link rel="stylesheet" href="/resource/css/admin/admin.css" media="screen" />  
<script type="text/javascript" src="/resource/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/resource/js/plugin/operamasks-ui.min.js"></script> 
<style>
.count{
		background-color: #FFEFAF;
		line-height: 30px;
		margin-bottom: 10px;
}
.member-count{
	margin: 0 50px 0 10px;
}
.info-block{
	text-align: center;
}
.statu_frozen{
	color: red;
}
</style>
<title>用户管理</title>
</head>
<body>
 <form class="form-horizontal"  id="tform" action="#">
		 
		<fieldset>
		   
			<legend><?php if ($id){?>修改用户<?php }else{?>新增用户<?php }?></legend>
			 <input type="hidden" value="<?php if($id){echo $id;}else{ echo 0;}?>" name="tu_id" />
			
			<div class="control-group">
				<label class="control-label" for="option1">用户名:</label>
				<div class="controls">
					<input type="text" id="tu_nickname" name="tu_nickname" <?php if($user){?> value="<?php echo $user->tu_nickname; ?>" <?php }?>>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="option1">电话:</label>
				<div class="controls">
					<input type="text" id="tu_mobile" name="tu_mobile" <?php if($user){?> value="<?php echo $user->tu_mobile; ?>" <?php }?>> 
				</div>
			</div>	
			
			<div class="control-group" style="display:none;">
				<label class="control-label" for="option1">email:</label>
				<div class="controls">
					<input type="text" id="tu_email" name="tu_email" <?php if($user){?> value="<?php echo $user->tu_email; ?>" <?php }?>>  
				</div>
			</div>	
			
			<div class="control-group">
				<label class="control-label" for="option1">性别:</label>
				<div class="controls">
					女：<input type="radio" name="tu_gender" value="1" <?php if($user&&$user->tu_gender){?>checked<?php }?>/>男：<input type="radio" name="tu_gender" value="0"  <?php if($user&&(!$user->tu_gender)){?>checked<?php }?>/>
				</div>
			</div>
			<div class="control-group" style="display:none;">
				<label class="control-label" for="option1">写字楼:</label>
				<div class="controls">
				    <select name="tu_service_building" id="tu_service_building">
				     <?php if($service_building){
				             foreach($service_building as $k=>$v){
				     	?> 
				     	 <option value="<?php echo $v->id;?>" <?php if($user&&($user->tu_default_building==$v->id)){?>selected<?php }?>><?php echo $v->name;?></option>
				     <?php }}?>
				    </select>
					 
				</div>
			</div>	 
   		  	<div class="control-group">
			    <div class="controls">
			      
			      <button id="save-btn" type="submit" class="btn btn-primary">保存</button>
			      <button id="back-btn" type="button" class="btn btn-primary" onclick="location.href='/admin/user_list'">返回</button>
			    </div>
		    </div>
		</fieldset>
	</form>
<script type="text/javascript">
$(function(){
	var $btn=$("#save-btn");
	var $form=$("#tform");
	var v = /^13[0-9]{1}[0-9]{8}$|15[01235689]{1}[0-9]{8}$|18[236789]{1}[0-9]{8}$/;
	var email = /^[a-zA-Z0-9_\.]+@[a-zA-Z0-9-]+[\.a-zA-Z]+$/;
	//验证表单
	$validator=$form.validate({
		rules:{
			tu_nickname:{required:true},
			tu_mobile:{required:true},
			tu_service_building:{required:true}
		},
		messages:{
			tu_nickname:{required:'用户名必填'},
			tu_mobile:{required:'手机必填'},
			tu_service_building:{required:'写字楼必选'}
		}, 
		 submitHandler:function(){
			tu_mobile = $("input[name='tu_mobile']",$form).val();
			if(!v.test(tu_mobile)){ 
	    		   alert('请输入正确的手机号');
	  	  		   return false;
		  	  }
		  	 tu_email = $("input[name='tu_email']",$form).val();
		  	 if(tu_email&&(!email.test(tu_email))){
			  		alert('请输入正确的电子邮件');
		  	  		   return false;
			  }
			var submitData={
				tu_nickname:$("input[name='tu_nickname']",$form).val(),
				tu_mobile:tu_mobile,
				tu_email:tu_email, 
				tu_gender:$("input[name='tu_gender']:checked",$form).val(),
				tu_service_building:$("select[name='tu_service_building']",$form).val(), 
				tu_id:$("input[name='tu_id']",$form).val()
			};
			$btn.addClass("disabled"); 
			
			 $.post('/admin/user_add',submitData,function(data){
				 window.location.href="/admin/user_list";
			},"json");
			return false;			
		}
	}); 
});

</script>
</body>	
</html>