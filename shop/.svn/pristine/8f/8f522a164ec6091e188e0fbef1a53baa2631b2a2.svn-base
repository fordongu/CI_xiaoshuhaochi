<!DOCTYPE html>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css" media="screen" />
<link rel="stylesheet" href="/resource/css/admin/admin.css" media="screen" /> 
<link rel="stylesheet" href="/css/jquery.dataTables.css" />
<script type="text/javascript" src="/resource/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
<title>我的代金券</title>

</head>
<body>
<style>
.modal-body td{line-heght:35px;height:35px;border:1px solid #DDDDDD;text-align:center;}

.publish,.gain_control{cursor:pointer;}
.green_bak{background-color:#CCC;}
.gray_bak{background-color:#ffffff;}
.tb-toolbar{
	margin-bottom:20px;
}
</style>
<script>
$(function(){
	$('#catelist').dataTable({	   
	      "oLanguage": {//语言国际化
	        "sUrl": "/js/jquery.dataTable.cn.txt"
	      },
	    });
    $(".delete_events").each(function(){
        $(this).click(function(){ 
                if(!confirm("您确定要删除此条数据吗？")){
 					return false;
                 }
	        var event = $(this).parents("tr");
	        var event_id = event.attr("data_d");
	        
	            var submitData={
		 			tc_id:event_id		 		 
		 		};
	       
		 		 $.post('/admin/coupon_delete',submitData,function(data){
		 			 alert(data.msg);
		 			 if(data.success=='yes'){
						 window.location.reload();
			 	     }
		 		 }
		 		 ,"json");
        })
    })
    $("i").click(function(){ 
		var flag = $(this).attr('class');
		var value=0;
		if(flag=='icon-remove'){
			 value= 1; 
		} 
		var $this = $(this);
		var id = $(this).parents('td').attr('tid');
		var submitData = {id:id,value:value,table:'coupons',field:'status'};
	      $.post('/store/ajax_change_data', submitData,function(data) { 
				if (data.success == 'yes') {   
					if(flag=='icon-remove'){ 
						 $this.attr('class','icon-ok');
						 
					}else{
						 $this.attr('class','icon-remove');
					}
				}else{
					alert('操作失败'); 
				}
				 
			},"json");
	});
 })
</script>
	<div class="main-title">
		<h3>代金券管理</h3>
	</div> 
<div class="tb-toolbar">
		<a href="/admin/coupon_add" class="btn btn-small btn-primary">新增</a>	
		&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/admin/coupon_send_single" class="btn btn-small btn-primary">单用户发放</a>
		&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/admin/coupon_send_multiply" class="btn btn-small btn-primary">批量发放</a>		 
	</div>		
 
	<table class="table table-hover table-striped" id="catelist">
		<thead>
			<tr> 
				<th>代金券编号</th>
				<th>名称</th>
				<th>面值</th>
				<th>使用条件</th>
				<th>满额度</th>
				<th>开始时间</th>
				<th>结束时间</th>
				<th>自动发放</th>
				<th>统计</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		if ($coupons){
		foreach ($coupons as $key=>$val){?>
			<tr class="<?php echo $val->tc_id;?>" data_d="<?php echo $val->tc_id;?>">
			    <td><?php echo $val->tc_id;?></td> 
				<td><?php echo $coupons_types[$val->tc_title];?></td> 
				<td><?php echo $val->tc_price;?></td> 
				<td><?php echo $val->tc_sale_price;?></td> 
				<td><?php echo $val->tc_cond_price;?></td> 
				<td><?php echo $val->tc_start_time;?></td> 
				<td><?php echo $val->tc_end_time;?></td> 
				<td tid="<?php echo $val->tc_id;?>"><i <?php if($val->status){?>class="icon-ok" <?php }else{?>class="icon-remove"<?php }?>></i></td>
				<td>发出<?php echo $val->total;?>张&nbsp;&nbsp;&nbsp;&nbsp;<a href="/admin/market_result/record/1/<?php echo $val->tc_id;?>" style="display:none;">详细</a><br/>
					使用<?php echo $val->total_used;?>张&nbsp;&nbsp;&nbsp;&nbsp;<a href="/admin/order_list/1/<?php echo $val->tc_id;?>" style="display:none;">详细</a></td> 
				<td>
				     <!-- a href="/admin/coupon_code/<?php echo $val->tc_id;?>">兑换码</a-->	
				     <a href="/admin/coupon_add/<?php echo $val->tc_id;?>">修改</a>&nbsp;&nbsp;|&nbsp;&nbsp;	
				     <a href="Javascript:void(0)" class="delete_events">删除</a>	
				</td>     
			</tr>
			 
		<?php 
          }
		}else {
			echo '暂时没有任何代金券';
		}
		?>
			
		
		</tbody>
	</table>
</body>
</html>