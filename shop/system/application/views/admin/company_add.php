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
<script>
$(function () {
	$('#develop_time').datepicker();
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
      var str = ''; 
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
      $('#area_id').change(function(){
          var area_id = $(this).val();
          var str = ''; 
    	      var submitData = {id:area_id};
    	      $.post('/store/ajax_get_service_building', submitData,function(data) { 
    				if (data.success == 'yes') { 
    				    var msg = data.msg;
    				    for(var i=0;i<msg.length;i++){
    				    	str+="<option value='"+msg[i].id+"'>"+msg[i].name+"</option>";					    
    				    }    
    				} 
    				
    				$('#service_building_id').html(str);
    	},"json");  			  		  
   })


	var validator = $("#tform").validate({
		rules: {
			name: {required: true},
			province_id: {required: true},
			city_id: {required: true},
			area_id: {required: true}
		},
		messages: {
			name: {required: "请输入公司名"},
			province_id: {required: '请选择省份'},
			city_id: {required: '请选择城市'},
			area_id: {required: '请选择区域'}
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
})
</script>
<title>新增企业客户</title>
</head>
<body>
 <form class="form-horizontal"  id="tform" action="/admin/company_add" method="POST">
		 <input type="hidden" name="id" value="<?php if($company){echo $company->id;}else{echo '0';}?>" />
		<fieldset>
		    <legend>添加企业客户</legend>
		 
			<div class="control-group">
				<label class="control-label" for="option1">公司名:</label>
				<div class="controls">
					<input type="text" id="name" name="name" <?php if($company){?> value="<?php echo $company->name; ?>" <?php }?>> 
				</div>
			</div>
			 
			<div class="control-group">
				<label class="control-label" for="option1">活动:</label>
				<div class="controls">
					 <select name="event_id" id="event_id">
					    <option value="" >请选择</option>
					  <?php if($event){foreach($event as $k=>$v){?>
					     <option value="<?php echo $v->id;?>" <?php if ($company){ if($company->event_id == $v->id){?>selected<?php }}?> ><?php echo $v->name;?></option>
					  <?php }}?> 
					 </select>
				</div>
			</div>
			 
			<div class="control-group">
				<label class="control-label" for="option1">省份:</label>
				<div class="controls">
					 <select name="province_id" id="province_id">
					    <option value="" >请选择</option>
					  <?php foreach($province as $k=>$v){?>
					     <option value="<?php echo $v->province_id;?>" <?php if ($company){ if($company->province_id == $v->province_id){?>selected<?php }}?> ><?php echo $v->province;?></option>
					  <?php }?> 
					 </select>
				</div>
			</div>
			
			
			<div class="control-group">
				<label class="control-label" for="option1">城市:</label>
				<div class="controls">
					 <select name="city_id" id="city_id">
					    <option value="" >请选择</option>
					    <?php if ($company){
					         foreach($citys as $k=>$v){?>
					            <option value="<?php echo $v->city_id;?>" <?php if ($company){ if($company->city_id == $v->city_id){?>selected<?php }}?> ><?php echo $v->city;?></option>
					    <?php }}?>
					 </select>
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="option1">区域:</label>
				<div class="controls">
					<select name="area_id" id="area_id">
					    <option value="" >请选择</option>
					    <?php if ($company){
					         foreach($areas as $k=>$v){?>
					            <option value="<?php echo $v->area_id;?>" <?php if ($company){ if($company->area_id == $v->area_id){?>selected<?php }}?> ><?php echo $v->area;?></option>
					    <?php }}?>
					 </select> 
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="option1">配送区域:</label>
				<div class="controls">
				  
				 <select name="service_building_id" id="service_building_id">
					    <option value="" >请选择</option>
					    <?php if ($company){
					         foreach($service_building as $k=>$v){?>
					            <option value="<?php echo $v->id;?>" <?php if ($company){ if($company->service_building_id == $v->id){?>selected<?php }}?> ><?php echo $v->name;?></option>
					    <?php }}?>
					 </select> 
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="option1">楼室:</label>
				<div class="controls">
					<input type="text" id="address" name="address" <?php if($company){?> value="<?php echo $company->address; ?>" <?php }?>> 
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="option1">开发时间:</label>
				<div class="controls">
					<input type="text" id="develop_time" name="develop_time" <?php if($company){?> value="<?php echo $company->develop_time; ?>" <?php }?>> 
				</div>
			</div>
			 
			<div class="control-group">
				<label class="control-label" for="option1">状态:</label>
				<div class="controls">
					供应中：<input type="radio" name="status" value="1" <?php if ($company){if($company->status){?>checked=true<?php }}else{?>checked=true<?php }?>/>&nbsp;&nbsp; 开发中：<input type="radio" name="status" value="0" <?php if ($company&&(!$company->status)){?>checked=true<?php }?> />
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="option1">备注:</label>
				<div class="controls">
					<textarea id="comment" name="comment" ><?php if($company){ echo $company->comment; }?></textarea> 
				</div>
			</div>				
   		  	<div class="control-group">
			    <div class="controls">
			      
			      <button id="save-btn" type="submit" class="btn btn-primary">保存</button>
			      <button id="back-btn" type="button" class="btn btn-primary" onclick="location.href='/admin/company_index'">返回</button>
			    </div>
		    </div>
		</fieldset>
	</form> 
</body>	
</html>