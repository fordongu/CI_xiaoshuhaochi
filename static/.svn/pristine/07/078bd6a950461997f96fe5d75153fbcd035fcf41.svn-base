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





function alert_frame(msg,flag){

	$("#alert_controller").find(".loading").removeClass('display-none');
	$("#alert_controller").show();
	$("#error_msg").html(msg);
	if(flag){
	   setTimeout(function() { $("#alert_controller").fadeOut(400); $('#black-popup').fadeOut(400);}, 2000);
	}else{
		setTimeout(function() { $("#alert_controller").fadeOut(400); }, 100000);
		//$("#alert_controller").find(".loading").addClass(class_display_none);
	}
}
//count_price是改变订单价格的固定方法默认的是增加按钮，2是减少按钮
function count_price(call){
			var count=$(call).prev(".confirm_order_count").html();
			var price=$(call).parent(".add_goods").attr("data_price");

			$(call).parent().parent().next().html(parseFloat(count*price).toFixed(2));

			$(".general").html("0");
			$(".totle").each(function(){
				var totle=parseFloat($(this).html());
				var general=parseFloat($(".general").html());
				$(".general").html((general+totle).toFixed(2));
			})
			$(".order_total").html(parseFloat($(".general").html()).toFixed(2));
			$("#real_total_amount").val(parseFloat($(".general").html()).toFixed(2));
			$('#coupons li img').each(function(){
				$(this).attr('src', "/images/li_normal.png");
			})
	}
	function count_price2(call){
			var count=$(call).next(".confirm_order_count").html();
			var price=$(call).parent(".add_goods").attr("data_price");
			$(call).parent().parent().next().html(parseFloat(count*price).toFixed(2));
			var i=0;
			$(".general").html("0");
			$(".normal_tr").each(function(){
				var aaa=$(this).children().children(".add_goods").attr("data_price");
				//aaa是判断有没有
				if(!aaa){
				$(this).remove();
				}

			})
			//$(call).parent().parent().parent().remove();
			$(".totle").each(function(){


				var totle=parseFloat($(this).html());
				var general=parseFloat($(".general").html());
				$(".general").html((general+totle).toFixed(2));

			})
			$(".order_total").html(parseFloat($(".general").html()).toFixed(2));
			$("#real_total_amount").val(parseFloat($(".general").html()).toFixed(2));
	}
function GetRTime(){
	var EndTime=$('#hidden_time').val();

	var NowTime = new Date();
	var nMS =EndTime - NowTime.getTime();
	var nS=Math.floor(nMS/1000) % 60;

    var str ='已发送('+nS+')秒';

    if(nS == 0){
    	$("#send_div").show();
		$('#verify_div').hide();
	}else{
	  $('#verify_div').html(str);
	}
	setTimeout("GetRTime()",1000);
}


function change_cart_count(good,count){

	   var id = $(good).parents('.good_detail_img_div').attr('data_good_id');
	   var week = $(good).parents('.wechat_goods_detail_div').children('.detail_week').attr('data_week');
	  // var current_date = $(good).parents('.good_detail_img_div ').attr('data_date');
           
         if($("#hidden_weeks").val()==0){
              var current_date=$(good).prev("div").children("select:eq(0)").find("option:selected").val(); 
           }else if($("#hidden_weeks").val()==1){
               var current_date=$(good).prev("div").children("select:eq(1)").find("option:selected").val(); 
           }
           if(current_date==0){
             return false;
           }
           
           var weeks_choose_next_mon=$("#weeks_choose").attr("next_mon");
	   var submitData = {id:id,count:count,current_date:current_date,weeks_choose_next_mon:weeks_choose_next_mon}
	   $.post('/main/cookie_cart', submitData,function(data) {
			if (data.success == 'yes') {
				$('.goods_count').html(data.count);
	             $('.cart_icon').html(data.count).show();

			if($(".cookie_count").html()==0){
						window.location.reload();
					}
			}else{
				alert(data.msg);
				window.location.reload();
			}
		},"json");
}

try {
		var urlhash = window.location.hash;
		if (!urlhash.match("fromapp"))
		{
			if ((navigator.userAgent.match(/(iPhone|iPod|Android|ios|iPad)/i)))
			{

				if(controller=='main'){
				    // window.location.href="/wechat/index";
				}

				if(/MicroMessenger/i.test(navigator.userAgent)){
			//可以使用微信支付
					type =1;
				}
			}else{

				if(controller=='wechat'){
					//  window.location.href="/main/index";
				}
			}
		}
	}
	catch(err)
	{
	   }

$(document).ready(function(){

	$('#new_shipping_address').click(function(){
				$('.add_new_address').fadeToggle();

			});

    $('.main_member_address_list').eq(0).children('li').eq(0).addClass('active');
	$('.main_member_address_list').click(function(){
		$(this).parent().children('.main_member_address_list').children('li').removeClass('active');
		$(this).children('li').eq(0).addClass('active');
	});

$('.main_member_order_list_title ol li:nth-child(2)').click(function (){
	$('.order_shipping_info_eric').fadeToggle();
});

/*$('.main_member_order_list_title ol li:nth-child(3)').click(function (){
	$(this).parent().parent().parent().fadeOut();
});
*/
   /* $('.views_wechat_title ul li').toggle(function(){
    	if ($(this).index() == 0) {
    		$(this).removeClass('active2').addClass('active1');
    	};
    },function(){});  */


/*

  var n = 0;
$('.views_wechat_title ul li').click(function(){
	n++;
	$(this).siblings().removeClass('active1').addClass('active2');
		$(this).removeClass('active2').addClass('active1');

	if(n%2 == 1 && $(this).not('.active1'))
	{
		$(this).parents('.views_wechat_title').next().children().animate({left:-width+'px'});
	}
	else if(n%2 == 1 && $(this).has('.active1')){
		$(this).parents('.views_wechat_title').next().children().animate();
	}


	}); */

$('#views_wechat_side span').toggle(function(){
	$(this).addClass('active');
},
function(){
	$(this).removeClass('active');
});



$('#add_addresss').toggle(function(){
				$('.add_new_address').css('display','none');
			},
			function(){
                $('.add_new_address').css('display','block');
			});


	$('.views_order_this span').toggle(function(){
		$(this).html('&#9745').css({'color':'#00A538'});
	},
	function(){
		$(this).html('&#9744').css({'color':'#aaa'});
	}
	);

	   $('.views_order_address li').children('span:eq(0)').html('&#9745').css({'color':'#00A538'});
	 $('.views_order_address li').children('span').click(function(){
        $('.views_order_address li').children('span').html('&#9744').css({'color':'#aaa'});
		$(this).html('&#9745').css({'color':'#00A538'});
	});



     $('.shipping_detail_eric li').children('span:eq(0)').html('&#9745').css({'color':'#00A538'});
	 $('.shipping_detail_eric li').children('span').click(function(){
        $('.shipping_detail_eric li').children('span').html('&#9744').css({'color':'#aaa'});
		$(this).html('&#9745').css({'color':'#00A538'});
		var va = $(this).attr('data_id');
        $('#hidden_pay_config').val(va);
	});


	$('.three_coupon_ul').children('li').children('div').click(function(){
		$('.three_coupon_ul').children('li').children('div').removeClass('three_coupon_normal');
		$('.three_coupon_ul').children('li').children('div').removeClass('three_coupon_high');
		$('.three_coupon_ul').children('li').children('div').addClass('three_coupon_normal');
		$(this).addClass('three_coupon_high');
		var coupon_id = $(this).attr('data_id');
		$('#coupons_id_used').val(coupon_id);
		var original_amount = $('#hidden_order_amount').val();
		var coupon_price = $(this).attr('data_price');
		var left_price = original_amount-coupon_price;
		if(left_price <0){
			left_price = 0;
		}

		$('#order_total_ampount').html(left_price);

	})

	$('.wechat_index_btn a').click(function(){
		$('.signupBar_eric').hide();
		$('.loginBar_eric').show();
	});


	    $('.three_payment_ul').children('li').children('div').click(function(){
		$('.three_payment_ul').children('li').children('div').removeClass('three_coupon_normal');
		$('.three_payment_ul').children('li').children('div').removeClass('three_coupon_high');
		$('.three_payment_ul').children('li').children('div').addClass('three_coupon_normal');
		$(this).addClass('three_coupon_high');
	})


	$('#empty_cart').click(function(){
		$.post('/main/clear_cookie_cart', '',function(data) {
			if (data.success == 'yes') {
				window.location.href='/wechat/index';
			}else{
				alert(data.msg);
			}
		},"json");

	})
	$('.empty_cart').click(function(){
		$.post('/main/clear_cookie_cart','',function(data) {
			if (data.success == 'yes') {
				window.location.href='/main/index';
			}else{
				alert(data.msg);
			}
		},"json");

	})


	//订单列表里去支付
	 $('.pay_now').click(function(){

		 var order_sn = $(this).attr('data_sn');
		 var pay_way = $(this).attr('data_pay_way');
		 if(controller == 'wechat'){
			 if(pay_way=='alipay'){
				 window.location.href='/wechat/pay_order/'+order_sn;
			 }else if(pay_way == 'wechat'){

				 window.location.href='/index.php?c=wechat&m=wechat_pay&order_sn='+order_sn;
			 }

		 }else{
			 if(pay_way=='alipay'){
				 window.location.href='/main/pay_order/'+order_sn;
			 }else if(pay_way=='wechat'){
				 window.location.href='/main/wechat_qcode_pay/'+order_sn;

			 }
		 }
	 })
		$(".close_order").click(function(){

		var	close_order = confirm("确认要删除订单?");
		if(close_order){
			var id=$(this).attr("data_id");
			var submitdata = {id:id};
			$.post("/member/close_order",submitdata,function(data){
				alert(data.msg);
				window.location.reload();
			},"json");
		}

		})

		 $(".order_detail_li").click(function(){
		 var id=$(this).attr("data_id");
			 $(".receiver_info").each(function(){
				if($(this).attr("data_id")==id){
					$(this).toggle();
				}
			 })
		 })


		/*
	 $('.wechat_order_title_img1').click(function(){
	 	$('.receiver_info').eq($(this).index()).toggle();
	 	$('.wechat_member_index_mobile').hide();
	 	$('.wechat_member_index_sex').hide();
	 	$('.wechat_member_index_password').hide();
	 });*/



	$('.wechat_member_index_list li:eq(0)').click(function(){
		$('.receiver_info').hide();
	 	$('.wechat_member_index_mobile').toggle();
	 	$('.wechat_member_index_sex').hide();
	 	$('.wechat_member_index_password').hide();
	});

	 $('.wechat_member_index_list li:eq(2)').click(function(){
	 	$('.receiver_info').hide();
	 	$('.wechat_member_index_mobile').hide();
	 	$('.wechat_member_index_sex').toggle();
	 	$('.wechat_member_index_password').hide();
	 });

     $('.wechat_member_index_list li:last').click(function(){
	 	$('.receiver_info').hide();
	 	$('.wechat_member_index_mobile').hide();
	 	$('.wechat_member_index_sex').hide();
	 	$('.wechat_member_index_password').toggle();
	 });
     /*
	 $('.shipping_address_ul li ol li:eq(0)').parent().parent().parent().find('li .shipping_class_selected').show();
     $('.shipping_address_ul li ol li:eq(1)').hide();
     $('.shipping_address_ul li ol li:eq(0)').click(function(){

     	  $(this).parent().parent().parent().find('li .shipping_class_selected').show();
     });*/
	$(".iconfont-fanhui1").click(function(){

		window.location.href="/wechat/member_center";
	})
	$(".shipping_class_selected").each(function(){

		if($(this).attr("data_address_id")==$("#data_address_id").val()){
			$(this).show();
		}
	})
     $('.wechat_member_account_section input:eq(0)').click(function(){
     	$('.wechat_member_account_list').show();
     });

     $('.wechat_member_account_section input:eq(1)').click(function(){
     	$('.wechat_member_sore_list').show();
     });

	//首页写字楼搜索
	$('#default_search_but').click(function(){
		var search_keywords = $('#search_input').val();
		if(!search_keywords){
			alert_frame('请输入您要搜索的关键词',1);
			return false;
		}

        window.location.href='/index.php?c=main&m=index&keywords='+search_keywords;
	})


 $('#search_form').submit(function(){
	 var search_keywords = $('#search_input').val();
		if(!search_keywords){

			return false;
		}
		alert(search_keywords);
     window.location.href='/index.php?c=main&m=index&keywords='+search_keywords;
   });



	$('.select_buildings li').click(function(){
		  var building_id = $(this).attr('data-id');
		  var building_name = $(this).html();
		  $('.good_menus').hide();
		  $('.data_buildings_'+building_id).show();
		  $('.location_name').html(building_name);
		  $('.select_buildings li').removeClass('current_buildings');
		  $(this).addClass('current_buildings');
		  $('.good_count').html(0);
		  $('.minus_good').removeClass('high_but');
		  $('.plus_good').addClass('high_but');
		  $.post('/main/clear_cookie_cart', '',function(data) {
				if (data.success == 'yes') {
					$('.goods_count').html(0);
				}else{
					alert(data.msg);
				}
			},"json");
	   })



	  var per_count_limit = parseInt($('#per_count_limit').val());
	   var total_count_limit = parseInt($('#total_count_limit').val());
	//加减商品数量
	   $('.plus_good').on("click",function(){
		  //salert(per_count_limit);
                     var data_date=$(this).prev("div").children("select:eq(0)").find("option:selected").val(); 
            if($("#hidden_weeks").val()==0){
              var data_date=$(this).prev("div").children("select:eq(0)").find("option:selected").val(); 
           }else if($("#hidden_weeks").val()==1){
               var data_date=$(this).prev("div").children("select:eq(1)").find("option:selected").val(); 
           }
           if(data_date==0){
               return false;
           }
                      
		 var total_count = $('.cart_icon').html();
               var count_num=  $(this).parents(".wechat_good_buy_button").children(".buy_good_count").html();
              var current_count=1;
	    // var current_count = $(this).parents(".wechat_good_buy_button").children(".buy_good_count").html();
            
	         if(current_count == 0){
	        	 $(this).prev('div').prev('div').addClass('high_but');
	         }
	         if(++current_count <= per_count_limit){

	        	 if(current_count == per_count_limit){
					$(this).removeClass('high_but');
	             }
	             //$(this).prev('div').html(current_count);
                      //$(this).parents(".wechat_good_buy_button").children(".buy_good_count").html(current_count);
	             $('.minus_good').removeClass('wechat_buy_icon_invalid');
	             $(this).parents('.index_good_count').children('.index_buy_icon_minus').show();
                   current_count=1;
	             change_cart_count($(this),current_count);

	         }
	   })
	//减商品数量
	   $('.minus_good').click(function(){
		   if(parseInt($(this).next(".buy_good_count").html()==0)){
			   return false;
		   }
		   var total_count = $('.cart_icon').html();
	     var current_count = $(this).next('div').html();

	         $(this).next('div').next('div').addClass('high_but');

	         current_count = current_count-1;
	         if((current_count <= per_count_limit)&&(current_count >=0)){

	        	 if(current_count == 0){
					$(this).removeClass('high_but');
	             }
	             $(this).next('div').html(current_count);

	             $('.cart_icon').html(--total_count);
	             if(total_count ==0){
	            	 $('.cart_icon').hide();
	            	 $(this).addClass('wechat_buy_icon_invalid');
	            	 $(this).parents('.index_good_count').children('.index_buy_icon_minus').hide();
	             }
	             change_cart_count($(this),current_count);

	         }
	   })

	//订购事件
	  /* $('.good_buy_button').click(function(){
		   var id = $(this).parents('ul').attr('data_good_id');
		   var count = $(this).prev('div').children('.good_count').html();
		   var week = $(this).parents('.good_menus').attr('data_week');
		   var current_date = $(this).parents('.good_menus').attr('data_date');

		   var submitData = {id:id+'_'+week,count:count,current_date:current_date}
		   $.post('/main/cookie_cart', submitData,function(data) {
				if (data.success == 'yes') {
					$('.goods_count').html(data.count);
				}else{
					alert(data.msg);
					window.location.reload();
				}
			},"json");
		})*/

		$(".plus_goods").click(function(){
					 if(parseInt($(".cookie_count").html())=="100"){
					  return false;
			}

			//var old_price=parseInt();

		   var id = $(this).parents('td').attr('data_good_id');
		   var count = parseInt($(this).prev('.confirm_order_count,.main_confirm_order_count').html());
		   var week = $(this).parents('td').attr('data_week');
		   var data_limit = $(this).parents('td').attr('data_limit');
           var data_good_id=$(this).parents('td').attr('data_good_id');
           var building_id = $(this).parents('td').attr('data_building_id');
		//	alert(per_count_limit);
		if(data_good_id==12||data_good_id==13||data_good_id==14||data_good_id==15||data_good_id==16)
                {

                    if(count >=3){
			   return false;
		   }
                }else{
                   if(count >=data_limit){
			   return false;
		   }
                }

		   count++;
		 $(this).prev(".confirm_order_count").html(count);
		 //////////
		 $(".cookie_count").html("0");
			$(".total_count,.green_color").html("0");
			$(".confirm_order_count").each(function(){
			$(".cookie_count,.green_color").html(parseInt($(this).html())+parseInt($(".cookie_count,.green_color").html()));
			$(this).parent().next().children(".single_price").html();
			var price=parseFloat($(this).parent().next().children(".single_price").html());
		   var totle_price=parseInt($(this).html())*price;
		   $(".total_count").html((totle_price+parseFloat($(".total_count").html())).toFixed(2));

			})






		 /////////

		   var submitData = {id:id+'_'+week,count:count,building_id:building_id}
		   $.post('/main/cookie_cart', submitData,function(data) {
				if (data.success == 'yes') {
					$(".cart_count").html($(".cookie_count").html());//同步购物车图标的数字
					//window.location.reload();
				}else{
					alert(data.msg);
				}
			},"json");

					//隐藏菜单的click function
					$(".good_detail_img_div").each(function(){
						var data_week=$(this).attr("data_week");
						var good_id=$(this).attr("data_good_id");
						if(week==data_week&&data_good_id==good_id){
							$(this).children().children().children(".buy_good_count").html(count);

						}

					})
                                        var data_info=$(this).attr("data_info");

                                        if(data_info==0){
					onsell(data_info);
					}else if(data_info==3){
					count_price($(this));
					onsell(data_info);
                                        order_confirm_pay();
					}else{
                                        count_price($(this));
					onsell(data_info);
                                        }


				  });
		$('.minus_goods').click(function(){

		   var id = $(this).parents('td').attr('data_good_id');
		   var count = parseInt($(this).next('.confirm_order_count,.main_confirm_order_count').html());
		   var week = $(this).parents('td').attr('data_week');
		   var building_id = $(this).parents('td').attr('data_building_id');
		   if(count >per_count_limit){
			  // return false;
		   }
		   count--;


			$(this).next(".confirm_order_count").html(count);
			$(".cookie_count,.green_color").html("0");
			$(".total_count").html("0");
			$(".confirm_order_count").each(function(){
			$(".cookie_count,.green_color").html(parseInt($(this).html())+parseInt($(".cookie_count,.green_color").html()));
			$(this).parent().next().children(".single_price").html();
			var price=parseFloat($(this).parent().next().children(".single_price").html());
		   var totle_price=parseInt($(this).html())*price;
		   $(".total_count").html((totle_price+parseFloat($(".total_count").html())).toFixed(2));

			})
		   var submitData = {id:id+'_'+week,count:count,building_id:building_id}
		   $.post('/main/cookie_cart', submitData,function(data) {
				if (data.success == 'yes') {
					$(".cart_count").html($(".cookie_count").html());
					if($(".cookie_count").html()==0){
						window.location.reload();
					}
					if(data.count !=0){
						//window.location.reload();
					}else{
			//判断是手机还是网页
					   if(controller == 'wechat'){
						   window.location.href='/wechat/index';
					   }else{
						   window.location.href='/main/index';
					   }
					}
				}else{
					alert(data.msg);
				}
			},"json");
			//////
			//删除值为0的元素


				$(".good_detail_img_div").each(function(){
						var data_week=$(this).attr("data_week");
						var good_id=$(this).attr("data_good_id");
						if(week==data_week&&id==good_id){
							$(this).children().children().children(".buy_good_count").html(count);

						}

					})

						$(".confirm_order_count").each(function(){
					if(parseInt($(this).html())==0){
						$(this).parent().parent().remove();
						return false;
					}
				})
                                     var data_info=$(this).attr("data_info");

                                        if(data_info==0){
					onsell(data_info);
					}else if(data_info==3){
					count_price2($(this));
					onsell(data_info);
                                        order_confirm_pay();
					}else{
                                        count_price2($(this));
					onsell(data_info);
                                        }
			////
		})

//判断订单总菜品数
	$('.cart_title').click(function(){
 //先判断用户是否登录

        var total_count = $('.goods_count').html();
		if(total_count > total_count_limit){
			alert_frame('菜品总数不能大于'+total_count_limit,1);
		}

		window.location.href="/main/order_confirm";
    })


    $('.member_center_wechat_div').click(function(){

    	window.location.href="/wechat/member_center";
    })

//微信提交
    $('.cart_title_wechat').click(function(){
 //先判断用户是否登录

        var total_count = $('.goods_count').html();
		if(total_count > total_count_limit){
			alert_frame('菜品总数不能大于'+total_count_limit,1);
		}

		//window.location.href="/wechat/order_confirm";
    })


	$('.register_span').click(function(){
      $('#black-popup').show();
      $('#popup').show();
    })

   $('.right_div>input').keydown(function(){
	   $(this).removeClass('error_note');
   })
      var v = /^13[0-9]{1}[0-9]{8}$|15[01235689]{1}[0-9]{8}$|18[236789]{1}[0-9]{8}$/;
	var email = /^[a-zA-Z0-9_\.]+@[a-zA-Z0-9-]+[\.a-zA-Z]+$/;

    $('#get_code').click(function(){
	    	 var mobile_email = $("#mobile_email").val();
	    	 var register_type = $('#register_type').val();

	    	 var url = '/main/send_mobile_sms';
		 	if(register_type == 2){
		 		url+='/2';
		 	}
		 		var v = /^(((13[0-9]{1})|(15[0-9]{1})|(14[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
		 		var submitData={
		 				 mobile : mobile_email
		 			 };

		 		if(!mobile_email){
		    		  $('#mobile_email').attr('placeholder','手机号码不能空').addClass('error_note');
		    		  return false;
		    	  }else{
		    		  $('#mobile_email').removeClass('error_note');
		    	  }

		    	  if(!v.test(mobile_email)){
		    		   $('#mobile_email').attr('placeholder','请输入正确的手机号').addClass('error_note');
		  	  		   return false;
			  	  }else{

			  	  }

		 		 $("#get_code").attr('disabled',true);
		 		$.post(url,submitData,function(data){

					 if(data.success == 'yes'){
						 $('#mobile_email').removeClass('error_note');
					  	  	var NowTime2 = new Date();
				 			var EndTime= NowTime2.getTime()+60*60*300;
				 		$('#hidden_time').val(EndTime);
			 			 GetRTime();
			 			$("#send_div").hide();
			 			 $('#verify_div').show();
					 }else{
						 alert_frame(data.msg,1);
					 }
				},"json");
		    })


 $('#forget_password,.third_login_input').on('click',function(){
	    	//0 for mobile,1 for email
	    	var password = $.trim($('#password').val());
	    	var repassword = $.trim($('#repassword').val());
	    	var mobile_email = $.trim($('#mobile_email').val());
                var v = /^(((13[0-9]{1})|(15[0-9]{1})|(14[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
	    	if(!password){
	    		$('#password').attr('placeholder','密码不能空').addClass('error_note');
	    		return false;
	    	}else{
	    		$('#password').removeClass('error_note');
	    	}

	    	if(!repassword){
	    		$('#repassword').attr('placeholder','重复密码不能空').addClass('error_note');
	    		return false;
	    	}else{
	    		$('#repassword').removeClass('error_note');
	    	}

	    	if(password != repassword){
	    		$('#repassword').attr('placeholder','密码不一致').addClass('error_note');
	    		return false;
	    	}else{
	    		$('#repassword').removeClass('error_note');
	    	}


	    	  if(!mobile_email){
	    		  $('#mobile_email').attr('placeholder','手机号码不能空').addClass('error_note');
	    		  return false;
	    	  }else{
	    		  $('#mobile_email').removeClass('error_note');
	    	  }

	    	  if(!v.test(mobile_email)){
                      alert('请输入正确的手机号');
	    		  // $('#mobile_email').attr('placeholder','请输入正确的手机号').addClass('error_note');
	  	  		   return false;
		  	  }else{
		  	  	   $('#mobile_email').removeClass('error_note');
		  	  }
	    	  var captcha = $.trim($('#captcha').val());
	    	  var submitdata = {
	    			     mobile_email : mobile_email,
		 				 password:password,
		 				 captcha:captcha
				 };

	    //提交注册数据
	    	$.post('/main/get_user_password',submitdata,function(data){
	    		 alert_frame(data.msg,1);
				 if(data.success == 'yes'){
					 if(login_flag==1){
						window.location.href="/main/order_confirm";
					 }else{
					     window.location.reload();
					 }
				 }else{

				 }
			},"json");

	    })

//注册相关js

    $('.submit_button').click(function(){
    	//0 for mobile,1 for email
    	var login_flag = $('#login_flag').val();
    	var reg_type = $('#register_type').val();
    	var password = $.trim($('#password').val());
    	var repassword = $.trim($('#repassword').val());
    	var mobile_email = $.trim($('#mobile_email').val());
        var v = /^(((13[0-9]{1})|(15[0-9]{1})|(14[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
    	if(!password){
    		$('#password').attr('placeholder','密码不能空').addClass('error_note');
    		return false;
    	}else{
    		$('#password').removeClass('error_note');
    	}

    	if(!repassword){
    		$('#repassword').attr('placeholder','重复密码不能空').addClass('error_note');
    		return false;
    	}else{
    		$('#repassword').removeClass('error_note');
    	}

    	if(password != repassword){
    		$('#repassword').attr('placeholder','密码不一致').addClass('error_note');
    		return false;
    	}else{
    		$('#repassword').removeClass('error_note');
    	}

    	if(reg_type == 0){

    	  if(!mobile_email){
    		  $('#mobile_email').attr('placeholder','手机号码不能空').addClass('error_note');
    		  return false;
    	  }else{
    		  $('#mobile_email').removeClass('error_note');
    	  }

    	  if(!v.test(mobile_email)){
              alert("请输入正确的手机号");
              //13816064684
    		   //$('#mobile_email').attr('placeholder','请输入正确的手机号').addClass('error_note');
  	  		   return false;
	  	  }else{
	  	  	   $('#mobile_email').removeClass('error_note');
	  	  }
    	  var captcha = $.trim($('#captcha').val());
    	  var submitdata = {
    			     mobile_email : mobile_email,
	 				 password:password,
	 				 captcha:captcha,
	 				 reg_type:reg_type
			 };
    	}else{
    		if(!mobile_email){
      		  $('#mobile_email').attr('placeholder','电子邮箱不能空').addClass('error_note');
      		  return false;
	      	  }else{
	      		  $('#mobile_email').removeClass('error_note');
	      	  }

	      	  if(!email.test(mobile_email)){
	      		   $('#mobile_email').attr('placeholder','请输入正确的电子邮箱').addClass('error_note');
	    	  		   return false;
	  	  	  }else{
	  	  	  	   $('#mobile_email').removeClass('error_note');
	  	  	  }

	      	  var submitdata = {
	      			     mobile_email : mobile_email,
	  	 				 password:password,
	  	 				 reg_type:reg_type
	  			 };
    	}
    //提交注册数据
    	$.post('/main/user_register',submitdata,function(data){
    		 alert_frame(data.msg,1);
			 if(data.success == 'yes'){
				 if(login_flag==1){
					window.location.href="/main/order_confirm";
				 }else{
				     window.location.reload();
				 }
			 }else{

			 }
		},"json");

    })


 //首页登录
    $('.user_login_button').click(function(){
    	var type = $(this).attr('id');
    	var login_type='';
    	var login_flag = $('#login_flag').val();
    	if(type == 'sub_login_button'){
    		var mobile_email = $.trim($('#login_mobile_email').val());
    		var password = $.trim($('#login_password').val());
    		var remember_flag = $('#remember_login').attr('checked');
    		if(remember_flag){
    			remember_flag = 1;
    		}else{
    			remember_flag = 2;
    		}
    		login_type='float';
    		var submitdata ={
    				mobile_email:mobile_email,
    				password:password,
    				remember_flag:remember_flag,
    				login_type:login_type
    		}
    	}else{
    		login_type='header';
    		var mobile_email = $.trim($('#header_username').val());
    		var password = $.trim($('#header_password').val());
    		var submitdata ={
    				mobile_email:mobile_email,
    				password:password,
    				login_type:login_type
    		}
    	}

    	$.post('/main/user_login',submitdata,function(data){
   		      alert_frame(data.msg,1);
			 if(data.success == 'yes'){
				    if(login_flag==1){
						window.location.href="/main/order_confirm";
					 }else{
					    window.location.reload();
					 }
			 }else{

			 }
		},"json");

    })


    $('#logout_sys').click(function(){

    	$.post('/main/user_logout','',function(data){

			 if(data.success == 'yes'){
				 window.location.href='/main/index';
			 }else{

			 }
		},"json");
    })

    $('#email_register').click(function(){
    	$('#register_type').val(1);
    	$('#capcha_div').hide();
    	$('#mobile_email').attr('placeholder','电子邮箱');
    	$(this).removeClass('title_right').addClass('title_left');
    	$('#mobile_register').removeClass('title_left').addClass('title_right');
    })

    $('#mobile_register').click(function(){
    	$('#register_type').val(0);
    	$('#capcha_div').show();
    	$('#mobile_email').attr('placeholder','手机号码');
    	$(this).removeClass('title_right').addClass('title_left');
    	$('#email_register').removeClass('title_left').addClass('title_right');
    })


    $('.pop_close_but').click(function(){
        $('#black-popup').hide();
        $('#popup').hide();
        $('.forgot_pass').hide();
        $('.signupBar_eric').hide();
        $('.loginBar_eric').hide();
		$('.order_detail_float').hide();

      })

    $('#register_now').click(function(){
    	$('#third_login_div').hide();
    	$('#third_register_div').show();
    	$('#register_second_div').hide();
    	$('#register_first_div').show();
    })
    $('#login_now').click(function(){
    	$('#third_login_div').show();
    	$('#third_register_div').hide();
    	$('#register_second_div').show();
    	$('#register_first_div').hide();
    })

    $('#forget_password_p').click(function(){
    	$('#third_login_div').hide();
    	$('#third_register_div').show();
    	$('#register_second_div').hide();
    	$('#register_first_div').show();
    	$('.register_title').html('重置密码');
    	$('#mobile_register').html('手机找回密码');
    	$('.xieyi').hide();
    	$('.form_div').html('<span id="forget_password">提交</span>');
    	$('#password').attr('placeholder','设置新密码');
    	$('#register_type').val(2);
    })
	//个人中心按钮
    $(".person_icon").click(function(){

	})
   function order_confirm_pay(){
       var general=$(".general").html();
         var onsell=$(".onsell").html();
         var paydown=parseFloat(general)-parseFloat(onsell);
       var order_total= parseFloat($(".order_total").html());
       $(".order_total").html((order_total-paydown).toFixed(2));
   }

})
