<?php echo $this->load->view('main/new_header');?>
<script type="text/javascript" src="/js/image_go2.js"></script>
<script type="text/javascript" src="/js/image_go.js"></script> 
<script>
 $(document).ready(function(){
	$('.about_detail').hover(function(){
		 
	     $(this).children('.red_height').addClass('yellow'); 
	},function(){
		 $(this).children('.red_height').removeClass('yellow'); 
	})

	$('.piclist4 a').hover(function(){
		 
	     $(this).next('.red_height').addClass('yellow'); 
	},function(){
		 $(this).next('.red_height').removeClass('yellow'); 
	})
	
 })
</script>
<img src="<?php echo $event->coverurl;?>"/>
<div class="about_title events_title">
  <p class="about_title_content extra_title">活动</p>
  <div class="detail_left about_intro events_intro">
     <p>作为设计创新公信力平台，CIDI举办多种形式的展览、论坛与研讨，内容涵盖设计、商业创新、技术应用、政府合作、人才培养等。</p>
  </div>
</div>   

<div class="news_list_line events_line"></div>  


 <!-- start_news -->
  <div class="home_news news_list_img">
     <div class="news_header news_list_header">
        <div class="news_little_title left"><a name="maodian1">展览</a></div>
        <div class="news_tab right">
           <?php if(count($news)>=2){?>
           <img src="/images/black_left.png"  class="og_prev3" data-attr="left"/>
           <img src="/images/black_right.png"  class="og_next3" data-attr="right" />
           <?php }?> 
	    </div>
     </div>
     <div class="picbox clear_float" style="min-height:520px;">
     	<ul class="piclist3 mainlist3" id="piclist">
     	<?php if ($news){
                  foreach($news as $k=>$v){?>
			<li>
			   <a href="/main/news_detail/<?php echo $v->tm_id;?>" target="_blank"><img src="<?php echo $v->tm_coverurl;?>" width="1080" /></a>
			   <p class="red_height event_height"></p>
			   <p class="slides_title left event_list_title" ><?php echo $v->tm_title;?></p>
		       <p class="slides_desc news_list_desc event_list_desc right" style="width:50%;"><?php echo $v->tm_summary;?></p> 
		    </li>
		 <?php }}?>  
		 <?php if ($news){
                  foreach($news as $k=>$v){?>
			<li>
			   <a href="/main/news_detail/<?php echo $v->tm_id;?>" target="_blank"><img src="<?php echo $v->tm_coverurl;?>" width="1080" /></a>
			   <p class="red_height event_height"></p>
			   <p class="slides_title left event_list_title"><?php echo $v->tm_title;?></p>
		       <p class="slides_desc news_list_desc event_list_desc right"><?php echo $v->tm_summary;?></p> 
		    </li>
		 <?php }}?>  
		</ul>
        <ul class="piclist3 swaplist3"></ul>
       </div> 
  </div> 
 <!-- end_news --> 
<div class="news_list_line"></div>  


<div class="home_news clear_float product_service_demo" >
     
     <div class="news_header">
         <div class="news_little_title left"><a name="maodian2">论坛</a></div>
        <div class="news_tab right">
        <?php if(count($hots)>2){?> 
           <img src="/images/black_left.png"  class="og_prev2" data-attr="left"/>
           <img src="/images/black_right.png"  class="og_next2" data-attr="right" /> 
         <?php }?>
	    </div>
	    
     </div>
    
     <div class="picbox clear_float" style="min-height:460px !important;">
     	<ul class="piclist2 mainlist2 detail_li" id="piclist">
     	<?php 
              foreach($hots as $k=>$v){?>
			<li style="width:532px;min-height:440px !important;">
			   <a href="/main/news_detail/<?php echo $v->tm_id;?>" target="_blank"><img src="<?php echo $v->tm_coverurl;?>" width="532" /></a>	
			   <p class="red_height"></p>
			   <p class="slides_title event_titles"><?php echo $v->tm_title;?></p>
		       <p class="slides_desc news_list_desc"><?php echo $v->tm_summary;?></p> 	    
		    </li>
		 <?php }?>
		 <?php 
              foreach($hots as $k=>$v){?>
			<li style="width:532px;min-height:440px !important;">
			   <a href="/main/news_detail/<?php echo $v->tm_id;?>" target="_blank"><img src="<?php echo $v->tm_coverurl;?>" width="532" /></a>	
			   <p class="red_height"></p>
			   <p class="slides_title event_titles"><?php echo $v->tm_title;?></p>
		       <p class="slides_desc news_list_desc"><?php echo $v->tm_summary;?></p> 	    
		    </li>
		 <?php }?>   
		</ul>
        <ul class="piclist2 swaplist2"  style="min-height:352px !important;"></ul>
       </div> 
  </div>
 
<div class="news_list_line events_line"></div>  
  
  
<div class="home_news clear_float product_service_demo">
      
     <div class="news_header">
         <div class="news_little_title left"><a name="maodian3">会议</a></div>
        <div class="news_tab right">
        <?php if(count($meetings)>2){?>
           <img src="/images/black_left.png"  class="og_prev4" data-attr="left"/>
           <img src="/images/black_right.png"  class="og_next4" data-attr="right" />
        <?php }?> 
	    </div>
	    
     </div>
    
     <div class="picbox clear_float" style="min-height:320px !important;">
     	<ul class="piclist4 mainlist4 detail_li" id="piclist">
     	<?php 
              foreach($meetings as $k=>$v){?>
			<li style="width:532px;min-height:440px !important;">
			   <a href="/main/news_detail/<?php echo $v->tm_id;?>" target="_blank"><img src="<?php echo $v->tm_coverurl;?>" width="532" /></a>	
			   <p class="red_height"></p>
			   <p class="slides_title event_titles"><?php echo $v->tm_title;?></p>
		        	    
		    </li>
		 <?php }?> 
		 <?php 
              foreach($meetings as $k=>$v){?>
			<li style="width:532px;min-height:440px !important;">
			   <a href="/main/news_detail/<?php echo $v->tm_id;?>" target="_blank"><img src="<?php echo $v->tm_coverurl;?>" width="532" /></a>	
			   <p class="red_height"></p>
			   <p class="slides_title event_titles"><?php echo $v->tm_title;?></p>
		        	    
		    </li>
		 <?php }?>   
		</ul>
        <ul class="piclist4 swaplist4"  style="min-height:352px !important;"></ul>
       </div> 
  </div>

  
<div class="scroll_top" id="back-to-top">
	    <img src="/images/about_top.png" data_flag ="low"/>
		<p>回到页首</p>
</div>
 
<?php echo $this->load->view('main/new_footer');?>