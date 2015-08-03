<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css" media="screen" />
<link rel="stylesheet" href="/resource/css/admin/admin.css" media="screen" />
<link rel="stylesheet" href="/jquery-ui/css/smoothness/jquery-ui-1.10.0.custom.min.css" media="screen" />
<link rel="stylesheet" href="/resource/css/plugin/jquery-ui-timepicker-addon.css" media="screen" />
<link rel="stylesheet" href="/resource/css/admin/appmsg.css" media="screen" />
<link rel="stylesheet" href="/resource/css/admin/coupon-setting.css" media="screen" />
<link rel="stylesheet" href="/jquery-ui/css/uploadify.css" media="screen" />
<script type="text/javascript" src="/resource/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/resource/js/plugin/operamasks-ui.min.js"></script>
<script type="text/javascript" src="/jquery-ui/js/jquery-ui-1.10.0.custom.min.js"></script>
<script type="text/javascript" src="/jquery-ui/js/jquery.uploadify.min.js"></script>
<script type="text/javascript" src="/resource/js/plugin/timepicker/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="/resource/js/plugin/timepicker/jquery-ui-timepicker-zh-CN.js"></script>
<script type="text/javascript" src="/resource/js/plugin/timepicker/jquery-ui-sliderAccess.js"></script>

<title>商品管理</title>
<style>
a:hover{
	text-decoration: none;
}
.controls input{
	width:130px;
}
</style>
<script>

  $(document).ready(function(){
	  $('#order_start').datetimepicker();
	  $('#order_end').datetimepicker();
	  $('#use_start').datetimepicker();
	  $('#use_end').datetimepicker();

  	  
	  $("#search_code").click(function(){ 
			var nickname = $("#nickname").val();
			var search_mobile = $("#search_mobile").val(); 
			var order_start = $('#order_start').val();
			var order_end = $('#order_end').val();
			var use_start =   $('#use_start').val();
			var use_end =  $('#use_end').val();
			var submitData= { 
					nickname:nickname,
					search_mobile:search_mobile, 
					order_start:order_start,
					order_end:order_end,
					use_start:use_start,
					use_end:use_end
			        };
			$.post('/store/order_index',submitData,function(data){
	        	 
				if(data.success=="no")
				{
	                alert(data.msg);
				}else{
						window.location.reload();
			    } 
				  
				
			},"json"); 
		});


	    $("#reset_code").click(function(){
			 
	    	var submitData= { 
					nickname:'',
					search_mobile:'', 
					order_start:'',
					order_end:'',
					use_start:'',
					use_end:''
			        };
			$.post('/store/order_index',submitData,function(data){
	        	 
				if(data.success=="no")
				{
	                alert(data.msg);
				}else{
					window.location.reload();
			    } 
				  
				
			},"json");
			 
		});
  })
</script>
</head>
<body>
<div class="main-title">
		<h3>订单总数&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $total_count;?></h3>
	</div>
 <div class="tb-toolbar">		
		 
		<a href="/admin/data_export/orders" class="btn btn-small btn-primary">导出excel</a>	
	</div><br/> 	
<div id="sn_form" class="form-horizontal">
			<div class="control-group">
		    	<div class="controls">
		    	姓名：<input type="text" name="nickname" id="nickname" value='<?php echo $nickname;?>' />
		    	手机：<input type="text" name="search_mobile" id="search_mobile" value='<?php echo $search_mobile;?>' />
			    下单时间：
			         <input type="text" name="order_start" id="order_start" value='<?php echo $order_start;?>' />
			         <input type="text" name="order_end" id="order_end" value='<?php echo $order_end;?>' /><br/><br/>
			    用餐时间：	
			   		 <input type="text" name="use_start" id="use_start" value='<?php echo $use_start;?>' />
			         <input type="text" name="use_end" id="use_end" value='<?php echo $use_end;?>' /> 
			    	<button class="btn btn-primary" id="search_code">查询</button>
			    	<button class="btn btn-primary" id="reset_code">重置</button>
		    	</div>
		  	</div>
		</div>	
	<div>	
		<h3>订单管理</h3>	
		<div class="count">
			 
		</div> 
		<br/>
		<table class="table table-bordered"  id="catelist">
			<thead>
				<tr> 
				    <th>订单号</th>
					<th>收货人</th>
					<th>手机号</th>
					<th>订单总额</th>
					<th>支付方式</th>
                    <th>支付状态</th>					
					<th>订单状态</th>
					<th>下单时间</th> 
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			   if($orders){ 
			        foreach ($orders as $key=>$val){?>	
					<tr>
					    <td><?php echo $val->to_order_sn;?></td>
						<td><?php echo $val->to_receiver;?></td>
						<td><?php echo $val->to_mobile;?></td>
						<td><?php echo $val->to_total_amount;?></td>
						<td><?php echo $payment_config[$val->to_pay_way];?></td> 
						<td><?php if($val->to_pay_status==0){echo "未支付";}else if($val->to_pay_status==1){echo "已支付";}?></td>
						<td><?php echo $order_status[$val->to_status];?></td>
						<th><?php echo $val->to_created;?></th> 
						<td tid="<?php echo $val->to_id;?>"> 
						    <a href="/store/order_review/<?php echo $val->to_id;?>">查看订单</a>
						     
							<?php if(($val->to_status == '10')||($val->to_status == '20')){?>  
							   &nbsp;&nbsp;|&nbsp;&nbsp;
							  <a href="javascript:void(0)" class="cate_del" data_id="70">取消</a>
							<?php }?>  
							
							<?php if(($val->to_status == '20')||(($val->to_pay_way == 'daofu')&&($val->to_status == '10'))||(($val->to_pay_way != 'daofu')&&($val->to_status == '10'))){?>  
							   &nbsp;&nbsp;|&nbsp;&nbsp;
							  <a href="javascript:void(0)" class="cate_del" data_id="30">确认订单</a>
							<?php  }?> 
							
							<?php if($val->to_status == '30'){?>  
							   &nbsp;&nbsp;|&nbsp;&nbsp;
							  <a href="javascript:void(0)" class="cate_del" data_id="40">成功订单</a>
							<?php }?>  
						</td>
					</tr>
			   <?php } }?>	
			</tbody>
		</table>			
	</div>
	
<div class="pagination">
  <ul>
<?php if($current_page=='1'){?><li class="disabled" ><span>上一页</span></li>
     <?php }else{?>
     <li><a href="/store/order_index/<?php echo $current_page-1;?>">上一页</a></li>
     <?php }?>
    <?php for ($i=1;$i<=$total;$i++){?>
       <?php if($current_page==$i){?><li class="active"><span><?php echo $i;?></span></li><?php }else{?>
       <li><a href="/store/order_index/<?php echo $i;?>"><?php echo $i;?></a></li><?php }?>
    <?php }?>
    <?php if ($current_page==$total){?>
    <li class="disabled"><span>下一页</span></li>
    <?php }else{?>
     <li><a href="/store/order_index/<?php echo $current_page+1;?>">下一页</a></li>
     <?php }?>
  </ul>
</div>	
	 <script type="text/javascript">
$(function(){ 
	$("#catelist").delegate(".cate_del","click",function(){
		if(confirm("确认更改这个订单的状态吗？")){
			var tid = $(this).closest("td").attr("tid");
			var status = $(this).attr('data_id'); 
			var submitData={id:tid,status:status};
			$.post('/store/order_update', submitData,function(data) { 
				alert(data.msg);
				if (data.success == 'yes') { 				    
				    window.location.reload();
				}  
			},"json");
		}
	}); 
});

</script>
</body>	
</html>