<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta name="robots" content="index, follow" />
<meta name="googlebot" content="index, follow" />
<link rel="stylesheet" href="<?php echo base_url();?>bootstrap/css/bootstrap.min.css" media="screen">
<link rel="stylesheet" href="<?php echo base_url();?>resource/css/admin/frame.css" media="screen">
<link rel="stylesheet" href="<?php echo base_url();?>resource/css/admin/guide.css" media="screen">
<link rel="icon" href="<?php echo base_url();?>resource/image/favicon.ico" type="image/x-icon"> 
<script type="text/javascript" src="<?php echo base_url();?>resource/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/messagetip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>resource/js/plugin/jquery.tipsy.js"></script>
<title>小树好吃</title>

<style>
.notice{
	position: absolute;
	top: 82px;
	left: 230px;
	z-index: 100;
	font-size: 14px;
	color: #3a87ad;
	height: 20px;
	overflow-y: hidden;
	font-weight:bold;
}
.notice li{
	padding-bottom: 10px;
}
.speaker{
	float: left;
	margin-top: 2px;
}
.user-type-logo.type-shoper {
	background: url(/resource/image/admin/shoper_spe.png) no-repeat;
	background-position:0px 0px;
}
</style>
</head>

<body class="showmenu">
	<div class="header"> 
	<div class="header-bottom">
		<div class="header-title"><i class="icon-home"></i><h5>运营管理平台</h5></div>
		<div class="header-info">欢迎您：<?php echo $user->username;?> [<a href="/admin/logout">退出</a>]<span class="line">&nbsp;</span></div>
	</div>
	
</div>
<div class="left">
	<div class="menu" id="menu">
 
<div class="nav-header" >智能客服</div>
<ul class="nav nav-list">
  <li><a href="/main/auto_service" target="main">首次关注微信回复</a></li>
  <li><a href="/main/single_list" target="main">图文回复</a></li> 
  <li><a href="/main/single_text" target="main">文本回复</a></li> 
</ul>
 

<div class="nav-header">商城管理</div>
<ul class="nav nav-list"  style="display:block;" >
	<li><a href="/store/category_index" target="main">菜品品类管理</a></li> 
	<li><a href="/store/supplier_index" target="main">供应商管理</a></li> 
	<li><a href="/store/areas" target="main">省市区管理</a></li> 
	<li><a href="/store/service_buildings_index" target="main">配送区域管理</a></li>
	<li class="active"><a href="/store/good_index" target="main">商品管理</a></li>
	<li><a href="/store/order_index" target="main">订单管理</a></li>
</ul>


<div class="nav-header" >优惠券管理</div>
<ul class="nav nav-list">
  <li><a href="/admin/coupon" target="main">优惠券管理</a></li>  
</ul>
 
 
<div class="nav-header" >后台权限管理</div>
<ul class="nav nav-list">
  <li><a href="/admin/admin_oauth" target="main">角色权限管理</a></li> 
  <li><a href="/admin/admin_index" target="main">后台用户管理</a></li>  
</ul>


<div class="nav-header" >用户管理</div>
<ul class="nav nav-list">
  <li><a href="/admin/user_list" target="main">用户列表</a></li>  
  <li><a href="/admin/company_index" target="main">企业用户列表</a></li>
  <li><a href="/admin/event_index" target="main">活动列表</a></li>  
</ul>



<div class="nav-header">相关配置</div>
<ul class="nav nav-list"> 
	<li><a href="/admin/sms_config" target="main">短信配置</a></li>
	<li><a href="/admin/jifen_bili_config" target="main">积分比例配置</a></li>
	<li><a href="/admin/payment_index" target="main">支付开关</a></li> 
	<li><a href="/main/reset_password" target="main">修改密码</a></li> 
	<li><a href="/admin/menu_settings_index" target="main">自定义菜单配置</a></li>
	<li><a href="/admin/weichat_settings" target="main">微信账号相关配置</a></li>
	<li><a href="/admin/order_time_settings" target="main">下单时间段配置</a></li> 
	<li><a href="/admin/order_date" target="main">下单提前天数管理</a></li>
	<li><a href="/admin/order_count" target="main">订单商品份数管理</a></li>  
</ul>


<script type="text/javascript">
$(".nav-header").click(function(e){
	var $nav = $(this).next();
	$nav.parent().find(".nav-list").not($nav).hide();
	$nav.toggle();
});
$(".nav-list li").click(function(e){
	var $li = $(this);
	$(".nav-list li").not($li).removeClass("active");
	$li.addClass("active");
});

function getUrlParam(name) {
	var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
	var r = window.location.search.substr(1).match(reg);  //匹配目标参数
	if (r!=null) return unescape(r[2]); return null; //返回参数值
} 
var ts = "20130605150325";
// 给每个连接后面添加时间戳，防止浏览器下iframe缓存不刷新的问题
$(".nav-list li a[target='main']").each(function(index,a){
	$a = $(a);
	if($a.attr("href").indexOf("?") != -1){
		$a.attr("href",$a.attr("href"));
	} else{
		$a.attr("href",$a.attr("href"));
	}
});
$(document).ready(function() {
	var targetParam = getUrlParam("target");
	var $href = $("li>a[href*='"+ targetParam + "']");
	if ($href.length > 0) {
		var $ul = $href.closest("ul");
		$ul.parent().find(".nav-list").not($ul).hide();
		$ul.toggle();
		
		$href.click();
		
		$(".main iframe").attr("src", $href.attr("href"));
	}
});
</script>

	</div>
	<div class="left-spliter"></div>
</div>
<div class="right">
	<div class="main">
		<iframe frameborder="0" id="main" name="main" src="/store/good_index" ></iframe>
	</div>
</div>


<style>
#article_choice_dialog{
	width: 800px;
	margin-left: -380px;
}
</style>
</body>
</html>