function onsell(data){	                    
			var Monday_promote=0;
			var Tuesday_promote=0;
			var Wednesday_promote=0;
			var Thursday_promote=0;
			var Friday_promote=0;
			var Monday_product=0;
			var Tuesday_product=0;
			var Wednesday_product=0;
			var Thursday_product=0;
			var Friday_product=0;
                        var Monday_tea=0;
			var Tuesday_tea=0;
			var Wednesday_tea=0;
			var Thursday_tea=0;
			var Friday_tea=0;
                        var Monday_left=0;
                        var tea1=0;
                        var tea2=0;
                        var tea3=0;
                        var tea4=0;
                        var tea5=0;
                        var count;
                        var tea;
			$(".good_date").each(function(count){
				var cate_id=$(this).attr("cate_id");
				var data_week=$(this).attr("data_week");
                               var good_id=$(this).attr("data_good_id");
				//每天的购买饮料的数量
                            if(data==0){
                               count=$(this).parent().children().children(".confirm_order_count").html();  
                           }else if(data==3){                             
                               count=$(this).html();                                                 
                           }else{
                               count=$(this).children(".views_menu_button").children(".add_delete").html();
                           }
                            
                                if(good_id=="46"&&data_week==0)
                            {
                              Monday_tea= parseInt(Monday_tea)+parseInt(count);
                              return true;
                           
                            }
                            if(good_id=="46"&&data_week==1)
                            {
                              Tuesday_tea= parseInt(Tuesday_tea)+parseInt(count);  
                             return true;
                            }
                            if(good_id=="46"&&data_week==2)
                            {
                              Wednesday_tea= parseInt(Wednesday_tea)+parseInt(count); 
                              return true;
                            }
                            if(good_id=="46"&&data_week==3)
                            {
                              Thursday_tea= parseInt(Thursday_tea)+parseInt(count); 
                              return true;
                            }
                            if(good_id=="46"&&data_week==4)
                            {
                             Friday_tea= parseInt(Friday_tea)+parseInt(count); 
                             return true;
                            }
                                if(cate_id=="9"&&data_week==0){
                                    
					Monday_promote=parseInt(Monday_promote)+parseInt(count);
				}
				if(cate_id=="9"&&data_week==1){                                   			
					Tuesday_promote=parseInt(Tuesday_promote)+parseInt(count);
				}
				if(cate_id=="9"&&data_week==2){
			
					Wednesday_promote=parseInt(Wednesday_promote)+parseInt(count);
				}
				if(cate_id=="9"&&data_week==3){
					Thursday_promote=parseInt(Thursday_promote)+parseInt(count);
				}
				if(cate_id=="9"&&data_week==4){
					Friday_promote=parseInt(Friday_promote)+parseInt(count);
				}
				//每天的购买饮料的数量
				//除了饮料之外的东西

				if(cate_id!=="9"&&data_week==0){				
					Monday_product=parseInt(Monday_product)+parseInt(count);
				}
				if(cate_id!=="9"&&data_week==1){
					Tuesday_product=parseInt(Tuesday_product)+parseInt(count);
				}
				if(cate_id!=="9"&&data_week==2){
				
					Wednesday_product=parseInt(Wednesday_product)+parseInt(count);
				}
				if(cate_id!=="9"&&data_week==3){										
					Thursday_product=parseInt(Thursday_product)+parseInt(count);
					
				}
				if(cate_id!=="9"&&data_week==4){				
					Friday_product=parseInt(Friday_product)+parseInt(count);
				}
				//除了饮料之外的东西                                                      							
			})
			//1
			if(Monday_product>=Monday_promote){
				Monday_count=Monday_promote;
			}else{
				Monday_count=Monday_product;
			}
			//2
			if(Tuesday_product>=Tuesday_promote){
				Tuesday_count=Tuesday_promote;
			}else{
				Tuesday_count=Tuesday_product;
			}
			//3
			if(Wednesday_product>=Wednesday_promote){
				Wednesday_count=Wednesday_promote;
			}else{
				Wednesday_count=Wednesday_product;
			}
			//4
			if(Thursday_product>=Thursday_promote){
				Thursday_count=Thursday_promote;
			}else{
				Thursday_count=Thursday_product;
			}
			//5
			if(Friday_product>=Friday_promote){
				Friday_count=Friday_promote;
			}else{
				Friday_count=Friday_product;
			}
                   //alert(Monday_product);  alert(Monday_promote); alert(Monday_tea);
             
                    Monday_left=Monday_product-Monday_promote;
                   if(Monday_left>0&&(Monday_left>=Monday_tea)){
                        tea1=Monday_tea;
                   }else if(Monday_left>0&&(Monday_left<Monday_tea)){
                       tea1= Monday_left;
                   }
                    var Tuesday_left=Tuesday_product-Tuesday_promote;
                   if(Tuesday_left>0&&(Tuesday_left>=Tuesday_tea)){
                       tea2=Tuesday_tea;
                   }else if(Tuesday_left>0&&(Tuesday_left<Tuesday_tea)){
                       tea2= Tuesday_left;
                   }
                   var Wednesday_left=Wednesday_product-Wednesday_promote;
                   if(Wednesday_left>0&&(Wednesday_left>=Wednesday_tea)){
                       tea3=Wednesday_tea;
                   }else if(Wednesday_left>0&&(Wednesday_left<Wednesday_tea)){
                       tea3= Wednesday_left;
                   }
		var Thursday_left=Thursday_product-Thursday_promote;
                   if(Thursday_left>0&&(Thursday_left>=Thursday_tea)){
                       tea4=Thursday_tea;
                   }else if(Thursday_left>0&&(Thursday_left<Thursday_tea)){
                       tea4= Thursday_left;
                   }
                   var Friday_left=Friday_product-Friday_promote;
                   if(Friday_left>0&&(Friday_left>=Friday_tea)){
                      tea5=Friday_tea;
                   }else if(Friday_left>0&&(Friday_left<Friday_tea)){
                       tea5= Friday_left;
                   }
             tea=tea1+tea2+tea3+tea4+tea5;  
	total_count=Monday_count+Tuesday_count+Wednesday_count+Thursday_count+Friday_count;//能优惠几个
	var old_total_count=parseFloat($(".total_count,.views_menu_total_number,.general").html());
	$(".onsell").html((old_total_count-parseFloat(total_count*6)-parseFloat(tea*3)).toFixed(2));//14是减少的价格需变动
}


//var currentImg = current_week_day; 




$(function () {
	//显示第几个
	//class=confirm_next_step_click
	
		if(parseInt($(".cookie_count").html())!==0){
						
			$(".confirm_next_step").addClass("confirm_next_step_click");
		}
	
	//week_day
	var showpic=parseInt($("#choose_pic").val())-1;
	if(parseInt($("#choose_pic").val())==6||parseInt($("#choose_pic").val())==7){
		showpic=0;
		
	}
	
	$(".choose_button:eq("+showpic+")").addClass("week_day_active");
	$(".wechat_goods_detail_div:eq("+showpic+")").show();
	
		$(".choose_button").click(function(){
			//显示点击的文件
		var showtab=$(this).attr("data_choose");
		$(".wechat_goods_detail_div").hide();
		$(".wechat_goods_detail_div:eq("+showtab+")").show();
		$(".choose_button ").removeClass("week_day_active");
		$(this).addClass("week_day_active");
	})
	
	
	
	
	
	$(".confirm_next_step").click(function(){
		
		if(parseInt($(".cookie_count").html())==0){
			alert("购物车为空，请添加菜品！");
	}else{
		location.href='/wechat/confirm_step_two';
	}
		
	})
	//计算总数
	var fun_count=$(".confirm_order_count").each(function(){
			var count=parseInt($(this).html());
			var cookie_count=parseInt($(".cookie_count").html());
			$(".cookie_count").html(count+cookie_count);
		})
	//计算总价格
		var fun_price=$(".single_price").each(function(){
		var single_price=parseFloat($(this).html());
	    var count=parseInt($(this).parent().prev(".confirm_buttom").children(".confirm_order_count").html());
		var real_price=single_price*count;
		var total_count=parseFloat($(".total_count").html());	
		$(".total_count").html((total_count+real_price).toFixed(2));  
		})
	
	
	
      var $check=$("#cookie_count").val();
      
 		 		 
		 
 		 
		 		 
   
   //个人中心图标效果控制
   /*
   $(".person_icon").click(function(){	    
			$(".person_center").show();
			event.stopPropagation();//阻止冒泡
			$("body").click(function(){
			$(".person_center").hide();
})
   })*/
	
   
   
   
  $('.click_popup').click(function(){
    $('#wechat_popup').toggle();
  })






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
   //打开隐藏的购物车的DIV
 
   $(".cart_count_div").click(function(){
	   if(parseInt($(".cookie_count").html())!==0){
		 if($(".order_confirm_table").css("display")=="none")
	{
		
		$(".order_confirm_table").show(); 
	}else{
		
		$(".order_confirm_table").hide(); 
	}  
	
       }
	
		 	   
	   
   })
   onsell(0); 
});


/**
 * Catch each phase of the swipe.
 * move : we drag the div
 * cancel : we animate back to where we were
 * end : we animate to the next image
 */



//控制当库存为0时
$(function(){
 // if(parseInt($(".cookie_count").html())){ 
	  //$(".confirm_next_step").addClass("confirm_next_step_click");
  //}

  
  $(".wechat_plus_good").on("click",function(){
	  //$(".confirm_next_step").addClass("addclass_to_next_step");
    var value=$(this).parent().prev(".stok_left").val();
    if(value==0){
      alert("今天的已售罄请明天再来");
      $(".wechat_minus_good").trigger("click");
	  
	  
    
    }
  });
  $(".wechat_goods_detail_div").each(function(){
      //如果当天没有菜择添加一个img标签
    
    if(!$(this).children(".good_detail_img_div").attr("data_good_price")){
    	
    	$(this).children(".good_detail_img_div").hide();
       $(this).html(" <img src='/images/caipin.png' style='width:100%;'/> ");
          //<img src='/images/caipin.png' class='good_detail_img wx_sq'/>
    }
    
  })

  $(".good_detail_img").click(function(){
	  var goods_id=$(this).parents(".good_detail_img_div").attr("data_good_id");
	  var data_building_id=$(this).parents(".good_detail_img_div").attr("data_building_id");
          var date_week=$("#hidden_weeks").val();
		location.href="index.php?c=wechat&m=goods_detail&date_week="+date_week+"&&goods_id="+goods_id+"&data_building_id="+data_building_id+"";
  })
 $(this).parents(".good_detail_img_div").children(".good_detail_img_div_sub").children(".good_detail_img");
 /*
  * 
  * $goods_id = (int)$this->input->post('goods_id');
        $date = $this->input->post('date');
        $num = (int)$this->input->post('num');
        $type = (int)$this->input->post('goods_type');
        $week_flag = (int)$this->input->post('week_flag');

  */
 
             

});
