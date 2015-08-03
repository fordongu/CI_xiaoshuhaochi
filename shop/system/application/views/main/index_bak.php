<?php $this->load->view('main/new_header');?>
<div class="select_div">
  <ul class="select_tab">
    <li data_province_id='0' class="active" id="province_title_li" data_name="province_ul"><span id="province_span"><?php echo $province[0]->province;?></span><i></i></li>
    <li data_city_id='0' id="city_title_li" data_name="city_ul"><span id="city_span">全部</span><i></i></li>
    <li data_area_id='0' id="area_title_li" data_name="area_ul"><span id="area_span">全部</span><i></i></li>
    <li data_building_id='0' id="building_title_li" data_name="building_ul"><span id="building_span">全部</span><i></i></li>
  </ul>  
  <ul class="select_detail_ul" id="province_ul">
      
    <?php foreach($province as $k=>$v){?>
      <li data_id="<?php echo $v->province_id;?>"><a><?php echo $v->province;?></a></li>
    <?php }?>  
  </ul>
  
  <ul class="select_detail_ul" id="city_ul"> 
       
  </ul>
  
  <ul class="select_detail_ul" id="area_ul"> 
      
  </ul>
  <ul class="select_detail_ul" id="building_ul"> 
     
  </ul>
</div>
<script>

function change_building(building_id,building_name){
	  var uid = '<?php echo $uid;?>';
	  if(uid !=0){
	  var submitData = {val:building_id,field:'tu_default_building',uid:uid};
	    $.post('/member/ajax_update_user', submitData,function(data) { 
				if (data.success == 'yes') { 
					window.location.href='<?php echo base_url();?>index.php?c=main&m=index&keywords='+building_name; 
				}  
				 
			},"json");
	  }else{
		  window.location.href='<?php echo base_url();?>index.php?c=main&m=index&keywords='+building_name; 
      }	
}


function change_city(city_id,city){
	 var submitData = {id:city_id,type:'area'};
     $.post('/member/ajax_get_city_area', submitData,function(data) { 
			if (data.success == 'yes') { 
			    var msg = data.msg;
			    var str = '';
			    for(var i=0;i<msg.length;i++){
				    str+="<li data_id='"+msg[i].area_id+"' data_p_id='"+city_id+"' onclick=change_area('"+msg[i].area_id+"','"+msg[i].area+"') ><a >"+msg[i].area+"</a></li>";					    
			    }    
			}  
			$('#area_ul').html(str);
			$('#city_ul').hide();
			$('#area_ul').show();
			$('#city_span').html(city);

			$('#city_title_li').removeClass('active');  
		    $('#city_title_li').show();
		    $('#area_title_li').show().addClass('active'); 
			
		},"json");
}



function change_area(area_id,area){
	 var submitData = {id:area_id,type:'service_buildings'};
   $.post('/member/ajax_get_companys', submitData,function(data) { 
			if (data.success == 'yes') { 
			    var msg = data.msg;
			    var str = '';
			    for(var i=0;i<msg.length;i++){
				    str+="<li data_id='"+msg[i].id+"' data_p_id='"+area_id+"' onclick=change_building('"+msg[i].id+"','"+msg[i].name+"') ><a >"+msg[i].name+"</a></li>";					    
			    }    
			}else{
				$('#building_ul').html('');
			}  
			 
			$('#building_ul').html(str);
			$('#area_ul').hide();
			$('#building_ul').show();
			$('#area_span').html(area);

			$('#area_title_li').removeClass('active');  
		    $('#area_title_li').show();
		    $('#building_title_li').show().addClass('active'); 
			
		},"json");
}


	
 $(document).ready(function(){
    $('.location_name').click(function(){
		$('.select_div').toggle();
     })
   
	 
    $('.select_tab').children('li').click(function(){
    	$('.select_tab').children('li').removeClass('active');
    	$(this).addClass('active');
    	var name = '#'+$(this).attr('data_name');
    	$('.select_detail_ul').hide(); 
    	$(name).show();
    })	 
    
    
    $('#province_ul').children('li').click(function(){
       var data_id = $(this).attr('data_id');
       var province= $(this).children('a').html();
      
       var submitData = {id:data_id,type:'city'};
	      $.post('/member/ajax_get_city_area', submitData,function(data) { 
				if (data.success == 'yes') { 
				    var msg = data.msg;
				    var str = '';
				    for(var i=0;i<msg.length;i++){
					    str+="<li data_id='"+msg[i].city_id+"' data_p_id='"+data_id+"' onclick=change_city('"+msg[i].city_id+"','"+msg[i].city+"')><a >"+msg[i].city+"</a></li>";					    
				    }    
				}  
				$('#city_ul').html(str);
				$('#province_ul').hide();
				$('#city_ul').show();
				$('#province_span').html(province);

			    $('#province_title_li').removeClass('active');  
			    $('#province_title_li').show();
			    $('#city_title_li').show().addClass('active'); 
			    
			},"json");
    })
    
  

     $('#city_ul').children('li').live('click',function(){
       var data_id = $(this).attr('data_id');
       var city= $(this).children('a').html();
     
       var submitData = {id:data_id,type:'area'};
	      $.post('/member/ajax_get_city_area', submitData,function(data) { 
				if (data.success == 'yes') { 
				    var msg = data.msg;
				    var str = '';
				    for(var i=0;i<msg.length;i++){
					    str+="<li data_id='"+msg[i].area_id+"' data_p_id='"+data_id+"' ><a >"+msg[i].area+"</a></li>";					    
				    }    
				}  
				$('#area_ul').html(str);
				$('#city_ul').hide();
				$('#area_ul').show();
				$('#city_span').html(city);

				$('#city_title_li').removeClass('active');  
			    $('#city_title_li').show();
			    $('#area_title_li').show().addClass('active'); 
				
			},"json");
    })
 })
</script>

<input type="hidden" id="per_count_limit" value="<?php echo $per_count_limit;?>" />
<input type="hidden" id="total_count_limit" value="<?php echo $total_count_limit;?>" />
<div class="search_div header_img">
   <div class="container_width search_content">
      <img src="/images/logo.png" class="logo_img float_left cursor_pointer" onclick="location.href='/main/index'"/>       
      <div class="index_search_input float_left"> 
        <input type="text" name="keywords" id="search_input" class="float_left" placeholder="输入搜索关键字搜索地址，写字楼名" /> 
        <img src="/images/search_icon.png" class="float_left search_img cursor_pointer" id="default_search_but"/>
 
      </div>
      
   </div>
</div> 
<div class="container container_width">
<!-- select buildings -->
 <div class="select_buildings">
     <ul> 
       <?php if($service_building){foreach($service_building as $k=>$v){
       	         if($k<6){
             ?>
         <li data-id="<?php echo $v['id'];?>"  class="float_left <?php if($v['id']==$current_service_building){?>current_buildings<?php }?>" ><?php echo $v['name'];?></li>
       <?php }}}else{
       	   echo '<span style="margin-left:30%;">您搜索的写字楼还未开发，请稍后再来</span>';
       } ?> 
     </ul>
 </div> 
 <!-- end_buildings -->
 
 <!-- good_menu -->
<?php 
      $current_time = date('H:i:s');
      $date_no = 0;
      
     foreach($week_orders as $key=>$val){
        $date_no++;  
        foreach($goods as $j=>$good){        
	?> 
  <div data_week="<?php echo $key;?>" data_date="<?php echo $val;?>" class="good_menus data_buildings_<?php echo $good->id;?>" <?php if($good->id != $current_service_building){?>style="display:none;"<?php }?>>
     <div class="shipping_time_date">
         <div class="menus_title float_left"><?php echo $val;?>&nbsp;&nbsp;<?php echo $weeks[$key];?></div>
     	 <div class="shipping_time float_left">配送时间：<?php echo date('H:i',strtotime($good->start_time));?>--<?php echo date('H:i',strtotime($good->end_time));?></div>
     </div>
     <div class="menus_detail">
     <?php foreach($good->temp_goods as $k=>$v){  
           if(in_array($key,$v->week)){  
     	?>
	       <ul data_building_id="<?php echo $v->building_id;?>" data_good_id="<?php echo $v->good_id;?>"  >
	       <?php if($v->title0){?>
	         <li>
	             <img src="<?php echo $v->coverurl0;?>"  class="menus_img"/>
	             <div class="goods_name"><?php echo $v->title0;?></div>
	         </li>
	       <?php }?> 
	       <?php if($v->title1){?>
	         <li>
	             <img src="<?php echo $v->coverurl1;?>"  class="menus_img"/>
	             <div class="goods_name"><?php echo $v->title1;?></div>
	         </li>
	       <?php }?> 
	       <?php if($v->title2){?>
	         <li>
	             <img src="<?php echo $v->coverurl2;?>"  class="menus_img"/>
	             <div class="goods_name"><?php echo $v->title2;?></div>
	         </li>
	       <?php }?> 
	       <?php if($v->title3){?>
	         <li>
	             <img src="<?php echo $v->coverurl3;?>"  class="menus_img"/>
	             <div class="goods_name"><?php echo $v->title3;?></div>
	         </li>
	       <?php }?> 
	       <?php if($v->title4){?>
	         <li>
	             <img src="<?php echo $v->coverurl4;?>"  class="menus_img"/>
	             <div class="goods_name"><?php echo $v->title4;?></div>
	         </li>
	       <?php }?>  
	         <li style="float:right;margin-right:1.3%;">
	            <div class="good_buy">
	               <div class="price">￥<?php echo $v->price;?>/份</div>
	               <div class="plus_minus">
	                  <div class="minus_good good_button">-</div>
	                  <div class="good_count">
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
	                 
	                   <?php if (($current_time<$order_time->tc_title)||($current_time>$order_time->tc_content)||($date_no>$valid_date)){?>
	                  <div class="plus  good_button ">+</div>
	                  <?php }else{?>
	                  	 <div class="plus plus_good good_button high_but">+</div>
	                  <?php }?>
                  
	               </div>
	             <?php if (($current_time<$order_time->tc_title)||($current_time>$order_time->tc_content)||($date_no>$valid_date)){?>
	                <img src="/images/gray_button.png" class="gray_good_buy_button" style="display:none;"/>
	             <?php }else{?>  
	               <img src="/images/buy_button.png" class="good_buy_button" style="display:none;" />
	               <?php }?>
	            </div>  
	         </li>
	      </ul>  
      <?php }}?> 
     </div>
  </div>
  <?php } }?> 
 <!-- good_menu_end -->
 </div>
 
<?php $this->load->view('main/new_footer');?>
 
 <div class="cart_div">
   <div class="cart_title">
     <img src="/images/cart_icon.png" class="cart_img float_left"/>
     <div class="cart_sum float_left">
        <span class="float_left">去结算</span>
        <div class="goods_count float_left"><?php echo $cookie_count;?></div>   
     </div>
   </div>
   <img src="/images/code.png" class="scode"/>
   <div class="wechat_icon">
     <img src="/images/wechat_icon.png" class="wechat_img float_left" />
     <p class="float_left">微信下单</p>  
   </div>
 </div>
 
</body>
</html> 