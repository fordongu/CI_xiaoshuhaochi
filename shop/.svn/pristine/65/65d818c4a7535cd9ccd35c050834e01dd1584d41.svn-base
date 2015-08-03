var slideTimer = 500;

var fadeTimer = 250;

var galleryReady = false;

var prevWindowSize = [0,0];

var wColCount = 0;

var dColCount = 0;

var fontsLoaded = false;

var cellW = 236;

var animating = false;

var swipeScrollTime = 600;

var swipeFadeTime = 300;

var imageLoadersToComplete = 0;

var imageLoadersComplete = 0;

var doImageLoadingCheck = false;

var timeSinceClick = 0;

jQuery(document).ready(function() {
	init();
});

function init() {
 
	var window_width = jQuery(document).width(); 
	var percent = (1080/window_width)*100+'%'; 
	jQuery('#main_div').width(percent);
	jQuery('.footer,#footer_menus').width(percent);
	
	jQuery('#footer').width(window_width);
	jQuery('#loadingScreen span').text('Loading Images');

    jQuery("img.lazyimg").show().lazyload({ effect : "fadeIn", event : "scrolledTo" });
    jQuery(window).trigger('resize');
 
	setupImageLoading(); 
	 
}
 

function checkImagesHaveLoaded() {
	if(doImageLoadingCheck)
	{
		if(	imageLoadersToComplete == imageLoadersComplete )
		{
			jQuery('#loadingScreen span').text('Images Fully Loaded');
			setTimeout(function() { jQuery('#loadingScreen').fadeOut(fadeTimer*2); }, 1000);
		}
	}
}
 
function setupArticleImagery(selector) {

	jQuery(selector).each(function() {

		var img = jQuery(this).find('img');

		if(img.attr('width') == undefined || img.attr('height') == undefined) {
			if(!img.hasClass('autoDimensionsSet'))
			{
				img.addClass('autoDimensionsSet');
				img.attr('width',img.width()).attr('height',img.height());	
			}
		}
		var wh = getNewWH(img.attr('width'), img.attr('height'), jQuery(this).width(), jQuery(this).height(), false, true);
		img.height(wh[1]).width(wh[0]);
		if(wh[1] > jQuery(this).height()){

			img.css('top', (jQuery(this).height() - wh[1])/2);
			
		}else if(wh[0] > jQuery(this).width()){
		
			img.css('left', (jQuery(this).width() - wh[0])/2);
		}	
	});
}
function setupGallery() {
  
		jQuery('.imageGallery a .overlay').hover(function() {
			var ac = jQuery(this).find('.articleContent');
			ac.stop(true, false);
			var h = 0;
			if(ac.css('display') == 'none'){
				ac.css('display','block');
				h = ac.height();
				ac.css({'overlay':'hidden','display':'block'}).height(0);
			}else{
				var oldH = 	ac.height();
				ac.height('auto');
				h = ac.height();
				ac.height(oldH);
			} 
			/*jQuery(this).find('.articleContent').animate({
				'height':h,
				'paddingTop':'14px'
			}, 500);
*/
		},function() {

			jQuery(this).find('.articleContent').stop(true, false).animate({

				'height':0,

				'paddingTop':0

			}, 500, null, function() {

				jQuery(this).removeAttr('style');	

			});

		});
 

	jQuery('.imageGalleryInner,.videoGalleryInner').width(0);

	

	if(jQuery('.imageGallery .item').length > 0)

		selector = '.imageGallery .item';

	else

		selectr = '.imageGallery img';

	

	jQuery('.imageGallery .item').each(function() {

		var h = parseInt(jQuery(this).find('img,iframe').attr('height'));

		var w = parseInt(jQuery(this).find('img,iframe').attr('width'));

		var ratio = w/h;

		var newW = Math.round(ratio*jQuery(this).find('img,iframe').height());

	

		jQuery('.imageGalleryInner').width(jQuery('.imageGalleryInner').width()+newW);

	});

	

	jQuery('.videoGallery .vid iframe').each(function() {

		jQuery('.videoGalleryInner').width(jQuery('.videoGalleryInner').width()+jQuery(this).width());

	});

	

	if(!jQuery('.imageGallery').parent().parent().hasClass('nope'))

	{

		if(jQuery('#ipadHomeGallery').length == 0)

		{

			jQuery(".imageGallery").mCustomScrollbar({

				scrollButtons:{

					enable:true

				},

				horizontalScroll: true,

				mouseWheel: 'pixels',

				mouseWheelPixels: 300,

				autoDraggerLength: false,

				callbacks : {

					whileScrolling: function() { 
						  
						jQuery(this).find('img').each(function(i) {
							 
							if(jQuery(this).offset().left -200 < jQuery(window).width()){
								jQuery(this).trigger('scrolledTo'); 
								 
							}
							if(jQuery(this).offset().left<700){
								jQuery(this).parents('a').find('.section').removeClass('img_gray');
							}else{
								jQuery(this).parents('a').find('.section').addClass('img_gray');
							}
						});
					}
				}
			});
			
			jQuery('.mCSB_buttonRight').mousedown(function() {
				timeSinceClick = new Date();
			}).mouseup(function() { 
				if(new Date() - timeSinceClick < 250)
				{
					var currentPos = Math.abs(jQuery(this).parents('.scrollable').find('.mCSB_container').offset().left);
					jQuery('#scrollToMe').removeAttr('id');
					var last = false;
					
					jQuery(this).parents('.scrollable').find('.mCSB_container').find('.item').each(function() {
						if(jQuery(this).position().left <= currentPos && jQuery(this).position().left + jQuery(this).width() > currentPos)
						{
							if(jQuery(this).next().length > 0)
								jQuery(this).next().attr('id','scrollToMe');
							else
								last = true;
							return false;
						}
					});
					
					if(last)
						jQuery(this).parents('.scrollable').mCustomScrollbar('scrollTo','last');
					else
						jQuery(this).parents('.scrollable').mCustomScrollbar('scrollTo','#scrollToMe');
				}
				
				return false;
			});
			
			jQuery('.mCSB_buttonLeft').mousedown(function() {
				timeSinceClick = new Date();
			}).mouseup(function() { 
				if(new Date() - timeSinceClick < 250)
				{
					var currentPos = Math.abs(jQuery(this).parents('.scrollable').find('.mCSB_container').offset().left);
					jQuery('#scrollToMe').removeAttr('id');
					
					jQuery(this).parents('.scrollable').find('.mCSB_container').find('.item').each(function() {
						if(jQuery(this).position().left <= currentPos && jQuery(this).position().left + jQuery(this).width() > currentPos)
						{
							jQuery(this).attr('id','scrollToMe');
							return false;
						}
					});

					jQuery(this).parents('.scrollable').mCustomScrollbar('scrollTo','#scrollToMe');
				}
				
				return false;
			});

		} 
	}
}



function setupImageLoading() {

	jQuery('.imageGalleryInner').width(jQuery(window).width()*2);
	imageLoadersToComplete++;
	jQuery('#homeGallery').imagesLoaded({

		callback: function() {

			setupGallery();

			imageLoadersComplete++;
			checkImagesHaveLoaded();
		},

		 progress: function (isBroken, jQueryImages, jQueryProper, jQueryBroken) {

			this.parents('a:first').find('.overlay').show();
        }
	});	

	
	imageLoadersToComplete++;
	jQuery('#weeklyArticles, #dailyArticles, #otherArticles').imagesLoaded(function() {

		setupArticleImagery('.weeklyImage, .dailyImage');

		imageLoadersComplete++;
		
		checkImagesHaveLoaded();
	});

}

