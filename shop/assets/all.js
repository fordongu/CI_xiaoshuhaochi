
$(document).ready(function () {

	$("#btn-popup-accpepts").click(function(){
		$("#black-popup, #popup").fadeOut(300);
		
		$.post('/events/authed','',function(data){
			if(data.success=="yes")
			{ 
				
			}
			},"json");
			
	});
	var priceMin = parseInt($("#price_min").val());
	var priceLowest = parseInt($("#price_lowest").val());
	var priceMax = parseInt($("#price_max").val());
	var priceLower = parseInt($("#price_lower").val());
	var gainCount = parseInt($("#gain_count").val());
	var ticketCount = parseInt($("#ticket_count").val());
	var priceBid = parseInt($("#price_gain").val());
	var priceRetail = parseInt($("#price_end").val());
	var priceStart = parseInt($("#price_start").val());
	var priceReal = parseFloat($("#real_price").val());
	var priceGainReal = parseFloat($("#gain_real_price").val());
	var gainstartflag = $("#gain_start_flag").val();
	var maxRating = parseFloat($("#max_rating").val());
	var middleRating = parseFloat($("#middle_rating").val());
	var minRating = parseFloat($("#min_rating").val());
	var winflag = $("#win_flag").val();
	var bidProbPreset = new Array(minRating, middleRating, maxRating);
	var windowHeight = window.screen.availHeight;
	var bak_price = priceReal;
	
	if(!gainstartflag){
	  	priceReal = 2*priceReal;
	  	priceBid = priceLowest = 0;
	}
	
	if(!priceMax){
		priceMax = priceRetail;
	}

	init();
	function init() {
	    $("#bid-quantity-selector").on("touchstart",function(){
	       var $this = $(this);
	       $this.on("touchend",function(){
		       	$this.focus();
		       	$this.unbind("touchend"); 
	       })
	    });
	
	
		var start = priceLowest;
		if (priceBid != 0){
			start = priceBid;
		}
		
		 
//初始化
		$("html").css("font-size", Math.min(document.body.clientWidth, document.body.clientHeight)/32 + "px");
		jQuery.fx.interval = 16;
		$(function() {
		    FastClick.attach(document.body);
		});
		if(gainstartflag){
		   $("#auction-price-sliderbar-forbidden").css("right",(1 - (start-priceLowest)/(priceRetail-priceLowest))*100 + "%");
		}else{
			$("#auction-price-sliderbar-forbidden").css("right",100 + "%");
		}
		auctionPanelGesture();

		$("#event-poster").load(function () {
			var posterSrc = $("#event-poster").attr("src");
			$("#event-poster-blur").css({
				"background-image": "url(" + posterSrc + ")",
				"height": $(this).height() + "px",
			});
		})
		var priceMin = priceMin?priceMin:priceLowest;
		 
		$(".bid-start-price").html(priceMin);
		
		$("#retail-price").html(bak_price);
//用于计算票面价位置		
	
		var retailPriceWrapperPositionPercentage = (priceReal - priceLowest)/(priceRetail - priceLowest);
		if(retailPriceWrapperPositionPercentage<0) retailPriceWrapperPositionPercentage=0;
		
		if(gainstartflag){ 
			$("#retail-price-wrapper").css("left", retailPriceWrapperPositionPercentage * 100 + "%" );
			if ( (1 - retailPriceWrapperPositionPercentage) * $("#auction-price-sliderbar").width() < $("#retail-price-wrapper").width()/2){
				$("#retail-price-container").css("left", (1 - retailPriceWrapperPositionPercentage) * $("#auction-price-sliderbar").width() - $("#retail-price-wrapper").width()/2 + "px");
			}
		}else{
			$("#retail-price-container").css("left", $("#auction-price-sliderbar").width()*0.5 + "px");
		}
		
		if(gainstartflag){ 
//禁止起拍价和票面价重叠
			//alert($("#retail-price-container").offset().left+'-----'+$("#bid-start-price-container").offset().left+'----'+$("#bid-start-price-container").width());
			if ($("#retail-price-container").offset().left < $("#bid-start-price-container").offset().left + $("#bid-start-price-container").width() - 10) {
				$("#bid-start-price-container").css("display", "none")
			}
	    }
		 
		if(!gainstartflag){
		   sliderUpdate((start - priceLowest)/(priceReal), false, 1);
		}else{
		   sliderUpdate((start - priceLowest)/(priceRetail-priceLowest), false, 1);
		}
	}
	
	$(window).resize(function () {
	    windowHeight = $(window).height();
		bidStatePositionUpdate();
	   }
	)
	
	
	function auctionPanelGesture() {
		var swipeStartY, swipeMoveY, swipeDeltaY;
		
		document.ontouchstart = function (e) {
			 
			swipeStartY = e.touches[0].clientY;
			//alert(swipeStartY+'--'+(windowHeight));
			if (swipeStartY > (windowHeight  - 150)) {						 
				e.preventDefault();
			}
		}
		document.ontouchmove = function(e){
			if (auctionPanelOpen) {
				e.preventDefault();
				return;
			};
			
			if (e.touches[0].clientY > (windowHeight - 150)) {
				e.preventDefault();
				swipeMoveY = e.touches[0].clientY;
				swipeDeltaY = swipeMoveY - swipeStartY;
				if (swipeDeltaY < 0) {
					$(".auction-panel").trigger("swipeup")
				}
			}
		};
	}


	
	
	var auctionPanelOpen = false;
	var auctionPanelHeight = parseInt($(".auction-panel").height())-0;
	$(".auction-panel").on("click swipeup",function () {
		if (auctionPanelOpen) {
			return;
		}
		var $this = $(this);
		auctionPanelOpen = true;
		$this.animate({"top" : -auctionPanelHeight+ "px"},500, "easeOutBack",function () {
			$(".black-auction-panel").on("touchstart click", function () {
				$this.animate({"top" : "0"},500,"easeOutBack",function () {
					auctionPanelOpen = false;
				})
				$("#auction-panel-arrow").fadeIn(300);
				$(".black-auction-panel").fadeOut(300);
				$("html, body").css("overflow", "auto");
				$(".black-auction-panel").unbind("touchstart click");
			})
		});
		
		$("#auction-panel-arrow").fadeOut(300);
		$(".black-auction-panel").fadeIn(300);
		
		$("html, body").css("overflow", "hidden");
	});
	
	
	var mouseMoveStartPosition;
	var sliderMoveStartLeft;

    if(priceBid !=0 ){
    	var p = priceBid - priceLowest;
    }else{
    	var p = priceLowest;
    } 
	var sliderLeftEnd = p/(priceRetail - priceLowest) * $("#auction-price-slider-container").width();
	 
	$("#auction-price-slider, #auction-bid-state").on("touchstart mousedown", function (e) {
		if (!e.originalEvent.touches) {
			e.touches = [{
				pageX: e.pageX,
				pageY: e.pageY
			}]
		}else {
			e.touches = e.originalEvent.touches;
		}
		var sliderRightEnd = $("#auction-price-slider-container").width();
		mouseMoveStartPosition = e.touches[0].pageX;
		
		sliderMoveStartLeft = parseInt($("#auction-price-slider").css("left"));
		$(".auction-panel").on("touchmove mousemove", function (e) {
			if (!e.originalEvent.touches) {
				e.touches = [{
					pageX: e.pageX,
					pageY: e.pageY
				}]
			}else {
				e.touches = e.originalEvent.touches;
			}
			
			var sliderMoveDistant =  e.touches[0].pageX- mouseMoveStartPosition;
			var sliderLeft = sliderMoveStartLeft + sliderMoveDistant;
			
			if (sliderLeft < sliderLeftEnd) {
				sliderLeft = sliderLeftEnd;
			}else if (sliderLeft > sliderRightEnd) {
				sliderLeft = sliderRightEnd;
			}
			
			
			
			var sliderPercentage = sliderLeft/($("#auction-price-sliderbar").width());
			$("#auction-price-slider").trigger("sliderActive", sliderPercentage);
			
		})
		$(".auction-panel").on("touchend mouseup", function () {
			$(".auction-panel").unbind("touchmove mousemove");
		})
	})
	 
  if((gainstartflag||(!gainstartflag&&priceGainReal==0))&&(!winflag)){	
	$("#auction-price-slider").on("sliderActive", function (e,sliderPercentage) {
		 
		sliderUpdate(sliderPercentage,false,5);
	})
  }	
	//false is input slider percentage; true is input a price;
	function sliderUpdate(inputNumber, isPrice, gap) {
		if(inputNumber<0) inputNumber=0;
		if (!isPrice) {
			 
			sliderPercentage = inputNumber;
			if (gainstartflag){
				priceBid = Math.round(sliderPercentage * (priceRetail-priceLowest) + priceLowest);
				
				if (gap) {
				 
					priceBid = Math.round(priceBid / gap) * gap;
				}
			}else{
				priceBid = Math.round(sliderPercentage * priceReal);
			}
		}else { 
			priceBid = inputNumber;
			sliderPercentage = (priceBid - priceLowest)/(priceRetail-priceLowest);
			//sliderPercentage = priceBid /priceRetail;
		}
        
		$("#auction-price-slider").css("left", sliderPercentage*100 + "%");
		 
		var b = priceBid?priceBid:priceLowest;
		
		$("#auction-bid-price-number").html(b);
		$("#gain_price_hidden").val(b);
		$("#popup-bid-inf-price").html(b);
		bidStatePositionUpdate();
		bidProbUpdate();
	}
	
	function bidStatePositionUpdate() {
		var auctionPriceSliderbarWidth = $("#auction-price-sliderbar").width();
		var auctionPriceSliderDotWidth = $("#auction-price-slider-dot").width();
		var auctionBidState            = $("#auction-bid-state").width();
		var bidStatePosition = auctionPriceSliderbarWidth * sliderPercentage - auctionBidState/2;
		if (bidStatePosition < -auctionPriceSliderDotWidth/2) {
			bidStatePosition = -auctionPriceSliderDotWidth/2;
		}else if (bidStatePosition > auctionPriceSliderbarWidth - auctionBidState + auctionPriceSliderDotWidth/2 ) {
			bidStatePosition = auctionPriceSliderbarWidth - auctionBidState + auctionPriceSliderDotWidth/2;
		}
		$("#auction-bid-state").css("left", bidStatePosition + "px");
	}
	



	function bidProbUpdate() {
		var bidProb = '';
		
		var priceLowest = priceStart;
//console.log(priceGainReal+'--'+priceBid+'--'+priceLowest);
		if ((priceGainReal == 0) && (priceBid <= priceMin)) {

 			bidProb = bidProbPreset[0];
 			//console.log('55');
		}else if((gainCount<=ticketCount)&&(priceGainReal != 0)){
			
			bidProb = bidProbPreset[2];
			//console.log('66');
		}else if(priceBid>=priceLower){
			//console.log(priceBid+'---11---'+priceLower);
			bidProb = bidProbPreset[2];
			
		}else if((priceBid >= priceLowest)&&(priceBid<priceLower)){
			//console.log('22');
			bidProb = (priceBid-priceLowest)/(priceLower-priceLowest)*(bidProbPreset[2]-bidProbPreset[1])+bidProbPreset[1];
			
		}else if((priceBid>=priceMin)&&(priceBid<priceLowest)&&(priceMin<priceLowest)){
			//console.log('33');
			bidProb = (priceBid-priceMin)/(priceLowest-priceMin)*(bidProbPreset[1]-bidProbPreset[0])+bidProbPreset[0];
			
		}else if ((priceBid>=priceMin)&&(priceBid<priceLowest)){
			//console.log('44');
			bidProb = (priceBid-priceMin)/(priceLowest-priceMin)*(bidProbPreset[1]-bidProbPreset[0])+bidProbPreset[0];
			 
		}
		
		bidProb = Math.round(bidProb*100);
		if(bidProb<(bidProbPreset[0]*100)){
			bidProb = bidProbPreset[0]*100;
		}
		$("#auction-bid-prob").html(bidProb);
		$("#popup-bid-inf-prob").html(bidProb);
	}
	
	function mapping(t1,f1,f2) {
		a1 = f1[0];
		b1 = f1[1];
		a2 = f2[0];
		b2 = f2[1];
		t2 = (t1 - a1) / (b1 - a1) * (b2 - a2) + a2
		return t2;
	}
	
	$("#btn-accept").click(function () {
		var win_flag = $("#win_flag").val();
		
		if(win_flag){
			var event_id = $("#schedule_id").val();
			var from = $("#from").val();
			var perprice = $("#gain_real_price").val();
			var cou = $("#tgh_ticket_count").val();
			var gain_id = $("#gain_id").val();
			window.location.href= '/service/service_order/'+from+'/'+event_id+'/'+cou+'/'+perprice+'/'+gain_id+'/rss';
		}else if(gainstartflag||(!gainstartflag&&priceGainReal==0)){
	//先判断cookie里是否有手机号
			var url = '/events/check_cookie_mobile';
			$.post(url,'',function(data){
				 if(data.success == 'yes'){
					 $("#black-popup, #popup").fadeIn(300);
				 }else{
					 $("#black-popup, #popup_gain").fadeIn(300);
				 }					
			},"json");	
		}
	})
	
	$("#btn-popup-cancel-check").click(function () {
		$("#popup-textarea-description-gain").html("请填写手机号，我们将会给您发送短信验证码");
		$("#popup-textarea-description-gain").removeClass("color-red"); 
		$("#black-popup, #popup_gain").fadeOut(300);
	})
	
	
	$("#btn-popup-accpept-check").click(function(){
		var mobile = $("#check_mobile_number").val();
		var url = '/events/update_cookie_mobile';
		
		var v = /^(((13[0-9]{1})|(15[0-9]{1})|(14[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
		var submitData={
				 mobile : mobile 
			 };
		 $("#btn-popup-accpept-gain").attr('disabled',true); 
		if(mobile == ''){
			 $("#popup-textarea-description-gain").html("请输入手机号");
			 $("#popup-textarea-description-gain").addClass("color-red");
			 return false;
		 }else if(!v.test(mobile)){
			 $("#popup-textarea-description-gain").html("请输入正确的手机号");
			 $("#popup-textarea-description-gain").addClass("color-red");
			 return false;
		 }else{
			 $("#btn-popup-accpept-gain").attr('disabled',false); 
		 }	
		alert_frame('短信发送中... ...',false);
			$.post(url,submitData,function(data){
				 if(data.success == 'yes'){
					 $('#check_mobile').html(mobile);
					 $('#hidden_check_mobile').val(mobile);
					 $("#textarea-phone-number").val(mobile);
					 $("#black-popup, #popup_gain").fadeOut(300);
					 $("#black-popup, #popup_gain_check").fadeIn(300);
				 }else{
					 $("#popup-textarea-description-gain").html(data.msg);
					 $("#popup-textarea-description-gain").addClass("color-red");
				 }					
			},"json");	
		 
	})
	
	
	$("#btn-popup-accpept-check-gain").click(function(){
		var code = $("#check_mobile_number_check").val();
		var mobile= $("#hidden_check_mobile").val();
		var submitData={
				 mobile : mobile,
				 code   : code
			 }; 
	    var url = "/events/check_mobile_code";
	    alert_frame('验证中... ...',true);
		$.post(url,submitData,function(data){
			 if(data.success == 'yes'){ 
				 $("#textarea-phone-number").val(mobile);
				 $("#black-popup, #popup_gain_check").fadeOut(300);
				 $("#black-popup, #popup").fadeIn(300);
			 }else{
				 $("#popup-textarea-description-gain-check").html(data.msg);
				 $("#popup-textarea-description-gain-check").addClass("color-red");
			 }					
		},"json");	
	})
		
	
	$("#btn-popup-cancel-check-gain").click(function () {
		var url = '/events/update_cookie_mobile';
		var mobile = $("#hidden_check_mobile").val();
		var submitData={
				 mobile : mobile 
			 };
		alert_frame('短信发送中... ...',false);
		$.post(url,submitData,function(data){
			if(data.success == 'yes'){
				 $("#popup-textarea-description-gain-check").html('新的验证码已经发送到您的手机，请查收！');
			 }else{  
				  
				 $("#popup-textarea-description-gain-check").html(data.msg);
				 $("#popup-textarea-description-gain-check").addClass("color-red");
			 }	
			
		},"json")
	})
	
	$("#btn-popup-cancel").click(function () {
		$("#popup-textarea-description").html("请留下您的手机号，方便我们及时通知您取票。");
		$("#popup-textarea-description").removeClass("color-red"); 
		$("#black-popup, #popup").fadeOut(300);
	})
	
	
	$("#btn-popup-accpept").click(function(){
		 var mobile = $("#textarea-phone-number").val();
		 var gain_price = $("#gain_price_hidden").val();
		 var schedule_id = $("#schedule_id").val();
		 var event_id = $("#event_id").val();
		 var from = $("#from").val();
		 var gain_start_flag = $("#gain_start_flag").val();
		 var gain_count = parseInt($("#bid-quantity-selector").val());
		 
		 var v = /^(((13[0-9]{1})|(15[0-9]{1})|(14[0-9]{1})|(18[0-9]{1}))+\d{8})$/;  
		 if(gain_price==0){
			 $("#popup-textarea-description").html("订阅价格必须大于0");
			 $("#popup-textarea-description").addClass("color-red");
			 return false;
		 }
		 if(mobile == ''){
			 $("#popup-textarea-description").html("请输入手机号");
			 $("#popup-textarea-description").addClass("color-red");
			 return false;
		 }else if(!v.test(mobile)){
			 $("#popup-textarea-description").html("请输入正确的手机号");
			 $("#popup-textarea-description").addClass("color-red");
			 return false;
		 }else{
			 $("#btn-popup-accpept").attr('disabled',"true"); 
			 var url = '/events/gain';
			 if(!gain_start_flag){
				 var submitData={
						 mobile : mobile,
						 price: gain_price,
						 schedule_id:schedule_id,
						 event_id : event_id,
						 from :from,
						 count:gain_count,
						 rss:'1'
					 };
			 }else{
				 var submitData={
						 mobile : mobile,
						 price: gain_price,
						 schedule_id:schedule_id,
						 event_id : event_id,
						 from :from,
						 count:gain_count,
						 rss:'0'
					 };
			 }
				 $.post(url,submitData,function(data){
					 
						if(data.success=="no")
						{	$("#btn-popup-accpept").removeAttr('disabled');
						   if(data.invalid){
							   $("#btn-popup-accpept").html('<a href="/wallet/recharge_form">去充值</a>') ;
						   }
							$("#popup-textarea-description").html(data.msg);
							$("#popup-textarea-description").addClass("color-red");
						}else{
							$("#btn-popup-accpept").removeAttr('disabled');
							$("#popup").html(data.msg);
							$("#popup").addClass('color-blue popup-succuss');
							setTimeout('window.location.reload()',1000);
						}						
					},"json");
		 }
		
	})
})

function alert_frame(msg,flag){ 
	$("#alert_controller").find(".loading").removeClass('display-none');
	$("#alert_controller").fadeIn(400);
	$("#error_msg").html(msg);
	if(flag){
	   setTimeout(function() { $("#alert_controller").fadeOut(400); }, 1000);
	}else{
		setTimeout(function() { $("#alert_controller").fadeOut(400); }, 5000);
		//$("#alert_controller").find(".loading").addClass(class_display_none);
	}
}
jQuery.easing.jswing=jQuery.easing.swing;jQuery.extend(jQuery.easing,{def:"easeOutQuad",swing:function(e,f,a,h,g){return jQuery.easing[jQuery.easing.def](e,f,a,h,g)},easeInQuad:function(e,f,a,h,g){return h*(f/=g)*f+a},easeOutQuad:function(e,f,a,h,g){return -h*(f/=g)*(f-2)+a},easeInOutQuad:function(e,f,a,h,g){if((f/=g/2)<1){return h/2*f*f+a}return -h/2*((--f)*(f-2)-1)+a},easeInCubic:function(e,f,a,h,g){return h*(f/=g)*f*f+a},easeOutCubic:function(e,f,a,h,g){return h*((f=f/g-1)*f*f+1)+a},easeInOutCubic:function(e,f,a,h,g){if((f/=g/2)<1){return h/2*f*f*f+a}return h/2*((f-=2)*f*f+2)+a},easeInQuart:function(e,f,a,h,g){return h*(f/=g)*f*f*f+a},easeOutQuart:function(e,f,a,h,g){return -h*((f=f/g-1)*f*f*f-1)+a},easeInOutQuart:function(e,f,a,h,g){if((f/=g/2)<1){return h/2*f*f*f*f+a}return -h/2*((f-=2)*f*f*f-2)+a},easeInQuint:function(e,f,a,h,g){return h*(f/=g)*f*f*f*f+a},easeOutQuint:function(e,f,a,h,g){return h*((f=f/g-1)*f*f*f*f+1)+a},easeInOutQuint:function(e,f,a,h,g){if((f/=g/2)<1){return h/2*f*f*f*f*f+a}return h/2*((f-=2)*f*f*f*f+2)+a},easeInSine:function(e,f,a,h,g){return -h*Math.cos(f/g*(Math.PI/2))+h+a},easeOutSine:function(e,f,a,h,g){return h*Math.sin(f/g*(Math.PI/2))+a},easeInOutSine:function(e,f,a,h,g){return -h/2*(Math.cos(Math.PI*f/g)-1)+a},easeInExpo:function(e,f,a,h,g){return(f==0)?a:h*Math.pow(2,10*(f/g-1))+a},easeOutExpo:function(e,f,a,h,g){return(f==g)?a+h:h*(-Math.pow(2,-10*f/g)+1)+a},easeInOutExpo:function(e,f,a,h,g){if(f==0){return a}if(f==g){return a+h}if((f/=g/2)<1){return h/2*Math.pow(2,10*(f-1))+a}return h/2*(-Math.pow(2,-10*--f)+2)+a},easeInCirc:function(e,f,a,h,g){return -h*(Math.sqrt(1-(f/=g)*f)-1)+a},easeOutCirc:function(e,f,a,h,g){return h*Math.sqrt(1-(f=f/g-1)*f)+a},easeInOutCirc:function(e,f,a,h,g){if((f/=g/2)<1){return -h/2*(Math.sqrt(1-f*f)-1)+a}return h/2*(Math.sqrt(1-(f-=2)*f)+1)+a},easeInElastic:function(f,h,e,l,k){var i=1.70158;var j=0;var g=l;if(h==0){return e}if((h/=k)==1){return e+l}if(!j){j=k*0.3}if(g<Math.abs(l)){g=l;var i=j/4}else{var i=j/(2*Math.PI)*Math.asin(l/g)}return -(g*Math.pow(2,10*(h-=1))*Math.sin((h*k-i)*(2*Math.PI)/j))+e},easeOutElastic:function(f,h,e,l,k){var i=1.70158;var j=0;var g=l;if(h==0){return e}if((h/=k)==1){return e+l}if(!j){j=k*0.3}if(g<Math.abs(l)){g=l;var i=j/4}else{var i=j/(2*Math.PI)*Math.asin(l/g)}return g*Math.pow(2,-10*h)*Math.sin((h*k-i)*(2*Math.PI)/j)+l+e},easeInOutElastic:function(f,h,e,l,k){var i=1.70158;var j=0;var g=l;if(h==0){return e}if((h/=k/2)==2){return e+l}if(!j){j=k*(0.3*1.5)}if(g<Math.abs(l)){g=l;var i=j/4}else{var i=j/(2*Math.PI)*Math.asin(l/g)}if(h<1){return -0.5*(g*Math.pow(2,10*(h-=1))*Math.sin((h*k-i)*(2*Math.PI)/j))+e}return g*Math.pow(2,-10*(h-=1))*Math.sin((h*k-i)*(2*Math.PI)/j)*0.5+l+e},easeInBack:function(e,f,a,i,h,g){if(g==undefined){g=1.70158}return i*(f/=h)*f*((g+1)*f-g)+a},easeOutBack:function(e,f,a,i,h,g){if(g==undefined){g=1.70158}return i*((f=f/h-1)*f*((g+1)*f+g)+1)+a},easeInOutBack:function(e,f,a,i,h,g){if(g==undefined){g=1.70158}if((f/=h/2)<1){return i/2*(f*f*(((g*=(1.525))+1)*f-g))+a}return i/2*((f-=2)*f*(((g*=(1.525))+1)*f+g)+2)+a},easeInBounce:function(e,f,a,h,g){return h-jQuery.easing.easeOutBounce(e,g-f,0,h,g)+a},easeOutBounce:function(e,f,a,h,g){if((f/=g)<(1/2.75)){return h*(7.5625*f*f)+a}else{if(f<(2/2.75)){return h*(7.5625*(f-=(1.5/2.75))*f+0.75)+a}else{if(f<(2.5/2.75)){return h*(7.5625*(f-=(2.25/2.75))*f+0.9375)+a}else{return h*(7.5625*(f-=(2.625/2.75))*f+0.984375)+a}}}},easeInOutBounce:function(e,f,a,h,g){if(f<g/2){return jQuery.easing.easeInBounce(e,f*2,0,h,g)*0.5+a}return jQuery.easing.easeOutBounce(e,f*2-g,0,h,g)*0.5+h*0.5+a}});