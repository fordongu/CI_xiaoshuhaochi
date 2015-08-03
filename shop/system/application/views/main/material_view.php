<html>
<head>
<meta http-equiv="Content-Type" content="testhtml" charset="utf-8">
<meta name="format-detection" content="telephone=no" />
<!--<meta name="viewport"
	content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">-->

	<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no" />
	
<link rel="stylesheet" href="/assets/normalize.css" type="text/css">
<link rel="stylesheet" href="/css/service/font_number.css" type="text/css">
<link rel="stylesheet" href="/css/service/circle.player.css">
<link rel="stylesheet" href="/css/service/dialog.css">
<link rel="stylesheet" href="/css/service/style.css">
<link rel="stylesheet" href="/css/service/old.css">

<link rel="stylesheet" href="/assets/all.css" type="text/less" />

<script src="/js/service/less-1.3.3.min.js" type="text/javascript"></script>
<script src="/js/jquery-1.7.2.min.js"></script>
<script src="/assets/jquery.easing.min.js" type="text/javascript"></script>
<script src="/assets/fastclick.js" type="text/javascript"></script> 
<style>
img {width:100%;}
p{
	font-size:19.25px;
	padding:0 4%;
    margin-bottom:1.5px;
} 
.title{
	font-size:19.25px;
	color:#4A4A4A;
	font-family: Helvetica Neue;
	margin-top:20px;
	padding-left:4%;
}
.time{
	color:#979797;
	font-size:16px;
	margin-left:4%;
	margin-right:4%;
	margin-top:5px;
	border-bottom:1px solid #979797;
	padding-bottom:10px;
}

#event-description img{
	margin-bottom:19.25px !important;
	margin-top:19.25px !important;
}
</style> 

<script type="text/javascript">

var dataForWeixin={
   appId:"",
   MsgImg:"<?php echo base_url().$material->tm_coverurl;?>",
   TLImg:"<?php echo base_url().$material->tm_coverurl;?>",
   url:"<?php echo base_url();?>index.php?c=main&m=material_view&id=<?php echo $material->tm_id?>",
   title:"<?php echo $material->tm_title;?>",
   desc:"<?php echo $material->tm_title;?>",
   fakeid:"",
   callback:function(){}
};

(function(){
   var onBridgeReady=function(){

   WeixinJSBridge.on('menu:share:appmessage', function(argv){
      WeixinJSBridge.invoke('sendAppMessage',{
         "appid":dataForWeixin.appId,
         "img_url":dataForWeixin.MsgImg,
         "img_width":"120",
         "img_height":"120",
         "link":dataForWeixin.url,
         "desc":dataForWeixin.desc,
         "title":dataForWeixin.title
      }, function(res){(dataForWeixin.callback)();});
   });
   WeixinJSBridge.on('menu:share:timeline', function(argv){
	  (dataForWeixin.callback)();
	  WeixinJSBridge.invoke('shareTimeline',{
         "img_url":dataForWeixin.TLImg,
         "img_width":"120",
         "img_height":"120",
         "link":dataForWeixin.url,
         "desc":dataForWeixin.desc,
         "title":dataForWeixin.title
      }, function(res){});
   });
   WeixinJSBridge.on('menu:share:weibo', function(argv){
	  WeixinJSBridge.invoke('shareWeibo',{
         "content":dataForWeixin.title,
         "url":dataForWeixin.url
      }, function(res){(dataForWeixin.callback)();});
   });
   WeixinJSBridge.on('menu:share:facebook', function(argv){
	  (dataForWeixin.callback)();
	  WeixinJSBridge.invoke('shareFB',{
         "img_url":dataForWeixin.TLImg,
         "img_width":"120",
         "img_height":"120",
         "link":dataForWeixin.url,
         "desc":dataForWeixin.desc,
         "title":dataForWeixin.title
      }, function(res){});
   });
};
if(document.addEventListener){
   document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
}else if(document.attachEvent){
   document.attachEvent('WeixinJSBridgeReady'   , onBridgeReady);
   document.attachEvent('onWeixinJSBridgeReady' , onBridgeReady);
}
})();

</script>
</head>
<body> 
	<div class="full_container"> 
		<div class="full">
			<img src="<?php echo $material->tm_coverurl;?>" />
			 		
		</div>
	</div>
	<div class="title"><?php echo $material->tm_title;?></div> 
	<div class="time"><?php echo $material->tm_time;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $material->tm_author;?></div>
	<div class="content_container">
		 
			<div id="event-description">
			   <?php echo $material->tm_content;?>
			</div>
		</div>
	 
</body>
</html>
