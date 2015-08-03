<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<link rel="stylesheet" href="<?php echo base_url();?>/bootstrap/css/bootstrap.min.css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>/resource/css/admin/admin.css" media="screen" />  
<link rel="stylesheet" href="<?php echo base_url();?>/jquery-ui/css/smoothness/jquery-ui-1.10.0.custom.min.css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>/resource/css/plugin/jquery-ui-timepicker-addon.css" media="screen" />
<script type="text/javascript" src="<?php echo base_url();?>/resource/js/jquery-1.7.2.min.js"></script>  
<script type="text/javascript" src="<?php echo base_url();?>resource/js/plugin/operamasks-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/jquery-ui/js/jquery-ui-1.10.0.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/resource/js/plugin/timepicker/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/resource/js/plugin/timepicker/jquery-ui-timepicker-zh-CN.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/resource/js/plugin/timepicker/jquery-ui-sliderAccess.js"></script>
<title>代金券设置</title>

<script type="text/javascript">
$(function(){
	$('#tc_end_time').datetimepicker();
	$('#tc_start_time').datetimepicker();
	var $btn=$("#save_btn");
var $form=$("#changpwdform");
//验证表单
$validator=$form.validate({
	rules:{
		tc_title:{required:true},
		tc_price:{required:true},
		tc_start_time:{required:true} 
	},
	messages:{
		tc_title:{required:"名称必填"},
		tc_price:{required:"面值必填"},
		tc_price:{required:"启用时间必填"} 
	}, 
	 submitHandler:function(){
		 
		var submitData={
			tc_title:$("select[name='tc_title']",$form).val(),
			tc_price:$("input[name='tc_price']",$form).val(),
			tc_desc:$("textarea[name='tc_desc']",$form).val(),
			tc_start_time:$("input[name='tc_start_time']",$form).val(),
			tc_end_time:$("input[name='tc_end_time']",$form).val(),
			tc_sale_price:$("input[name='tc_sale_price']",$form).val(),
			tc_cond_price:$("input[name='tc_cond_price']",$form).val(),
			tc_id:$("input[name='tc_id']",$form).val()
		};
		$btn.addClass("disabled"); 
		
		 $.post('/admin/coupon_add',submitData,function(data){
			 window.location.href="/admin/coupon";
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
<input type="hidden" id="tc_id" name="tc_id" value="<?php if ($coupons){ echo $coupons->tc_id; }else{?>0<?php }?>" />
<div class="control-group">
	<label class="control-label"  for="keyword">名称：</label>
	<div class="controls">
	    <select name="tc_title" id="tc_title">
	       <?php foreach($coupons_types as $k=>$v){?>
	          <option value="<?php echo $k;?>" <?php if ($coupons&&($coupons->tc_title == $k)){?>selected=true <?php }?>><?php echo $v;?></option>
	       <?php }?>
	    </select> 
	    
	</div>
</div>

<div class="control-group">
	<label class="control-label"  for="keyword">面值：</label>
	<div class="controls">
	   <input id="tc_price" type="text" value="<?php if ($coupons){ echo $coupons->tc_price; }?>"  name="tc_price">
	</div>
</div>


<div class="control-group">
	<label class="control-label"  for="keyword">描述：</label>
	<div class="controls">
	   <textarea name="tc_desc" id="tc_desc"><?php if ($coupons){ echo $coupons->tc_desc; }?></textarea>
	</div>
</div>


<div class="control-group">
	<label class="control-label"  for="keyword">最低消费(使用条件)：</label>
	<div class="controls">
	   <input id="tc_sale_price" type="text" value="<?php if ($coupons){ echo $coupons->tc_sale_price; }?>"  name="tc_sale_price">
	</div>
</div>


<div class="control-group">
	<label class="control-label"  for="keyword">消费额度：</label>
	<div class="controls">
	   <input id="tc_sale_price" type="text" value="<?php if ($coupons){ echo $coupons->tc_cond_price; }?>"  name="tc_cond_price">
	</div>
</div>


<div class="control-group">
	<label class="control-label"  for="keyword">启用时间：</label>
	<div class="controls">
	   <input id="tc_start_time" type="text" value="<?php if ($coupons){ echo $coupons->tc_start_time; }?>"  name="tc_start_time">
	</div>
</div>

<div class="control-group">
	<label class="control-label"  for="keyword">结束时间：</label>
	<div class="controls">
	   <input id="tc_end_time" type="text" value="<?php if ($coupons){ echo $coupons->tc_end_time; }?>"  name="tc_end_time">
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