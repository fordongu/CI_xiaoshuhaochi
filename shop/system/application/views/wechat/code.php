<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
<meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport"> 
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta content="telephone=no" name="format-detection">
	<title>Green&Yummy</title>  
	<script>
	  var controller = '<?php echo $this->router->class; ?>';
	</script> 
	<link href="/css/wechat.css" rel="stylesheet"> 
	<link href="/css/wechat_new.css" rel="stylesheet">  
    <script type="text/javascript" src="/js//jquery-1.8.2.min.js"></script> 
    <script type="text/javascript" src="/js/jquery.touchSwipe.min.js"></script>  
    <script type="text/javascript" src="/js/shop_common.js"></script>   
<script> 
var u = navigator.userAgent, app = navigator.appVersion;
var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1; //android终端或者uc浏览器
var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
if(isAndroid){
	var window_width =  window.screen.availWidth/3; 
}else{
	var window_width =  window.screen.availWidth;
}

var real_width = window_width*0.9+'px';
var margin = window_width*0.05+'px';
var total_width = window_width*6+'px';
var real_height =  window.screen.height;

var IMG_WIDTH = window_width;
var currentImg = 0;
var maxImages = 5;
var speed = 500;

var imgs;

var swipeOptions = {
    triggerOnTouchEnd: true,
    swipeStatus: swipeStatus,
    allowPageScroll: "vertical",
    threshold: 75
};


/**
 * Catch each phase of the swipe.
 * move : we drag the div
 * cancel : we animate back to where we were
 * end : we animate to the next image
 */
function swipeStatus(event, phase, direction, distance) {
    //If we are moving before swipe, and we are going L or R in X mode, or U or D in Y mode then drag.
    if (phase == "move" && (direction == "left" || direction == "right")) {
        var duration = 0;

        if (direction == "left") {
            scrollImages((IMG_WIDTH * currentImg) + distance, duration);
        } else if (direction == "right") {
            scrollImages((IMG_WIDTH * currentImg) - distance, duration);
        }

    } else if (phase == "cancel") {
        scrollImages(IMG_WIDTH * currentImg, speed);
    } else if (phase == "end") {
        if (direction == "right") {
            previousImage();
        } else if (direction == "left") {
            nextImage();
        }
    }
}

function previousImage() {
    currentImg = Math.max(currentImg - 1, 0);
    scrollImages(IMG_WIDTH * currentImg, speed);
}

function nextImage() {
    currentImg = Math.min(currentImg + 1, maxImages - 1);
    scrollImages(IMG_WIDTH * currentImg, speed);
}

/**
 * Manually update the position of the imgs on drag
 */
function scrollImages(distance, duration) {
    imgs.css("transition-duration", (duration / 1000).toFixed(1) + "s");

    //inverse the number we set in the css
    var value = (distance < 0 ? "" : "-") + Math.abs(distance).toString();
    imgs.css("transform", "translate(" + value + "px,0)");
}

$(function () {
	 
	$('.click_popup').click(function(){
		$('#wechat_popup').toggle();
	})
	 
	$('.wechat_goods_detail_div').css('width',real_width);
	
	$('.good_detail_img').css('width',real_width);
	$('.wechat_goods_detail_div').css('height',real_height);
	$('.wechat_goods_detail_div').css('margin-left',margin);
	$('.wechat_goods_detail_div').css('margin-right',margin);
	$('#wechat_index_goods').css({'width':total_width,'transform':'translate(-2880px, 0px)'});
    imgs = $("#wechat_index_goods");
    imgs.swipe(swipeOptions);


    $('#popup_area_ul').children('li').click(function(){
		   var service_id = $(this).attr('data_id');
		   if(service_id !=0){
			   var submitData = {service_id:service_id};
			      $.post('/member/ajax_update_service_buildings', submitData,function(data) { 
			    	   
						if (data.success == 'yes') { 
						  	window.location.reload();   
						} 
					},"json");
		   }
	 })

	 $('#popup_ul').children('li').click(function(){
		   var area_id = $(this).attr('data_id');
		   if(area_id !=0){
			   var submitData = {id:area_id,type:'service_buildings'};
			      $.post('/member/ajax_get_companys', submitData,function(data) { 
			    	   
						if (data.success == 'yes') { 
						  	 var count = data.msg.length;
						  	 var msg = data.msg;
						  	 var str= '';
						  	 for(var i=0;i<count;i++){
   							   str+="<li data_id='"+msg[i].id+"'>"+msg[i].name+"</li>";
							 }  
							 $('#popup_area_ul').html(str);
						} 
					},"json");
		   }
	 })
	 
});


</script> 
</head>
<body>
<input type="hidden" id="per_count_limit" value="<?php echo $per_count_limit;?>" />
<input type="hidden" id="total_count_limit" value="<?php echo $total_count_limit;?>" />
<div id="wechat_popup" <?php if(!$building_flag){?>style="display:block;"<?php }?>>
   <ul id="popup_ul" class="float_left popup_ul" <?php if(!$building_flag){?>style="display:block;"<?php }?>> 
    <?php foreach($area as $k=>$v){?>
       <li data_id = '<?php echo $v->area_id;?>'><?php echo $v->area;?><img src="/images/wechat_area_arrow.png" class="wechat_area_arrow" /></li>
    <?php }?> 
   </ul>
   
    <ul id="popup_area_ul" class="float_left popup_ul">
    <?php foreach($service_buildings as $k=>$v){?>  
     <li data_id = "<?php echo $v->id;?>"><?php echo $v->name;?></li>
    <?php }?> 
      
   </ul>

</div>
<div class="wechat_new_title">
   <div class="wechat_buildings_name float_left click_popup" >
      <?php echo $default_building;?>&nbsp;
   </div>
   <img src="/images/wechat_new_arrow.png" class="float_left down_arrow click_popup" />
   <img src="/images/wechat_avatar.png" class="person_icon float_right" />

</div>
<div class="wechat_index_goods" id="wechat_index_goods">
<?php
	$current_time = date('H:i:s');
	$date_no = 0;
 foreach($week_orders as $key=>$val){
	$date_no++;
        foreach($goods as $j=>$good){         
	?> 
   <div class="wechat_goods_detail_div">
         <div class="detail_week"><?php echo $val;?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $weeks[$key];?></div>
     <!-- first_good -->   
     <?php foreach($good->temp_goods as $k=>$v){
           if(in_array($key,$v->week)){  
     	?> 
         <div class="good_detail_img_div">
            <img src="<?php echo $v->coverurl0;?>" class="good_detail_img"/>
            <div class="good_detail_title"><?php echo $v->title0;?></div>
            <ul>
              <li class="good_name_icon">菜名</li> 
              <?php if($v->title1){?><li class="normal_icon"><?php echo $v->title1;?></li> <?php }?>
              <?php if($v->title2){?><li class="normal_icon"><?php echo $v->title2;?></li> <?php }?>
              <?php if($v->title3){?><li class="normal_icon"><?php echo $v->title3;?></li> <?php }?>
              <?php if($v->title4){?><li class="normal_icon"><?php echo $v->title4;?></li> <?php }?>
               
            </ul>
            <div class="wechat_good_detail_price_count ">
               <div class="wechat_good_price float_left">
                 ￥<?php echo $v->price;?>
               </div>
               
               <div class="wechat_good_buy_button float_right">
                   <div class="wechat_minus_good wechat_buy_icon float_left">-</div>
                   <div class="float_left buy_good_count">
                     <?php if($cookie_good){
	                    	 	  $count = 0;
	                    	 	  
		                           foreach($cookie_good as $m=>$j){
			  						  foreach($j as $l=>$n){
		   								  if(($l==$key)&&($n['id']==$v->good_id)){
		 										$count =  $n['count'];
			                    	       } 
		                    	       }
									}
									echo $count;
	                   			 }else{ echo 0;}
							?>
                   </div>
                   <div class="wechat_plus_good wechat_buy_icon float_left">+</div>
               </div> 
            </div> 
         </div>
     <!-- first_good_end --> 
    <?php }}?> 
     <!-- first_good -->    
         <div class="good_detail_img_div">
            <img src="/api_images/2015013074243jFZCUVKf6.jpg" class="good_detail_img"/>
            <div class="good_detail_title">牛肉套餐</div>
            <ul>
              <li class="good_name_icon">菜名</li> 
              <li class="normal_icon">芹菜肉丝</li> 
              <li class="normal_icon">香菇菜心</li> 
            </ul>
            <div class="wechat_good_detail_price_count ">
               <div class="wechat_good_price float_left">
                 ￥25
               </div>
               
               <div class="wechat_good_buy_button float_right">
                   <div class="wechat_minus_good wechat_buy_icon float_left">-</div>
                   <div class="float_left buy_good_count">
                      
                   </div>
                   <div class="wechat_plus_good wechat_buy_icon float_left">+</div>
               </div> 
            </div> 
         </div>
     <!-- first_good_end -->
<?php }}?>     
     <!-- first_good -->    
         <div class="good_detail_img_div">
            <img src="/api_images/2015013074243jFZCUVKf6.jpg" class="good_detail_img"/>
            <div class="good_detail_title">牛肉套餐</div>
            <ul>
              <li class="good_name_icon">菜名</li> 
              <li class="normal_icon">芹菜肉丝</li> 
              <li class="normal_icon">香菇菜心</li> 
            </ul>
            <div class="wechat_good_detail_price_count ">
               <div class="wechat_good_price float_left">
                 ￥25
               </div>
               
               <div class="wechat_good_buy_button float_right">
                   <div class="wechat_minus_good wechat_buy_icon float_left">-</div>
                   <div class="float_left buy_good_count">1</div>
                   <div class="wechat_plus_good wechat_buy_icon float_left">+</div>
               </div> 
            </div> 
         </div>
     <!-- first_good_end -->
         
   </div>
   
   <div class="wechat_goods_detail_div">
         <div class="detail_week">周二&nbsp;&nbsp;|&nbsp;&nbsp;2015-02-03</div>
     <!-- first_good -->    
         <div class="good_detail_img_div">
            <img src="/api_images/2015013074243jFZCUVKf6.jpg" class="good_detail_img"/>
            <div class="good_detail_title">牛肉套餐</div>
            <ul>
              <li class="good_name_icon">菜名</li> 
              <li class="normal_icon">芹菜肉丝</li> 
              <li class="normal_icon">香菇菜心</li> 
            </ul>
            <div class="wechat_good_detail_price_count ">
               <div class="wechat_good_price float_left">
                 ￥25
               </div>
               
               <div class="wechat_good_buy_button float_right">
                   <div class="wechat_minus_good wechat_buy_icon float_left">-</div>
                   <div class="float_left buy_good_count">1</div>
                   <div class="wechat_plus_good wechat_buy_icon float_left">+</div>
               </div> 
            </div> 
         </div>
     <!-- first_good_end --> 
     
     <!-- first_good -->    
         <div class="good_detail_img_div">
            <img src="/api_images/2015013074243jFZCUVKf6.jpg" class="good_detail_img"/>
            <div class="good_detail_title">牛肉套餐</div>
            <ul>
              <li class="good_name_icon">菜名</li> 
              <li class="normal_icon">芹菜肉丝</li> 
              <li class="normal_icon">香菇菜心</li> 
            </ul>
            <div class="wechat_good_detail_price_count ">
               <div class="wechat_good_price float_left">
                 ￥25
               </div>
               
               <div class="wechat_good_buy_button float_right">
                   <div class="wechat_minus_good wechat_buy_icon float_left">-</div>
                   <div class="float_left buy_good_count">1</div>
                   <div class="wechat_plus_good wechat_buy_icon float_left">+</div>
               </div> 
            </div> 
         </div>
     <!-- first_good_end -->
     
     <!-- first_good -->    
         <div class="good_detail_img_div">
            <img src="/api_images/2015013074243jFZCUVKf6.jpg" class="good_detail_img"/>
            <div class="good_detail_title">牛肉套餐</div>
            <ul>
              <li class="good_name_icon">菜名</li> 
              <li class="normal_icon">芹菜肉丝</li> 
              <li class="normal_icon">香菇菜心</li> 
            </ul>
            <div class="wechat_good_detail_price_count ">
               <div class="wechat_good_price float_left">
                 ￥25
               </div>
               
               <div class="wechat_good_buy_button float_right">
                   <div class="wechat_minus_good wechat_buy_icon float_left">-</div>
                   <div class="float_left buy_good_count">1</div>
                   <div class="wechat_plus_good wechat_buy_icon float_left">+</div>
               </div> 
            </div> 
         </div>
     <!-- first_good_end -->
         
   </div>
   
   <div class="wechat_goods_detail_div">
         <div class="detail_week">周三&nbsp;&nbsp;|&nbsp;&nbsp;2015-02-05</div>
     <!-- first_good -->    
         <div class="good_detail_img_div">
            <img src="/api_images/2015013074243jFZCUVKf6.jpg" class="good_detail_img"/>
            <div class="good_detail_title">牛肉套餐</div>
            <ul>
              <li class="good_name_icon">菜名</li> 
              <li class="normal_icon">芹菜肉丝</li> 
              <li class="normal_icon">香菇菜心</li> 
            </ul>
            <div class="wechat_good_detail_price_count ">
               <div class="wechat_good_price float_left">
                 ￥25
               </div>
               
               <div class="wechat_good_buy_button float_right">
                   <div class="wechat_minus_good wechat_buy_icon float_left">-</div>
                   <div class="float_left buy_good_count">1</div>
                   <div class="wechat_plus_good wechat_buy_icon float_left">+</div>
               </div> 
            </div> 
         </div>
     <!-- first_good_end --> 
     
     <!-- first_good -->    
         <div class="good_detail_img_div">
            <img src="/api_images/2015013074243jFZCUVKf6.jpg" class="good_detail_img"/>
            <div class="good_detail_title">牛肉套餐</div>
            <ul>
              <li class="good_name_icon">菜名</li> 
              <li class="normal_icon">芹菜肉丝</li> 
              <li class="normal_icon">香菇菜心</li> 
            </ul>
            <div class="wechat_good_detail_price_count ">
               <div class="wechat_good_price float_left">
                 ￥25
               </div>
               
               <div class="wechat_good_buy_button float_right">
                   <div class="wechat_minus_good wechat_buy_icon float_left">-</div>
                   <div class="float_left buy_good_count">1</div>
                   <div class="wechat_plus_good wechat_buy_icon float_left">+</div>
               </div> 
            </div> 
         </div>
     <!-- first_good_end -->
     
     <!-- first_good -->    
         <div class="good_detail_img_div">
            <img src="/api_images/2015013074243jFZCUVKf6.jpg" class="good_detail_img"/>
            <div class="good_detail_title">牛肉套餐</div>
            <ul>
              <li class="good_name_icon">菜名</li> 
              <li class="normal_icon">芹菜肉丝</li> 
              <li class="normal_icon">香菇菜心</li> 
            </ul>
            <div class="wechat_good_detail_price_count ">
               <div class="wechat_good_price float_left">
                 ￥25
               </div>
               
               <div class="wechat_good_buy_button float_right">
                   <div class="wechat_minus_good wechat_buy_icon float_left">-</div>
                   <div class="float_left buy_good_count">1</div>
                   <div class="wechat_plus_good wechat_buy_icon float_left">+</div>
               </div> 
            </div> 
         </div>
     <!-- first_good_end -->
         
   </div>
   
   <div class="wechat_goods_detail_div">
         <div class="detail_week">周四&nbsp;&nbsp;|&nbsp;&nbsp;2015-02-03</div>
     <!-- first_good -->    
         <div class="good_detail_img_div">
            <img src="/api_images/2015013074243jFZCUVKf6.jpg" class="good_detail_img"/>
            <div class="good_detail_title">牛肉套餐</div>
            <ul>
              <li class="good_name_icon">菜名</li> 
              <li class="normal_icon">芹菜肉丝</li> 
              <li class="normal_icon">香菇菜心</li> 
            </ul>
            <div class="wechat_good_detail_price_count ">
               <div class="wechat_good_price float_left">
                 ￥25
               </div>
               
               <div class="wechat_good_buy_button float_right">
                   <div class="wechat_minus_good wechat_buy_icon float_left">-</div>
                   <div class="float_left buy_good_count">1</div>
                   <div class="wechat_plus_good wechat_buy_icon float_left">+</div>
               </div> 
            </div> 
         </div>
     <!-- first_good_end --> 
     
     <!-- first_good -->    
         <div class="good_detail_img_div">
            <img src="/api_images/2015013074243jFZCUVKf6.jpg" class="good_detail_img"/>
            <div class="good_detail_title">牛肉套餐</div>
            <ul>
              <li class="good_name_icon">菜名</li> 
              <li class="normal_icon">芹菜肉丝</li> 
              <li class="normal_icon">香菇菜心</li> 
            </ul>
            <div class="wechat_good_detail_price_count ">
               <div class="wechat_good_price float_left">
                 ￥25
               </div>
               
               <div class="wechat_good_buy_button float_right">
                   <div class="wechat_minus_good wechat_buy_icon float_left">-</div>
                   <div class="float_left buy_good_count">1</div>
                   <div class="wechat_plus_good wechat_buy_icon float_left">+</div>
               </div> 
            </div> 
         </div>
     <!-- first_good_end -->
     
     <!-- first_good -->    
         <div class="good_detail_img_div">
            <img src="/api_images/2015013074243jFZCUVKf6.jpg" class="good_detail_img"/>
            <div class="good_detail_title">牛肉套餐</div>
            <ul>
              <li class="good_name_icon">菜名</li> 
              <li class="normal_icon">芹菜肉丝</li> 
              <li class="normal_icon">香菇菜心</li> 
            </ul>
            <div class="wechat_good_detail_price_count ">
               <div class="wechat_good_price float_left">
                 ￥25
               </div>
               
               <div class="wechat_good_buy_button float_right">
                   <div class="wechat_minus_good wechat_buy_icon float_left">-</div>
                   <div class="float_left buy_good_count">1</div>
                   <div class="wechat_plus_good wechat_buy_icon float_left">+</div>
               </div> 
            </div> 
         </div>
     <!-- first_good_end -->
         
   </div>
   
   <div class="wechat_goods_detail_div">
         <div class="detail_week">周五&nbsp;&nbsp;|&nbsp;&nbsp;2015-02-03</div>
     <!-- first_good -->    
         <div class="good_detail_img_div">
            <img src="/api_images/2015013074243jFZCUVKf6.jpg" class="good_detail_img"/>
            <div class="good_detail_title">牛肉套餐</div>
            <ul>
              <li class="good_name_icon">菜名</li> 
              <li class="normal_icon">芹菜肉丝</li> 
              <li class="normal_icon">香菇菜心</li> 
            </ul>
            <div class="wechat_good_detail_price_count ">
               <div class="wechat_good_price float_left">
                 ￥25
               </div>
               
               <div class="wechat_good_buy_button float_right">
                   <div class="wechat_minus_good wechat_buy_icon float_left">-</div>
                   <div class="float_left buy_good_count">1</div>
                   <div class="wechat_plus_good wechat_buy_icon float_left">+</div>
               </div> 
            </div> 
         </div>
     <!-- first_good_end --> 
     
     <!-- first_good -->    
         <div class="good_detail_img_div">
            <img src="/api_images/2015013074243jFZCUVKf6.jpg" class="good_detail_img"/>
            <div class="good_detail_title">牛肉套餐</div>
            <ul>
              <li class="good_name_icon">菜名</li> 
              <li class="normal_icon">芹菜肉丝</li> 
              <li class="normal_icon">香菇菜心</li> 
            </ul>
            <div class="wechat_good_detail_price_count ">
               <div class="wechat_good_price float_left">
                 ￥25
               </div>
               
               <div class="wechat_good_buy_button float_right">
                   <div class="wechat_minus_good wechat_buy_icon float_left">-</div>
                   <div class="float_left buy_good_count">1</div>
                   <div class="wechat_plus_good wechat_buy_icon float_left">+</div>
               </div> 
            </div> 
         </div>
     <!-- first_good_end -->
     
     <!-- first_good -->    
         <div class="good_detail_img_div">
            <img src="/api_images/2015013074243jFZCUVKf6.jpg" class="good_detail_img"/>
            <div class="good_detail_title">牛肉套餐</div>
            <ul>
              <li class="good_name_icon">菜名</li> 
              <li class="normal_icon">芹菜肉丝</li> 
              <li class="normal_icon">香菇菜心</li> 
            </ul>
            <div class="wechat_good_detail_price_count ">
               <div class="wechat_good_price float_left">
                 ￥25
               </div>
               
               <div class="wechat_good_buy_button float_right">
                   <div class="wechat_minus_good wechat_buy_icon float_left">-</div>
                   <div class="float_left buy_good_count">1</div>
                   <div class="wechat_plus_good wechat_buy_icon float_left">+</div>
               </div> 
            </div> 
         </div>
     <!-- first_good_end -->
         
   </div>


</div>
</body>
</html>
