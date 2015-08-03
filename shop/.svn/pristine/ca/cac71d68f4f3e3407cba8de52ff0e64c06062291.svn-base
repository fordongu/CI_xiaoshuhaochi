<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css" media="screen" />
<link rel="stylesheet" href="/resource/css/admin/admin.css" media="screen" />
<link rel="stylesheet" href="/resource/css/admin/appmsg.css" media="screen" /> 
<script type="text/javascript" src="/resource/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/resource/js/plugin/operamasks-ui.min.js"></script> 
<title>相关配置</title>
<style>
label{
	display: inline-block;
}
.help-inline{
	vertical-align: top;
}
.row{
	padding-top: 20px;
	padding-bottom: 20px;
}
</style>
</head>
<script>
 $(function(){
var validator = $("#appmsg-form").validate({
 
			submitHandler: function() {
				 
				var $form = $("#appmsg-form");
				var $btn = $("#save-btn");
				if($btn.hasClass("disabled")) return;
				var submitData = {
						field1: $("#field1").val(),
						field2:$("#field2").val(),
						field3:$("#field3").val(),
						field4:$("#field4").val(),
						field5:$("#field5").val()
				};
				$btn.addClass("disabled");
				$.post('/admin/weichat_settings', submitData,function(data) {
					$btn.removeClass("disabled");
					if (data.success == 'yes') {
						alert("保存成功");
						location.href = "/admin/weichat_settings";
					}  else{
							alert("保存失败");						 
					}
				},"json");
				return false;
			}
		}); 
 })
</script>
<body>
	<div class="row">

		<div class="span7">
			<div class="msg-editer-wrapper">
				<div class="msg-editer">
					<form id="appmsg-form" class="form">
						 
					  	<div class="control-group">
						<label class="control-label">微信公共账号</label>    
						    <div class="controls">
								<input type="text" name="field1"  value="<?php if($system_help){echo $system_help->field1;}?>" id="field1" style="width:300px;"> 
							</div>
						</div>
						<div class="control-group">
						<label class="control-label">微信公共账号密码</label>    
						    <div class="controls">
								<input type="text" name="field2"  value="<?php if($system_help){echo $system_help->field2;}?>" id="field2" style="width:300px;"> 
							</div>
						</div>
						<div class="control-group">
						<label class="control-label">AppID</label>    
						    <div class="controls">
								<input type="text" name="field3"  value="<?php if($system_help){echo $system_help->field3;}?>" id="field3"> 
							</div>
						</div>
						
						<div class="control-group">
						<label class="control-label">AppSecret</label>    
						    <div class="controls">
								<input type="text" name="field4"  value="<?php if($system_help){echo $system_help->field4;}?>" id="field4" style="width:300px;"> 
							</div>
						</div>
						
						<div class="control-group">
						<label class="control-label">微信原始ID</label>    
						    <div class="controls">
								<input type="text" name="field5"  value="<?php if($system_help){echo $system_help->field5;}?>" id="field5" style="width:300px;"> 
							</div>
						</div>
						 
					  	<div class="control-group">
						    <div class="controls">
						      <button id="save-btn" type="submit" class="btn btn-primary btn-large">保存</button>
						      <button id="cancel-btn" type="button" class="btn btn-large">取消</button>
						      						    </div>
					    </div>
					</form> 
				</div>
				<span class="abs msg-arrow a-out" style="margin-top: 0px;"></span>
				<span class="abs msg-arrow a-in" style="margin-top: 0px;"></span>
			</div>
		</div>
	</div>
</body>
</html>