<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css" media="screen" />
<link rel="stylesheet" href="/resource/css/admin/admin.css" media="screen" />
<link rel="stylesheet" href="/jquery-ui/css/smoothness/jquery-ui-1.10.0.custom.min.css" media="screen" />
<link rel="stylesheet" href="/resource/css/plugin/jquery-ui-timepicker-addon.css" media="screen" />
<link rel="stylesheet" href="/resource/css/admin/appmsg.css" media="screen" />
<link rel="stylesheet" href="/resource/css/admin/coupon-setting.css" media="screen" />
<link rel="stylesheet" href="/jquery-ui/css/uploadify.css" media="screen" />
<script type="text/javascript" src="/resource/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/resource/js/plugin/operamasks-ui.min.js"></script>
<script type="text/javascript" src="/jquery-ui/js/jquery-ui-1.10.0.custom.min.js"></script> 
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
						content:$("#content").val(),
						title:$("#title").val(),
						extra:$("#extra").val(),
				};
				$btn.addClass("disabled");
				$.post('/admin/jifen_bili_config', submitData,function(data) {
					$btn.removeClass("disabled");
					if (data.success == 'yes') {
						alert("保存成功");
						location.href = "/admin/jifen_bili_config";
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
						<label class="control-label">积分兑换比例</label>    
						    <div class="controls">
								<input type="text" name="title" id="title"  value=" <?php if($configs){ echo $configs->tc_title; }?>" />  <span>1块钱兑换积分数</span>
							</div>
						</div> 
						
						
						<div class="control-group">
						<label class="control-label">优惠券积分兑换比例</label>    
						    <div class="controls">
								<input type="text" name="extra" id="extra"  value=" <?php if($configs){ echo $configs->tc_extra; }?>" />  <span>1块钱优惠券兑换积分数</span>
							</div>
						</div>  
						
						<div class="control-group">
						<label class="control-label">客服电话</label>    
						    <div class="controls">
								<input type="text" name="content" id="content"  value=" <?php if($configs){ echo $configs->tc_content; }?>" />
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