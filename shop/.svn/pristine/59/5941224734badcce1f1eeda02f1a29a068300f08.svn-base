<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css" media="screen" />
<link rel="stylesheet" href="/resource/css/admin/admin.css" media="screen" />
<link rel="stylesheet" href="/resource/css/admin/appmsg.css" media="screen" />
<link rel="stylesheet" href="/jquery-ui/css/uploadify.css" media="screen" />
<script type="text/javascript" src="/resource/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/resource/js/plugin/operamasks-ui.min.js"></script>  
<link rel="stylesheet" href="/jquery-ui/css/smoothness/jquery-ui-1.10.0.custom.min.css" media="screen" />
<link rel="stylesheet" href="/resource/css/plugin/jquery-ui-timepicker-addon.css" media="screen" />    
<script type="text/javascript" src="/resource/js/plugin/operamasks-ui.min.js"></script>
<script type="text/javascript" src="/jquery-ui/js/jquery-ui-1.10.0.custom.min.js"></script> 
<script type="text/javascript" src="/resource/js/plugin/timepicker/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="/resource/js/plugin/timepicker/jquery-ui-timepicker-zh-CN.js"></script>
<script type="text/javascript" src="/resource/js/plugin/timepicker/jquery-ui-sliderAccess.js"></script>
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
<title>活动管理</title>
</head>
<body>
 <form class="form-horizontal"  id="tform" action="/admin/event_add" method="POST">
		 
		<fieldset>
		   
			<legend><?php if ($event){?>修改活动<?php }else{?>新增活动<?php }?></legend>
			 <input type="hidden" value="<?php if($id){echo $id;}else{ echo 0;}?>" name="id"  id="id" />
			
			<div class="control-group">
				<label class="control-label" for="option1">活动名:</label>
				<div class="controls">
					<input type="text" id="name" name="name" <?php if($event){?> value="<?php echo $event->name; ?>" <?php }?>>
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="option1">价格:</label>
				<div class="controls">
					<input type="text" id="price" name="price" <?php if($event){?> value="<?php echo $event->price; ?>" <?php }?>>元
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="option1">开始时间:</label>
				<div class="controls">
					<input type="text" id="start_time" name="start_time" <?php if($event){?> value="<?php echo $event->start_time; ?>" <?php }?>> 
				</div>
			</div>	
			
			<div class="control-group">
				<label class="control-label" for="option1">结束时间:</label>
				<div class="controls">
					<input type="text" id="end_time" name="end_time" <?php if($event){?> value="<?php echo $event->end_time; ?>" <?php }?>>  
				</div>
			</div>	
			  
			<div class="control-group">
				<label class="control-label" for="option1">简介:</label>
				<div class="controls">
					<textarea id="desc" name="desc"><?php if($event){echo $event->desc;}?></textarea>
				</div>
			</div>  
   		  	<div class="control-group">
			    <div class="controls">
			      
			      <button id="save-btn" type="submit" class="btn btn-primary">保存</button>
			      <button id="back-btn" type="button" class="btn btn-primary" onclick="location.href='/admin/event_list'">返回</button>
			    </div>
		    </div>
		</fieldset>
	</form>
<script type="text/javascript">
$(function(){
	$('#start_time').datepicker();
	$('#end_time').datepicker();
	var $btn=$("#save-btn");
	var $form=$("#tform"); 
	//验证表单
	$validator=$form.validate({
		rules:{
			name:{required:true},
			price:{required:true},
			start_time:{required:true},
			end_time:{required:true}
		},
		messages:{
			name:{required:'请输入活动名'},
			price:{required:'请输入价格'},
			start_time:{required:'请输入开始时间'},
			end_time:{required:'请输入结束时间'}
		} 
	}); 
});

</script>
</body>	
</html>