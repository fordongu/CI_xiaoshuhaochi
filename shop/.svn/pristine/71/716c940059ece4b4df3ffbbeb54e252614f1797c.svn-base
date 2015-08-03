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
<title>支付方式管理</title>
</head>
<body>
 <form class="form-horizontal"  id="tform" action="/admin/payment_add" method="POST">
		 
		<fieldset>
		   
			<legend><?php if ($id){?>修改支付<?php }else{?>新增支付<?php }?></legend>
			 <input type="hidden" value="<?php if($id){echo $id;}else{ echo 0;}?>" name="id" />
			<div class="control-group">
				<label class="control-label" for="option1">支付方式:</label>
				<div class="controls">
				    <select name="name">
				      <option value="alipay" <?php if($payment&&($payment->name=='alipay')){?>selected<?php }?>>支付宝</option>
				      <option value="wechat" <?php if($payment&&($payment->name=='wechat')){?>selected<?php }?>>微信支付</option>
				      <option value="daofu" <?php if($payment&&($payment->name=='daofu')){?>selected<?php }?>>货到付款</option>
				    </select>
					 
				</div>
			</div>	
			<div class="control-group">
				<label class="control-label" for="option1">支付账号:</label>
				<div class="controls">
					<input type="text" id="payname" name="payname" <?php if($payment){?> value="<?php echo $payment->payname; ?>" <?php }?>> <span>微信支付填写：微信支付商户号mchid</span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="option1">支付账号ID:</label>
				<div class="controls">
					<input type="text" id="app_id" name="app_id" <?php if($payment){?> value="<?php echo $payment->app_id; ?>" <?php }?>> <span>微信支付填写：appid</span>
				</div>
			</div>	
			
			<div class="control-group">
				<label class="control-label" for="option1">支付账号Secret:</label>
				<div class="controls">
					<input type="text" id="app_secret" name="app_secret" <?php if($payment){?> value="<?php echo $payment->app_secret; ?>" <?php }?>> <span>微信支付填写：appsecret</span>
				</div>
			</div>	
			<div class="control-group">
				<label class="control-label" for="option1">支付partnerkey:</label>
				<div class="controls">
					<input type="text" id="partner_key" name="partner_key" <?php if($payment){?> value="<?php echo $payment->partner_key; ?>" <?php }?>> <span>支付宝留空，微信必填</span>
				</div>
			</div>	
			 
			<div class="control-group">
				<label class="control-label" for="option1">状态:</label>
				<div class="controls">
					开启：<input type="radio" name="status" value="1" <?php if($payment&&$payment->status){?>checked<?php }?>/>关闭：<input type="radio" name="status" value="0"  <?php if($payment&&(!$payment->status)){?>checked<?php }?>/>
				</div>
			</div>
			 
   		  	<div class="control-group">
			    <div class="controls">
			      
			      <button id="save-btn" type="submit" class="btn btn-primary">保存</button>
			      <button id="back-btn" type="button" class="btn btn-primary" onclick="location.href='/admin/payment'">返回</button>
			    </div>
		    </div>
		</fieldset>
	</form>
<script type="text/javascript">
$(function(){
	var validator = $("#tform").validate({
		rules: {
			name: {required: true}
		},
		messages: {
			name: {required: "请输支付方式"}
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
});

</script>
</body>	
</html>