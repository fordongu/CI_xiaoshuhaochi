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
<script type="text/javascript" src="<?php echo base_url();?>resource/js/plugin/jquery.json-2.4.min.js"></script>
<script type="text/javascript">window.UEDITOR_HOME_URL = '/ueditor/';window.fixedImagePath='http://api.weiqudao.net/image/';</script>
<script type="text/javascript" src="/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/ueditor/ueditor.all.min.js"></script>
<link rel="stylesheet" href="/ueditor/themes/default/css/ueditor.css" />
<script type="text/javascript" src="<?php echo base_url();?>jquery-ui/js/jquery.uploadify.min.js"></script>
<title>多图文编辑</title>
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
</style>
</head>
<script>
 $(function(){
   $(".check_enable").click(function(){
	    var enable_check = 1;
        if(!$(this).attr('checked')){
            enable_check = 0;
         }
        var submitData = {
            enable_check:enable_check,
            type:'multiply'
                }
        $.post('/main/check_enable',submitData,function(data){
			 
			
		},"json");
    })
 })
</script>
<body>
	<div class="row">
		<div class="span5 msg-preview">
			<div class="msg-item-wrapper">

				<div id="appmsgItem1" class="appmsgItem msg-item">
					<p class="msg-meta">
						<span class="msg-date"><?php echo date("Y-m-d");?></span>
					</p>
					<div class="cover">
						<?php if(!$materials){?><p class="default-tip" >封面图片</p><?php }?>
						<h4 class="msg-t">
							<span class="i-title"><?php if($materials){ echo $materials[0]->tm_title;}else{?>标题<?php }?></span>
						</h4>
						<ul class="abs tc sub-msg-opr">                 
							<li class="b-dib sub-msg-opr-item">                   
								<a href="javascript:;" class="th opr-icon edit-icon">编辑</a>                 
							</li>               
						</ul>
						<img class="i-img" <?php if($materials){ ?> src="<?php echo $materials[0]->tm_coverurl; ?>" <?php }?> style="">
					</div>
					<p class="msg-text"></p>
					<input type="hidden" value="<?php if($materials){ echo $materials[0]->tm_id;}?>" class="id" />
					<input type="hidden" value="<?php if($materials){ echo $materials[0]->tm_title;}?>" class="title" />
					<input type="hidden" value="<?php if($materials){ echo $materials[0]->tm_coverurl;}?>"  class="cover" />
					<input type="hidden" value="<?php if($materials){ echo $materials[0]->tm_coverurl;}?>"  class="coverurl" />
					<textarea class="content" style="display: none;"><?php if($materials){ echo $materials[0]->tm_content;}?></textarea>
					<input type="hidden" value="<?php if($materials){ echo $materials[0]->tm_source_url;}?>"  class="sourceurl" />
				</div>
			<?php if($materials) {
				  foreach($materials as $key=>$val){
		 
			   if ($key>0){?>	
				<div class="rel sub-msg-item appmsgItem">              
					<span class="thumb">                 
					<?php if(!$val->tm_coverurl){?><span class="default-tip" style="">缩略图</span> <?php }?>        
					<img src="<?php if($val->tm_coverurl){ echo $val->tm_coverurl;}?>" class="i-img" <?php if(!$val->tm_coverurl){?>style="display:none" <?php }?>>       
					</span>       
					<h4 class="msg-t">                    
					<span class="i-title"><?php if($val->tm_title){ echo $val->tm_title;}else{?>标题<?php }?></span>                
					</h4>       
					<ul class="abs tc sub-msg-opr">         
						<li class="b-dib sub-msg-opr-item">           
							<a href="javascript:;" class="th opr-icon edit-icon">编辑</a>         
						</li>         
						<li class="b-dib sub-msg-opr-item">           
							<a href="javascript:;" class="th opr-icon del-icon">删除</a>         
						</li>       
					</ul>    
					<input type="hidden" class="id" value="<?php if($val->tm_title){ echo $val->tm_id;}?>"/>
					<input type="hidden" class="title" value="<?php if($val->tm_title){ echo $val->tm_title;}?>"/>
					<input type="hidden" class="cover" value="<?php if($val->tm_coverurl){ echo $val->tm_coverurl;}?>"/>
					<input type="hidden" class="coverurl" value="<?php if($val->tm_coverurl){ echo $val->tm_coverurl;}?>" />
					<textarea class="content" style="display: none;"><?php if($val->tm_coverurl){ echo $val->tm_content;}?></textarea>
					<input type="hidden" class="sourceurl" value="<?php if($val->tm_source_url){ echo $val->tm_source_url;}?>" />
				</div>
		 <?php } }
		   }?>
		   <div class="rel sub-msg-item appmsgItem">              
					<span class="thumb">                 
					<span class="default-tip" style="">缩略图</span>         
					<img src="" class="i-img" style="display:none">       
					</span>       
					<h4 class="msg-t">                    
					<span class="i-title">标题</span>                
					</h4>       
					<ul class="abs tc sub-msg-opr">         
						<li class="b-dib sub-msg-opr-item">           
							<a href="javascript:;" class="th opr-icon edit-icon">编辑</a>         
						</li>         
						<li class="b-dib sub-msg-opr-item">           
							<a href="javascript:;" class="th opr-icon del-icon">删除</a>         
						</li>       
					</ul>    
					<input type="hidden" class="title" />
					<input type="hidden" class="cover" />
					<input type="hidden" class="coverurl" />
					<textarea class="content" style="display: none;"></textarea>
					<input type="hidden" class="sourceurl" />
				</div>
		   		
				<div class="sub-add">            
				<a href="javascript:;" class="block tc sub-add-btn">
				<span class="vm dib sub-add-icon"></span>增加一条</a>           
				</div>
				
			</div>
						<div class="control-group">
							<label class="control-label">回复关键字</label><span class="maroon">*</span><span class="help-inline">(必填)</span>
							<div class="controls">
								<input type="hidden" value="<?php if($materials){ echo $materials[0]->tm_id;}?>" id="tm_id" class="span5" style="width: 482px;" name="tm_id" />
						    	<input type="text" value="<?php if($materials){ echo $materials[0]->tm_keyword;}?>" id="keywords" class="span5" style="width: 482px;" name="keywords" />
						    </div>
					    </div>
		</div>
		<div class="span7">
			<div class="msg-editer-wrapper">
				<div class="msg-editer">
					<div class="control-group">
						<label class="control-label">标题</label><span class="maroon">*</span><span class="help-inline">(必填,不能超过64个字)</span>
						<div class="controls">
					    	<input type="text" value="<?php if($materials){ echo $materials[0]->tm_title;}?>" id="title" class="span5" style="width: 482px;" name="title" />
					    </div>
				    </div>
				    <div class="control-group">
						<label class="control-label">封面</label><span class="maroon">*</span><span class="help-inline">(必须上传一张图片)</span>    
						<div class="controls">
							<div class="cover-area">
								<div class="cover-hd">
									<input id="file_upload" name="file_upload" type="file" />
									<input id="coverurl" value="<?php if($materials){ echo $materials[0]->tm_coverurl;}?>" name="coverurl" type="hidden" />
								</div>
								<p id="upload-tip" class="upload-tip">大图片：900px*500px;小图片：360px*200px</p>
								<p id="imgArea" class="cover-bd" style="display: none;">
								<img src="<?php if($materials){ echo $materials[0]->tm_coverurl;}?>" id="img">
								<a href="javascript:;" class="vb cover-del" id="delImg">删除</a>
								</p>
							</div>
						</div>
					</div>
				  	<div class="control-group">
					<label class="control-label">正文</label> <span class="maroon">*</span><span class="help-inline">(必填,不能超过20000个字)</span>     
					    <div class="controls">
							<script type="text/plain" id="editor"><?php if($materials){ echo $materials[0]->tm_content;}?></script>
						</div>
					</div>
					<a id="url-block-link" href="javascript:void(0);" class="url-link block" >添加来源</a>
				  	<div id="url-block" <?php if(!$materials){?>style="display: none;"<?php }?> class="control-group">
						<label class="control-label">来源</label> <span class="help-inline">(请输入正确的URL链接格式)</span>          
					    <div class="controls">
							<input type="text" id="source_url" class="span5" value="<?php if($materials){ echo $materials[0]->tm_source_url;}?>" style="width: 482px;" name="source_url" />
						</div>
					</div>
				  	<div class="control-group">
					    <div class="controls">
					      <button id="save-btn" type="submit" class="btn btn-primary btn-large">保存</button>
					      <button id="cancel-btn" type="button" class="btn btn-large">取消</button>
					    </div>
				    </div>
				    
				    <input id="uid" name="uid" type="hidden" value="42" />
				    <input id="action" name="action" type="hidden" value="mul_add" />
				</div>
				<span class="abs msg-arrow a-out" style="margin-top: 0px;"></span>
				<span class="abs msg-arrow a-in" style="margin-top: 0px;"></span>
			</div>
		</div>
	</div>
</body>
</html>