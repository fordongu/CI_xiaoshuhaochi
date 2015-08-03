<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="/resource/css/admin/admin.css" />
<script type="text/javascript" src="/resource/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>

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
a:hover{
	text-decoration: none;
}
</style>
<script>
 $(document).ready(function(){

		$("i").click(function(){ 
			var flag = $(this).attr('class');
			var value=0;
			if(flag=='icon-remove'){
				 value= 1; 
			} 
			var $this = $(this);
			var id = $(this).parents('td').attr('tid');
			var submitData = {id:id,value:value,table:'area',field:'status'};
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
<title>区域管理</title>
</head>
<body>
   <h3>区域管理</h3>	
    <div class="tb-toolbar">		
		 
	</div><br/> 
		<table class="table table-bordered" id="catelist">
			<thead>
				<tr>
					<th>省份</th> 
					<th>状态</th>  
				</tr>
			</thead>
			<tbody>
			<?php 
			   if (!empty($area)){
			      foreach ($area as $key=>$val){?>	
					<tr>
						<td><?php echo $val->area;?></td> 
						<td tid="<?php echo $val->id;?>"><i <?php if($val->status){?>class="icon-ok" <?php }else{?>class="icon-remove"<?php }?>></i></td>
						  
					</tr>
			   <?php }
			   
			   foreach ($area2 as $key=>$val){?>
			   		<tr>
						<td><?php echo $val->area;?></td> 
						<td tid="<?php echo $val->id;?>"><i <?php if($val->status){?>class="icon-ok" <?php }else{?>class="icon-remove"<?php }?>></i></td>
						  
					</tr>
			   <?php } }else{ ?>
			   	  <tr><td colspan="3">没有任何记录</td></tr> 
			  <?php }
			   ?>	
			</tbody>
		</table>			
   
</body>	
</html>