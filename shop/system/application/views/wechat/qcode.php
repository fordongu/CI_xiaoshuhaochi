

<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>微信安全支付</title>
</head>
<body  style="text-align:center;height:600px;width:600px;margin:0 auto;">
	

	<div align="center" style="font-size:18px;font-family:Microsoft YaHei,微软雅黑, Tahoma, Arial, Helvetica, 宋体;">
		<p>请使用微信“扫一扫”功能扫描下面的二维码进行支付！</p>
	</div>
	<div align="center" id="qrcode">
	</div>
	<div align="center" style="font-size:18px;font-family:Microsoft YaHei,微软雅黑, Tahoma, Arial, Helvetica, 宋体;">
		<p>订单号：<?php echo $out_trade_no; ?></p>
	</div>
</body>
	<script src="/js/qrcode.js"></script>
	<script src="/js/jquery.1.10.js"></script>
	<script>
	$(function(){
		$("img").attr("width","300");
		$("img").attr("height","300");
	})
	setTimeout('window_reload()',10000);

	function window_reload(){
		window.location.reload();
	}
		if(<?php echo $unifiedOrderResult["code_url"] != NULL; ?>)
		{
			var url = "<?php echo $code_url;?>";
			//参数1表示图像大小，取值范围1-10；参数2表示质量，取值范围'L','M','Q','H'
			var qr = qrcode(10, 'Q');
			qr.addData(url);
			qr.make();
			var wording=document.createElement('p');
			//wording.innerHTML = "请扫一扫下面的二维码";
			var code=document.createElement('DIV');
			code.innerHTML = qr.createImgTag();
			var element=document.getElementById("qrcode");
			element.appendChild(wording);
			element.appendChild(code);
		}
	</script>
	
</html>