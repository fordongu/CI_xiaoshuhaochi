<?php $this->load->view('main/new_header');?> 
<style>

body{ 
	background:url(/images/default_index_bg.png);
	background-size:cover;   
	font-family: "Microsoft YaHei" !important;
}
</style>
 <script> 
	    $(document).ready(function(){
	    	var rea_height = 0; 
	    	var explorer = window.navigator.userAgent ;
	    	//ie 
	    	if (explorer.indexOf("MSIE") >= 0) {
	    		rea_height =  document.documentElement.clientHeight; 
	    	}
	    	//firefox 
	    	else if (explorer.indexOf("Firefox") >= 0) {
	    	   rea_height =  document.body.clientHeight; 
	    	}
	    	//Chrome
	    	else if(explorer.indexOf("Chrome") >= 0){
	    		rea_height =  document.documentElement.clientHeight-120; 
	    	}
	    	//Opera
	    	else if(explorer.indexOf("Opera") >= 0){
	    		rea_height =  document.body.clientHeight; 
	    	}
	    	//Safari
	    	else if(explorer.indexOf("Safari") >= 0){
	    		rea_height =  document.documentElement.clientHeight-120; 
	    	}
  			$('.default_index_content').css('height',rea_height+'px'); 
	    })
</script>	    
<!-- index_content -->
  <div class="default_index_content container_width">
     <div class="index_content_left float_left">
       <form id="search_form" > 
         <div class="index_content_header">
             <div class="content_select_div float_left">
				<div class="index_select_input float_left">
				    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;浦东新区
			    </div> 
				<div class="select_icon float_left">
				   <img src="/images/drop-down_02.png" class="select_top" />
				   <img src="/images/drop-down_03.png" class="select_bottom" />
				</div>              
             </div>
            
             	<input class="default_index_search_input float_left" id="keywords" name="keywords" placeholder="请输入写字楼(或路名)" />
            
         </div>
      </form>    
         <div class="index_building_title">
           请选择您所在的写字楼：
         </div> 
         <ul class="default_building_ul" id="service_buildings">
         <?php foreach($service_buildings as $k=>$v){?>
             <li data_id="<?php echo $v->id;?>" onclick="change_building(this)"><?php echo $v->name;?></li>
          <?php }?>   
         </ul>
     </div>
     <img src="/images/default_index_qcode.png" class="index_qcode float_right"  />
  </div>
<!-- index_content_end -->
<?php $this->load->view('main/new_footer');?>