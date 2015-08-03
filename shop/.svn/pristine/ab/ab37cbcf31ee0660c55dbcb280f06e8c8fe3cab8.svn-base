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
<script type="text/javascript" src="/resource/js/page/appmsg.js"></script> 
<script type="text/javascript" src="/jquery-ui/js/jquery.uploadify.min.js?ver=<?php echo rand(0,9999);?>"></script> 
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
	$('#open_time').datepicker();
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
				    	str+="<input type='checkbox' value='"+msg[i].area_id+"' name='areas[]'>"+msg[i].area+"&nbsp;&nbsp;";				    
				    }    
				} 
				
				$('#area_id').html(str);
			},"json");    
   })
})
</script>
<title>新增供应商</title>
</head>
<body>
 <form enctype="multipart/form-data" class="form-horizontal"  id="tform" action="/store/supplier_add/<?php echo $id ;?>" method="POST">
		 
		<fieldset>
		    <legend>添加供应商</legend>
			<div class="control-group">
				<label class="control-label" for="option1">供应商名:</label>
				<div class="controls">
					<input type="text" id="name" name="name" <?php if($supplier){?> value="<?php echo $supplier->name; ?>" <?php }?>> 
				</div>
			</div>
			 
			<div class="control-group">
				<label class="control-label" for="option1">配送省份:</label>
				<div class="controls">
					 <select name="province_id" id="province_id">
					    <option value="" >请选择</option>
					  <?php foreach($province as $k=>$v){?>
					     <option value="<?php echo $v->province_id;?>" <?php if ($supplier){ if($supplier->province_id == $v->province_id){?>selected<?php }}?> ><?php echo $v->province;?></option>
					  <?php }?> 
					 </select>
				</div>
			</div>
			
			
			<div class="control-group">
				<label class="control-label" for="option1">配送城市:</label>
				<div class="controls">
					 <select name="city_id" id="city_id">
					    <option value="" >请选择</option>
					    <?php if ($supplier){
					         foreach($citys as $k=>$v){?>
					            <option value="<?php echo $v->city_id;?>" <?php if ($supplier){ if($supplier->city_id == $v->city_id){?>selected<?php }}?> ><?php echo $v->city;?></option>
					    <?php }}?>
					 </select>
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="option1">配送区域:</label>
				<div class="controls" id="area_id">
				<?php if($supplier){?>
					 <?php foreach($areas as $k=>$v){?>
					  <input type="checkbox" value="<?php echo $v->area_id;?>" <?php if($valid_areas&&in_array($v->area_id,$valid_areas)){?>checked=true<?php }?>class="cates" name='areas[]'/><?php echo $v->area;?>
					<?php } }?> 
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="option1">地址:</label>
				<div class="controls">
					<input type="text" id="address" name="address" <?php if($supplier){?> value="<?php echo $supplier->address; ?>" <?php }?>> 
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="option1">开业时间:</label>
				<div class="controls">
					<input type="text" id="open_time" name="open_time" <?php if($supplier){?> value="<?php echo $supplier->open_time; ?>" <?php }?>> 
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="option1">菜品品类:</label>
				<div class="controls">
					<?php if($p_cates){?>
					   <?php foreach($p_cates as $k=>$v){?>
					     <input type="checkbox" value="<?php echo $v->id;?>" <?php if($valid_cates&&in_array($v->id,$valid_cates)){?>checked=true<?php }?>class="cates" name='cates[]'/><?php echo $v->name;?>
					   <?php }?> 
					<?php }?>
					<?php foreach($cates as $k=>$v){?>
					  <input type="checkbox" value="<?php echo $v->id;?>" <?php if($valid_cates&&in_array($v->id,$valid_cates)){?>checked=true<?php }?>class="cates" name='cates[]'/><?php echo $v->name;?>
					<?php }?> 
				</div>
			</div>
		  
			<div class="control-group">
				<label class="control-label" for="option1">状态:</label>
				<div class="controls">
					营业：<input type="radio" name="status" value="1" <?php if ($supplier){if($supplier->status){?>checked=true<?php }}else{?>checked=true<?php }?>/>&nbsp;&nbsp; 停业：<input type="radio" name="status" value="0" <?php if ($supplier&&(!$supplier->status)){?>checked=true<?php }?> />
				</div>
			</div >
			<!--摘要-->
                    <div class="control-group">
                        <div>
                            供应商摘要：<textarea type="text" name="summary" class="summary" style="width:480px;height:100px;"> <?php if($supplier){if($supplier->summary){?> <?php echo  $supplier->summary;}}?></textarea>
                        </div>
                    </div>
                        <!--简介-->
                        <div class="control-group">
                        <div>
                            供应商简介：<textarea type="text" name="descr" class="descr"  style="width:480px;height:200px;"> <?php if($supplier){if($supplier->descr){?> <?php echo  $supplier->descr;}}?></textarea>
                        </div>
                    </div>
                        <div>
                            
                            主图 ：<input type="file" class="file_upload" name="pic0" <?php if($supplier){if($supplier->image0_url){?>value=<?php echo $supplier->image0_url;}}?>><br/>
                            附图1：<input type="file" class="file_upload" name="pic1" <?php if($supplier){if($supplier->image1_url){?>value=<?php echo $supplier->image1_url;}}?>><br/>
                            附图2：<input type="file" class="file_upload" name="pic2" <?php if($supplier){if($supplier->image2_url){?>value=<?php echo $supplier->image2_url;}}?>><br/>
                            附图3：<input type="file" class="file_upload" name="pic3" <?php if($supplier){if($supplier->image3_url){?>value=<?php echo $supplier->image3_url;}}?>><br/>
                            附图4：<input type="file" class="file_upload" name="pic4" <?php if($supplier){if($supplier->image4_url){?>value=<?php echo $supplier->image4_url;}}?>>
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