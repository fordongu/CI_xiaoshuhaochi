                                          <!-- 主体 Begin -->
<input type="hidden" id="dav_memory" value="<?php //echo $index;?>">
 <input type="hidden" id="dav_select" value="<?php //echo $dav_select;?>">
 <input type="hidden" id="cookie_good_count" value="<?php //echo $cookie_count;?>">
<input type="hidden" id="choose_pic" value="<?php //echo $day_choose;?>">
<input type="hidden" id="per_count_limit" value="<?php //echo $per_count_limit;?>" />
<input type="hidden" id="total_count_limit" value="<?php //echo $total_count_limit;?>" />
 <input type="hidden" id="uid" value="<?php echo $uid;?>" />
 <input type="hidden" id="week" value="<?php echo $week;?>" />
<input type="hidden" id="date" value="<?php echo $date_day[0];?>" />
<input type="hidden" id="date_time" value="<?php echo $date_day[1];?>" />
<input type="hidden" id="date_for_cart" value="0" />
<input type="hidden" id="date_now" value="<?php echo date("w");?>" />
<input type="hidden" id="date_choose" this_mon="<?php echo strtotime($weeks_contorl[0][0]);?>" this_fri="<?php echo strtotime($weeks_contorl[0][1]);?>" next_mon="<?php echo strtotime($weeks_contorl[1][0]);?>" next_fri="<?php echo strtotime($weeks_contorl[1][1]);?>"/>
<div class="views_main_content">
    <div class="views_main_wrap">
  <!--  <ul id="views_mian_list">
      <li><h2>西餐</h2><div></div></li>
      <li><h2>中餐</h2><div></div></li>
      <li><h2>日本料理</h2><div></div></li>
      <li><h2>饮料</h2><div></div></li>
    </ul> -->
     <?php

     foreach ($goods[0]->temp_goods as $key=>$val){

         $date_day_select=$date_day[1];
         if($date_day[1]==6||$date_day[1]==7){
              $date_day_select=1;
         }
      ?>

        <?php
         if(in_array($date_day_select,$val->week)&&strtotime(date("Y/m/d H:i:s"))>strtotime($val->start_time)||strtotime($val->end_time)>=strtotime($weeks_contorl[1][0])){

         //$date[0]是日期date[1]是周几
        //  if($val->good_id==$first[$date_day_select-1]){
              //取首元素
                $i=0;
           //   $arr = explode("+", $val->name);
     ?>

          <?php //}
          // else{
           $pinlei="";
           $canlei="";
            if($val->sub_cate_id==21){
                $pinlei="xican";
            }else if($val->sub_cate_id==20){
                $pinlei="zhongcan";
            }else if($val->sub_cate_id==22){
                $pinlei="riliao";
            }else if($val->sub_cate_id==23){
                $pinlei="yinliao";
            }
            if($val->cate_id==18){
                $canlei="wucan";
            }else if($val->cate_id==19){
                $canlei="yinpin";
            }
            
               ?>
        <dl data_start_time='<?php echo $val->start_time;?>' data_end_time='<?php echo $val->end_time;?>' class="views_main_content_small <?php if(strtotime($val->start_time)<strtotime($weeks_contorl[0][1])&&strtotime($val->end_time)>=strtotime($weeks_contorl[0][0])){echo 'this_week_show';}if(strtotime($val->start_time)<=strtotime($weeks_contorl[1][0])&&strtotime($val->end_time)>=strtotime($weeks_contorl[1][0])){echo 'next_week_show';}if(strtotime($val->start_time)>strtotime($weeks_contorl[1][1])){echo 'no_show';} echo " ".$pinlei." ".$canlei;?>">
        <dt class="get_detail" good_id="<?php echo $val->good_id;?>">
          <img src="<?php echo $val->coverurl0;?>" alt="主菜" data_goods_id="<?php echo $val->good_id;?>">
          <img src="<?=$static_url?>/images/wx_sq.png" class="wx_sq hide_wq" style="display:none"/>
  
 <?php if($val->stock=="0"){         
             ?>
          <img src="<?=$static_url?>/images/wx_sq.png" class="wx_sq"/>
         <?php }?>
        </dt>
        <dd>
          <ul>
            <li>
             <ol>
               <li>
                 <h3><?php echo $val->name;?></h3>
               </li>
               <!--
			   <li>
                  <span>用餐时间:</span>
                  <span class="week_day_chinese">

                  </span>
                  <span class="week_day"><?php echo $date_day[0];?></span>
              </li>
			  -->
			  <li><span>餐厅:</span>
			  <span><?php echo $val->supplier_name;?></span>
			  </li>
             </ol>
            </li>
            <li>
              <span><small>¥</small><?php echo $val->price;?></span>
              <button class="plus_good_main" data_week="0" data_good_id="<?php echo $val->good_id;?>"  cate_id="<?php echo $val->cate_id;?>">点餐</button>
            </li>
          </ul>
        </dd>
      </dl>

             <?php }//}?>



             <?php
           }?>

<!--
      <div class="views_main_index_carouse">

        <ul>
              <?php     foreach ($goods[0]->temp_goods as $key=>$val){

				  ?>

            <li>
                <img src="images/suppliers/<?php echo $val->image0_url;?>">
                <div>
                   <h5>大士村</h5>
                   <span>地址:</span><span></span><br/>
                   <span><?php echo $val->descr;?></span>
                </div>
            </li>

              <?php }?>
        </ul>
        <ol>
             <?php     foreach ($goods[0]->temp_goods as $key=>$val){?>
          <li class="normal"><a href="javascript:;"></a></li>

           <?php }?>
        </ol>

      </div>
-->
   </div>
</div>
                                          <!-- 主体 End -->

    <!-- 购物车 Begin -->
  <div id="goods_cart">
  <!--<img class="views_main_shopping_cart_tips" width="30px" height="30px" src="icon/index-icon2.png" alt="购物车">-->
  <span class="views_main_shopping_cart_tips"></span>
  <span class="views_cart_number">0</span>
  </div>
  <div class="views_main_shopping_cart">
    <!--div class="views_main_dinner_time" id="views_main_dinner_time_0" style="display:none;">
       <ul>
         <li>
           <ol class="o-hidden" id="week_select_0">
             <li data-id="0" data-week="0">请选择日期</li>
           </ol>
         </li>
         <li class="next"></li>
       </ul>
    </div-->
    <div class="views_main_dinner_time" id="views_main_dinner_time_0" style="display:none;">
      本周
    </div>
    <ul class="views_main_cart_list" id="week_cart_0"></ul>
    <!--div class="views_main_dinner_time" id="views_main_dinner_time_1" style="display:none;">
       <ul>
         <li>
           <ol class="o-hidden" id="week_select_1">
            <li data-id="0" data-week="1">请选择日期</li>
           </ol>
         </li>
         <li class="next"></li>
       </ul>
    </div-->
    <div class="views_main_dinner_time" id="views_main_dinner_time_1" style="display:none;">
       下周
    </div>
    <ul class="views_main_cart_list" id="week_cart_1"></ul>
    <div class="views_main_cart_subtotal">
      <ul>
        <li>
          <h5>小计:</h5>
          ¥<span id="sub_total">0.00</span>元
        </li>
        <li>
          <h5>优惠:</h5>
          ¥<span id="favorable">0.00</span>元
        </li>
      </ul>
    </div>
    <div class="views_main_cart_total">
      <ul>
        <li>
          <h5>总计:</h5>
          ¥<span id="total_price">0.00</span>元
        </li>
        <li>
          <ol>
            <li onclick="clearCart();"><i></i><span>清除所有</span></li>
            <li><a href="<?=$old_website?>/main/order_confirm"><button>结算</button></a></li>
          </ol>
        </li>
      </ul>
    </div>
  </div>
 <!-- 购物车 End -->
                                           <!-- 详情 Begin -->
   <div class="views_main_detail">
     <span class="delete"><img src="<?=$static_url?>/icon/delete.png" alt="关闭" /></span>
     <dl>
        <dt>
          <ul>
              <li><img id="detail_img1" src="" alt="主菜"></li>
              
            <li><h3></h3><span id="detail_name"></span></li>
            <li>
                        <img class="detail_img_pd" id="detail_img1_1"  alt="" style="display:none"/>
			<img class="detail_img_pd"  id="detail_img2"   alt="" style="display:none"/>
			<img class="detail_img_pd" id="detail_img3"   alt="" style="display:none"/>
			<img class="detail_img_pd" id="detail_img4"  alt="" style="display:none"/>
			<img class="detail_img_pd" id="detail_img5"   alt="" style="display:none"/>
			
            </li>
          </ul>
        </dt>
        <dd>
        <ul>
          <li>
             <h3 class="name_of_cai"></h3>
          </li>
          <li>
            <ol>
              <li><span>餐厅: </span><span class="detail_supplier"></span></li>
              <!--
			  <li>
                  <span>用餐时间:</span>
                  <span class="views_main_content_week" id="detail_server_week"></span>
                  <span class="views_main_content_date" id="detail_server_day">4/5/2015</span>
              </li>
			  -->

            </ol>
          </li>
          <li>
             <span id="detail_good_desc" class="detail_desc"></span>
          </li>
          <li>
            <span><small>¥</small ><a id="detail_price"></a></span>
            <button class="views_main_plus_button plus_good_main">点餐</button>
          </li>
        </ul>
       </dd>
      </dl>
      <div>
        <img id="detail_image" src="../images/index_menu02.png"  alt="餐厅图片" />
        <div>
          <h5 class="detail_supplier"></h5>
          <span id="detail_supplier_address"></span>
		      <p id="descr" class="p"></p>
        </div>

      </div>
   </div>
   <!-- 详情 End -->

   <!-- notice Begin -->
   
   <!-- notice End -->
   
   
   <?php if (!$notice) {?>
<div class="general_notice">
     <span class="delete"><img src="<?=$static_url?>/icon/delete.png" alt="关闭" /></span>
     <ul>
       <li>为了您能准时收到您订购的美味，<br/>请您在需要的用餐日期前或当天<big>10:00</big>前进行预订。</li>
       <li>我们的配送时间为：<big>11:00AM</big> - <big>12:00AM</big>!</li>
       <li>您可以提前预订本周和下周的美食!</li>
     </ul>
   </div>
   <?php }?>

                                        <!-- 主体 End -->
