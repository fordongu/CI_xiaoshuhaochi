<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<meta name="viewport" content="width=1000" />
	<meta name="baidu-site-verification" content="DaB7aTEuf9" />
	<meta name="360-site-verification" content="b5ee01669c37bdcd217103b2cde25bff" />
	<meta name="description" content="">	
	<meta property="qc:admins" content="2450024670601173050173016375" />
	<title>小树好吃</title>  
	<link href="/css/main.css" rel="stylesheet"> 
	<LINK href="/favicon.ico" type="image/x-icon" rel=icon>
	<LINK href="/favicon.ico" type="image/x-icon" rel="shortcut icon">
	<script>
	  var controller = '<?php echo $this->router->class; ?>';
	</script>
	<script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script> 
    <script type="text/javascript" src="/js/shop_common.js"></script>  
    <script>
    
	    $(document).ready(function(){
			var window_width = window.screen.width; 
			var percent = 1000/window_width;
			var left_per = (window_width-1000)/window_width/2;
			$('.select_div').css('left',left_per*100+'%');
			
			$('.container_width').css('width',percent*100+'%');
			$('.cart_div').css('left',86+'%');
			
			window.onresize = function(){
			
			 var window_width = document.body.clientWidth; 
			 var w = 1000;
			 if(window_width<1000){
		         var w = window_width;
			  } 
			 var percent = w/window_width;
			 $('.container_width').css('width',percent*100+'%');
			}
	    })
 </script>
</head>

<body> 
<?php $user_cookie = isset($_COOKIE['user_cookie'])?$_COOKIE['user_cookie']:'';
      if($user_cookie){
      	$user_cookie = unserialize($user_cookie);       
      }
?>
 <div class="header">
   <div class="container_width header_top" >
     <div class="top_content">
        <img src="/images/header_line.png" class="header_line float_left"/>
        <div class="current_location float_left">
           <img src="/images/location.png" class="location_icon float_left " />
           <div class="location_name gray_color float_left"><?php echo $service_buildings;?></div> 
           <img src="/images/header_line.png" class="header_line float_left"/>
           <div class="mobile float_left">
             <div class="mobile-title float_left">电话：</div>
             <div class="green_color float_left other_style"><?php echo $sys_mobile;?></div>
           </div>
           <img src="/images/header_line.png" class="header_line float_left"/>
           
	      <!-- login start -->    
	        <div class="login_div float_left">
	          <?php if(!$user_cookie){?> 
		           <input type="text" name="user_name"  class="login_input" id="header_username" placeholder="手机号码" />
		           <input type="password" name="password"  class="login_password" id="header_password"  placeholder="密码" />
		           <input type="button" value="登录"  id="submit_but" class="login_button cursor_pointer user_login_button" />
		           <span class="green_color cursor_pointer register_span" id="register_span">注册</span>
	           <?php }else{?>
	               <span class="green_color cursor_pointer" id="member_center_span" onclick="location.href='/member/index'">个人中心</span>
	               <span class="green_color cursor_pointer" id="logout_sys">退出</span>
	           <?php }?>
	        </div>
	         <img src="/images/header_line.png" class="header_line float_left"/>
	    <!-- login end --> 
	    
	    <!-- help_about_start -->
	        <div class="help_about float_left">
	            <p class="float_left help cursor_pointer">帮助</p>
	            <p class="float_left about cursor_pointer">关于我们</p>
	        </div>
	    <!-- help_about_end -->
        </div>   
        <img src="/images/header_line.png" class="header_line float_right"/>
     </div>
   </div>  
 </div>
 
 

