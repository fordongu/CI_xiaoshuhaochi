<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="<?php echo base_url();?>/bootstrap/css/bootstrap.min.css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>/resource/css/admin/admin.css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>/jquery-ui/css/smoothness/jquery-ui-1.10.0.custom.min.css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>/resource/css/plugin/jquery-ui-timepicker-addon.css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>/resource/css/admin/appmsg.css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>/resource/css/admin/coupon-setting.css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>jquery-ui/css/uploadify.css" media="screen" />
<script type="text/javascript" src="<?php echo base_url();?>/resource/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/resource/js/plugin/operamasks-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/jquery-ui/js/jquery-ui-1.10.0.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>jquery-ui/js/jquery.uploadify.min.js?ver=<?php echo rand(0,9999);?>"></script>
<script type="text/javascript">
$(function(){

	$('input.file_upload').each(function(){
		var $fileInput = $(this);
		var $cont =  $fileInput.closest(".cover-area");
	   setTimeout(function(){
		$fileInput.uploadify({			 
			'swf'      : '/resource/swf/uploadify.swf',
			'uploader' : '/uploads.php',
			'onUploadSuccess' : function(file,data,response)  {
				var jsonData = eval("("+data+")");
				$cont.find(".img-area").show();
				var img = "<img src='"+jsonData.fileUrl+"' />";
				$cont.find(".img-area").prepend(img);
		    //	$cont.show().find("img").attr("src",jsonData.fileUrl);
		    	var url = $cont.find('.cover-input').val();
		    	if(url){
		    		$cont.find('.cover-input').val(url+";"+jsonData.fileUrl);
		    	}else{
		    		$cont.find('.cover-input').val(jsonData.fileUrl);
		    	}
		    }			 
		});
	   },10);	
	});
			 $(".cover-del").click(function(){
				var $cont =  $(this).closest(".cover-area"); 
				$(".img-area",$cont).hide();
				$(".cover-input",$cont).val("");
				$(".cover .i-img",$cont).hide();
			 });

				
			 var $btn=$("#submitbtn");
			 var $form=$("#qform");
			 //验证表单
			 $validator=$form.validate({
			 	rules:{
			 		tas_title:{required:true},
			 		tas_image:{required:true},
			 		tas_intro:{required:true} 
			 	},
			 	messages:{
			 		tas_title:{required:'自动回复标题必填'},
			 		tas_image:{required:'请上传自动回复图片'},
			 		tas_intro:{required:'自动回复内容必填'} 
			 	}, 
			 	 submitHandler:function(){
			 		var submitData={
			 			tas_title:$("input[name='tas_title']",$form).val(),
			 			tas_image:$("input[name='tas_image']",$form).val(),
			 			tas_url:$("input[name='tas_url']",$form).val(),
			 			tas_intro:$("textarea[name='tas_intro']",$form).val()
			 		};
			 		
			 		$btn.addClass("disabled"); 
			 		 $.post('/main/auto_service',submitData,function(data){
			 			$btn.removeClass("disabled");
			 			if(data.success=="no"){
			 				alert('保存失败');
			 			}else if(data.success=="yes")
			 			{
				 		   alert('保存成功');
			 			  window.location.reload();
			 			}
			 			
			 		},"json");
			 		return false;			
			 	}
			 }); 
 
});
</script>
<title>智能客服管理</title>
</head>
<body>
	
	<form class="form-horizontal"  id="qform">
		
        <fieldset>
          <legend>首次关注微信回复</legend>
       <div class="control-group">
	    <label class="control-label" for="tas_title">智能回复标题:</label>
	    <div class="controls">
	      <input type="text" id="tas_title" value="<?php if($service){echo $service->tas_title;}?>"  name="tas_title">
	      <span class="maroon">*</span> 
	    </div>
	  </div>
	  
	  
<div class="control-group">
<label class="control-label"  for="keyword">自动回复图片：</label>
	<div class="controls">
			<div class="cover-area">
							<div class="cover-hd" >
								<input id="file_upload" name="file_upload" class="file_upload" type="file" />
								<input id="cover3" style="width:400px;" class="cover-input" value="<?php if ($service){ echo $service->tas_image; }?>" name="tas_image" type="text" />
							</div>
						
							<p class="img-area cover-bd" >
							<img src="<?php echo base_url(); if ($service){ echo $service->tas_image;}?>" id="img_square">
							<a href="javascript:;" class="vb cover-del"   >删除</a>
							</p>
	</div>
  </div>
</div>
       
<div class="control-group">
<label class="control-label"  for="keyword">自动回复内容：</label>
	<div class="controls">
	  <textarea name="tas_intro" id="tas_intro"><?php if($service){echo $service->tas_intro;  }?></textarea>
	</div> 
</div>
	  
	  <div class="control-group">
	    <label class="control-label" for="tas_url">智能回复URL:</label>
	    <div class="controls">
	      <input type="text" id="tas_url" style="width:300px;" value="<?php if($service){echo $service->tas_url;}?>"  name="tas_url">
	      <span class="maroon">*</span>
	    </div>
	  </div>
	  

          <div class="form-actions">
            <button type="submit" class="btn btn-primary" id="submitbtn">保存</button>
            <button class="btn">取消</button>
          </div>
        </fieldset>
      </form>
</body>
</html>