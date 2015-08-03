//显示购物车商品数量
function showCount() {
    $.ajax({
        url:'/cart/getCartCount',
        data: '',
        type: 'get',
        dataType: 'text',
        success: function(data) {
            $(".cart_count").show().html(data);
          
            $('.views_cart_number').html(data);
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
        url: '/cart/getCart',
        data: '',
        type: 'get',
        dataType: 'text',
        success: function(data) {
            var result = eval("(" + data + ")");
            if (result.goods_list.goods_count == 0) {
            
                 window.location.href = "/wechat/index";
                return;
              

            }
            var this_week = '';
            var str0 = '';
            if (result.goods_list.cart_goods[0] != '') {

                this_week = '<thead><tr><td colspan="4">本周：<select class="dinner_dates" data-week="0">';
                var selected_date0 = result.goods_list.cart_goods[0][0].date;
                str0 = '<option value="0">请选择用餐日期</option>';
                for (var i in result.this_dinner_dates) {
                    var selected = '';
                    if (i == selected_date0) {
                        selected = ' selected="selected"';
                    }
                    str0 += '<option value="'+i+'"'+selected+'>'+result.this_dinner_dates[i]+'</option>';
                }
                this_week += str0 + '</selecte></td></tr></thead><tbody>';
            }
          //  if($("#wechat_only").val()&&$("#wechat_only").val()==1){
             //       this_week="";
           //     }
            for (var i in result.goods_list.cart_goods[0]) {
                this_week +='<tr class="normal_tr"><!--td>'+result.goods_list.cart_goods[0][i].date+'</td--><td>'+result.goods_list.cart_goods[0][i].goods_name+'</td><td>￥<span>'+result.goods_list.cart_goods[0][i].price+'</span></td><td><div class="add_goods"><button class="btn minus good_button float_left" onclick="decrCart(\''+result.goods_list.cart_goods[0][i].goods_key+'\',0)">-</button><div class="float_left main_confirm_order_count confirm_order_count good_date">'+result.goods_list.cart_goods[0][i].goods_num+'</div><button class="btn plus good_button high_but float_left" onclick="incrCart(\''+result.goods_list.cart_goods[0][i].goods_key+'\',0)">+</button></div></td><td>'+(result.goods_list.cart_goods[0][i].goods_num * result.goods_list.cart_goods[0][i].price).toFixed(2)+'</td></tr>';
            }
            if (str0 != '') {
                this_week += '</tbody>';
                $('#this_goods_list').html(this_week);
            } else {
                $('#this_goods_list').html('');
            }

            var next_week = '';
            var str1 = '';
            if (result.goods_list.cart_goods[1] != '') {
                next_week = '<thead><tr><td colspan="4">下周：<select class="dinner_dates" data-week="1">';
                var selected_date1 = result.goods_list.cart_goods[1][0].date;
                str1 = '<option value="0">请选择用餐日期</option>';
                for (var i in result.next_dinner_dates) {
                    var selected = '';
                    if (i == selected_date1) {
                        selected = ' selected="selected"';
                    }
                    str1 += '<option value="'+i+'"'+selected+'>'+result.next_dinner_dates[i]+'</option>';
                }
                next_week += str1 + '</selecte></td></tr></thead><tbody>';
            }
            // if($("#wechat_only").val()&&$("#wechat_only").val()==1){
                   // next_week="";
              //  }
            for (var i in result.goods_list.cart_goods[1]) {
               next_week +='<tr class="normal_tr"><!--td>'+result.goods_list.cart_goods[1][i].date+'</td--><td>'+result.goods_list.cart_goods[1][i].goods_name+'</td><td>￥<span>'+result.goods_list.cart_goods[1][i].price+'</span></td><td><div class="add_goods"><button class="btn minus good_button float_left" onclick="decrCart(\''+result.goods_list.cart_goods[1][i].goods_key+'\',1)">-</button><div class="float_left main_confirm_order_count confirm_order_count good_date">'+result.goods_list.cart_goods[1][i].goods_num+'</div><button class="btn plus good_button high_but float_left" onclick="incrCart(\''+result.goods_list.cart_goods[1][i].goods_key+'\',1)">+</button></div></td><td>'+(result.goods_list.cart_goods[1][i].goods_num * result.goods_list.cart_goods[1][i].price).toFixed(2)+'</td></tr>';
            }

            if (str1 != '') {
                next_week += '</tbody>';
                $('#next_goods_list').html(next_week);
            } else {
                $('#next_goods_list').html('');
            }

            //$('#cart_goods_list').html(this_week+next_week);
            $('#cost_price').text(result.goods_list.order_price.toFixed(2));
            $('#preferential_price').text(result.goods_list.total_price.toFixed(2));
            return;
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
        url: '/cart/incrCart',
        data: 'goods_key=' + goods_key + '&goods_num=1&week_flag=' + week_flag,
        type: 'post',
        dataType: 'text',
        success: function(data) {
            showCart();
            showCount();
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
        url: '/cart/decrCart',
        data: 'goods_key=' + goods_key + '&goods_num=1&week_flag=' + week_flag,
        type: 'post',
        dataType: 'text',
        success: function(data) {
            //刷新购物车
            showCart();
            showCount();
        },
        error: function(er) {
            //网络请求超时
            alert("网络请求超时，请重试");
        }
    });
}

//更改用餐日期
function modifyDinnerDate(dinner_date, week_flag)
{
    $.ajax({
        url: '/cart/updateCartDate',
        data: 'date=' + dinner_date + '&week_flag=' + week_flag,
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

$('.dinner_dates').live('change',function(){
    var dinner_date = $(this).val();
    var week_flag = $(this).attr('data-week');
    modifyDinnerDate(dinner_date, week_flag);
});
$(function(){
       $(".wechat_plus_good").click(function(){
                    var goods_id =$(this).parents(".good_detail_img_div ").attr("data_good_id");
                    if(!goods_id){
                        goods_id=$(this).attr("data_good_id");
                    }
                    var date=0;
                    var num=1;
                    var type=0;
                    var week_flag=$("#hidden_weeks").val();
                    if(!goods_id){
                        week_flag=$(this).attr("date_week");
                    }
                    var submitData={
                       goods_id:goods_id,
                       date:date,
                       num:num,
                       type:type,
                       week_flag:week_flag
                    }
                        $.post("/cart/addCart",submitData,function(data){
                             showCount();
                              });
                })
})
