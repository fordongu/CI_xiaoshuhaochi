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
<script type="text/javascript" src="<?php echo base_url();?>jquery-ui/js/jquery.uploadify.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>resource/js/plugin/operamasks-ui.min.js"></script>
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
<input type="hidden" id="main_id" name="main_id" value="<?php if (isset($menu_settings)){ echo $menu_settings->tms_id; }else{?>0<?php }?>" />
<div class="control-group">
	<label class="control-label"  for="keyword">按钮名称：</label>
	<div class="controls">
	   <input id="main_menu" type="text" value="<?php if (isset($menu_settings)){ echo $menu_settings->tms_main_menu; }?>"  name="main_menu">
	</div>
</div>

<div class="control-group">
	<label class="control-label"  for="keyword">按钮类型：</label>
	<div class="controls">
	   <select name="main_type">
		     <option value="click" <?php if (isset($menu_settings)){ if($menu_settings->tms_main_type=='click'){?> selected<?php } }?> >触发关键词</option>
		     <option value="view" <?php if (isset($menu_settings)){ if($menu_settings->tms_main_type=='view'){?> selected<?php } }?>>跳转网页</option>
	   </select>
	</div>
</div>

<div class="control-group">
	<label class="control-label"  for="keyword">关键字：</label>
	<div class="controls">
	   <input id="main_key" type="text" value="<?php if (isset($menu_settings)){ echo $menu_settings->tms_main_key; }?>"  name="main_key">
	</div>
</div>

<div class="control-group">
	<label class="control-label"  for="keyword">跳转网页：</label>
	<div class="controls">
	   <input id="main_url" type="text" value="<?php if (isset($menu_settings)){ echo $menu_settings->tms_main_url; }?>"  name="main_url">
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
		main_menu:{required:true}  
	},
	messages:{
		main_menu:{required:"菜单必填"} 
	}, 
	 submitHandler:function(){
		var submitData={
			main_menu:$("input[name='main_menu']",$form).val(),
			main_key:$("input[name='main_key']",$form).val(),
			main_id:$("input[name='main_id']",$form).val(),
			main_type:$("select[name='main_type']",$form).val(),
			main_url:$("input[name='main_url']",$form).val(),
		};
		$btn.addClass("disabled"); 
		 $.post('/admin/menu_settings_add',submitData,function(data){
			$btn.removeClass("disabled");
			if(data.success=="token"){
				alert('此菜单已经被使用过');
			}else if(data.success=="yes")
			{
			   alert('保存成功');
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