$(function() {
     $(".no_show").remove();
      $(".next_week_show").hide();
      // alert($(".this_week_shownext_week_show").length);
       // alert($(".this_week_show").length);
       //  alert($(".next_week_show").length);
    $(".get_detail").on("click", function() {

        var good_id = $(this).attr("good_id");
        var building_id = 43;
        $(".views_main_plus_button").attr("data_good_id",good_id);
         $(".views_main_plus_button").attr("data_week",$("#date_for_cart").val());
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
                $(".detail_supplier").html(detail.supplier_name);
				$("#detail_supplier_address").html(detail.address);
				$("#detail_good_desc").html(detail.desc0);
				//$("#detail_supplier2").html(detail.supplier_name);
                $("#detail_price").html(detail.price);
                $("#detail_img1").attr("src", base_url+detail.coverurl0);
               var add_html='<img src='+static_url+'/images/wx_sq.png class="wx_sq qudiao"/>';
                
               
                if ($("#date_for_cart").val()=="0"&&$("#date_time").val()=="6"||$("#date_for_cart").val()=="0"&&$("#date_time").val()=="7")
                {
                  
                    
                    $("#detail_img1").after(add_html); 
                    
                }else  if(detail.stock=="0"){
                     
                    
                    $("#detail_img1").after(add_html);
                    
                }else{
                  
                    
                    $(".qudiao").remove();
                    
                }
                
               
                if(detail.coverurl0){
                  $("#detail_img1_1").attr("src", base_url+detail.coverurl0);
		        $("#detail_img1_1").attr("alt", detail.title0);
                        $("#detail_img1_1").show();
                }
		if (detail.coverurl1){

                $("#detail_img2").attr("src",  base_url+detail.coverurl1);
                $("#detail_img2").attr("alt",  detail.title1);
                        $("#detail_img2").show();
                        
                }	
                if(detail.coverurl2){
                $("#detail_img3").attr("src", base_url+detail.coverurl2);
                $("#detail_img3").attr("alt", detail.title2);
                        $("#detail_img3").show();
                }	
                 if(detail.coverurl3){
                 $("#detail_img4").attr("src", base_url+detail.coverurl3);
                $("#detail_img4").attr("alt", detail.title3);
                        $("#detail_img4").show();
                }	
                  if(detail.coverurl4){
               $("#detail_img5").attr("src", base_url+detail.coverurl4);
                $("#detail_img5").attr("alt", detail.title4);
                        $("#detail_img5").show();
                }	
               
		
                $("#detail_server_week").html(detail_server_week);
                $("#detail_server_day").html($("#date").val());
                $("#detail_image").attr("src", "api_images/suppliers/" + detail.image0_url);
                $("#descr").html(detail.descr);
                $(".name_of_cai").html(detail.goods_name);
                $("#join_cart").attr('data_week',1);
                $("#join_cart").attr('data_good_id',good_id);
            }
        }, "json");
		$(".detail_img_pd").each(function(){
			//alert($(this).attr("src"));
			if($(this).attr("src")==""||$(this).attr("src")==base_url){
				$(this).remove();
			}
		})
    })
    $("#next_week").click(function() {
       $(".this_week_show").hide();
       $(".next_week_show").show();
       $("#date_for_cart").val("1");
      $(".hide_wq").hide();
      $(".plus_good_main").attr("data_week","1");
    })
     $("#this_week").click(function() {
        $(".next_week_show").hide();
        $(".this_week_show").show();
         $(".plus_good_main").attr("data_week","0");
         if($("#date_now").val()==6||$("#date_now").val()==0){
      $(".wx_sq").show();

        }
        $("#date_for_cart").val("0");
    })
  if($("#date_now").val()==6||$("#date_now").val()==0){
      $(".wx_sq").show();
      $("#next_week").trigger("click");
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
