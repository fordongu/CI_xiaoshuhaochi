<?php echo $this->load->view('main/new_header');?>
<script>
 $(document).ready(function(){
	$('.about_detail').hover(function(){
		 
	     $(this).children('.red_height').addClass('yellow'); 
	},function(){
		 $(this).children('.red_height').removeClass('yellow'); 
	})
	
 })
</script>
<div class="about_node">
  <p class="about_title_content left extra_title">关于</p>
  <div class="detail_left about_intro">
     <p><?php echo $about->descriptions;?></p>
  </div>
</div> 
 
<div class="about_content">
  <div class="about_detail left">
  	 <img src="<?php echo $yuanjing->coverurl;?>" style="width:530px" onclick="location.href='/main/news_detail/41'" />
  	 <p class="red_height"></p>
  	 <p class="about_detail_title" onclick="location.href='/main/news_detail/41'">愿景使命</p>
  </div>
  
  <div class="about_detail right">
  	<img src="<?php echo $hexin->coverurl;?>" style="width:530px"  onclick="location.href='/main/special'" />
  	<p class="red_height"></p>
  	<p class="about_detail_title" onclick="location.href='/main/special'">核心团队</p>
  </div>
  
  <div class="about_detail left">
  	<img src="<?php echo $ditu->coverurl;?>" style="width:530px"  onclick="location.href='/main/news_detail/27'" />
  	<p class="red_height"></p>
  	<p class="about_detail_title" onclick="location.href='/main/news_detail/114'" >地图导引</p>
  </div>
  
  <div class="about_detail right">
 	 <img src="<?php echo $lianxi->coverurl;?>" style="width:530px"  onclick="location.href='/main/news_detail/26'" />
 	 <p class="red_height"></p>
 	 <p class="about_detail_title" onclick="location.href='/main/news_detail/26'">联系方式</p>
  </div>
</div> 

<div class="scroll_top" id="back-to-top">
	    <img src="/images/about_top.png" data_flag ="low"/>
		<p>回到页首</p>
</div>
 
<?php echo $this->load->view('main/new_footer');?>