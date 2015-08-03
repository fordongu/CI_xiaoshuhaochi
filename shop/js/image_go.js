// JavaScript Document
$(document).ready(function(e) {
	/***不需要自动滚动，去掉即可***/
	time = window.setInterval(function(){
		$('.og_next').click();	
	},1000000);
	/***不需要自动滚动，去掉即可***/
	linum = $('.mainlist li').length;//图片数量
	w = linum * (344+24);//ul宽度 
	$('.piclist').css('width', w + 'px');//ul宽度
	$('.swaplist').html($('.mainlist').html());//复制内容
	
	$('.og_next').click(function(){
		
		if($('.swaplist,.mainlist').is(':animated')){
			$('.swaplist,.mainlist').stop(true,true);
		}
		
		if($('.mainlist li').length>3){//多于4张图片
			ml = parseInt($('.mainlist').css('left'));//默认图片ul位置
			sl = parseInt($('.swaplist').css('left'));//交换图片ul位置
			if(ml<=0 && ml>w*-1){//默认图片显示时
				$('.swaplist').css({left: '1104px'});//交换图片放在显示区域右侧
				$('.mainlist').animate({left: ml - 1104 + 'px'},'slow');//默认图片滚动				
				if(ml==(w-1104)*-1){//默认图片最后一屏时
					$('.swaplist').animate({left: '0px'},'slow');//交换图片滚动
				}
			}else{//交换图片显示时
				$('.mainlist').css({left: '1104px'})//默认图片放在显示区域右
				$('.swaplist').animate({left: sl - 1104 + 'px'},'slow');//交换图片滚动
				if(sl==(w-1104)*-1){//交换图片最后一屏时
				 
					$('.mainlist').animate({left: '0px'},'slow');//默认图片滚动
				}
			}
		}
	})
	$('.og_prev').click(function(){
		
		if($('.swaplist,.mainlist').is(':animated')){
			$('.swaplist,.mainlist').stop(true,true);
		}
		
		if($('.mainlist li').length>3){
			ml = parseInt($('.mainlist').css('left'));
			sl = parseInt($('.swaplist').css('left'));
			if(ml<=0 && ml>w*-1){
				$('.swaplist').css({left: w * -1 + 'px'});
				$('.mainlist').animate({left: ml + 1104 + 'px'},'slow');				
				if(ml==0){
					$('.swaplist').animate({left: (w - 1104) * -1 + 'px'},'slow');
				}
			}else{
				$('.mainlist').css({left: (w - 1104) * -1 + 'px'});
				$('.swaplist').animate({left: sl + 1104 + 'px'},'slow');
				if(sl==0){
					$('.mainlist').animate({left: '0px'},'slow');
				}
			}
		}
	})    
});

$(document).ready(function(){
	$('.og_prev,.og_next').hover(function(){
		    var h = $(this).attr('data-attr');
			$(this).attr('src','/images/red_'+h+'.png');
		},function(){
			var h = $(this).attr('data-attr');
			$(this).attr('src','/images/black_'+h+'.png');
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
	
	$('.piclist2 a').hover(function(){
		 
	     $(this).next('.red_height').addClass('yellow'); 
	},function(){
		 $(this).next('.red_height').removeClass('yellow'); 
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
	
	
})

