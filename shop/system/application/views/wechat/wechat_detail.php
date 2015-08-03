<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" >
<title>Green&Yummy</title>
<link rel="stylesheet" type="text/css" href="/css/wechat_new.css"/>
 <script type="text/javascript" src="/js/jquery-1.4.2.min.js"></script> 
 <script type="text/javascript" src="/js/cart.js"></script> 
</head>
<script>
showCount();
</script>

<script type="text/javascript">
	 $(function(){
  
$('.wechat_detail_info').eq(0).show();
$('#wechat_detail_list li').click(function (){
  $(this).addClass('active');
  $(this).siblings().removeClass('active');
  $('.wechat_detail_info').fadeOut('fast');
  $('.wechat_detail_info').eq($(this).index()).fadeIn('slow');
  
});


             
	 $(".wechat_plus_good").click(function(){

      var pic=$(this).parents(".wechat_detail").children().children().children('.wechat_good_detail_img');
	 var flyElm = $(pic).clone();
     flyElm.css({
     'z-index': 9000,
      'display': 'block',
      'position': 'absolute',
      'top': $(this).parents(".wechat_detail").children().children().children('.wechat_good_detail_img').offset().top +'0px',
      'left': $(this).parents(".wechat_detail").children().children().children('.wechat_good_detail_img').offset().left +'0px',
      'width': $(this).parents(".wechat_detail").children().children().children('.wechat_good_detail_img').width() +'px',
      'height': $(this).parents(".wechat_detail").children().children().children('.wechat_good_detail_img').height() +'px'
     })
    $('body').append(flyElm);
	flyElm.animate({
      top:$('.cart_count').offset().top,
      left:$('.cart_count').offset().left,
      width:30+'px',
      height:30+'px',
    });

	setTimeout(function(){$(flyElm).remove();},400);
	})
	showCount();
	 })
	</script>


<body>
<?php if($good_detail){?>
    <input type="hidden" id="hidden_weeks" value="<?php echo $this->input->get("date_week");?>">
<div class="wechat_detail">
	<dl>
	   <dt>
	   	 <img class="wechat_good_detail_img" src="<?php echo $good_detail->coverurl0;?>" alt="主菜"/>
	   </dt>
	   <dd>
	   	 <h3><?php echo $good_detail->goods_name;?></h3>
	   	 <p><!--<span>供应日期:</span><span>需替换</span>--></p>
         <p>¥<big><?php echo $good_detail->price;?></big>
		 
		 <button class="wechat_plus_good" data_good_id="<?php echo $this->input->get("goods_id");?>" date_week="<?php echo $this->input->get("date_week");?>">点餐</button>
	
		 <?php if($good_detail->stock=="0"){         
             ?>
          <img src="/images/wx_sq.png" class="wx_sq"/>
         <?php }?>
	
		 </p>
	   </dd>
	</dl>
	<ul id="wechat_detail_list">
		<li class="active">菜品</li>
		<li>餐厅</li>
	</ul>
	<dl class="wechat_detail_info">
		
		<dt>
		<?php if(!$good_detail->coverurl1&&!$good_detail->coverurl2&&!$good_detail->coverurl3&&!$good_detail->coverurl4){}else{?>
			<h3></h3>
			<ul>
				<li>
					<?php if($good_detail->coverurl1){?> <img src="<?php echo $good_detail->coverurl1;?>" />
					<span><?php echo $good_detail->title1;?></span>
					<?php }?>				
					<!--<img src="<?php echo $good_detail->coverurl1;?>">
					<span><?php echo $good_detail->title1;?></span>-->
				</li>
				<li>
					<?php if($good_detail->coverurl2){?> <img src="<?php echo $good_detail->coverurl2;?>" />
					<span><?php echo $good_detail->title2;?></span>
					<?php }?>
					<!--<img src="<?php echo $good_detail->coverurl2;?>">
					<span><?php echo $good_detail->title2;?></span>-->
				</li>
				<li>
					<?php if($good_detail->coverurl3){?> <img src="<?php echo $good_detail->coverurl3;?>" />
					<span><?php echo $good_detail->title3;?></span>
					<?php }?>
					<!--<img src="<?php echo $good_detail->coverurl3;?>">
					<span><?php echo $good_detail->title3;?></span>-->
				</li>
				<li>
					<?php if($good_detail->coverurl4){?> <img src="<?php echo $good_detail->coverurl4;?>" />
					<span><?php echo $good_detail->title4;?></span>
					<?php }?>
					<!--<img src="<?php echo $good_detail->coverurl4;?>">
					<span><?php echo $good_detail->title4;?></span>-->
				</li>
			</ul>
		<?php }?>
		</dt>
        <dd>
			<p><?php echo $good_detail->desc0;?></p>
		</dd>
	</dl>
	<dl class="wechat_detail_info">
		<dt>
			<h3></h3>
			
			<img src="<?php echo base_url()."api_images/suppliers/".$good_detail->image0_url;?>" alt="商家图片" />
			
		</dt>
		<dd>
			<p><span>店名: </span><?php echo $good_detail->supplier_name;?></p>
			<p><span>地址: </span><?php echo $good_detail->address;?></p>
			<p><span>介绍: </span><?php echo $good_detail->descr;?></p>
			
		</dd>
	</dl>
	<div class="wechat_detail_cart">
		<ul>
                    <li  id="go_to"  onclick="location.href='/wechat/confirm_step_two'"><i></i><span class="cart_count"></span></li>
			<li onclick="location.href='/wechat/index'"><i></i></li>
		</ul>
	</div>
</div>
<?php }?>
</body>
</html>