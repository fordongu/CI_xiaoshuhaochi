$(function(){
    
    $(".pay_now_eric").on("click",function(){
        $(this).parents(".main_member_content").find(".change_pay_div").toggle();
       // $(".change_pay_div").toggle();
        var data_pay_way=$(this).attr("data_pay_way");
       $(this).parents(".main_member_content").find("input:radio").each(function(){
        
           if ($(this).attr("data_pay_way")==data_pay_way) {
           
               $(this).attr("checked","checked");
           }
       });
      
    })
     $('.pay_now').on("click",function(){
                 var order_sn = $(this).attr('data_sn');
               
		 //var pay_way = $(this).attr('data_pay_way');    
                 var pay_way=$(this).parent(".change_pay_div").children("input:radio:checked").val();
                 var submitdata={
                  order_sn:order_sn,
                  pay_way:pay_way
                                  }    
            $.post('/main/chang_pay_way',submitdata,function(data){
                    
                if (data) {         
                    
                    if (data.success="yes") {
                        
                        var pay_way=data.msg;           
                        if (pay_way=='alipay') {
                            
				 window.location.href='/main/pay_order/'+order_sn;
			 }else if (pay_way=='wechat') {
                             
				 window.location.href='/main/wechat_qcode_pay/'+order_sn;

			 }
                    }
                }
            },"json");
              
                     
         
     })
    /*
    $("#login_btn").click(function(){

        var login_cell=$("#login_cell").val();
        var login_password=$("#login_password").val();
        var remember_flag = $('#remember_password').attr('checked');
        if(remember_flag){
    			remember_flag = 1;
    		}else{
    			remember_flag = 2;
    		}
                var submitdata ={
    				mobile_email:login_cell,
    				password:login_password,
    				remember_flag:remember_flag
    		}

        $.ajax({
            type: "get",
            async: false,
            url: "http://dev.xiaoshuhaochi.com/main/user_login",
            dataType: "jsonp",
            jsonp: "callback",//传递给请求处理程序或页面的，用以获得jsonp回调函数名的参数名(一般默认为:callback)
            data: submitdata,
            jsonpCallback:"callback_login",//自定义的jsonp回调函数名称，默认为jQuery自动生成的随机函数名，也可以写"?"，jQuery会自动为你处理数据
            success: function(json){
                alert(json.msg);
            },
            error: function(err){
                alert('请求超时，请重试');
            },
            timeout:300000000000
        });
        return;
      })*/
})

