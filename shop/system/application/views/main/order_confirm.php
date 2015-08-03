<?php $this->load->view('main/new_header'); ?>
<script type="text/javascript" src="/js/shipping_address.js"></script>
<input type="hidden" id="per_count_limit" value="<?php echo $per_count_limit; ?>" />
<input type="hidden" id="tsa_id_default" value="<?php echo $tsa_id;?>">
<input type="hidden" id="total_count_limit" value="<?php echo $total_count_limit; ?>" />
<script>
    var invalid_flag = parseInt('<?php echo $invalid_flag; ?>');

    $(document).ready(function() {
        $("#this_week,#next_week").click(function(){
            location.href='http://www.xiaoshuhaochi.com';
        })
        //设置默认地址
        $('.address_delete').click(function() {
            if (confirm('确认删除此快递地址吗？')) {
                var id = $(this).parents('.shipping_address_li').attr('data_id');
                var $this = $(this);
                var submitdata = {address_id: id};
                $.post('/member/delete_default_address', submitdata, function(data) {
                    if (data.success == 'yes') {
                        $this.parents('.shipping_address_li').remove();
                    } else {
                        alert(data.msg);
                    }
                }, "json");
            }
        })
		/*
			$(".iiiii").click(function(){
			$(".iiiii_active").attr("class","iiiii");
			$(this).attr("class","iiiii_active")
		//$(".iiiii_active").attr("class","iiiii");
				//$(this).attr("class","iiiii_active");

		})



					*/
        //设置默认地址
        $('.iiiii').click(function() {
			$(".iiiii_active").attr("class","iiiii");
            var normal_url = '/images/li_normal.png';
            var select_url = '/images/li_selected.png';
            var id = $(this).parent().attr('data_id');
			var isthis=$(this);
           // var $this = $(this);
            var submitdata = {address_id: id};
            $.post('/member/change_default_address', submitdata, function(data) {
                if (data.success == 'yes') {

					$(isthis).attr("class","iiiii_active");

                    $('.shipping_address_li>img').attr('src', normal_url);
                    $('.shipping_address_li').removeClass('current');
                    $(this).parent().attr('src', select_url);
                    $(this).parent().parents('li').addClass('current');
                } else {
                    alert(data.msg);
                }
            }, "json");

        })

//切换支付方式
        $('.payment_config>img').click(function() {
            var normal_url = '/images/li_normal.png';
            var select_url = '/images/li_selected.png';
            $('.payment_config>img').attr('src', normal_url);
            var va = $(this).attr('data_id');
            $('#hidden_pay_config').val(va);
            $(this).attr('src', select_url);
        })

        $('#save_order').click(function() {
            var comment_input = $('#comment_input').val();
            var payway = $('#hidden_pay_config').val();
            var coupons_id = $('#coupons_id_used').val();

            var this_week_cart_str = getCookie('this_week_cart');
            var this_week_cart = eval("("+this_week_cart_str+")");
            for (var i in this_week_cart){
                var goods_key = i.split('_');
                var date = goods_key[1];
                if (date == 0) {
                    alert("请选择本周用餐日期");
                    return;
                }
            }

            var next_week_cart_str = getCookie('next_week_cart');
            var next_week_cart = eval("("+next_week_cart_str+")");
            for (var i in next_week_cart){
                var goods_key = i.split('_');
                var date = goods_key[1];
                if (date == 0) {
                    alert("请选择下周用餐日期");
                    return;
                }
            }
            var submitdata = {
                comment_input: comment_input,
                payway: payway,
                coupons_id: coupons_id
            };

            if (invalid_flag == 1) {
                alert_frame('请选择正确的配送区域', 1);
                return false;
            }
            $.post('/main/save_order', submitdata, function(data) {
                if (data.success == 'yes') {
                    if (data.price == 0) {
                        window.location.href = "/member/order_list";
                    } else {
                        if (data.pay_config == 'alipay') {
                            window.location.href = "/main/pay_order/" + data.order_sn;
                        } else if (data.pay_config == 'daofu') {
                            window.location.href = "/member/order_list";
                        } else {
                            window.location.href = '/main/wechat_qcode_pay/' + data.order_sn;
                        }
                    }
                } else {
                    alert(data.msg);
                }
            }, "json");
        })

        $('.coupon_div').click(function() {

            $("#coupons").animate({
                height: 'toggle'
            }, 0);
        })

        $('#coupons li').click(function() {
            var normal_url = '/images/li_normal.png';
            var select_url = '/images/li_selected.png';
            $('#coupons img').attr('src', normal_url);
            $(this).children('img').attr('src', select_url);
            var data_id = $(this).attr('data_id');
            var real_total_price = parseFloat($('#real_total_amount').val());
            var price = 0;
            if (data_id != 0) {
                price = parseInt($(this).children('span').html());

            }

            var left_price = parseFloat(real_total_price - price);
            if (left_price < 0) {
                left_price = 0;
            }

           // left_price += ".00";
            $('.coupons_price').html(price + '.00');
            $('.order_total').html(left_price.toFixed(2));

            $('#coupons_id_used').val(data_id);
        })


        $('.add_addresss').click(function() {
            $('.new_address_edit').toggle();
        })

        $('.address_edit').click(function() {
            var display_flag = $('.new_address_edit').css('display');
            $('.new_address_edit').toggle();
            if (display_flag == 'none') {
                var tsa_id = $(this).parents('li').attr('data_id');
                var submitdata = {tsa_id: tsa_id};

                $.post('/main/ajax_get_shipping_address', submitdata, function(data) {
                    if (data.success == 'yes') {
                        msg = data.msg;
                        $('#nickname').val(msg.tsa_nickname);
                        $('#mobile').val(msg.tsa_mobile);
                        var addres = msg.province + '&nbsp;&nbsp;&nbsp;&nbsp;' + msg.city + '&nbsp;&nbsp;&nbsp;&nbsp;' + msg.area + '&nbsp;&nbsp;&nbsp;&nbsp;' + msg.tsa_address + '&nbsp;&nbsp;&nbsp;&nbsp;' + msg.building_name;
                        $('#new_address_span').html(addres);
                        $('#province_id').val(msg.tsa_province);
                        $('#city_id').val(msg.tsa_city);
                        $('#area_id').val(msg.tsa_district);
                        $('#tsa_building_id').val(msg.tsa_building_id);
                        $('#company').val(msg.tsa_company);
                        $('#hidden_id').val(tsa_id);
                        $('#address').val(tsa_address);
                    } else {
                        alert(data.msg);
                    }
                }, "json");
            }
        })

        $('.cookie_val').change(function() {
            var val = $(this).val();
            var name = $(this).attr('name');
            var submitdata = {name: name, val: val};

            $.post('/main/cookie_shipping_val', submitdata, function(data) {
                if (data.success == 'yes') {

                } else {
                    alert(data.msg);
                }
            }, "json");
        })
		$(".iiiii").each(function(){
			if($(this).parents(".shipping_address_li").attr("data_id")==$("#tsa_id_default").val()){
				$(this).attr("class","iiiii_active");
			}
		})


            onsell(3);

   var promote= parseFloat($(".general").html()-$(".onsell").html());
       $(".order_total").html((parseFloat($(".order_total").html())-promote).toFixed(2))

    });

//读取cookie
function getCookie(name)
{
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");

    if(arr=document.cookie.match(reg))

        return unescape(arr[2]);
    else
        return null;
}
</script>
<div class="order_search_div">

    <input value="<?php echo $total_count; ?>" id="real_total_amount" type="hidden" />
    <input value="0" id="coupons_id_used" type="hidden" />
    <input type="hidden"  id="hidden_pay_config" value="<?php echo $payment[0]->name; ?>" />
    <!--<div class="container_width order_search_content">
       <img src="/images/logo.png" class="logo_img float_left cursor_pointer"  onclick="location.href='/main/index'"/>
       <div class="order_confirm_title float_left">填写并核对配送信息</div>
    </div>-->
</div>
<div class="main_order_confirm_content">
 <div class="main_order_confirm_content_wrapper">
 <!-- order_list -->
    <div class="views_order_confirm_new container_width_left_new">
    <div class="shipping_config order_configs">
        <ul class="main_order_confirm_title">
        	<li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
    	</ul>
    </div>
   <table class="order_list_table_new" id="this_goods_list">
   <?php
if ($cart_goods[0]) {
?>
       <thead>
            <tr>
            <td colspan="4">本周：
            
               <select data-week="0" class="dinner_dates">
                    <option value="0">请选择用餐日期</option>
                    <?php
                    foreach($this_week_list as $k => $day){
                        $selected = '';
                        if ($k == $cart_goods[0][0]['date']) {
                            $selected = ' selected="selected"';
                        }
                        echo '<option value="'.$k.'"'.$selected.'>'.$day.'</option>';
                    }?>
                </select>
            </td>
          <!--  <td>原价(元)</td>
            <!--<td>优惠</td>
            <td>份数</td><td>小计(元)</td>  -->
            </tr>
        </thead>
        <tbody>



<?php
    foreach ($cart_goods[0] as $k => $goods) {
?>
    <tr class="normal_tr">
 <!--       <td><?php echo $goods['date']; ?></td> -->
        <td><?php echo $goods['goods_name'];?></td>
        <td>￥<span><?php echo $goods['price'];?></span></td>
        <!--<td class="youhui"><?php echo $v->event_name; ?></td>-->
        <td>
            <div class="add_goods">
                <button class="btn minus good_button minus_goods float_left" onclick="decrCart('<?=$goods['goods_key']?>',0)">-</button>
                <div class='float_left main_confirm_order_count confirm_order_count good_date'><?php echo $goods['goods_num']; ?></div>
                <button class="btn plus good_button high_but float_left" onclick="incrCart('<?=$goods['goods_key']?>',0)">+</button>
            </div>
        </td>
  <td class="totle">
           <?php echo number_format($goods['goods_num'] * $goods['price'], 2, '.', '');  ?>
        </td>
    </tr>
<?php
    }
}
?>

       </tbody>
    </table>
    <table class="order_list_table_new" id="next_goods_list">
   <?php
if ($cart_goods[1]) {
?>
<thead>
            <tr>
            <td colspan="4">下周：
           
               <select data-week="1" class="dinner_dates">
                    <option value="0">请选择用餐日期</option>
                    <?php
                    foreach($next_week_list as $k => $day){
                        $selected = '';
                        if ($k == $cart_goods[1][0]['date']) {
                            $selected = ' selected="selected"';
                        }
                        echo '<option value="'.$k.'"'.$selected.'>'.$day.'</option>';
                    }?>
                </select>
            </td>
          <!--  <td>原价(元)</td>
            <!--<td>优惠</td>
            <td>份数</td><td>小计(元)</td>  -->
            </tr>
        </thead>
        <tbody >
<?php
    foreach ($cart_goods[1] as $k => $goods) {
?>
    <tr class="normal_tr">
  <!--    <td><?php echo $goods['date']; ?></td>  -->
      <td><?php echo $goods['goods_name'];?></td>
        <td>￥<span><?php echo $goods['price'];?></span></td>
        <!--<td class="youhui"><?php echo $v->event_name; ?></td>-->
        <td>
            <div class="add_goods">
                <button class="btn minus good_button float_left" onclick="decrCart('<?=$goods['goods_key']?>',1)">-</button>
                <div class='float_left main_confirm_order_count confirm_order_count good_date'><?php echo $goods['goods_num']; ?></div>
                <button class="btn plus good_button high_but float_left" onclick="incrCart('<?=$goods['goods_key']?>',1)">+</button>
            </div>
        </td>
   <td class="totle">
           <?php echo number_format($goods['goods_num'] * $goods['price'], 2, '.', '');  ?>
        </td>
    </tr>
<?php
    }
}
?>

       </tbody>
    </table>

    <div class="main_order_confirm_left_bottom">
         <span class="save_two">原价:￥<a id="cost_price"><?php echo number_format($orignal_amount, 2, '.', ''); ?></a>元</span>
         <span class="save_three">优惠价:￥<a id="preferential_price"><?php echo number_format($total_count, 2, '.', ''); ?></a>元</span>
    </div>
    </div>
    <!-- order_list_end -->
<div class="container_width_right_new">
  <div class="container_width_right_wrap">
    <!-- shipping_config -->
    <div class="container_width_right_title">
		<span></span><h3>配送信息</h3>

    </div>


<?php if ($shipping_address) {

    ?>
        <ul id="order_detail_configs" class="shipping_detail_new order_configs">
    <?php
    foreach ($shipping_address as $k => $v) {

        ?>
                <li>
                   <ul class="views_order_address">
                     <!--<li style="position:absolute;top:68px;right:-40px;width:200px;"><a  href="javascript:" style="color:#98C51A;height:20px;" id="add_addresss" class="config_title add_addresss add_address">
           + 新增
        </a> </li>-->
	                     <li class="shipping_address_li cursor_pointer <?php if ((!$uid && ($v->tsa_id == $default_id)) || ($uid && $v->tsa_default)) { ?>current<?php } ?>" data_id="<?php echo $v->tsa_id; ?>">
	                         <span>&#9744;</span>
	                         <div>
                             <span><?php echo $v->tsa_nickname; ?></span>
                             <span><?php echo $v->tsa_mobile;?></span>
                             <span><?php echo $v->province . ' ' . $v->city . ' ' . $v->area; ?></span>
                             <span><?php echo $v->building_address; ?></span>
                             <span><?php echo $v->company_address; ?></span>
                             <a href="javascript:;" class="address_delete float_right cursor_pointer" >删除</a>
	                         </div>
	                    </li>
                   </ul>
                </li>
        <?php }
        ?>

        </ul>
<?php } ?>
<a  href="javascript:;" id="add_addresss">+ 添加新的地址</a>
<ul class="add_new_address" <?php if (!$shipping_address) { ?>style='display: block;'<?php } ?>>

        <li><input type="hidden" id="hidden_id" value="0" />
            <span class="base_info_title "><i>*</i>姓名:</span> <span class="base_info_input "><input type="text" name="nickname" id="nickname" class="cookie_val" value="<?php echo $address_cookie_nickname; ?>" /><span class="error_note"></span></span>
        </li>
        <li>
            <span class="base_info_title "><i>*</i>电话:</span> <span class="base_info_input "><input type="text" name="mobile" id="mobile" class="cookie_val" value="<?php echo $address_cookie_mobile; ?>" /><span class="error_note"></span></span>
        </li>

        <li>
            <span class="base_info_title "><i>*</i>地址:</span>
            <span class="base_info_input ">
                <span id='new_address_span'>  <?php $building = $default_building[0];
echo $building->province . '&nbsp;&nbsp;' . $building->city . '&nbsp;&nbsp;' . $building->area . '&nbsp;&nbsp;' . $building->address . '&nbsp;&nbsp;';
?></span><input type="text" name="extra_building_address" id="extra_building_address" placeholder="xx路xx号" value="" /><span class="error_note"></span>
               <input type="text" name="company_address" id="company_address" placeholder="xx楼xx室" value="" /><span class="error_note"></span>

                <span class="error_note" id="address_note"></span>
            </span>
            <input type="hidden" id="province_id"  value="<?php echo $building->province_id; ?>" />
            <input type="hidden" id="city_id"  value="<?php echo $building->city_id; ?>" />
            <input type="hidden" id="area_id"  value="<?php echo $building->area_id; ?>" />
            <input type="hidden" id="tsa_building_id"  value="<?php echo $building->id; ?>" />

            <input type="hidden" id="zipcode"  value="" />
            <input type="hidden" id="uid"  value="<?php echo $uid; ?>" />
            <input type="hidden" id="new_flag"  value="<?php echo $new_flag; ?>" />
            <input type="hidden" id="edit_flag"  value="<?php echo $edit_flag; ?>" />
        </li>
       <li style="display:none;" class="last_li">
            <div class="base_info_title float_left">&nbsp;</div>
            <div class="base_info_input float_left address_detail">
                <input type="text" name="extra_company" id="extra_company" placeholder="请输入公司名称" value="" /><span class="error_note"></span>
                <input type="text" name="address" id="address" placeholder="请输入X楼X室" value="" /><span class="error_note"></span>


            </div>
        </li>
          <li class="base_info_input">
             <button id="save_address" data_flag='0' class="base_info_input">保存</button>
        </li>
    </ul>

    <!-- shipping_config_end -->

    <!-- payment_config -->
    <div class="container_width_right_title">
       <span></span><h3>支付方式</h3>
    </div>

  <ul class="shipping_detail_eric order_configs">
     <?php if($payment){
              foreach($payment as $k=>$v){
        ?>
      <li class="address_detail payment_config">
         <span data_id="<?=$v->name?>">&#9744;</span>
         <h3><?php echo $payment_lang[$v->name];?></h3>
      </li>
    <?php }
     }
    ?>
    <div class="clear"></div>
  </ul>
    <!-- payment_config_end -->
    <!-- comment -->

    <!-- comment_end -->
   <!--<div class="views_order_this"><span>&#9744;</span><h3>使用优惠券</h3></div>-->
   <div class="beizhu">
        <span>备注:</span><input type="text" name="comment_input" id="comment_input" />
    </div>
    <ul style="display:none;" class="shipping_detail order_configs order_sum_new">

        <li style="display:none;">
            <p class="save_one">共<span class="green_color"><?php echo $cookie_count; ?>&nbsp;</span>份，原价共计：</p>
            <p class="save_two">￥<a class="general"><?php echo number_format($orignal_amount, 2, '.', ''); ?></a>元</p>
        </li>
        <!--<li>
            <p class="save_one">优惠后总金额：</p>
            <p class="save_two green_color">￥<span class="order_total"><a><?php echo number_format($total_count, 2, '.', ''); ?></a></span>元</p>
        </li>-->
        <li <?php if(!$coupons){?>style='display: none;'<?php }?>>
            <p class="save_one">优惠券折扣：</p>
            <p class="save_two">￥<span class="coupons_price"><a>0</a>元</span></p>
        </li>
        <li>
            <p class="save_one">应付金额：</p>
            <p class="save_two order_total_amount">￥<span class="order_total"><?php echo number_format($total_count, 2, '.', ''); ?></span>元</p>
        </li>
    </ul>

    <?php if (!$event) { ?>
        <!-- coupon -->
        <?php if ($coupons) { ?>
            <div class="shipping_config order_configs coupon_div ">
                <img src="/images/plus_button.png" class="coupon_img float_left" /><p class="green_color coupon_note float_left">使用优惠券抵扣</p>
            </div>
            <ul id="coupons">
                <li data_id='0'><img src="/images/li_normal.png" class="li_selected float_left" />
                    &nbsp;&nbsp;<span>不使用任何优惠券</span>
                </li>
        <?php foreach ($coupons as $k => $v) {
            ?>
                    <li data_id='<?php echo $v->tcr_id; ?>' ><img src="/images/li_normal.png" class="float_left" />
                        &nbsp;&nbsp;<span><?php echo $v->tc_price; ?></span>元
                    </li>
        <?php } ?>
            </ul>
    <?php } ?>
        <!-- coupon_end -->
<?php } ?>
    <!-- sum_order -->
    <div class="shipping_config order_configs sum_order">
        <button class="sub_button cursor_pointer" id="save_order">提交订单</button>
    </div>
    <!-- sum_order_end  -->
</div>
</div>
</div>
<?php $this->load->view('main/new_footer'); ?>
</div>

</body>
</html>
