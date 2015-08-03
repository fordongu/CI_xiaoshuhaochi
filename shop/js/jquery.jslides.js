/**
 * jQuery jslides 1.1.0
 *
 * http://www.cactussoft.cn
 *
 * Copyright (c) 2009 - 2013 Jerry
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */
$(function(){
	
	$("#back-to-top").click(function() {
        $('body,html').animate({
            scrollTop: 0
        },
        1000);
        return false;
    });
	
	
	$('.scroll_top').hover(function(){
		 
	     $(this).children('img').attr('src','/images/about_top_selected.png'); 
	},function(){
		$(this).children('img').attr('src','/images/about_top.png');
	})
	
	
	$('.short_p').hover(function(){
		 var flag = $(this).attr('data-attr');
		 var url  = $(this).children('img').attr('data-url');
		 $(this).children('img').attr('src','/images/'+url+'_red.png');
	     $(this).addClass('yellow_font'); 
	},function(){
		 var url  = $(this).children('img').attr('data-url');
		 $(this).children('img').attr('src','/images/'+url+'.png');
		 $(this).removeClass('yellow_font'); 
	})
	
	
	$('#fs').hover(function(){
	     
	    var flag = $(this).attr('data-attr');
	    if(flag == 'up'){
	    	$(this).attr('src','/images/right.gif');
	    }else{
	    	$(this).attr('src','/images/left.gif');
	    }
	},function(){
		var h = $(this).attr('data-attr');
		$(this).attr('src','/images/black_'+h+'.png');
	})
	
	$('.piclist a').hover(function(){
		 
	     $(this).next('.red_height').addClass('yellow'); 
	},function(){
		 $(this).next('.red_height').removeClass('yellow'); 
	})
	
	
	$('.piclist4 a').hover(function(){
		 
	     $(this).next('.red_height').addClass('yellow'); 
	},function(){
		 $(this).next('.red_height').removeClass('yellow'); 
	})
	
	
	
	$('.product_service_title li').hover(function(){
		 var select_li = '#'+$(this).attr('id')+'_li';
		 $('.product_service_title li').removeClass('yellow_event_selected');
		 $('.product_service_title li').removeClass('yellow_event');
	     $(this).addClass('yellow_event'); 
	      
	},function(){
		 $(this).removeClass('yellow_event'); 
	})
	
	
	$('.product_service_title li').click(function(){
		 $('.product_service_title li').removeClass('yellow_event_selected'); 
		var select_li = '#'+$(this).attr('id')+'_li';
		var select_div = '#'+$(this).attr('id')+'_div';
	     $(this).addClass('yellow_event_selected'); 
	     $(".product_service_img").children('li').hide();
	     $(select_li).show();
	     
	     $('.product_service_exam').hide();
	     $(select_div).show();
	})
	
	
	$('.photos div').hover(function(){
		 var flag = $(this).children('img').attr('data-id');
		 if(flag =='grey') return false;
		 $('.profession_detail').hide();
		 $('.'+flag).show();
	     $(this).addClass('photo_border'); 
	},function(){
		 $(this).removeClass('photo_border'); 
	})
	
	$('.photos div').click(function(){
		var flag = $(this).children('img').attr('data-id');
		window.location.href="/main/special/"+flag;
	})
	
	
	
	//获取要定位元素距离浏览器顶部的距离 
	var navH = $(".logo_menu").offset().top; 
	//滚动条事件 
	$(window).scroll(function(){ 
		//获取滚动条的滑动距离 
		var scroH = $(this).scrollTop(); 
		//滚动条的滑动距离大于等于定位元素距离浏览器顶部的距离，就固定，反之就不固定 
		if(scroH>=navH){ 
			$(".logo_menu").addClass('logo_menu_focus');
		}else if(scroH<navH){ 
			$(".logo_menu").removeClass('logo_menu_focus'); 
		} 
	}) 
	
	
	
	$('#fs').click(function(){
		var flag = $(this).attr('data-attr');
		if(flag == 'down'){
			$('#title_home_show').addClass('active');
			$('#title_home_show').animate({height:'show'},500);
			$(this).attr({'src':'/images/black_up.png','data-attr':'up'});
		}else{
			$(this).attr({'src':'/images/black_down.png','data-attr':'down'});
			$('#title_home_show').removeClass('active');
			$('#title_home_show').animate({height:'toggle'}, 200);
		}
	});
	
	$('body').click(function(e){
		if($(e.target).attr('id') == 'body')
		{
			if($('#title_home_show').hasClass('active'))
			{
				$(this).attr({'src':'/images/black_down.png','data-attr':'down'});
				$('#title_home_show').removeClass('active');
				$('#title_home_show').animate({height:'toggle'}, 200);				 
			}
		}	
	});
	
	
	$('.menu_li').click(function(){
		
		var flag = $(this).attr('data-attr');
		var li_menu = '.menu_detail_'+flag;
		$(li_menu).animate({height:'toggle'}, 0);
		$('.menu_event').hide();
		$(li_menu).show('fast');
		
	})
	
	
	
	var numpic = $('.slides li').size()-1;
	var numpic2 = $('.slides2 li').size()-1;
	var numpic3 = $('.slides3 li').size()-1;
	var numpic4 = $('.slides4 li').size()-1;
	var nownow = 0;
	var nownow2 = 0;
	var nownow3 = 0;
	var nownow4 = 0;
	var inout = 0;
	var TT = 0;
	var inout2 = 0;
	var TT2 = 0;
	var inout3 = 0;
	var TT3 = 0;
	var inout4 = 0;
	var TT4 = 0;
	var SPEED = 7000;

$('.slides2 li').eq(0).css({'z-index':'800'});
	$('.middle_images li').eq(0).siblings('li').css({'display':'none'});
	$('.news_images li').eq(0).siblings('li').css({'display':'none'});
	$('.slides_title_ul li').eq(0).siblings('li').css({'display':'none'});
	$('.slides_title_ul2 li').eq(0).siblings('li').css({'display':'none'});
	$('.slides_title_ul3 li').eq(0).siblings('li').css({'display':'none'});
	$('.slides_title_ul4 li').eq(0).siblings('li').css({'display':'none'});

	var ulstart = '<ul class="pagination pages">',ulstart2 = '<ul class="pagination pages2">',ulstart3 = '<ul class="pagination pages3 right">'
		,ulstart4 = '<ul class="pagination pages4 right">'
		ulcontent = '',ulcontent2 = '',ulcontent3 = '',ulcontent4 = '',
		ulend = '</ul>';
	ADDLI();
	ADDLI2();
	ADDLI3();
	ADDLI4();
	var pagination = $('.pages li');
	var paginationwidth = $('.pages').width();
	
	pagination.eq(0).addClass('current');
		
	var pagination2 = $('.pages2 li');
	var paginationwidth2 = $('.pages2').width();
	
	pagination2.eq(0).addClass('current');
	
	var pagination3 = $('.pages3 li');
	var paginationwidth3 = $('.pages3').width();
	
	pagination3.eq(0).addClass('current');
	
	var pagination4 = $('.pages4 li');
	var paginationwidth4 = $('.pages4').width();
	
	pagination4.eq(0).addClass('current');
	
	function ADDLI(){
		//var lilicount = numpic + 1;
		for(var i = 0; i <= numpic; i++){
			ulcontent += '<li>' + '<a href="javascript:void(0)">' + (i+1) + '</a>' + '</li>';
		}
		
		$('.slides').after(ulstart + ulcontent + ulend);	
	}
	function ADDLI2(){
		//var lilicount = numpic + 1;
		for(var i = 0; i <= numpic2; i++){
			ulcontent2 += '<li>' + '<a href="javascript:void(0)">' + (i+1) + '</a>' + '</li>';
		}
		
		$('.slides2').after(ulstart2 + ulcontent2 + ulend);	
	}
	
	function ADDLI3(){
		//var lilicount = numpic + 1;
		for(var i = 0; i <= numpic3; i++){
			ulcontent3 += '<li>' + '<a href="javascript:void(0)">' + (i+1) + '</a>' + '</li>';
		}
		
		$('.slides3').after(ulstart3 + ulcontent3 + ulend);	
	}
	
	
	function ADDLI4(){
		//var lilicount = numpic + 1;
		for(var i = 0; i <= numpic4; i++){
			ulcontent4 += '<li>' + '<a href="javascript:void(0)">' + (i+1) + '</a>' + '</li>';
		}
		
		$('.slides4').after(ulstart4 + ulcontent4 + ulend);	
	}

	pagination.on('click',DOTCHANGE);
	pagination2.on('click',DOTCHANGE2);
	pagination3.on('click',DOTCHANGE3);
	pagination4.on('click',DOTCHANGE4);
	
	function DOTCHANGE(){
		
		var changenow = $(this).index(); 
		$('.slides li').eq(nownow).css('z-index','900');
		$('.slides li').eq(changenow).css({'z-index':'800'}).show();
		pagination.eq(changenow).addClass('current').siblings('li').removeClass('current');
		$('.slides li').eq(nownow).fadeOut(400,function(){$('.slides li').eq(changenow).fadeIn(500);});
		
		$('.slides_title_ul li').eq(nownow).hide();
		$('.slides_title_ul li').eq(changenow).show();
		$('.slides_title_ul li').eq(nownow).fadeOut(0,function(){$('.slides_title_ul li').eq(changenow).fadeIn(0);});
		
		nownow = changenow;
		
		
	}
	
	function DOTCHANGE2(){
		
		var changenow2 = $(this).index(); 
		$('.slides2 li').eq(nownow2).css('z-index','900');
		$('.slides2 li').eq(changenow2).css({'z-index':'800'}).show();
		pagination2.eq(changenow2).addClass('current').siblings('li').removeClass('current');
		$('.slides2 li').eq(nownow2).fadeOut(400,function(){$('.slides2 li').eq(changenow2).fadeIn(500);});
		
		$('.slides_title_ul2 li').eq(nownow2).hide();
		$('.slides_title_ul2 li').eq(changenow2).show();
		$('.slides_title_ul2 li').eq(nownow2).fadeOut(0,function(){$('.slides_title_ul2 li').eq(changenow2).fadeIn(0);});
		
		nownow2 = changenow2;
	}
	
	
	function DOTCHANGE3(){
		
		var changenow3 = $(this).index(); 
		$('.slides3 li').eq(nownow3).css('z-index','900');
		$('.slides3 li').eq(changenow3).css({'z-index':'800'}).show();
		pagination3.eq(changenow3).addClass('current').siblings('li').removeClass('current');
		$('.slides3 li').eq(nownow3).fadeOut(400,function(){$('.slides3 li').eq(changenow3).fadeIn(500);});
		
		$('.slides_title_ul3 li').eq(nownow3).hide();
		$('.slides_title_ul3 li').eq(changenow3).show();
		$('.slides_title_ul3 li').eq(nownow3).fadeOut(0,function(){$('.slides_title_ul3 li').eq(changenow3).fadeIn(0);});
		
		nownow3 = changenow3;
	}
	
	
	function DOTCHANGE4(){
		
		var changenow4 = $(this).index(); 
		$('.slides4 li').eq(nownow4).css('z-index','900');
		$('.slides4 li').eq(changenow4).css({'z-index':'800'}).show();
		pagination4.eq(changenow4).addClass('current').siblings('li').removeClass('current');
		$('.slides4 li').eq(nownow4).fadeOut(400,function(){$('.slides4 li').eq(changenow4).fadeIn(500);});
		
		$('.slides_title_ul4 li').eq(nownow4).hide();
		$('.slides_title_ul4 li').eq(changenow4).show();
		$('.slides_title_ul4 li').eq(nownow4).fadeOut(0,function(){$('.slides_title_ul4 li').eq(changenow4).fadeIn(0);});
		
		nownow4 = changenow4;
	}

	function GOGO(){
		
		var NN = nownow+1;
		
		if( inout == 1 ){
			} else {
			if(nownow < numpic){
			$('.slides li').eq(nownow).css('z-index','900');
			$('.slides li').eq(NN).css({'z-index':'800'}).show();
			pagination.eq(NN).addClass('current').siblings('li').removeClass('current');
			$('.slides li').eq(nownow).fadeOut(400,function(){$('.slides li').eq(NN).fadeIn(500);});
			
			$('.slides_title_ul li').eq(nownow).hide();
			$('.slides_title_ul li').eq(NN).show();
			$('.slides_title_ul li').eq(nownow).fadeOut(0,function(){$('.slides_title_ul li').eq(NN).fadeIn(0);});
			
			
			nownow += 1;

		}else{
			NN = 0;
			$('.slides li').eq(nownow).css('z-index','900');
			$('.slides li').eq(NN).stop(true,true).css({'z-index':'800'}).show();
			$('.slides li').eq(nownow).fadeOut(400,function(){$('.slides li').eq(0).fadeIn(500);});
			
			$('.slides_title_ul li').eq(nownow).css('z-index','900');
			$('.slides_title_ul li').eq(NN).stop(true,true).css({'z-index':'800'}).show();
			$('.slides_title_ul li').eq(nownow).fadeOut(0,function(){$('.slides_title_ul li').eq(0).fadeIn(0);});
			
			pagination.eq(NN).addClass('current').siblings('li').removeClass('current');

			nownow=0;

			}
		}
		TT = setTimeout(GOGO, SPEED);
	}
	
	//TT = setTimeout(GOGO, SPEED);
	
	function GOGO2(){
		var NN2 = nownow2+1;
		
		if( inout2 == 1 ){
			} else {
			if(nownow2 < numpic2){
			$('.slides2 li').eq(nownow2).css('z-index','900');
			$('.slides2 li').eq(NN2).css({'z-index':'800'}).show();
			pagination2.eq(NN2).addClass('current').siblings('li').removeClass('current');
			$('.slides2 li').eq(nownow2).fadeOut(400,function(){$('.slides2 li').eq(NN2).fadeIn(500);});
			
			$('.slides_title_ul2 li').eq(nownow2).hide();
			$('.slides_title_ul2 li').eq(NN2).show();
			$('.slides_title_ul2 li').eq(nownow2).fadeOut(0,function(){$('.slides_title_ul2 li').eq(NN2).fadeIn(0);});
			
			nownow2 += 1;

		}else{
			NN2 = 0;
			$('.slides2 li').eq(nownow2).css('z-index','900');
			$('.slides2 li').eq(NN2).stop(true,true).css({'z-index':'800'}).show();
			$('.slides2 li').eq(nownow2).fadeOut(400,function(){$('.slides2 li').eq(0).fadeIn(500);});
			
			$('.slides_title_ul2 li').eq(nownow2).css('z-index','900');
			$('.slides_title_ul2 li').eq(NN2).stop(true,true).css({'z-index':'800'}).show();
			$('.slides_title_ul2 li').eq(nownow2).fadeOut(0,function(){$('.slides_title_ul2 li').eq(0).fadeIn(0);});
			
			pagination2.eq(NN2).addClass('current').siblings('li').removeClass('current');

			nownow2=0;

			}
		}
		TT2 = setTimeout(GOGO2, SPEED);
	}
	
	//TT2 = setTimeout(GOGO2, SPEED);
	
	
function GOGO3(){
		
		var NN3 = nownow3+1;
		
		if( inout3 == 1 ){
			} else {
			if(nownow3 < numpic3){
			$('.slides3 li').eq(nownow3).css('z-index','900');
			$('.slides3 li').eq(NN3).css({'z-index':'800'}).show();
			pagination3.eq(NN3).addClass('current').siblings('li').removeClass('current');
			$('.slides3 li').eq(nownow3).fadeOut(400,function(){$('.slides3 li').eq(NN3).fadeIn(500);});
			
			$('.slides_title_ul3 li').eq(nownow3).hide();
			$('.slides_title_ul3 li').eq(NN3).show();
			$('.slides_title_ul3 li').eq(nownow3).fadeOut(0,function(){$('.slides_title_ul3 li').eq(NN3).fadeIn(0);});
			
			nownow3 += 1;

		}else{
			NN3 = 0;
			$('.slides3 li').eq(nownow3).css('z-index','900');
			$('.slides3 li').eq(NN3).stop(true,true).css({'z-index':'800'}).show();
			$('.slides3 li').eq(nownow3).fadeOut(400,function(){$('.slides3 li').eq(0).fadeIn(500);});
			
			$('.slides_title_ul3 li').eq(nownow3).css('z-index','900');
			$('.slides_title_ul3 li').eq(NN3).stop(true,true).css({'z-index':'800'}).show();
			$('.slides_title_ul3 li').eq(nownow3).fadeOut(0,function(){$('.slides_title_ul3 li').eq(0).fadeIn(0);});
			
			pagination3.eq(NN3).addClass('current').siblings('li').removeClass('current');

			nownow3=0;

			}
		}
		TT3 = setTimeout(GOGO3, SPEED);
	}
	
	TT3 = setTimeout(GOGO3, SPEED);
	


	function GOGO4(){
			
			var NN4 = nownow4+1;
			
			if( inout4 == 1 ){
				} else {
				if(nownow4 < numpic4){
				$('.slides4 li').eq(nownow4).css('z-index','900');
				$('.slides4 li').eq(NN4).css({'z-index':'800'}).show();
				pagination4.eq(NN4).addClass('current').siblings('li').removeClass('current');
				$('.slides4 li').eq(nownow4).fadeOut(400,function(){$('.slides4 li').eq(NN4).fadeIn(500);});
				
				$('.slides_title_ul4 li').eq(nownow4).hide();
				$('.slides_title_ul4 li').eq(NN4).show();
				$('.slides_title_ul4 li').eq(nownow4).fadeOut(0,function(){$('.slides_title_ul4 li').eq(NN4).fadeIn(0);});
				
				nownow4 += 1;

			}else{
				NN4 = 0;
				$('.slides4 li').eq(nownow4).css('z-index','900');
				$('.slides4 li').eq(NN4).stop(true,true).css({'z-index':'800'}).show();
				$('.slides4 li').eq(nownow4).fadeOut(400,function(){$('.slides4 li').eq(0).fadeIn(500);});
				
				$('.slides_title_ul4 li').eq(nownow4).css('z-index','900');
				$('.slides_title_ul4 li').eq(NN4).stop(true,true).css({'z-index':'800'}).show();
				$('.slides_title_ul4 li').eq(nownow4).fadeOut(0,function(){$('.slides_title_ul4 li').eq(0).fadeIn(0);});
				
				pagination4.eq(NN4).addClass('current').siblings('li').removeClass('current');

				nownow4=0;

				}
			}
			TT4 = setTimeout(GOGO4, SPEED);
		}
		
		TT4 = setTimeout(GOGO4, SPEED);	

		
})