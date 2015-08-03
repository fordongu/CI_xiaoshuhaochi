<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="/css/bootstrap.min.css" />
<link rel="stylesheet" href="/css/admin.css" />
<link rel="stylesheet" href="/css/jquery-ui-1.10.0.custom.min.css" />
<link rel="stylesheet" href="/css/jquery-ui-timepicker-addon.css" />
<link rel="stylesheet" href="/css/appmsg.css" />
<link rel="stylesheet" href="/css/coupon-setting.css" />
<link rel="stylesheet" href="/jquery-ui/css/uploadify.css" media="screen" />
<script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/jquery-ui/js/jquery.uploadify.min.js"></script><script type="text/javascript" src="/resource/js/plugin/operamasks-ui.min.js"></script>
<script type="text/javascript" src="/resource/js/plugin/operamasks-ui.min.js"></script>
<title>自定义菜单设置</title>
</head>
<body>
<style type="text/css">
.error {
    color: red;
}
</style>
<br /><br />
<form id="changpwdform" class="form-horizontal" action="#">
<input type="hidden" id="me_id" name="me_id" value="<?php echo $me_id; ?>" />
<input type="hidden" id="main_id" name="main_id" value="<?php echo $main_id; ?>" />
<div class="control-group">
	<label class="control-label"  for="keyword">按钮名称：</label>
	<div class="controls">
	   <input id="main_menu" type="text" readonly="" value="<?php if (isset($main_menu_settings)){ echo $main_menu_settings->tms_main_menu; }?>"  name="main_menu">
	</div>
</div>
<div class="control-group">
	<label class="control-label"  for="keyword">按钮关键字：</label>
	<div class="controls">
	   <input id="main_key" type="text" readonly="" value="<?php if (isset($main_menu_settings)){ echo $main_menu_settings->tms_main_key; }?>"  name="main_key">
	</div>
</div>
<div class="control-group">
	<label class="control-label"  for="keyword">子按钮名称：</label>
	<div class="controls">
	   <input id="sub_menu" type="text"  value="<?php if (isset($menu_settings)){ echo $menu_settings->tms_sub_menu; }?>"  name="sub_menu">
	</div>
</div>
<div class="control-group">
	<label class="control-label"  for="keyword">子按钮类型：</label>
	<div class="controls">
	   <select name="sub_type">
		     <option value="click" <?php if (isset($menu_settings)){ if($menu_settings->tms_sub_type=='click'){?> selected<?php } }?> >触发关键词</option>
		     <option value="view" <?php if (isset($menu_settings)){ if($menu_settings->tms_sub_type=='view'){?> selected<?php } }?>>跳转网页</option>
	   </select>
	</div>
</div>

<div class="control-group">
	<label class="control-label"  for="keyword">子按钮关键字：</label>
	<div class="controls">
	   <input id="sub_key" type="text" value="<?php if (isset($menu_settings)){ echo $menu_settings->tms_sub_key; }?>"  name="sub_key">
	</div>
</div>

<div class="control-group">
	<label class="control-label"  for="keyword">子跳转网页：</label>
	<div class="controls">
	   <input id="sub_url" type="text" value="<?php if (isset($menu_settings)){ echo $menu_settings->tms_sub_url; }?>"  name="sub_url">
	</div>
</div>

<div class="control-group">
	<div class="controls">
	   <button id="save_btn" class="btn btn-primary btn-large" type="submit">保存</button>
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
		sub_menu:{required:true}  
	},
	messages:{
		sub_menu:{required:"子菜单必填"} 
	}, 
	 submitHandler:function(){
		var submitData={
			main_menu:$("input[name='main_menu']",$form).val(),
			main_key:$("input[name='main_key']",$form).val(),
			main_id:$("input[name='main_id']",$form).val(),
			me_id:$("input[name='me_id']",$form).val(),
			sub_menu:$("input[name='sub_menu']",$form).val(),
		    sub_key:$("input[name='sub_key']",$form).val(),
		    sub_url:$("input[name='sub_url']",$form).val(),
		    sub_type:$("select[name='sub_type']",$form).val()
		};
		$btn.addClass("disabled"); 
		 $.post('/admin/sub_menu_settings_add',submitData,function(data){
			$btn.removeClass("disabled");
			if(data.success=="token"){
				alert('此菜单已经被使用过');
			}else if(data.success=="yes")
			{
			   location.href="/admin/menu_settings_index";
			}
			
			else
			{
			   alert("修改失败错误的填写信息");
			}
		},"json");
		return false;			
	}
}); 
	});
	
</script>
</body>
</html>