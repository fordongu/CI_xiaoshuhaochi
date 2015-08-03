
//本js文件主要放置PC端页面js事件－－－



$(function() {
    //main => new-header.php  Begin
   
    
    //控制页面高度与屏幕等高
    setInterval(function() {

        $('.main_order_confirm_content').css({'height': document.documentElement.clientHeight + 'px', 'max-height': '2000px'});
        $('#cover').css({'height': document.documentElement.clientHeight + 'px', 'max-height': '2000px'});
        $('.views_main_content').css({'height': document.documentElement.clientHeight + 'px', 'max-height': '2000px'});
        $('.views_main_header').css({'height': document.documentElement.clientHeight + 'px', 'overflow': 'hidden', 'max-height': '2000px'});
         }, 18);

    //筛选分类


    //控制本周和下周切换 本周默认被选中
    $('.views_main_header ul > li:nth-child(3) ol li:nth-child(1)').addClass('active');
    $('.views_main_header ul > li:nth-child(3) ol li:lt(2)').click(function() {
        $(this).siblings().removeClass('active');
        $(this).addClass('active');
    });


    //幻灯片自动播放
    $('.views_main_index_carouse ul').css('width', $('.views_main_index_carouse').width() * $('.views_main_index_carouse ul li').size() + 'px');
    var n = 0;
    var timer = null;

    $('.views_main_index_carouse ol').children('li').eq(0).addClass('active');
    function carousel() {
        timer = setInterval(function() {
            n++;

            if (n == $('.views_main_index_carouse ul li').size()) {
                n = 0;
                $('.views_main_index_carouse ul').eq(0).css({'position': 'relative', 'left': $('.views_main_index_carouse').width() + 'px'});
            }
            $('.views_main_index_carouse ol').children('li').removeClass('active');
            $('.views_main_index_carouse ol').children('li').eq(n).addClass('active');
            $('.views_main_index_carouse ul').animate({left: -1040 * n + 'px'});
        }, 3000);
    }
    ;

    if ($('.views_main_index_carouse ul li')) {
        carousel();
    }



    $('.views_main_index_carouse').on({
        'mouseover': function() {
            clearInterval(timer);
        },
        'mouseout': function() {
            carousel();
        }
    });

    $('.views_main_index_carouse ol li').on({
        'mouseover': function() {
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
            n = $(this).index();
            $('.views_main_index_carouse ul').animate({left: -$('.views_main_index_carouse').width() * n + 'px'}, '3000', 'easing');
        },
        'mouseout': function() {
            n = $(this).index();
        }
    });


    //飞入购物车
    $(".plus_good_main").click(function() {
        var flyElm = $(this).parents('dl').children('dt').clone();
        flyElm.css({
            'z-index': 9999,
            'display': 'block',
            'position': 'absolute',
            'top': $(this).parents('dl').offset().top + 'px',
            'left': $(this).parents('dl').offset().left + 'px',
            'width': $(this).parents('dl').children('dt').width() + 'px',
            'height': $(this).parents('dl').children('dt').height() + 'px',
            'opacity': '0.8'
        })
        $('body').append(flyElm);
        flyElm.animate({
            top: $('.views_main_shopping_cart_tips').offset().top,
            left: $('.views_main_shopping_cart_tips').offset().left,
            width: 10 + 'px',
            height: 10 + 'px',
        });

        setTimeout(function() {
            $(flyElm).remove();
        }, 400);

    });

    //点击弹出详情页

    $('.views_main_wrap dl img').click(function() {
        $('.views_main_detail').fadeIn();
        $('#cover').fadeIn();
    });

    //关闭详情页

    $('.delete').click(function() {
        $('.views_main_detail').fadeOut();
        $('#cover').fadeOut();
        $('.views_main_login_sign_one').fadeOut();
        $('.views_main_login_sign_two').fadeOut();
        $('.views_main_login_sign_three').fadeOut();
        $('.general_notice').remove();
    });


    //购物车

    /*$('#goods_cart').on({
     'mouseover':function(){
     $('.views_main_shopping_cart').show();
     if($('.views_main_shopping_cart').show()){
     $('.views_main_shopping_cart').on({
     'mouseover':function(){
     $(this).show();
     },
     'mouseout':function(){
     $(this).hide();
     }
     });
     }
     },
     'mouseout':function(){
     $('.views_main_shopping_cart').hide();
     }
     });*/

    //登录 注册
  /*
    $('.views_main_header ul > li:nth-child(2) ol li:nth-child(1)').click(function() {
        var value=$("#mobile_check").val();
     
        if(value==1){
           location.href= "http://shop.xiaoshuhaochi.com/member/index";
        }else{
          $('.views_main_login_sign_one').fadeIn();
        $('#cover').fadeIn();
        }
      
    });*/
    $('#sign_now,.sign_now').click(function() {
        $('.views_main_login_sign_two').fadeIn();
        $('.views_main_login_sign_one').fadeOut();
        $('.views_main_login_sign_three').fadeOut();
    });
    $("#fogot_password").click(function(){
      
         $('.views_main_login_sign_one').fadeOut();
         $(".views_main_login_sign_three").fadeIn();
    })
    $('#login_now').click(function() {
        $('.views_main_login_sign_one').fadeIn();
        $('.views_main_login_sign_two').fadeOut();
    });
    $('#fogetpass').click(function() {
        $('.views_main_login_sign_three').fadeIn();
        $('.views_main_login_sign_one').fadeOut();
    });
    //退出登录
   if( !$('.person_name span').html() ){
   // alert($(this).text());
    //$(this).html('222');
   } 
    //main => new-header.php  End
    //注册的方法JS
    $(".userRister").click(function() {
        // var login_flag = $('#login_flag').val();
        //var reg_type = $('#register_type').val();

        var password = $.trim($('.password_reg').val());
        var repassword = $.trim($('.repassword_reg').val());
        var mobile_email = $.trim($('.mobile_email_reg').val());
        var code = $.trim($('.code').val());
        var v = /^(((13[0-9]{1})|(15[0-9]{1})|(14[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/;

        if (!code) {
            $('.code').attr('placeholder', '验证码不能为空');
            return false;
        }
        if (!password) {
            $('.password_reg').attr('placeholder', '密码不能空');
            return false;
        } else {
            //$('#password').removeClass('error_note');
        }
        if (!repassword) {
            $('.repassword_reg').attr('placeholder', '重复密码不能空');
            return false;
        } else {
            // $('#repassword').removeClass('error_note');
        }
        if (password != repassword) {
            //$('.repassword_reg').attr('placeholder','密码不一致');
            alert('密码不一致');
            return false;
        } else {
            $('.repassword_reg').removeClass('error_note');
        }

        if (!mobile_email) {
            $('.mobile_email_reg').attr('placeholder', '手机号码不能空');
            return false;
        } else {
            $('.mobile_email_reg').removeClass('error_note');
        }

        if (!v.test(mobile_email)) {
            alert("请输入正确的手机号");
            //13816064684
            //alert
            //$('#mobile_email').attr('placeholder','请输入正确的手机号').addClass('error_note');
            return false;
        } else {
            //   $('#mobile_email').removeClass('error_note');
        }
        var reg_type = "reg";
        var submitdata = {
            mobile_email: mobile_email,
            password: password,
            code: code,
            reg_type: reg_type
            
        };
        $.post(base_url + "/Main/userRister/", submitdata, function(data) {
                   
            if (data.success=="yes"){
               alert(data.msg); 
               window.location.reload();
       
            }else{
               
                alert(data.msg);
            }
           
        }, "json");
    })
    //用户登录
$("#login_btn").click(function(){

                var v = /^(((13[0-9]{1})|(15[0-9]{1})|(14[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
                
                var remember_flag = $('#remember_password').attr('checked');
            
        if(remember_flag){
          remember_flag = 1;
        }else{
          remember_flag = 0;
        }
                var cell=$("#login_cell").val();
                var password=$("#login_password").val();
                if (!cell){
                    alert("用户名不能为空");
                    return false;
                }
                if (!password){
                    alert("密码不能为空");
                    return false;
                }
                var submitdata ={
            mobile_email:cell,
            password:password,
            remember_flag:remember_flag
          //  login_type:login_type
        }
                $.post(base_url+"/Main/userLogin",submitdata,function(data){
                if(data.success=="yes"){
                    alert(data.msg);
                    window.location.reload();
                }else{
                    alert(data.msg);
                }
                    
                },"json");
})

})


$(".login_out").click(function(){
 
     $.post(base_url+ "/Main/loginOut","",function(data){
        if(data.success=="yes"){
            alert(data.msg);
            window.location.href="/";
        }
    },"json");
})
//密码修改//
$("#changpass").click(function(){
    
        var password = $.trim($('#password').val());
        var repassword = $.trim($('#repassword').val());
        var mobile_email = $.trim($('#mobile_email').val());
        var code = $.trim($('#code').val());
       
        var v = /^(((13[0-9]{1})|(15[0-9]{1})|(14[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
        if(!v.test(mobile_email)){
            alert("手机号码的格式不正确");
        }
    
        if (!code) {
            $('#code').attr('placeholder', '验证码不能为空');
            return false;
        }
        if (!password) {
            $('#password').attr('placeholder', '密码不能空');
            return false;
        } else {
            //$('#password').removeClass('error_note');
        }
        if (!repassword) {
            $('#repassword').attr('placeholder', '重复密码不能空');
            return false;
        } else {
            // $('#repassword').removeClass('error_note');
        }
        if (password != repassword) {
            //$('.repassword_reg').attr('placeholder','密码不一致');
            alert('密码不一致');
            return false;
        } else {
            //$('.repassword_reg').removeClass('error_note');
        }

        if (!mobile_email) {
            alert("手机号码不能空");
            //$('.mobile_email_reg').attr('placeholder', '手机号码不能空');
            return false;
        } else {
           // $('.mobile_email_reg').removeClass('error_note');
        }
    var check = 1;
    var submitData = {
        mobile_email: mobile_email,
        password:password,
        code:code,
        check: check
    };
                $.post(base_url + '/Main/passwordForget/',submitData,function(data){
                    if (data.success=="yes") {
                        alert(data.msg);
                        window.location.reload();
                    }else{
                        alert(data.msg);
                    }
                },"json");
})


function send_code() {
    var mobile_email = $(".mobile_email_reg").val();
    var url = '/Main/dosendSms/';
    var v = /^(((13[0-9]{1})|(15[0-9]{1})|(14[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/;
    var check = 0;
    var submitData = {
        mobile_email: mobile_email,
        check: check
    };

    if (!mobile_email) {
        $(".mobile_email_reg").attr('placeholder', '手机号码不能空');
        return false;
    }

    if (!v.test(mobile_email)) {

        $(".mobile_email_reg").val('请输入正确的手机号');
        return false;
    } else {

        var NowTime2 = new Date();
        var EndTime = NowTime2.getTime() + 60 * 60 * 300;
        $('.hidden_time').val(EndTime);
        GetRTime2();
        $(".send_code").hide();
        $('.send_div').show();

    }
    $(".send_sms").attr('disabled', true);
    $.post(url, submitData, function(data) {

        if (data.success == 'yes') {
            alert(data.msg);
        } else {
             if(data.success=='used'){
                         alert(data.msg);  
                         window.location.reload();
                }else{
                     alert(data.msg);
            $(".send_div").hide();
            $('.send_sms').show();
                }
           
        }
    }, "json");


}
function GetRTime2() {
    var EndTime = $('.hidden_time').val();
    var NowTime = new Date();
    var nMS = EndTime - NowTime.getTime();
    var nS = Math.floor(nMS / 1000) % 60;


  //main => new-header.php  End


    var str = nS + '秒后获取';

    if (nS == 0) {
        $(".send_div").hide();
        $('.send_code').show();
        $(".send_code").attr('disabled', false);

    } else {
        $('.send_div').html(str);
    }
    setTimeout("GetRTime2()", 1000);
}



function send_sms() {
    var mobile_email = $("#mobile_email").val();
    var url = '/Main/dosendSms/';
    var v = /^(((13[0-9]{1})|(15[0-9]{1})|(14[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/;
    var check = 1;//找回密码
    var submitData = {
        mobile_email: mobile_email,
        check: check
    };

    if (!mobile_email) {
        $("#mobile_email").attr('placeholder', '手机号码不能空');
        return false;
    }

    if (!v.test(mobile_email)) {

        $("#mobile_email").val('请输入正确的手机号');
        return false;
    } else {

        var NowTime = new Date();
        var EndTime = NowTime.getTime() + 60 * 60 * 300;
        $('.hidden_time').val(EndTime);
        GetRTime();
        $(".send_sms").hide();
        $('#send_div').show();

    }
    $(".send_sms").attr('disabled', true);
    $.post(url, submitData, function(data) {

        if (data.success == 'yes') {
            alert(data.msg);
        } else {
             if(data.success=='used'){
                         alert(data.msg);  
                         window.location.reload();
                }else{
                     alert(data.msg);
            $("#send_div").hide();
            $('.send_sms').show();
                }
           
        }
    }, "json");


}
function GetRTime() {
    var EndTime = $('.hidden_time').val();
    var NowTime = new Date();
    var nMS = EndTime - NowTime.getTime();
    var nS = Math.floor(nMS / 1000) % 60;


  //main => new-header.php  End


    var str = nS + '秒后获取';

    if (nS == 0) {
        $("#send_div").hide();
        $('.send_sms').show();
        $(".send_sms").attr('disabled', false);

    } else {
        $('#send_div').html(str);
    }
    setTimeout("GetRTime()", 1000);
}
   //保留文本格式
   function outHTML() {
var aValue=document.getElementsByClassName("p");
for (var i = 0 ;i < aValue.length; i++) {
 // aValue[i].value = ((aValue[i].value.replace(/<(.+?)>/gi,"&lt;$1&gt;")).replace(/ /gi,"&nbsp;")).replace(/\n/gi,"<br>");
}

   };
outHTML();

   //
  //main => new-header.php  End

    

