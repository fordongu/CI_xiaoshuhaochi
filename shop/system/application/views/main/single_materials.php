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
<script type="text/javascript" src="/resource/js/page/appmsg_single.js"></script>
<script type="text/javascript">window.UEDITOR_HOME_URL = '/ueditor/';</script>
<script type="text/javascript" src="/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/ueditor/ueditor.all.min.js"></script>
<link rel="stylesheet" href="/ueditor/themes/default/css/ueditor.css" />
<script type="text/javascript" src="/jquery-ui/js/jquery.uploadify.min.js"></script>
<title>单图文编辑</title>
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
            type:'single'
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
				<div id="appmsgItem1" class="msg-item">
					<h4 class="msg-t">
						<span class="i-title"><?php if($material){ echo $material->tm_title;}else{?>标题<?php }?></span>
					</h4>
					<p class="msg-meta">
						<span class="msg-date"><?php echo date('Y-m-d');?></span>
					</p>
					<div class="cover">
						<?php if(!$material){ ?><p class="default-tip" >封面图片</p><?php }?>
						<img class="i-img" <?php if($material){ ?>src="<?php echo base_url().$material->tm_coverurl; ?>" <?php } ?>  style="">
					</div>
					<p class="msg-text"><?php if($material){ echo $material->tm_summary;}?></p>
				</div>
				<div class="msg-hover-mask"></div>
				<div class="msg-mask">
					<span class="dib msg-selected-tip"></span>
				</div>
			</div>
		</div>
		<div class="span7">
			<div class="msg-editer-wrapper">
				<div class="msg-editer">
					<form id="appmsg-form" class="form">
						<div class="control-group">
							<label class="control-label">标题</label><span class="maroon">*</span><span class="help-inline">(必填,不能超过64个字)</span>
							<div class="controls">
						    	<input type="text" value="<?php if($material){ echo $material->tm_title;}?>" id="title" class="span5" style="width: 482px;" name="title" />
						    </div>
					    </div>
					    <div class="control-group">
							<label class="control-label">封面</label><span class="maroon">*</span><span class="help-inline">(必须上传一张图片)</span>    
							<div class="controls">
								<div class="cover-area">
									<div class="cover-hd">
										<input id="file_upload" name="file_upload" type="file" />
										<input id="coverurl" value="<?php if($material){ echo $material->tm_coverurl;}?>" name="coverurl" type="hidden" />
									</div>
									<p id="upload-tip" class="upload-tip">大图片：700px*300px,720*400,小图片：300px*167px</p>
									<p id="imgArea" class="cover-bd" style="display: none;">
									<?php if($material){ ?><img src="<?php if($material){ echo $material->tm_coverurl;}?>" id="img"><?php }?>
									<a href="javascript:;" class="vb cover-del" id="delImg">删除</a>
									</p>
								</div>
							</div>
						</div>
						<a id="desc-block-link" href="javascript:void(0);" class="url-link block" >添加摘要</a>
					  	<div id="desc-block"  class="control-group">
							<label class="control-label">摘要</label> <span class="help-inline">(不能超过120个字)</span>          
						    <div class="controls">
								<textarea name="summary" id="summary" class="msg-txta"><?php if($material){ echo $material->tm_summary;}?></textarea>    
							</div>
						</div>
					  	<div class="control-group">
						<label class="control-label">正文</label> <span class="maroon">*</span><span class="help-inline">(必填,不能超过20000个字)</span>     
						    <div class="controls">
								<script type="text/plain" id="editor"><?php if($material){ echo $material->tm_content;}?></script>
							</div>
						</div>
						<a id="url-block-link" href="javascript:void(0);" class="url-link block" >添加来源</a>
					  	<div id="url-block"  class="control-group">
							<label class="control-label">来源</label> <span class="help-inline">(请输入正确的URL链接格式)</span>          
						    <div class="controls">
								<input type="text" id="source_url" class="span5" value="<?php if($material){ echo $material->tm_source_url;}else{ echo 'http://www.xiaoshuhaochi.com/index.php?c=wechat&m=material_view';}?>" style="width: 482px;" name="source_url" />
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label">回复关键字</label><span class="maroon">*</span><span class="help-inline">(必填)</span>
							<div class="controls">
						    	<input type="text" value="<?php if($material){ echo $material->tm_keyword;}?>" id="title" class="span5" style="width: 482px;" name="keywords" />
						    </div>
					    </div>
					    
					  	<div class="control-group">
						    <div class="controls">
						      <button id="save-btn" type="submit" class="btn btn-primary btn-large">保存</button>
						      <button id="cancel-btn" type="button" class="btn btn-large">取消</button>
						      
						    </div>
					    </div>
					     
					    <input id="m_id" name="m_id" type="hidden" value="<?php if($material){ echo $material->tm_id;}?>" />
					</form> 
				</div>
				<span class="abs msg-arrow a-out" style="margin-top: 0px;"></span>
				<span class="abs msg-arrow a-in" style="margin-top: 0px;"></span>
			</div>
		</div>
	</div>
</body>
</html>