<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css" media="screen" />
<link rel="stylesheet" href="/resource/css/admin/admin.css" media="screen" /> 
<link rel="stylesheet" href="<?php echo base_url();?>/jquery-ui/css/smoothness/jquery-ui-1.10.0.custom.min.css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>/resource/css/plugin/jquery-ui-timepicker-addon.css" media="screen" />
<script type="text/javascript" src="/resource/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>/jquery-ui/js/jquery-ui-1.10.0.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/resource/js/plugin/timepicker/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/resource/js/plugin/timepicker/jquery-ui-timepicker-zh-CN.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/resource/js/plugin/timepicker/jquery-ui-sliderAccess.js"></script>
<style>
.count{
		background-color: #FFEFAF;
		line-height: 30px;
		margin-bottom: 10px;
}
.member-count{
	margin: 0 50px 0 10px;
}
.info-block{
	text-align: center;
}
.statu_frozen{
	color: red;
}
td,th{
	padding:0 10px;
	line-height:35px; 
}
td input{
	margin-right:10px;
}
thead{
	background-color:#f6f6f6;
	color:#222;
}
</style>
<script>
$(function () {
	 $('.start_time').datetimepicker();
	 $('.end_time').datetimepicker();
   
})
</script>
<title>新增供应商</title>
</head>
<body>
 <form class="form-horizontal"  id="tform" action="/store/good_extra/<?php echo $good_id;?>" method="POST">
	  <?php foreach($supplier as $k=>$v){ if($v->buildings){ ?> 	 
		<fieldset>
		    <legend><?php echo $v->name;?></legend>
		    <table>
		      <tr><th>写字楼</th><th>供应日期</th><th>供应星期</th><th>库存</th></tr>
		     <?php foreach($v->buildings as $key=>$val){?>
		         
		          <tr><td><?php echo $val->name;?></td><td><input type="text" class="start_time" name="start_time_<?php echo $v->supplier_id;?>[]" value="<?php if (isset($end_data[$v->supplier_id][$val->id])){echo $end_data[$v->supplier_id][$val->id]['start_time'];}?>">
		          <input type="text" class="end_time" name="end_time_<?php echo $v->supplier_id;?>[]" value="<?php if (isset($end_data[$v->supplier_id][$val->id])){echo $end_data[$v->supplier_id][$val->id]['end_time'];}?>" /></td>
		          <td><?php foreach($weeks as $k1=>$v1){?>
					  <input type="checkbox" value="<?php echo $k1+1;?>" <?php if($end_data&&isset($end_data[$v->supplier_id][$val->id])&&(in_array($k1,$end_data[$v->supplier_id][$val->id]['weeks']))){?>checked=true<?php }?>class="weeks" name='weeks_<?php echo $v->supplier_id;?>_<?php echo $val->id;?>[]'/><?php echo $v1;?>
					<?php }?>  
				</td>
				   <td><input style="width:50px;" type="text" class="stock" name="stock_<?php echo $v->supplier_id;?>[]" value="<?php if (isset($end_data[$v->supplier_id][$val->id])){echo $end_data[$v->supplier_id][$val->id]['stock'];}?>" /></td>
				</tr>
		     <?php } ?> 
		    </table>  
		</fieldset>
		<?php }}?>
		<div class="control-group" style="margin-top:20px;">
			    <div class="controls">
			      
			      <button id="save-btn" type="submit" class="btn btn-primary">保存</button>
			      <button id="back-btn" type="button" class="btn btn-primary" onclick="location.href='/store/supplier_index'">返回</button>
			    </div>
		    </div>
	</form> 
</body>	
</html>