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
</style>
<title>自定义菜单管理</title>
<script>
$(function(){
  $("#update_btn").click(function(){
	$.post('/admin/menu_update','',function(data){
				if(data.success=="yes")
				{
                    alert(data.msg);
				}
				
			},"json");
	})		
})			
</script>			
</head>
<body>

	<div>	
		<h3>自定义菜单管理</h3>	
		 <div class="tb-toolbar">
		<a class="btn btn-small btn-primary" id="update_btn" href="javascript:void(0)">更新菜单</a>
	</div>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>菜单</th>
					<th>菜单关键字</th>
					<th>子菜单</th>
					<th>子菜单关键字</th>					
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($menu_settings as $key=>$val){?>	
					<tr>
						<td><?php if($val->tms_main_id!=0){ echo "|-----";} echo $val->tms_main_menu;?></td>
						<td><?php echo $val->tms_main_key;?></td>
						<td><?php echo $val->tms_sub_menu;?></td>
						<td><?php echo $val->tms_sub_key;?></td>
						<td>
						    <?php if($val->tms_main_id==0){?>
						    <a href="/admin/sub_menu_settings_add/<?php echo $val->tms_id;?>">添加子菜单</a>&nbsp;&nbsp;|&nbsp;&nbsp;
						    <a href="/admin/menu_settings_add/<?php echo $val->tms_id;?>">修改</a>&nbsp;&nbsp;|&nbsp;&nbsp;
						    <?php }else{?>
						    <a href="/admin/sub_menu_settings_add/<?php echo $val->tms_id;?>">修改</a>&nbsp;&nbsp;|&nbsp;&nbsp;
						    <?php }?>
						    <a href="/admin/menu_settings_delete/<?php echo $val->tms_id;?>">删除</a></td>
						
					</tr>
			   <?php }?>	
			</tbody>
		</table>			
<div class="tb-toolbar">
		<a class="btn btn-small btn-primary" href="/admin/menu_settings_add">新增</a>
	</div>
	</div>

</body>	
</html>