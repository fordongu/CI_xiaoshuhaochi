<!DOCTYPE html>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="<?php echo base_url();?>css/bootstrap.css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>resource/css/admin/admin.css" media="screen" />
<link rel="stylesheet" href="/css/jquery.dataTables.css" />
<script type="text/javascript" src="/resource/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
<title>我的兑换码</title>

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
    $(".btn-small").click(function(){
         
	        var event_id = $(this).attr("data_d");
	        var day = $('#day').val();
	        if(day == ''){
				alert('兑换天数不能空');return false;
		    }
	            var submitData={
		 			tc_id:event_id,
		 			day:day		 		 
		 		};
	            window.location.href='/admin/general_codes/'+event_id+'/'+day;
		 		 
        })
   
    
 })
</script>
	<div class="main-title">
		<h3>兑换码管理       有效期：<?php echo $coupon->tc_end_time;?>    面值：<?php echo $coupon->tc_price;?>元</h3>
	</div>
<div class="tb-toolbar">
		<a href="/admin/coupon_code/<?php echo $tc_id;?>/2">未兑换</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/admin/coupon_code/<?php echo $tc_id;?>/1">已兑换</a>&nbsp;&nbsp;|&nbsp;&nbsp;兑换天数：<input type="text" id="day" name="day" style="width:20px;" />&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-small btn-primary" data_d="<?php echo $tc_id;?>">生成码</a>		 
</div>		
 
	<table class="table table-hover table-striped" id="catelist">
		<thead>
			<tr> 
				<th>兑换码</th>
				<th>兑换截止期</th> 
				<th>状态</th> 
			</tr>
		</thead>
		<tbody>
		<?php 
		if ($coupon_code){
		foreach ($coupon_code as $key=>$val){?>
			<tr class="<?php echo $val->tcc_id;?>" data_d="<?php echo $val->tcc_id;?>">
			    <td><?php echo $val->tcc_codes;?></td> 
				<td><?php echo $val->tcc_valid_time;?></td>  
				<td><?php if($val->tcc_status){ echo '已兑换';}else{ echo '未兑换';}?></td> 
				     
			</tr>
			 
		<?php 
          }
		}else {
			echo '暂时没有任何兑换码';
		}
		?>
			
		
		</tbody>
	</table>

</body>
</html>