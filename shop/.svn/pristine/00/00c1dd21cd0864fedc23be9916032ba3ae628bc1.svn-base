// JavaScript Document
$(document).ready(function(e) {
	/***不需要自动滚动，去掉即可***/
	time = window.setInterval(function(){
		$('.og_next2').click();	
	},1000000);
	/***不需要自动滚动，去掉即可***/
	linum = $('.mainlist2 li').length;//图片数量
	var union_lens = (532+24);
	w = linum * union_lens;//ul宽度 556*2= 1112
	$('.piclist2').css('width', w + 'px');//ul宽度
	$('.swaplist2').html($('.mainlist2').html());//复制内容
	
	$('.og_next2').click(function(){
		
		if($('.swaplist2,.mainlist2').is(':animated')){
			$('.swaplist2,.mainlist2').stop(true,true);
		}
		
		if($('.mainlist2 li').length>2){//多于4张图片
			ml = parseInt($('.mainlist2').css('left'));//默认图片ul位置
			sl = parseInt($('.swaplist2').css('left'));//交换图片ul位置
			console.log(w+'---'+ml+'-----'+sl);
			if(ml<=0 && ml>w*-1){//默认图片显示时 
				$('.swaplist2').css({left: '1112px'});//交换图片放在显示区域右侧
				$('.mainlist2').animate({left: (ml - 1112) + 'px'},'slow');//默认图片滚动		
				 
				if(w+(ml - 1112) == union_lens){//默认图片最后一屏时
					$('.swaplist2').animate({left: union_lens+'px'},'slow');//交换图片滚动
				}else if(w+(ml - 1112) < union_lens){
					$('.swaplist2').animate({left: (ml - 1112)+w+'px'},'slow');//交换图片滚动
				}
			}else{//交换图片显示时 
				$('.mainlist2').css({left: '1112px'})//默认图片放在显示区域右
				$('.swaplist2').animate({left: (sl - 1112) + 'px'},'slow');//交换图片滚动 
				if(sl>=(w-1112)*-1){//交换图片最后一屏时 
					$('.mainlist2').animate({left: '0px'},'slow');//默认图片滚动
				}
			}
		}
	})
	$('.og_prev2').click(function(){
		
		if($('.swaplist2,.mainlist2').is(':animated')){
			$('.swaplist2,.mainlist2').stop(true,true);
		}
		
		if($('.mainlist2 li').length>3){
			ml = parseInt($('.mainlist2').css('left'));
			sl = parseInt($('.swaplist2').css('left'));
			if(ml<=0 && ml>w*-1){
				$('.swaplist2').css({left: w * -1 + 'px'});
				$('.mainlist2').animate({left: ml + 1112 + 'px'},'slow');				
				if(ml==0){
					$('.swaplist2').animate({left: (w - 1112) * -1 + 'px'},'slow');
				}
			}else{
				$('.mainlist2').css({left: (w - 1112) * -1 + 'px'});
				$('.swaplist2').animate({left: sl + 1112 + 'px'},'slow'); 
				if(sl==0){
					$('.mainlist2').animate({left: '0px'},'slow');
				}
			}
		}
	})    
 
	$('.og_prev2,.og_next2').hover(function(){
		    var h = $(this).attr('data-attr');
			$(this).attr('src','/images/red_'+h+'.png');
		},function(){
			var h = $(this).attr('data-attr');
			$(this).attr('src','/images/black_'+h+'.png');
	})
	 
	
	
	
	/***不需要自动滚动，去掉即可***/
	time = window.setInterval(function(){
		$('.og_next3').click();	
	},1000000);
	/***不需要自动滚动，去掉即可***/
	linums = $('.mainlist3 li').length;//图片数量
	var union_len = 1080;
	ws = linums * union_len;//ul宽度 556*2= 1112
	$('.piclist3').css('width', ws + 'px');//ul宽度
	$('.swaplist3').html($('.mainlist3').html());//复制内容
	
	$('.og_next3').click(function(){
		
		if($('.swaplist3,.mainlist3').is(':animated')){
			$('.swaplist3,.mainlist3').stop(true,true);
		}
		
		if($('.mainlist3 li').length>2){//多于4张图片
			mls = parseInt($('.mainlist3').css('left'));//默认图片ul位置
			sls = parseInt($('.swaplist3').css('left'));//交换图片ul位置
			
			if(mls<=0 && mls>ws*-1){//默认图片显示时 
				$('.swaplist3').css({left: union_len+'px'});//交换图片放在显示区域右侧
				$('.mainlist3').animate({left: (mls - union_len) + 'px'},'slow');//默认图片滚动		
				 
				if(ws+(mls - union_len) == union_len){//默认图片最后一屏时
					$('.swaplist3').animate({left: union_len+'px'},'slow');//交换图片滚动
				}else if(ws+(mls - union_len) < union_len){
					$('.swaplist3').animate({left: (mls - union_len)+ws+'px'},'slow');//交换图片滚动
				}
			}else{//交换图片显示时 
				$('.mainlist3').css({left: union_len+'px'})//默认图片放在显示区域右
				$('.swaplist3').animate({left: (sls - union_len) + 'px'},'slow');//交换图片滚动 
				if(sls>=(ws-union_len)*-1){//交换图片最后一屏时 
					$('.mainlist3').animate({left: '0px'},'slow');//默认图片滚动
				}
			}
		}
	})
	$('.og_prev3').click(function(){
		
		if($('.swaplist3,.mainlist3').is(':animated')){
			$('.swaplist3,.mainlist3').stop(true,true);
		}
		
		if($('.mainlist3 li').length>3){
			mls = parseInt($('.mainlist3').css('left'));
			sls = parseInt($('.swaplist3').css('left'));
			if(mls<=0 && mls>ws*-1){
				$('.swaplist3').css({left: ws * -1 + 'px'});
				$('.mainlist3').animate({left: mls + 2*union_len + 'px'},'slow');				
				if(mls==0){
					$('.swaplist3').animate({left: (ws - 2*union_len) * -1 + 'px'},'slow');
				}
			}else{
				$('.mainlist3').css({left: (ws - 2*union_len) * -1 + 'px'});
				$('.swaplist3').animate({left: sls + 2*union_len + 'px'},'slow'); 
				if(sls==0){
					$('.mainlist3').animate({left: '0px'},'slow');
				}
			}
		}
	})    
 
	$('.og_prev3,.og_next3').hover(function(){
		    var h = $(this).attr('data-attr');
			$(this).attr('src','/images/red_'+h+'.png');
		},function(){
			var h = $(this).attr('data-attr');
			$(this).attr('src','/images/black_'+h+'.png');
	})
	 
	
	
	time = window.setInterval(function(){
		$('.og_next4').click();	
	},1000000);
	/***不需要自动滚动，去掉即可***/
	linum = $('.mainlist4 li').length;//图片数量
	var union_lens = (532+24);
	w = linum * union_lens;//ul宽度 556*2= 1112
	$('.piclist4').css('width', w + 'px');//ul宽度
	$('.swaplist4').html($('.mainlist4').html());//复制内容
	
	$('.og_next4').click(function(){
		
		if($('.swaplist4,.mainlist4').is(':animated')){
			$('.swaplist4,.mainlist4').stop(true,true);
		}
		
		if($('.mainlist4 li').length>2){//多于4张图片
			ml = parseInt($('.mainlist4').css('left'));//默认图片ul位置
			sl = parseInt($('.swaplist4').css('left'));//交换图片ul位置
			console.log(w+'---'+ml+'-----'+sl);
			if(ml<=0 && ml>w*-1){//默认图片显示时 
				$('.swaplist4').css({left: '1112px'});//交换图片放在显示区域右侧
				$('.mainlist4').animate({left: (ml - 1112) + 'px'},'slow');//默认图片滚动		
				 
				if(w+(ml - 1112) == union_lens){//默认图片最后一屏时
					$('.swaplist4').animate({left: union_lens+'px'},'slow');//交换图片滚动
				}else if(w+(ml - 1112) < union_lens){
					$('.swaplist4').animate({left: (ml - 1112)+w+'px'},'slow');//交换图片滚动
				}
			}else{//交换图片显示时 
				$('.mainlist4').css({left: '1112px'})//默认图片放在显示区域右
				$('.swaplist4').animate({left: (sl - 1112) + 'px'},'slow');//交换图片滚动 
				if(sl>=(w-1112)*-1){//交换图片最后一屏时 
					$('.mainlist4').animate({left: '0px'},'slow');//默认图片滚动
				}
			}
		}
	})
	$('.og_prev4').click(function(){
		
		if($('.swaplist4,.mainlist4').is(':animated')){
			$('.swaplist4,.mainlist4').stop(true,true);
		}
		
		if($('.mainlist4 li').length>3){
			ml = parseInt($('.mainlist4').css('left'));
			sl = parseInt($('.swaplist4').css('left'));
			if(ml<=0 && ml>w*-1){
				$('.swaplist4').css({left: w * -1 + 'px'});
				$('.mainlist4').animate({left: ml + 1112 + 'px'},'slow');				
				if(ml==0){
					$('.swaplist4').animate({left: (w - 1112) * -1 + 'px'},'slow');
				}
			}else{
				$('.mainlist4').css({left: (w - 1112) * -1 + 'px'});
				$('.swaplist4').animate({left: sl + 1112 + 'px'},'slow'); 
				if(sl==0){
					$('.mainlist4').animate({left: '0px'},'slow');
				}
			}
		}
	})    
 
	$('.og_prev4,.og_next4').hover(function(){
		    var h = $(this).attr('data-attr');
			$(this).attr('src','/images/red_'+h+'.png');
		},function(){
			var h = $(this).attr('data-attr');
			$(this).attr('src','/images/black_'+h+'.png');
	})
	 
	
})

