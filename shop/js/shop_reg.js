 //注册

 function GetRTime2(){
	var EndTime=$('.hidden_time').val(); 
	
	var NowTime = new Date();
	var nMS =EndTime - NowTime.getTime(); 
	var nS=Math.floor(nMS/1000) % 60;
	 
    var str =nS+'秒后获取';

    if(nS == 0){
    	$(".send_div").hide();
		$('.send_code_eric').show();	
		$(".send_code").attr('disabled',false); 
	
	}else{
	  $('.send_div').html(str);
	}
	setTimeout("GetRTime2()",1000);
}
  $(document).ready(function(){
	//  $('.tu_birthday').datepicker({ changeMonth: true, 
	//	    changeYear: true});

	  $('.click_input').click(function(){
	      var name = $(this).closest('div').attr('data_val'); 
	      var flag = $(this).prev('.noto').children('input').attr('name');
	       
	      if(flag == undefined){
		      var v = $(this).closest('div').children('.noto').html();
		      if(v.indexOf("href") > 0 )
		      {
		         v = $(this).closest('div').children('.noto').children('a').html();
		      }
		      var uid = $(".user_id").val();
		      var input = "<input type='text' name='"+name+"' data_id='"+uid+"' value='"+v+"' style='' />";
		      $(this).prev('.noto').html(input);
		      $(this).hide();
		      $(this).next('span').show();
		      $('.verify_li').show();
	      }
	   })

	  $(".comfirm").click(function() {
	            //var $input = $(this).prev('span').prev('.noto').children('input');
	            var val = $(".cellphone").val();               
	            var field = "tu_mobile";
	            var uid = $("#user_id").val(); 
	            var mobile_code = $('.sms_code').val();	       
	            if(!mobile_code){
					alert("短信验证码不能为空")
  		    		  return false;
		        } 
				 var mobile_email = $(".cellphone").val(); 	    						 		
  		 		 var v = /^(((13[0-9]{1})|(15[0-9]{1})|(14[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/;
  		 		 var submitData={
  		 				 mobile : mobile_email 
  		 			 };
  		 		  
  		 		if(!mobile_email){
  		    		  $(".cellphone").attr('placeholder','手机号码不能空');
  		    		  return false;
  		    	  } 
  	  		 	
  		    	  if(!v.test(mobile_email)){ 
   		    		 
  		    		 $(".cellphone").val('请输入正确的手机号');
  		  	  		   return false;
  			  	  }
	        //post表单提交、、//密码判断
				var password = $('.password_forgot').val();
				var confirm_password = $('.repassword_forgot').val();
				var reg =/^[\w]{6,20}$/;
				 if(!reg.test($(".password_forgot").val())){ 
   		    		 alert("密码必须是6-20位的数字");
  		    		// $(".pass").attr('placeholder','密码必须是6-20位的数字');
  		  	  		   return false;
  			  	  }
				if(password == ''){
            $('.password_forgot').attr('placeholder','密码不能为空');
            return false;
          }
        if(confirm_password == ''){
            $('.repassword_forgot').attr('placeholder','请输入确认密码');
            return false;
          }
        if(confirm_password !== password){
			alert("密码不一致");
          // $('.surePass').attr('placeholder','密码不一致');
            return false;
          }
			  $.post("/member/ajax_update_user",{val:val,field:field,password:password,uid:uid,mobile_code:mobile_code},function(data) {
	            	
					if(data.success!=='yes')
					{
						alert(data.msg,1);
					}
					
	                if(data.success=='yes'){
						alert("修改成功");
	  					window.location.reload();
	                }
				 
			 },"json")
	            
	        }) 
			 
	        //////////////////////////////////////////////////////
	        $(".tu_birthday_span").click(function() {
	            var val = $(this).prev('input').val();     
	            var field = $(this).prev('input').attr('name');
	            var uid = $(".user_id").val(); 
	        //post表单提交
	            $.post("/member/ajax_update_user",{val:val,field:field,uid:uid},function(data) {
	            	alert_frame(data.msg,1);
	                if(data.success=='yes'){
	  					window.location.reload();
	                }
	            },"json");
	        })      
      $('.save_sex').click(function(){
		   $("input:radio").each(function(){
			    if($(this).attr("checked")){ 
				$(".sex").val($(this).val());
			 }
		   })
			var sex = $(".sex").val();		
		var uid = $(".user_id").val();														
			$.post("/member/ajax_update_user_sex",{sex:sex,uid:uid},function(data) {
            	alert(data.msg,1);
                if(data.success=='yes'){
  					window.location.reload();
                }
            },"json");
      }) 
	        
	        
//修改密码
	  $('.change_password').click(function(){
		  
        var opassword = $('.opassword').val();
        var new_password = $('.new_password').val();
        var confirm_password = $('.confirm_password').val();
        if(opassword == ''){
		
          $('.opassword').attr("placeholder","原始密码不能为空");
          return false;
        }else{
        	$('.opassword').next('span').html('');
        }
        if(new_password == ''){
            $('.new_password').attr("placeholder",'新密码不能为空');
            return false;
          }else{
          	$('.new_password').next('span').html('');
          }
        if(confirm_password == ''){
            $('.confirm_password').attr("placeholder",'请确认密码不能为空');
            return false;
          }else{
          	$('.confirm_password').next('span').html('');
          }
        if(confirm_password != new_password){
			alert("密码不一致");
           // $('.confirm_password').attr("placeholder",'密码不一致');
            return false;
          }else{
          	$('.confirm_password').next('span').html('');
          }
		var submit_data = {
					opassword:opassword,
					new_password:new_password
				};
        $.post("/member/ajax_update_user_password",submit_data,function(data) {
        	alert_frame(data.msg,1);
             if(data.success=='yes'){
				 alert("修改成功");
					window.location.reload();
            }else{
				alert(data.msg);
			}
        },"json");
        
      })


      
      $('.send_sms_eric').click(function(){
		
		 $('.send_div').show(); 
  	    	 var mobile_email = $(".cellphone").val(); 	    	
  	    	 var url = '/main/send_mobile_sms/';		 		
  		 		var v = /^(((13[0-9]{1})|(15[0-9]{1})|(14[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/;
  		 		var check=0;
				var submitData={
  		 				 mobile : mobile_email,
						 check:check	
  		 			 };
  		 		  
  		 		if(!mobile_email){
  		    		  $(".cellphone").attr('placeholder','手机号码不能空');
  		    		  return false;
  		    	  } 
  	  		 	
  		    	  if(!v.test(mobile_email)){ 
   		    		 
  		    		 $(".cellphone").val('请输入正确的手机号');
  		  	  		   return false;
  			  	  }else{
  	  			  
  					  	  	var NowTime2 = new Date();
  				 			var EndTime= NowTime2.getTime()+60*60*300; 
  				 		$('.hidden_time').val(EndTime);	
  			 			 GetRTime2();
  			 			$(".send_sms_eric").hide();
  			 			 $('.send_div').show(); 
  			 			
  			  	  } 
  		 		 $(".send_sms_eric").attr('disabled',true); 
  		 		$.post(url,submitData,function(data){
  		 		 
  					 if(data.success == 'yes'){
  						 
  					 }else{
  						 alert(data.msg);
   						$(".send_div").hide();
  						$('.send_sms_eric').show();
  					 }					
  				},"json");
				
				
				
  		    })
			$(".change_cell").click(function(){
				
					$(".input_cell").show();
					$(this).hide();
				})						
  })
  
   function GetRTime(){
	var EndTime=$('#hidden_time').val(); 
	
	var NowTime = new Date();
	var nMS =EndTime - NowTime.getTime(); 
	var nS=Math.floor(nMS/1000) % 60;
	 
    var str =nS+'秒后获取';

    if(nS == 0){
    	$("#send_div").hide();
		$('.code_eric').show();
		
		$(".code_eric").attr('disabled',false); 
	
	}else{
	  $('#send_div').html(str);
	}
	setTimeout("GetRTime()",1000);
}
  $(document).ready(function(){
	//  $('#tu_birthday').datepicker({ changeMonth: true, 
	//	    changeYear: true});

	  $('.click_input').click(function(){
	      var name = $(this).closest('div').attr('data_val'); 
	      var flag = $(this).prev('.noto').children('input').attr('name');
	       
	      if(flag == undefined){
		      var v = $(this).closest('div').children('.noto').html();
		      if(v.indexOf("href") > 0 )
		      {
		         v = $(this).closest('div').children('.noto').children('a').html();
		      }
		      var uid = $("#user_id").val();
		      var input = "<input type='text' name='"+name+"' data_id='"+uid+"' value='"+v+"' style='' />";
		      $(this).prev('.noto').html(input);
		      $(this).hide();
		      $(this).next('span').show();
		      $('#verify_li').show();
	      }
	   })

	  $("#signupBtn_eric").click(function() {
	            //var $input = $(this).prev('span').prev('.noto').children('input');
	            var val = $("#cellphone").val();               
	            var field = "tu_mobile";
	            var uid = $("#user_id").val(); 
	            var mobile_code = $('#mobile_code').val();	       
	            if(!mobile_code){
					alert("验证码不能为空")
  		    		  return false;
		        } 
				 var mobile_email = $("#cellphone").val(); 	    						 		
  		 		 var v = /^(((13[0-9]{1})|(15[0-9]{1})|(14[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
  		 		 var submitData={
  		 				 mobile : mobile_email 
  		 			 };
  		 		  
  		 		if(!mobile_email){
  		    		  $("#cellphone").attr('placeholder','手机号码不能空');
  		    		  return false;
  		    	  } 
  	  		 	
  		    	  if(!v.test(mobile_email)){ 
   		    		 
  		    		 $("#cellphone").val('请输入正确的手机号');
  		  	  		   return false;
  			  	  }
	        //post表单提交、、//密码判断
				var password = $('#pass').val();
				var confirm_password = $('#surePass').val();
				var reg =/^[\w]{6,20}$/;
				 if(!reg.test($("#pass").val())){ 
   		    		 alert("密码必须是6-20位的数字");
  		    		// $("#pass").attr('placeholder','密码必须是6-20位的数字');
  		  	  		   return false;
  			  	  }
				if(password == ''){
            $('#pass').attr('placeholder','密码不能为空');
            return false;
          }
        if(confirm_password == ''){
            $('#surePass').attr('placeholder','请输入确认密码');
            return false;
          }
        if(confirm_password !== password){
			alert("密码不一致");
          // $('#surePass').attr('placeholder','密码不一致');
            return false;
          }
			  $.post("/member/ajax_update_user_info",{val:val,field:field,password:password,uid:uid,mobile_code:mobile_code},function(data) {
	            	
					if(data.success!=='yes')
					{
						alert(data.msg,1);
					}
					
	                if(data.success=='yes'){
						alert("注册成功");
	  					window.location.reload();
	                }
				 
			 },"json")
	            
	        }) 
			 
	        //////////////////////////////////////////////////////
	        $("#tu_birthday_span").click(function() {
	            var val = $(this).prev('input').val();     
	            var field = $(this).prev('input').attr('name');
	            var uid = $("#user_id").val(); 
	        //post表单提交
	            $.post("/member/ajax_update_user",{val:val,field:field,uid:uid},function(data) {
	            	alert_frame(data.msg,1);
	                if(data.success=='yes'){
	  					window.location.reload();
	                }
	            },"json");
	        })      
      $('.gender').click(function(){
			var sex = $(this).val();		
		var uid = $("#user_id").val();														
			$.post("/member/ajax_update_user",{val:sex,field:'tu_gender',uid:uid},function(data) {
            	alert(data.msg,1);
                if(data.success=='yes'){
  					window.location.reload();
                }
            },"json");
      }) 
	        
	        
//修改密码
	  $('#save_address').click(function(){
        var opassword = $('#opassword').val();
        var new_password = $('#new_password').val();
        var confirm_password = $('#confirm_password').val();
        if(opassword == ''){
          $('#opassword').next('span').html('请输入原密码');
          return false;
        }else{
        	$('#opassword').next('span').html('');
        }
        if(new_password == ''){
            $('#new_password').next('span').html('请输入新密码');
            return false;
          }else{
          	$('#new_password').next('span').html('');
          }
        if(confirm_password == ''){
            $('#confirm_password').next('span').html('请输入确认密码');
            return false;
          }else{
          	$('#confirm_password').next('span').html('');
          }
        if(confirm_password != new_password){
            $('#confirm_password').next('span').html('密码不一致');
            return false;
          }else{
          	$('#confirm_password').next('span').html('');
          }
		var submit_data = {
					opassword:opassword,
					new_password:new_password
				};
        $.post("/member/ajax_update_user_password",submit_data,function(data) {
        	alert_frame(data.msg,1);
             if(data.success=='yes'){
					window.location.reload();
            }
        },"json");
        
      })

	
      
      $('.code_eric').click(function(){
		
  	    	 var mobile_email = $("#cellphone").val(); 	    	
  	    	 var url = '/main/send_mobile_sms/';		 		
  		 		var v = /^(((13[0-9]{1})|(15[0-9]{1})|(14[0-9]{1})||(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
  		 		var check=1;
				var submitData={
  		 				 mobile : mobile_email,
							check:check						 
  		 			 };
  		 		  
  		 		if(!mobile_email){
  		    		  $("#cellphone").attr('placeholder','手机号码不能空');
  		    		  return false;
  		    	  } 
  	  		 	
  		    	  if(!v.test(mobile_email)){ 
   		    		 
  		    		 $("#cellphone").val('请输入正确的手机号');
  		  	  		   return false;
  			  	  }else{
  	  			  
  					  	  	var NowTime2 = new Date();
  				 			var EndTime= NowTime2.getTime()+60*60*300; 
  				 		$('#hidden_time').val(EndTime);	
  			 			 GetRTime();
  			 			$(".code_eric").hide();
  			 			 $('#send_div').show(); 
  			 			
  			  	  } 
  		 		 $(".code_eric").attr('disabled',true); 
  		 		$.post(url,submitData,function(data){
  		 		//alert(data.success);
  					 if(data.success == 'yes'){
  						 
  					 }else{
						
						 if(data.success=="used"){
								alert(data.msg);
								$("#send_div").hide();
								$('.code_eric').show(); 
								$(".code_eric").attr('disabled',false); 
						 }else{
							 alert(data.msg);
   						$("#send_div").hide();
  						$('.code_eric').show(); 
						 }
  						
  					 }					
  				},"json");
				
				
				
  		    })
			$(".change_cell").click(function(){
				
					$(".input_cell").show();
					$(this).hide();
				})

		$(".loginButton").click(function(){
			var username=$.trim($(".cellphone_login").val());
			var password=$(".password_login").val();
			var check=0;	
				
				var submitdata ={
    				mobile_email:username,
    				password:password,
    				check:check
    		}
			$.post('/main/user_login',submitdata,function(data){
   		      alert(data.msg,1);
			 if(data.success == 'yes'){
				   // if(login_flag==1){
						window.location.href="/wechat/index"; 
					// }else{
					//    window.location.reload();
					// }
			 }else{
				
			 }					
		},"json");
		})
  $(".save_cell").click(function() {
	            //var $input = $(this).prev('span').prev('.noto').children('input');
	            var val = $(".cellphone").val(); 
	              
	            var field = "tu_mobile";
	            var uid = $(".user_id").val(); 
		
	            var mobile_code = $('.code').val();
	       
	            if(!mobile_code){
	            	alert('请输入验证码');
	            	return false;
		        } 
	        //post表单提交
			
					$.post("/member/ajax_update_user_info",{field:field,uid:uid,val:val,mobile_code:mobile_code},function(data) {
	            	
				
	                if(data.success=='yes'){
						alert(data.msg);						
	  					window.location.reload();
	                }else{
						alert(data.msg);
					}
	            },"json"); 
				
				 
			
	            
	        }) 
			
						
  })
  
  ///
  