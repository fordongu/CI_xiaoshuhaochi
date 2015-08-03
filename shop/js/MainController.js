$(function() {
     $(".no_show").remove();
      $(".next_week_show").hide();
      // alert($(".this_week_shownext_week_show").length);
       // alert($(".this_week_show").length);
       //  alert($(".next_week_show").length);
   /*屏蔽网站详情页
    *  $(".get_detail").on("click", function() {

        var good_id = $(this).attr("good_id");
        var building_id = 43;
        var submitData = {good_id: good_id, building_id: building_id}
        $.post(base_url+"/GoodsDetail/goodsdetail", submitData, function(data) {
            if (data.sussces == "yes") {
                var detail = data.msg;
                var week_day = $("#date_time").val();
                if (week_day == 1) {
                    var detail_server_week = "星期一";
                } else if (week_day == 2) {
                    var detail_server_week = "星期二";
                } else if (week_day == 3) {
                    var detail_server_week = "星期三";
                } else if (week_day == 4) {
                    var detail_server_week = "星期四";
                } else if (week_day == 5) {
                    var detail_server_week = "星期五";
                }
               // $("#detail_name").html(detail.title0+detail.title1+detail.title2);
                $("#detail_supplier").html(detail.supplier_name);
                $("#detail_price").html(detail.price);
                $("#detail_img1").attr("src", detail.coverurl0);
                $("#detail_img1").attr("alt", detail.title0);
                $("#detail_img2").attr("src", detail.coverurl1);
                $("#detail_img2").attr("alt", detail.title1);
                $("#detail_img3").attr("src", detail.coverurl2);
                $("#detail_img3").attr("alt", detail.title2);
                $("#detail_img4").attr("src", detail.coverurl3);
                $("#detail_img4").attr("alt", detail.title3);
                $("#detail_server_week").html(detail_server_week);
                $("#detail_server_day").html($("#date").val());
                $("#detail_image").attr("src", "images/supplier/" + detail.image0_url);
                $("#descr").html(detail.descr);
                $(".name_of_cai").html(detail.goods_name);
            }
        }, "json");

    })*/
    $("#next_week").click(function() {
       $(".this_week_show").hide();
       $(".next_week_show").show();   
       $("#date_for_cart").val("1");
      $(".hide_wq").hide();
    }) 
     $("#this_week").click(function() {
        $(".next_week_show").hide();
        $(".this_week_show").show();
         if($("#date_time").val()==6||$("#date_time").val()==7){
      $(".hide_wq").show();
        }
        $("#date_for_cart").val("0");
    })
  if($("#date_time").val()==6||$("#date_time").val()==7){
      $(".wx_sq").show();
  }

  /*
  var length=$('.this_week_shownext_week_show').length;
 $(".next_week_show").each(function(length){
     if($(this).css('display')=="none"){
          $('.next_week_show').replaceWith($('.this_week_shownext_week_show:eq('+parseInt(length)+'-1)'));
     }
 })
 */
})
