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
<title>单个优惠券发放</title>
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
			rules: {
				uid: {required: true},
				count:{required:true}
			},
			messages: {
				uid: {required: "用户ID必填"},
				count:{required:"发放张数必填"}
			},
			showErrors: function(errorMap, errorList) {
				if (errorList && errorList.length > 0) {
					$.each(errorList,
					function(index, obj) {
						var item = $(obj.element);
						if(item.is(".cover")){
							alert(obj.message);
						}
						// 给输入框添加出错样式
						item.closest(".control-group").addClass('error');
						item.attr("title",obj.message);
					});
				} else {
					var item = $(this.currentElements);
					item.closest(".control-group").removeClass('error');
					item.removeAttr("title");
				}
			},
			
			submitHandler: function() {
				 
				var $form = $("#appmsg-form");
				var $btn = $("#save-btn");
				if($btn.hasClass("disabled")) return;
				var submitData = { 
						uid:$("#uid").val(),
						coupon_id:$("#coupon_id").val(),
						count:$("#count").val(),
				};
				$btn.addClass("disabled");
				$.post('/admin/coupon_send_single', submitData,function(data) {
					$btn.removeClass("disabled");
					if (data.success == 'yes') {
						alert("发放成功");
						location.href = "/admin/coupon";
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
						<label class="control-label">用户ID</label>    
						    <div class="controls">
								<input type="text" name="uid" id="uid"  value="" />
							</div>
						</div> 
						
						
						<div class="control-group">
						<label class="control-label">优惠券类型</label>    
						    <div class="controls">
								<select name="coupon_id" id="coupon_id">
								   <?php foreach($coupons as $k=>$v){?>
								      <option value="<?php echo $v->tc_id;?>" ><?php echo $coupons_types[$v->tc_title];?></option>
								   <?php }?>
								</select>
							</div>
						</div>  
						
						<div class="control-group">
						<label class="control-label">发放张数</label>    
						    <div class="controls">
								<input type="text" name="count" id="count"  value="" />
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