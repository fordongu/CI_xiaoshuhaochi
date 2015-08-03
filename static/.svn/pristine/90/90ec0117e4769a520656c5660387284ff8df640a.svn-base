//购物车
$('#goods_cart').on({
    'mouseover':function(){
        $.ajax({
            url: base_url + '/cart/getCartCount',
            data: '',
            type: 'post',
            dataType: 'text',
            success: function(data) {
                $('.views_cart_number').text(data);
                if(data == 0) {
                    return;
                } else {
                    /*$('#goods_cart').bind('click',function(){
                        window.location.href = old_website + '/main/order_confirm';
                        return;
                    });*/
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
                    showCart();
                }
            },
            error: function(er) {

            }
        });
    },
    'mouseout':function(){
        $('.views_main_shopping_cart').hide();
    }
});

//加入购物车
$(".plus_good_main").click(function(){
    var goods_id = $(this).attr("data_good_id");
    var date = 0;
    var num = 1;
    var type = 0;
    var week_flag = $("#date_for_cart").val();
  
    var submitData = {goods_id:goods_id,date:date,num:num,type:type,week_flag:week_flag}
    $.post(base_url + "/cart/addCart",submitData,function(data){
        showCount();
    });
});


//显示购物车商品数量
function showCount() {
    $.ajax({
        url: base_url + '/cart/getCartCount',
        data: '',
        type: 'post',
        dataType: 'text',
        success: function(data) {
            $('.views_cart_number').text(data);
        },
        error: function(er) {
            //网络请求超时
            alert("网络请求超时，请重试");
        }
    });
}
//展示购物车
function showCart() {
  
    $.ajax({
        url: base_url + '/cart/getCart',
        data: '',
        type: 'post',
        dataType: 'text',
        success: function(data) {
            var result = eval("(" + data + ")");
            if (result.goods_count == 0) {
                $('.views_main_shopping_cart').hide();
            }
            var this_week = '';
            for (var i in result.cart_goods[0]) {
                date0 = result.cart_goods[0][i].date;
                this_week += '<li><span>' + result.cart_goods[0][i].goods_name +'</span>' + '<span onclick="decrCart(\''+result.cart_goods[0][i].goods_key+'\', 0);">-</span><span>' + result.cart_goods[0][i].goods_num + '</span><span onclick="incrCart(\''+result.cart_goods[0][i].goods_key+'\', 0)">+</span>'+'<span>'+(result.cart_goods[0][i].price * 1).toFixed(2)+'</span></li>';
            }
            if (this_week != '') {
                //getDinnerTime(0);
                /*$('#week_select_0 li').trigger('click',function(){
                    $(this).eq(0).html('aa');
                    $(this).eq(0).attr('data-id',0);
                    $(this).eq(0).attr('data-week',date0);
                });*/


                $('#views_main_dinner_time_0').show();
                $('#week_cart_0').show();
            } else {
                $('#views_main_dinner_time_0').hide();
                $('#week_cart_0').hide();
            }
            $('#week_cart_0').html(this_week);

            var next_week = '';
            var date1 = 0;
            for (var k in result.cart_goods[1]) {
                date1 = result.cart_goods[1][k].date;
                next_week += '<li><span>' + result.cart_goods[1][k].goods_name +'</span>' + '<span onclick="decrCart(\''+result.cart_goods[1][k].goods_key+'\', 1);">-</span><span>' + result.cart_goods[1][k].goods_num + '</span><span onclick="incrCart(\''+result.cart_goods[1][k].goods_key+'\', 1)">+</span>'+'<span>'+(result.cart_goods[1][k].price * 1).toFixed(2)+'</span></li>';
            }
            if (next_week != '') {
                //getDinnerTime(1);
                $('#views_main_dinner_time_1').show();
                $('#week_cart_1').show();
            } else {
                $('#views_main_dinner_time_1').hide();
                $('#week_cart_1').hide();
            }
            $('#week_cart_1').html(next_week);

            $('#sub_total').text(result.order_price.toFixed(2));
          
            $('#favorable').text(result.promote.toFixed(2));
            $('#total_price').text(result.total_price.toFixed(2));
            $('.views_cart_number').text(result.goods_count);
            return;
        },
        error: function(er) {
            //网络请求超时
            alert("网络请求超时，请重试");
        }
    });
}

//获取用餐时间列表
function getDinnerTime(week_flag)
{
    $.ajax({
        url: base_url + '/cart/getDinnerTime',
        data: 'week_flag=' + week_flag,
        type: 'post',
        dataType: 'text',
        success: function(data) {
            var result = eval("(" + data + ")");
            var html = '<li data-id="0">请选择日期</li>';
            for (var i in result) {
                html += '<li data-id="'+i+'" data-week="'+week_flag+'">' + result[i] + '</li>';
            }
            $('#week_select_'+ week_flag).html(html);
        },
        error: function(er) {
            //网络请求超时
            alert("网络请求超时，请重试");
        }
    });
}
//更新购物
function updateCartTime(date, week_flag)
{
    $.ajax({
        url: base_url + '/cart/updateCartDate',
        data: 'date=' + date + '&week_flag=' + week_flag,
        type: 'post',
        dataType: 'text',
        success: function(data) {
            //隐藏购物车,购物车数量显示0
            if ( date.status == 0) {
                showCart();
            } else {
                //alert(data.error);
            }
        },
        error: function(er) {
            //网络请求超时
            alert("网络请求超时，请重试");
        }
    });
}

//清空购物车
function clearCart() {
    $.ajax({
        url: base_url + '/cart/clearCart',
        data: '',
        type: 'post',
        dataType: 'text',
        success: function(data) {
            //隐藏购物车,购物车数量显示0
            $('.views_main_shopping_cart').hide();
            $('.views_cart_number').text(0);
        },
        error: function(er) {
            //网络请求超时
            alert("网络请求超时，请重试");
        }
    });
}

//增加商品数量
function incrCart(goods_key, week_flag) {
    $.ajax({
        url: base_url + '/cart/incrCart',
        data: 'goods_key=' + goods_key + '&goods_num=1&week_flag=' + week_flag,
        type: 'post',
        dataType: 'text',
        success: function(data) {
            //刷新购物车
            showCart();
        },
        error: function(er) {
            //网络请求超时
            alert("网络请求超时，请重试");
        }
    });
}

//减少商品数量
function decrCart(goods_key, week_flag) {
    $.ajax({
        url: base_url + '/cart/decrCart',
        data: 'goods_key=' + goods_key + '&goods_num=1&week_flag=' + week_flag,
        type: 'post',
        dataType: 'text',
        success: function(data) {
            //刷新购物车
            showCart();
        },
        error: function(er) {
            //网络请求超时
            alert("网络请求超时，请重试");
        }
    });
}

 //购物车 点选日期
/*$('.views_main_shopping_cart .views_main_dinner_time ul > li:nth-child(1)').on({
  'mouseover':function(){
        $(this).children('ol').removeClass('o-hidden');
    },
   'mouseout':function(){
        $(this).children('ol').addClass('o-hidden');
    }
});

$('.views_main_shopping_cart .views_main_dinner_time ul > li:nth-child(1) ol  li').live('click',function(){
    var data_id = $(this).eq(0).attr('data-id');
    var data_week = $(this).eq(0).attr('data-week');
    $(this).parent().children().eq(0).attr('data-id',data_id);
    $(this).parent().children().eq(0).attr('data-week',data_week);
    $(this).parent().children().eq(0).html($(this).eq(0).html());
    updateCartTime(data_id,data_week);
});*/

showCount();
