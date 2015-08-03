<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css" media="screen" />
<link rel="stylesheet" href="/resource/css/admin/admin.css" media="screen" />
<link rel="stylesheet" href="/resource/css/admin/appmsg.css" media="screen" />
<link rel="stylesheet" href="/resource/css/admin/appmsg-mul.css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>jquery-ui/css/uploadify.css" media="screen" />
<script type="text/javascript" src="/resource/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/resource/js/plugin/operamasks-ui.min.js"></script>
<script type="text/javascript" src="/resource/js/page/appmsg-mul.js"></script>
<script type="text/javascript" src="/resource/js/plugin/jquery.json-2.4.min.js"></script>
<script type="text/javascript">window.UEDITOR_HOME_URL = '/ueditor/';window.fixedImagePath='http://api.weiqudao.net/image/';</script>
<script type="text/javascript" src="/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/ueditor/ueditor.all.min.js"></script>
<link rel="stylesheet" href="/ueditor/themes/default/css/ueditor.css" />
<script type="text/javascript" src="/jquery-ui/js/jquery.uploadify.min.js?ver=<?php echo rand(0,9999);?>"></script>
<title>添加菜品</title>
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
.province_city_area select{
	width:100px;
} 
</style>
</head>
<script>
 $(function(){ 
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
	   
		  $('#cate_id').change(function(){
		      var pid = $(this).val();
		      var str = '<option value="" >请选择</option>'; 
			      var submitData = {pid:pid};
			      $.post('/store/ajax_get_sub_category', submitData,function(data) { 
						if (data.success == 'yes') { 
						    var msg = data.msg;
						    for(var i=0;i<msg.length;i++){
							    str+="<option value='"+msg[i].id+"'>"+msg[i].name+"</option>";
						    }    
						    $('#sub_cate_id').html(str);
						  /*  if (data.supplier) {  
							    var supplier = data.supplier;
							    var strs = ''; 
							    for(var i=0;i<supplier.length;i++){
							    	strs+="<input type='checkbox' value='"+supplier[i].id+"' name='suppliers[]'>"+supplier[i].name+"&nbsp;&nbsp;";	
							    }
							    $('#suppliers').html(strs);   						    
							}*/
						} 
						
						
					},"json");		     
		   }) 
		   
		   $('#sub_cate_id').change(function(){
		      var pid = $(this).val();
		     
			      var submitData = {cate_id:pid};
			      $.post('/store/ajax_get_supplier_from_category', submitData,function(data) { 
						if (data.success == 'yes') { 
						    var msg = data.msg;
						    var str = '<option value="" >请选择</option>'; 
						    for(var i=0;i<msg.length;i++){
						    	str+="<option value='"+msg[i].id+"'>"+msg[i].name+"</option>";
						    	 
						    }
						    $('#suppliers').html(str);   						    
						} 
						 
					},"json");		     
		   })
	
 })
</script>
<body>
	<div class="row">
		<div class="span5 msg-preview">
		 <div class="control-group">
			<label class="control-label">菜品套餐名</label><span class="maroon">*</span><span class="help-inline">(必填)</span>
			<div class="controls">
			     <input type="text" name="name" id="name" value="<?php if($good){ echo $good->name;}?>" />
		    </div>
	   </div>
	   
	   
	   <div class="control-group">
			<label class="control-label">菜品品类</label><span class="maroon">*</span><span class="help-inline">(必填)</span>
			<div class="controls">
			     <select name="cate_id" id="cate_id">
			     <option value="" >请选择</option>
				 <?php foreach($cates as $k=>$v){?>
				   <option value="<?php echo $v->id;?>" <?php if($good && ($good->cate_id == $v->id)){?>selected=true<?php }?>><?php echo $v->name;?></option>
				 <?php }?>
				</select> 
		    </div>
	   </div>
	   
	   
		<div class="control-group">
			<label class="control-label">菜品品类</label><span class="maroon">*</span><span class="help-inline">(必填)</span>
			<div class="controls">
			     <select name="sub_cate_id" id="sub_cate_id">
			       <option value="" >请选择</option>
			     <?php if($good){
			        foreach($sub_cates as $k=>$v){?>
			          <option value="<?php echo $v->id;?>" <?php if($good && ($good->sub_cate_id == $v->id)){?>selected=true<?php }?> ><?php echo $v->name;?></option>
			     <?php }}?>  
			     </select> 
		    </div>
	   </div>
	 
	   	
			<div class="msg-item-wrapper">
				<input type="hidden" class="id" value="<?php if($good){ echo $good->id;}?>" id="tm_id"/>
				<div id="appmsgItem1" class="appmsgItem msg-item">
					<p class="msg-meta">
						<span class="msg-date"><?php echo date("Y-m-d");?></span>
					</p>
					<div class="cover">
						<?php if(!$good){?><p class="default-tip" >菜品图片</p><?php }?>
						<h4 class="msg-t">
							<span class="i-title"><?php if($good){ echo $good->title0;}else{?>菜品名<?php }?></span>
						</h4>
						<ul class="abs tc sub-msg-opr">                 
							<li class="b-dib sub-msg-opr-item">                   
								<a href="javascript:;" class="th opr-icon edit-icon">编辑</a>                 
							</li>               
						</ul>
						<img class="i-img" <?php if($good){ ?> src="<?php echo $good->coverurl0; ?>" <?php }?> style="">
					</div>
					<p class="msg-text"></p>
					 
					<input type="hidden" value="<?php if($good){ echo $good->title0;}?>" class="title" />
					<input type="hidden" value="<?php if($good){ echo $good->coverurl0;}?>"  class="cover" />
					<input type="hidden" value="<?php if($good){ echo $good->coverurl0;}?>"  class="coverurl" />
					<textarea class="content" style="display: none;"><?php if($good){ echo $good->desc0;}?></textarea> 
				</div>
		 
		   <div class="rel sub-msg-item appmsgItem">              
					<span class="thumb">                 
					<span class="default-tip" <?php if($good){?> style="display:none" <?php }?>>缩略图</span>         
					<img src="<?php if($good){ echo $good->coverurl1;}?>" class="i-img" <?php if(!$good){?> style="display:none" <?php }?>>       
					</span>       
					<h4 class="msg-t">                    
					<span class="i-title"><?php if($good){ echo $good->title1;}else{?>菜品名<?php }?></span>                
					</h4>       
					<ul class="abs tc sub-msg-opr">         
						<li class="b-dib sub-msg-opr-item">           
							<a href="javascript:;" class="th opr-icon edit-icon">编辑</a>         
						</li>         
					</ul>    
					<input type="hidden" value="<?php if($good){ echo $good->title1;}?>" class="title" />
					<input type="hidden" value="<?php if($good){ echo $good->coverurl1;}?>"  class="cover" />
					<input type="hidden" value="<?php if($good){ echo $good->coverurl1;}?>"  class="coverurl" />
					<textarea class="content" style="display: none;"><?php if($good){ echo $good->desc1;}?></textarea> 
				</div>
				
				<div class="rel sub-msg-item appmsgItem">              
					<span class="thumb">                 
					<span class="default-tip" <?php if($good){?> style="display:none" <?php }?>>缩略图</span>         
					<img src="<?php if($good){ echo $good->coverurl2;}?>" class="i-img" <?php if(!$good){?> style="display:none" <?php }?>>      
					</span>       
					<h4 class="msg-t">                    
					<span class="i-title"><?php if($good){ echo $good->title2;}else{?>菜品名<?php }?></span>                
					</h4>       
					<ul class="abs tc sub-msg-opr">         
						<li class="b-dib sub-msg-opr-item">           
							<a href="javascript:;" class="th opr-icon edit-icon">编辑</a>         
						</li>    
					</ul>    
					<input type="hidden" value="<?php if($good){ echo $good->title2;}?>" class="title" />
					<input type="hidden" value="<?php if($good){ echo $good->coverurl2;}?>"  class="cover" />
					<input type="hidden" value="<?php if($good){ echo $good->coverurl2;}?>"  class="coverurl" />
					<textarea class="content" style="display: none;"><?php if($good){ echo $good->desc2;}?></textarea> 
				</div>
				
				<div class="rel sub-msg-item appmsgItem">              
					<span class="thumb">                 
					<span class="default-tip" <?php if($good){?> style="display:none" <?php }?>>缩略图</span>         
					<img src="<?php if($good){ echo $good->coverurl3;}?>" class="i-img" <?php if(!$good){?> style="display:none" <?php }?>>       
					</span>       
					<h4 class="msg-t">                    
					<span class="i-title"><?php if($good){ echo $good->title3;}else{?>菜品名<?php }?></span>                
					</h4>       
					<ul class="abs tc sub-msg-opr">         
						<li class="b-dib sub-msg-opr-item">           
							<a href="javascript:;" class="th opr-icon edit-icon">编辑</a>         
						</li>       
					</ul>    
					<input type="hidden" value="<?php if($good){ echo $good->title3;}?>" class="title" />
					<input type="hidden" value="<?php if($good){ echo $good->coverurl3;}?>"  class="cover" />
					<input type="hidden" value="<?php if($good){ echo $good->coverurl3;}?>"  class="coverurl" />
					<textarea class="content" style="display: none;"><?php if($good){ echo $good->desc3;}?></textarea> 
				</div>
				
				
				<div class="rel sub-msg-item appmsgItem">              
					<span class="thumb">                 
					<span class="default-tip" <?php if($good){?> style="display:none" <?php }?>>缩略图</span>         
					<img src="<?php if($good){ echo $good->coverurl4;}?>" class="i-img" <?php if(!$good){?> style="display:none" <?php }?>>        
					</span>       
					<h4 class="msg-t">                    
					<span class="i-title"><?php if($good){ echo $good->title4;}else{?>菜品名<?php }?></span>                
					</h4>       
					<ul class="abs tc sub-msg-opr">         
						<li class="b-dib sub-msg-opr-item">           
							<a href="javascript:;" class="th opr-icon edit-icon">编辑</a>         
						</li>       
					</ul>    
					<input type="hidden" value="<?php if($good){ echo $good->title4;}?>" class="title" />
					<input type="hidden" value="<?php if($good){ echo $good->coverurl4;}?>"  class="cover" />
					<input type="hidden" value="<?php if($good){ echo $good->coverurl4;}?>"  class="coverurl" />
					<textarea class="content" style="display: none;"><?php if($good){ echo $good->desc4;}?></textarea> 
				</div> 
				
			</div>
				 
		</div>
<div class="span7">
		<div class="control-group">
			<label class="control-label">供应商</label>
			<div class="controls" >
			      
			     <select name="suppliers" id="suppliers">
			       <option value="" >请选择</option>
			     <?php if($good){
			        foreach($supplier as $k=>$v){?>
			          <option value="<?php echo $v->id;?>" <?php if(in_array($v->id,$supplier_valid)){?>selected=true<?php }?> ><?php echo $v->name;?></option>
			     <?php }}?>  
			     </select> 
		    </div>
	   </div>
	   
	   <div class="control-group">
			<label class="control-label">菜品价格</label><span class="maroon">*</span><span class="help-inline">(必填)</span>
			<div class="controls">
			     <input type="text" name="price" id="price" value="<?php if($good){ echo $good->price;}?>" />
		    </div>
	   </div>
	   
	   <div class="control-group">
			<label class="control-label">状态: </label>
			<div class="controls">
			     <input type="radio" name="status" value="0" <?php if($good&&($good->status==0)){ ?>checked=true<?php }?> />准备&nbsp;&nbsp;
			     <input type="radio" name="status" value="1" <?php if($good&&($good->status==1)){ ?>checked=true<?php }?>  />上架&nbsp;&nbsp;
			     <input type="radio" name="status" value="2" <?php if($good&&($good->status==2)){ ?>checked=true<?php }?>  />下架
		    </div>
	   </div>
	      	   	   
<div class="msg-editer-wrapper">		
				<div class="msg-editer">
					<div class="control-group">
						<label class="control-label">菜品名</label><span class="maroon">*</span><span class="help-inline">(必填,不能超过64个字)</span>
						<div class="controls">
					    	<input type="text" value="<?php if($good){ echo $good->title0;}?>" id="title" class="span5" style="width: 482px;" name="title" />
					    </div>
				    </div>
				    <div class="control-group">
						<label class="control-label">菜品图片</label><span class="maroon">*</span><span class="help-inline">(必须上传一张图片)</span>    
						<div class="controls">
							<div class="cover-area">
								<div class="cover-hd">
									<input id="file_upload" name="file_upload" type="file" />
									<input id="coverurl" value="<?php if($good){ echo $good->coverurl0;}?>" name="coverurl" type="hidden" />
								</div>
								<p id="upload-tip" class="upload-tip">大图片建议尺寸：700像素 * 300像素</p>
								<p id="imgArea" class="cover-bd" style="display: none;">
								<img src="<?php if($good){ echo $good->coverurl0;}?>" id="img">
								<a href="javascript:;" class="vb cover-del" id="delImg">删除</a>
								</p>
							</div>
						</div>
					</div>
				  	<div class="control-group">
					<label class="control-label">菜品简介</label> <span class="maroon">*</span><span class="help-inline">(必填,不能超过20000个字)</span>     
					    <div class="controls">
							<script type="text/plain" id="editor"><?php if($good){ echo $good->desc0;}?></script>
						</div>
					</div> 
				  	<div class="control-group">
					    <div class="controls">
					      <button id="save-btn" type="submit" class="btn btn-primary btn-large">保存</button>
					      <button id="cancel-btn" type="button" class="btn btn-large">取消</button>
					    </div>
				    </div> 
				    <input id="action" name="action" type="hidden" value="mul_add" />
				</div>
				<span class="abs msg-arrow a-out" style="margin-top: 0px;"></span>
				<span class="abs msg-arrow a-in" style="margin-top: 0px;"></span>
			</div>
		</div>
	</div>
</body>
</html>