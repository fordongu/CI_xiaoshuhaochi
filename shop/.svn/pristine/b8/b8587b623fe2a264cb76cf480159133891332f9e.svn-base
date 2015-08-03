<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<link rel="stylesheet" href="<?php echo base_url();?>/bootstrap/css/bootstrap.min.css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>/resource/css/admin/admin.css" media="screen" />   
<script type="text/javascript" src="/resource/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/resource/js/plugin/operamasks-ui.min.js"></script>
<title>权限设置</title>
 
</head>
<body>
<style type="text/css">
.error {
    color: red;
}
</style>
<script type="text/javascript">
$(function(){
	var validator = $("#tform").validate({
		rules: {
			role_name: {required: true}
		},
		messages: {
			role_name: {required: "请输入角色名"}
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
		}
		 
	}); 
});

</script>
<br /><br />
<form id="tform" class="form-horizontal" action="/admin/authority_add" method="post">
<input type="hidden" id="id" name="id" value="<?php if ($oauth){ echo $oauth->id; }else{?>0<?php }?>" />

<div class="control-group">
	<label class="control-label"  for="keyword">角色名：</label>
	<div class="controls">
	   <input id="role_name" type="text" value="<?php if ($oauth){ echo $oauth->role_name; }?>"  name="role_name">
	</div>
</div>

<div class="control-group">
	<label class="control-label"  for="keyword">智能客服：</label>
	<div class="controls">
	    <input type="checkbox" value="auto_service" name="oauth[]"  <?php if($oauth&&(in_array('auto_service',$oauth->oauth))){?>checked<?php }?> /> 首次关注微信回复
	    <input type="checkbox" value="single_list" name="oauth[]" <?php if($oauth&&(in_array('single_list',$oauth->oauth))){?>checked<?php }?> /> 图文回复
	</div>
</div>

<div class="control-group">
	<label class="control-label"  for="keyword">商城管理：</label>
	<div class="controls">
	   <input type="checkbox" value="category_index" name="oauth[]"  <?php if($oauth&&(in_array('category_index',$oauth->oauth))){?>checked<?php }?> /> 菜品品类管理
	    <input type="checkbox" value="supplier_index" name="oauth[]" <?php if($oauth&&(in_array('supplier_index',$oauth->oauth))){?>checked<?php }?> /> 供应商管理
	    <input type="checkbox" value="areas" name="oauth[]" <?php if($oauth&&(in_array('areas',$oauth->oauth))){?>checked<?php }?> /> 省市区管理
	    <input type="checkbox" value="service_buildings_index" name="oauth[]" <?php if($oauth&&(in_array('service_buildings_index',$oauth->oauth))){?>checked<?php }?> /> 配送区域管理
	    <input type="checkbox" value="good_index" name="oauth[]" <?php if($oauth&&(in_array('good_index',$oauth->oauth))){?>checked<?php }?> /> 菜品管理
	    <input type="checkbox" value="order_index" name="oauth[]" <?php if($oauth&&(in_array('order_index',$oauth->oauth))){?>checked<?php }?> /> 订单管理
	</div>
</div>


<div class="control-group">
	<label class="control-label"  for="keyword">优惠券管理：</label>
	<div class="controls">
	   <input type="checkbox" value="coupon" name="oauth[]" <?php if($oauth&&(in_array('coupon',$oauth->oauth))){?>checked<?php }?> /> 优惠券管理
	</div>
</div>


<div class="control-group">
	<label class="control-label"  for="keyword">后台权限管理：</label>
	<div class="controls">
	   <input type="checkbox" value="admin_oauth" name="oauth[]" <?php if($oauth&&(in_array('admin_oauth',$oauth->oauth))){?>checked<?php }?> /> 角色权限管理
	   <input type="checkbox" value="admin_index" name="oauth[]" <?php if($oauth&&(in_array('admin_index',$oauth->oauth))){?>checked<?php }?> /> 后台用户管理
	</div>
</div>


<div class="control-group">
	<label class="control-label"  for="keyword">用户管理：</label>
	<div class="controls">
	   <input type="checkbox" value="user_list" name="oauth[]" <?php if($oauth&&(in_array('user_list',$oauth->oauth))){?>checked<?php }?> /> 用户列表
	   <input type="checkbox" value="company_index" name="oauth[]" <?php if($oauth&&(in_array('company_index',$oauth->oauth))){?>checked<?php }?> /> 企业用户列表
	   <input type="checkbox" value="event_index" name="oauth[]" <?php if($oauth&&(in_array('event_index',$oauth->oauth))){?>checked<?php }?> /> 活动列表
	   
	</div>
</div>


<div class="control-group">
	<label class="control-label"  for="keyword">相关配置：</label>
	<div class="controls">
	   <input type="checkbox" value="sms_config" name="oauth[]" <?php if($oauth&&(in_array('sms_config',$oauth->oauth))){?>checked<?php }?> /> 短信配置
	   <input type="checkbox" value="jifen_bili_config" name="oauth[]" <?php if($oauth&&(in_array('jifen_bili_config',$oauth->oauth))){?>checked<?php }?> /> 积分比例配置
	   <input type="checkbox" value="payment_index" name="oauth[]" <?php if($oauth&&(in_array('payment_index',$oauth->oauth))){?>checked<?php }?> /> 支付开关
	   <input type="checkbox" value="reset_password" name="oauth[]" <?php if($oauth&&(in_array('reset_password',$oauth->oauth))){?>checked<?php }?> /> 修改密码
	   <input type="checkbox" value="menu_settings_index" name="oauth[]" <?php if($oauth&&(in_array('menu_settings_index',$oauth->oauth))){?>checked<?php }?> /> 自定义菜单配置
	   <input type="checkbox" value="weichat_settings" name="oauth[]" <?php if($oauth&&(in_array('weichat_settings',$oauth->oauth))){?>checked<?php }?> /> 微信账号相关配置
	   <input type="checkbox" value="order_time_settings" name="oauth[]" <?php if($oauth&&(in_array('order_time_settings',$oauth->oauth))){?>checked<?php }?> /> 下单时间配置
	   <input type="checkbox" value="order_date" name="oauth[]" <?php if($oauth&&(in_array('order_date',$oauth->oauth))){?>checked<?php }?> /> 下单提前天数管理
	   <input type="checkbox" value="order_count" name="oauth[]" <?php if($oauth&&(in_array('order_count',$oauth->oauth))){?>checked<?php }?> /> 订单商品份数管理
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