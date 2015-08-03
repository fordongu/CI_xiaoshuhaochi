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
<script type="text/javascript" src="/jquery-ui/js/jquery.uploadify.min.js"></script>
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
<script>
$(function () {
	
	$('#develop_time').datepicker();
	$('#start_time').timepicker();
	$('#end_time').timepicker();
  $('#province_id').change(function(){
      var province_id = $(this).val();
      var str = '<option value="" >请选择</option>'; 
	      var submitData = {id:province_id,type:'city'};
	      $.post('/store/ajax_get_city_area', submitData,function(data) { 
				if (data.success == 'yes') { 
				    var msg = data.msg;
				    for(var i=0;i<msg.length;i++){
					    str+="<option value='"+msg[i].city_id+"'>"+msg[i].city+"</option>";					    
				    }    
				} 
				
				$('#city_id').html(str);
			},"json");
     
   })
   
   
    $('#city_id').change(function(){
      var city_id = $(this).val();
      var str = '<option value="" >请选择</option>'; 
	      var submitData = {id:city_id,type:'area'};
	      $.post('/store/ajax_get_city_area', submitData,function(data) { 
				if (data.success == 'yes') { 
				    var msg = data.msg;
				    for(var i=0;i<msg.length;i++){
					    str+="<option value='"+msg[i].area_id+"'>"+msg[i].area+"</option>";					    
				    }    
				} 
				
				$('#area_id').html(str);
			},"json");
     
   })


   var validator = $("#tform").validate({
		rules: {
			name: {
				required: true 
			}
		},
		messages: {
			name: {
				required: "请输入写字楼名" 
			} 
		},
		showErrors: function(errorMap, errorList) {
			if (errorList && errorList.length > 0) {
				$.each(errorList,
						function(index, obj) {
					var item = $(obj.element);
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
			 
			var $form = $("#tform");
			var $btn = $("#save-btn");
			if($btn.hasClass("disabled")) return;
			var submitData = {
					name: $("input[name='name']", $form).val(),
					province_id: $("select[name='province_id']", $form).val(),
					city_id: $("select[name='city_id']", $form).val(),
				    area_id: $("select[name='area_id']", $form).val(), 
					address: $("input[name='address']", $form).val(),
					status: $("select[name='status']", $form).val(),
					develop_time: $("input[name='develop_time']" , $form).val(), 
				    start_time: $("input[name='start_time']" , $form).val(), 
					end_time: $("input[name='end_time']" , $form).val(),  
					id:$("input[name='id']", $form).val(),
					remark:$("textarea[name='remark']", $form).val() 
			};
			$btn.addClass("disabled");
			
			$.post('/store/service_buildings_add', submitData,function(data) {
				$btn.removeClass("disabled");
				if (data.success == 'yes') {
				    alert(data.msg);
					location.href = "/store/service_buildings_index";
				}  else{
					alert(data.msg);
					
				}
			},"json");
			return false;
		}
	});
})
</script>
<title>新增写字楼</title>
</head>
<body>
 <form class="form-horizontal"  id="tform" action="/store/service_buildings_add" method="POST">
		 <input type="hidden" name="id" value="<?php echo $id;?>" />
		<fieldset>
		    <legend><?php if($id){ echo '修改写字楼';}else{ echo '新增写字楼';}?></legend>
			<div class="control-group">
				<label class="control-label" for="option1">写字楼名:</label>
				<div class="controls">
					<input type="text" id="name" name="name" <?php if($building){?> value="<?php echo $building->name; ?>" <?php }?>> 
				</div>
			</div>
			 
			<div class="control-group">
				<label class="control-label" for="option1">省份:</label>
				<div class="controls">
					 <select name="province_id" id="province_id">
					    <option value="" >请选择</option>
					  <?php foreach($province as $k=>$v){?>
					     <option value="<?php echo $v->province_id;?>" <?php if ($building){ if($building->province_id == $v->province_id){?>selected<?php }}?> ><?php echo $v->province;?></option>
					  <?php }?> 
					 </select>
				</div>
			</div>
			
			
			<div class="control-group">
				<label class="control-label" for="option1">城市:</label>
				<div class="controls">
					 <select name="city_id" id="city_id">
					    <option value="" >请选择</option>
					    <?php if ($building){
					         foreach($citys as $k=>$v){?>
					            <option value="<?php echo $v->city_id;?>" <?php if ($building){ if($building->city_id == $v->city_id){?>selected<?php }}?> ><?php echo $v->city;?></option>
					    <?php }}?>
					 </select>
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="option1">区域:</label>
				<div class="controls">
					 <select name="area_id" id="area_id">
					    <option value="" >请选择</option>
					    <?php if ($building){
					         foreach($areas as $k=>$v){?>
					            <option value="<?php echo $v->area_id;?>" <?php if ($building){ if($building->area_id == $v->area_id){?>selected<?php }}?> ><?php echo $v->area;?></option>
					    <?php }}?>
					 </select>
				</div>
			</div>
		 	
			<div class="control-group">
				<label class="control-label" for="option1">地址:</label>
				<div class="controls">
					<input type="text" id="address" name="address" <?php if($building){?> value="<?php echo $building->address; ?>" <?php }?>> 
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="option1">状态:</label>
				<div class="controls">
					<select id="status" name="status">
					  <option value="0" <?php if($building&&($building->status ==0)){?>selected=true<?php }?>>开发中</option>
					  <option value="1" <?php if($building&&($building->status ==1)){?>selected=true<?php }?>>供应中</option>
					  <option value="2" <?php if($building&&($building->status ==2)){?>selected=true<?php }?>>停止供应</option>
					  <option value="3" <?php if($building&&($building->status ==3)){?>selected=true<?php }?>>活动写字楼</option>
					  <option value="4" <?php if($building&&($building->status ==3)){?>selected=true<?php }?>>虚拟写字楼</option>
					</select>
				</div>
			</div>
			
			
			<div class="control-group">
				<label class="control-label" for="option1">开发时间:</label>
				<div class="controls">
					<input type="text" id="develop_time" name="develop_time" <?php if($building){?> value="<?php echo $building->develop_time; ?>" <?php }?>> 
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="option1">供应开始时间:</label>
				<div class="controls">
					<input type="text" id="start_time" name="start_time" <?php if($building){?> value="<?php echo $building->start_time; ?>" <?php }?>> 
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="option1">供应结束时间:</label>
				<div class="controls">
					<input type="text" id="end_time" name="end_time" <?php if($building){?> value="<?php echo $building->end_time; ?>" <?php }?>> 
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="option1">备注:</label>
				<div class="controls">
					<textarea name="remark" id="remark"><?php if($building){ echo $building->remark;  }?></textarea> 
				</div>
			</div>
			 
			 
   		  	<div class="control-group">
			    <div class="controls">
			      
			      <button id="save-btn" type="submit" class="btn btn-primary">保存</button>
			      <button id="back-btn" type="button" class="btn btn-primary" onclick="location.href='/store/supplier_index'">返回</button>
			    </div>
		    </div>
		</fieldset>
	</form> 
</body>	
</html>