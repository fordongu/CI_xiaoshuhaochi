
	
  function totle_price(){
	
	 
     $(".views_menu_total_number").html("0");
     $(".totle_price_check").each(function(){
       var single_price=$(this).children(".views_menu_price").children(".views_menu_price_color").html();
       var single_totle=$(this).children(".views_menu_button").children(".views_menu_number").html();
       var totle_price=single_totle*single_price;
      
       $(".views_menu_total_number").html((parseFloat($(".views_menu_total_number").html())+totle_price).toFixed(2));
     })
   }
   
 $(document).ready(function(){
				//onsell();
                                    

			if(parseInt($(".views_cart_number").html())!==0){
				
			$(".views_main_shopping_cart").removeClass("grey").addClass("grey_active");
				
				}else{
					
					$(".views_main_shopping_cart grey_active").attr("class","views_cart grey");
				}
					
				
	 var day_choose=$("#choose_pic").val();
			if(day_choose==6||day_choose==7){
				day_choose=1;
			}
			
                        if(($("#dav_memory").val())){
                         var day_show= parseInt($("#dav_memory").val())-1;

                            $("#choose_pic").val($("#dav_memory").val());
                        }else{
                            var day_show=day_choose-1;
                        } 
                      
                        var dav_select=$("#dav_select").val();
                     
                        $('.data_week:eq('+day_show+')').css('display','block');
			 $('.views_main_aside_right_title_left li:eq('+dav_select+')').addClass('active');
			//$('.views_main_aside_right_title_left li').eq(1).addClass('active');
			$('.views_main_aside_right_title_right li').eq(1).addClass('active');
			$(".will_delete").eq(day_show).addClass('active').removeClass('will_delete');
			//$('.data_week:eq('+day_show+')').css('display','block');
			$(".views_main_list li:has('span')").click(function(){
				$(this).addClass('active').removeClass('will_delete');
				$(this).siblings().addClass('will_delete').removeClass('active');
				$('.views_main_section li').siblings().css('display','none');
				$('.views_main_section li').eq($(this).index()-1).css('display','block');
                            $("#dav_memory").val($(this).index());    
                            
                          
			})


			
                                
			$(".go_to").click(function(){
                            var index=$(this).index();
                            var memory = $("#dav_memory").val();
                         
                            if(index==1){
                                location.href="http://www.xiaoshuhaochi.com/index.php?c=main&index="+memory+"";
                                
                            }
                            if(index==2){
                               
                                location.href="http://www.xiaoshuhaochi.com/index.php?c=main&price=lt20&index="+memory+"";
                                 
                            }
                            if(index==3){
                                location.href="http://www.xiaoshuhaochi.com/index.php?c=main&price=lt30&index="+memory+"";
                            }
                            if(index==4){
                                location.href="http://www.xiaoshuhaochi.com/index.php?c=main&price=gt30&index="+memory+"";
                            }
                             
                           
                            
                             
                            
                            })
                      
                        
			
                       
                       
                      
			$('.views_main_aside_right_title_right li').mouseover(function(){
				$(this).addClass('active');
				$(this).siblings().removeClass('active');
			} ); 

			
		
	 //如果空隐藏DIV
	 
	 if($(".views_cart_number").html()==0){
						$(".views_menu_title").hide();
						}else{
						$(".views_menu_title").show();	
						}
	 
	  $(".views_menu_total_btn").click(function(){
		  if($(".views_cart_number").html()==0){
			  alert("购物车为空，请添加菜品");
			 
		  }else{
			 location.href='/main/order_confirm';
		  }
	  })
   totle_price();
   onsell(data=2);
   var showpic=parseInt($("#choose_pic").val())-1;
	if(parseInt($("#choose_pic").val())==6||parseInt($("#choose_pic").val())==7){
		showpic=0;
		
	}
	
	
	$(".data_week:eq("+showpic+")").show();
   
   
/*  
$('.views_main_list li').on({
  'mouseover':function(){
  	
   $('.views_main_section li').eq($(this).index()).css('display','block');
    },
    'mouseout':function (){
    	$(this).children('.hide_day').css('z-index',1);
    $(this).children('dl').children('dd').eq(0).css('display','block');
    }
});
*/

   
 
   
$(".week_day_change").each(function(){
	var data_week_up=$(this).parent().parent().parent(".data_week").attr("data_week_up");
	$(this).html(data_week_up);
	})




	 $('.new_index_left').click(function(){
			$('#wechat_popup').toggle();
		})

 
		 $('#popup_ul').children('li').click(function(){
			   var area_id = $(this).attr('data_id');
			   if(area_id !=0){
				   var submitData = {id:area_id,type:'service_buildings',from:'main'};
				      $.post('/member/ajax_get_companys', submitData,function(data) { 
				    	   
							if (data.success == 'yes') { 
							  	 var count = data.msg.length;
							  	 var msg = data.msg;
							  	 var str= '';
							  	 for(var i=0;i<count;i++){
	   							   str+="<li data_id='"+msg[i].id+"' onclick='change_user_building(this)'>"+msg[i].name+"</li>";
								 }  
								 $('#popup_area_ul').html(str);
							} 
						},"json");
			   }
		 })
                 
                 //TOMMY
                 $(".wechat_goods_detail_div").each(function(){
                 var index =$(this).children(".good_detail_img_div").attr("data_good_id");
           
                 if(!index){
                  
                     $(this).children(".new_index_left").after("<div><font color='white'>正在为您准备中请稍候</font></div>");
                 }
                 })
   

      

	

	   
		 	
})
 
 


 
 function change_user_building(li){

			   var service_id = $(li).attr('data_id');
			   var building_name = $(li).html();
			   if(service_id !=0){
				   var submitData = {service_id:service_id};
				      $.post('/member/ajax_update_service_buildings', submitData,function(data) { 
				    	   
							if (data.success == 'yes') { 
								window.location.reload();
								/*
							  	 $('.new_index_building').html(building_name);
								  	$('#wechat_popup').hide();*/
							} 
						},"json");
			   }
		 
 }
 function change_cart_count(good,count){
	   var id = $(good).parents(".good_id").attr('data_good_id'); 
	   var week = $(good).parents(".data_week").attr('data_week');
	   var current_date = $(good).parents(".data_week").attr('data_date');
	   
	   var submitData = {id:id+'_'+week,count:count,current_date:current_date}
	   $.post('/main/cookie_cart', submitData,function(data) { 
			if (data.success == 'yes') {
				$('.views_cart_number').html(data.count);  
				if(data.count==0){
					$(".views_menu_title").hide();
				
			$(".views_cart").attr("class","views_cart grey");
				
				}else{
					$(".views_cart").attr("class","views_cart grey_active");
				}
			}else{
				alert(data.msg);
				window.location.reload();
			}
		},"json");	
 }
 function change_cart_count2(good,count){
	    var id = $(good).parents(".totle_price_check").attr('data_good_id'); 
	   var week = $(good).parents(".totle_price_check").attr('data_week');
	 var current_date = $(good).parents(".totle_price_check").attr('data_date'); 
	   
	   var submitData = {id:id+'_'+week,count:count,current_date:current_date}
	   $.post('/main/cookie_cart', submitData,function(data) { 
			if (data.success == 'yes') {
				$('.views_cart_number').html(data.count); 
				if(data.count==0){
					$(".views_menu_title").hide();
				
			$(".views_cart").attr("class","views_cart grey");
				
				}else{
					$(".views_cart").attr("class","views_cart grey_active");
				}			
			}else{
				alert(data.msg);
				window.location.reload();
			}
		},"json");	
 }
 
 $(function(){

 	


 	/*
	 $(".plus_good_main").click(function(){
             
      var pic=$(this).parent().parent().parent().prev('dt').children('img');
	 var flyElm = $(pic).clone().css('opacity','0.8');
     flyElm.css({
     'z-index': 9000,
      'display': 'block',
      'position': 'absolute',
      'top': $(this).parent().parent().parent().parent().offset().top +'px',
      'left': $(this).parent().parent().parent().parent().offset().left +'px',
      'width': $('.good_img').width() +'px',
      'height': $('.good_img').height() +'px'
     })
    $('body').append(flyElm);
	flyElm.animate({
      top:$('.views_main_shopping_cart').offset().top,
      left:$('.views_main_shopping_cart').offset().left,
      width:40+'px',
      height:40+'px',
    });
	
	setTimeout(function(){$(flyElm).remove();},400);
	*/




		$(".views_main_table").show();
		   var per_count_limit=$("#per_count_limit").val();	   
		  var total_count = $('.views_cart_number').html();		
	     var current_count = $(this).prev('big').html();
	         if(current_count == 0){
	        	 $(this).prev('span').prev('div').addClass('high_but');
	         }
	         if(++current_count <= per_count_limit){
	        	 
	        	 if(current_count == per_count_limit){
					$(this).removeClass('high_but');	
	             }
				 
	             $(this).prev('big').html(current_count);  
	             $('.minus_good').removeClass('wechat_buy_icon_invalid');
	             $(this).parents('.views_main_section_dd_bottom').children('.index_buy_icon_minus').show();
							//通过统一的方法改变cookies
				var result=change_cart_count($(this),current_count);
				var data_week=$(this).parents(".data_week").attr("data_week");
				var data_week_up=$(this).parents(".data_week").attr("data_week_up");
				var good_id=$(this).parents(".good_id").attr("data_good_id");
				var good_name=$(this).parents("dd").children(".views_main_section_dd_h5_left").html();
                                 var price=$(this).parent().prev().children("big").html();
				var ajax_count=$(this).prev("big").html();
                                var data_date=$(this).parents(".data_week").attr("data_date");
                                var cate_id=$(this).attr("cate_id");
	var add_html="<li class='totle_price_check good_date' cate_id="+cate_id+" data_date="+data_date+" data_good_add_delete="+good_id+"_"+data_week+" data_good_id="+good_id+"  data_week="+data_week+"><span class='views_menu_time'>"+data_week_up+"</span>&nbsp;&nbsp;<span class='views_menu_name'>"+good_name+"</span><span class='views_menu_price'>¥ <span class='views_menu_price_color'>"+price+"</span></span>&nbsp;<span class='views_menu_button'><button class='minus_goods_main'>-</button>&nbsp;<span class='views_menu_number add_delete'>"+ajax_count+"</span>&nbsp;<button class='plus_goods_main'>+</button></span></li>";
					var find_good= $(".views_main_menu").find("li").attr("data_good_add_delete");
					
					
						 $(".add_delete").each(function(){
						 var id=$(this).parent().parent().attr("data_good_id");
						 var week=$(this).parent().parent().attr("data_week");
						 var data_good_add_delete=$(this).parent().parent().attr("data_good_add_delete");
						 
						 if(data_good_add_delete==good_id+"_"+data_week){
							 $(this).html(current_count);
							 	$(this).parent().parent("li").remove();
							   return false;
						 }
						
					 })
			
			 $(".views_main_menu").children("ul").append(add_html); 
					 totle_price();
                                        onsell();
					$(".plus_goods_main").unbind("click");
					$(".plus_goods_main").on("click",function(){
						$(".views_menu_title").show();
						var per_count_limit=$("#per_count_limit").val();	   
			var total_count = $('.views_cart_number').html();		
			var current_count = $(this).prev('.views_menu_number').html();
		
			if(++current_count <= per_count_limit){
	        	 //这个CLASS待开发
	        	 if(current_count == per_count_limit){
					$(this).removeClass('high_but');	
	             }
				
	             $(this).prev('.views_menu_number').html(current_count);  
	             change_cart_count2($(this),current_count);
                       
				 var data_good_add_delete=$(this).parent().parent().attr("data_good_add_delete");
				 
				 $(".good_id").each(function(){
					 var data_week=$(this).parent(".data_week").attr("data_week");
					 var data_good_id=$(this).attr("data_good_id");
					 if(data_good_id+"_"+data_week==data_good_add_delete){
						 $(this).children("dd").children("div").children("span:eq(1)").children("big").html(current_count);
							 
					 }
				 })
				 totle_price();
	                            onsell();

	         } 
					
					})
					$(".minus_goods_main").unbind("click");
					 $(".minus_goods_main").click(function(){
		  var per_count_limit=$("#per_count_limit").val();	   
		  var total_count = $('.views_cart_number').html();		
	     var current_count = $(this).next('.views_menu_number').html();
		  if(current_count == 0){
	         }
			  current_count = current_count-1;
	          if((current_count <= per_count_limit)&&(current_count >=0)){
	        	 
	        	 
	             $(this).next('.views_menu_number').html(current_count); 
	              if(current_count==0){
					 $(this).parent().parent("li").remove();
				 }
	             change_cart_count2($(this),current_count);
				   var data_good_add_delete=$(this).parent().parent().attr("data_good_add_delete");
				
						
				 $(".good_id").each(function(){
					 var data_week=$(this).parent(".data_week").attr("data_week");
					 var data_good_id=$(this).attr("data_good_id");
					 if(data_good_id+"_"+data_week==data_good_add_delete){
						 $(this).children("dd").children("div").children("span:eq(1)").children("big").html(current_count);
							 ////
							 
						////
					 }
				 })
				 totle_price();
                                 onsell();
	         }
                 
	 })
				 
	         } 
	 })
 

      $('.views_main_shopping_cart').mouseover(function(){
      	 $('.views_main_table').show();
      });
      $('.views_main_table').mouseleave(function(){
      	 $('.views_main_table').hide();
      });
           






	$(".views_cart_img1").mouseover(function(){
		if(parseInt($(".views_cart_number").html())!==0){
			
			$(".views_main_table").show();	
		}
	
		
		})
		$(".views_main_table").mouseleave(function(){
				$(".views_main_table").hide();
	})



  
   	  $('.views_main_title li span').mouseover(function(){
   	  	 $('.views_main_title_wrap div button').animate({width:($(this).parent().index())*100+'px'});
   	  });
      $('.mon').on({'mouseover':function(){
      	 $(this).css({'background-color':'#FCB75F','color':'#fff'});
      	 

      	},

      	 'mouseout':function(){
      	 	$(this).css({'background-color':'#F0EEF4','color':'#FCB75F'});
      	 }
      	});
      $('.tues').on({'mouseover':function(){
      	 $(this).css({'background-color':'#E291F7','color':'#fff'});
        
      	},
      	 'mouseout':function(){
      	 	$(this).css({'background-color':'#F0EEF4','color':'#E291F7'});
			
      	 }
      	});
      $('.wed').on({'mouseover':function(){
      	 $(this).css({'background-color':'#61BBF3','color':'#fff'});
       
      	},
      	 'mouseout':function(){
      	 	$(this).css({'background-color':'#F0EEF4','color':'#61BBF3'});
      	 }
      	});
      $('.thur').on({'mouseover':function(){
      	 $(this).css({'background-color':'#4AC073','color':'#fff'});
        
      	},
      	 'mouseout':function(){
      	 	$(this).css({'background-color':'#F0EEF4','color':'#4AC073'});
      	 }
      	});
      $('.fri').on({'mouseover':function(){
      	 $(this).css({'background-color':'#FCAE84','color':'#fff'});
        
      	},
      	 'mouseout':function(){
      	 	$(this).css({'background-color':'#F0EEF4','color':'#FCAE84'});
      	 }
      	});
   

     
         
       
    
      
     






	 $(".minus_good_main").click(function(){
		   var per_count_limit=$("#per_count_limit").val();
		   
		  var total_count = $('.views_cart_number').html();		
	     var current_count = $(this).next('big').html();
	         if(current_count == 0){
	        	 $(this).prev('div').prev('div').addClass('high_but');
	        	
	         }
			  current_count = current_count-1;
	          if((current_count <= per_count_limit)&&(current_count >=0)){
	        	 
	        	 if(current_count == 0){
					
			 
				 	
	             }
	             $(this).next('big').html(current_count); 
	             
	            
	             if(total_count ==0){
	            	 $('.cart_icon').hide();
	            	 $(this).addClass('wechat_buy_icon_invalid');
	            	 $(this).parents('.index_good_count').children('.index_buy_icon_minus').hide();
	             }
	             change_cart_count($(this),current_count);
				 
				var result=change_cart_count($(this),current_count);
				var data_week=$(this).parents(".data_week").attr("data_week");
				var data_week_up=$(this).parent(".data_week").attr("data_week_up");
				var good_id=$(this).parents(".good_id").attr("data_good_id");
				var good_name=$(this).parents("dd").children(".views_main_section_dd_h5_left").html();
                                var price=$(this).parent().prev().children("big").html();
				var ajax_count=$(this).next("big").html();
                                var data_date=$(this).parents(".data_week").attr("data_date");
                                  var cate_id=$(this).attr("cate_id");
	var add_html="<li class='totle_price_check good_date' cate_id="+cate_id+" data_date="+data_date+" data_good_add_delete="+good_id+"_"+data_week+" data_good_id="+good_id+"  data_week="+data_week+"><span class='views_menu_time'>"+data_week_up+"</span>&nbsp;&nbsp;<span class='views_menu_name'>"+good_name+"</span><span class='views_menu_price'>¥ <span class='views_menu_price_color'>"+price+"</span></span>&nbsp;<span class='views_menu_button'><button class='minus_goods_main'>-</button>&nbsp;<span class='views_menu_number add_delete'>"+ajax_count+"</span>&nbsp;<button class='plus_goods_main'>+</button></span></li>";
					var find_good= $(".views_main_wrap").find("li").attr("data_good_add_delete");
					
				$(".add_delete").each(function(){
						 var id=$(this).parent().parent().attr("data_good_id");
						 var week=$(this).parent().parent().attr("data_week");
						 var data_good_add_delete=$(this).parent().parent().attr("data_good_add_delete");
						
                                            
						 if(data_good_add_delete==good_id+"_"+data_week){
							 $(this).html(current_count);
							 	$(this).parent().parent("li").remove();
							   return false;
						 }
				})
				 $(".views_main_wrap").children("ul").append(add_html);
				 
				 totle_price();
				onsell();
                                 $(".add_delete").each(function(){
								if($(this).html()==0){
                             //alert($(".add_delete").html());
                                  $(this).parent().parent("li").remove();
                                                 }		
						
				})
				
                                            
				 $(".plus_goods_main").unbind("click");
					$(".plus_goods_main").on("click",function(){
						$(".views_menu_title").show();
						var per_count_limit=$("#per_count_limit").val();	   
			var total_count = $('.views_cart_number').html();		
			var current_count = $(this).prev('.views_menu_number').html();
                        
			if(++current_count <= per_count_limit){
	        	 //这个CLASS待开发
	        	 if(current_count == per_count_limit){
					$(this).removeClass('high_but');	
	             }
				
	             $(this).prev('.views_menu_number').html(current_count);  
	             change_cart_count2($(this),current_count);
				 var data_good_add_delete=$(this).parent().parent().attr("data_good_add_delete");
				 
				 $(".good_id").each(function(){
					 var data_week=$(this).parent(".data_week").attr("data_week");
					 var data_good_id=$(this).attr("data_good_id");
					 if(data_good_id+"_"+data_week==data_good_add_delete){
						 $(this).children("dd").children("div").children("span:eq(1)").children("big").html(current_count);
							 
					 }
				 })
				 totle_price();
                                    onsell();
	         } 
						
					})
					$(".minus_goods_main").unbind("click");
					 $(".minus_goods_main").click(function(){
		  var per_count_limit=$("#per_count_limit").val();	   
		  var total_count = $('.views_cart_number').html();		
	     var current_count = $(this).next('.views_menu_number').html();
		  if(current_count == 0){
	         }
			  current_count = current_count-1;
	          if((current_count <= per_count_limit)&&(current_count >=0)){
	        	 
	        	 if(current_count == 0){
					//$(this).removeClass('high_but');	
	             }
	             $(this).next('.views_menu_number').html(current_count); 
	             
	             change_cart_count2($(this),current_count);
				  if(current_count==0){
					 $(this).parent().parent("li").remove();
				 
				 }
				   var data_good_add_delete=$(this).parent().parent().attr("data_good_add_delete");
				 
				 $(".good_id").each(function(){
					 var data_week=$(this).parent(".data_week").attr("data_week");
					 var data_good_id=$(this).attr("data_good_id");
					 if(data_good_id+"_"+data_week==data_good_add_delete){
						 $(this).children("dd").children("div").children("span:eq(1)").children("big").html(current_count);
							 
					 }
				 })
				 totle_price();
				 onsell();
				 
	         } 
	 })
				 
	       
	         } 
	 })
	 //购物车上的按钮
	 $(".plus_goods_main").click(function(){
		 var per_count_limit=$("#per_count_limit").val();	   
		  var total_count = $('.views_cart_number').html();		
	     var current_count = $(this).prev('.views_menu_number').html();
		
		  if(++current_count <= per_count_limit){
	        	 //这个CLASS待开发
	        	 if(current_count == per_count_limit){
					$(this).removeClass('high_but');	
	             }
				
	             $(this).prev('.views_menu_number').html(current_count);  
	             change_cart_count2($(this),current_count);
	             var data_good_add_delete=$(this).parent().parent().attr("data_good_add_delete");
				 
				 $(".good_id").each(function(){
					 var data_week=$(this).parent(".data_week").attr("data_week");
					 var data_good_id=$(this).attr("data_good_id");
					 if(data_good_id+"_"+data_week==data_good_add_delete){
						 $(this).children("dd").children("div").children("span:eq(1)").children("big").html(current_count);
							 
					 }
				 })
				 totle_price();
                                 onsell();
	         } 
	 })





	 $(".minus_goods_main").click(function(){
		  var per_count_limit=$("#per_count_limit").val();	   
		  var total_count = $('.views_cart_number').html();		
	     var current_count = $(this).next('.views_menu_number').html();
		  if(current_count == 0){
	         }
			  current_count = current_count-1;
	          if((current_count <= per_count_limit)&&(current_count >=0)){
	        	 
	        	 if(current_count == 0){
					//$(this).removeClass('high_but');	
	             }
	             $(this).next('.views_menu_number').html(current_count); 
	             if(current_count==0){
					 $(this).parent().parent("li").remove();
				 }
	             change_cart_count2($(this),current_count);
				   var data_good_add_delete=$(this).parent().parent().attr("data_good_add_delete");
				 
				 $(".good_id").each(function(){
					 var data_week=$(this).parent(".data_week").attr("data_week");
					 var data_good_id=$(this).attr("data_good_id");
					 if(data_good_id+"_"+data_week==data_good_add_delete){
						 $(this).children("dd").children("div").children("span:eq(1)").children("big").html(current_count);
							 
					 }
					 
				 })
				 totle_price();
				onsell();
	         } 
	 })
		
