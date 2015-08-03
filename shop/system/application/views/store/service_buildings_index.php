<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="/resource/css/admin/admin.css" />
<link rel="stylesheet" href="/css/jquery.dataTables.css" />
<script type="text/javascript" src="/resource/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>

<title>写字楼管理</title>
<style>
a:hover{
	text-decoration: none;
}
</style>
</head>
<body>

	<div>	
		<h3>写字楼管理</h3>	
		<div class="count">
			<span class="member-count">写字楼总数: <?php echo $total_amount;?></span>
		</div>
		<div class="tb-toolbar">		
			<a href="/store/service_buildings_add" class="btn btn-small btn-primary">新增写字楼</a>
			&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="/admin/data_export/building" class="btn btn-small btn-primary">导出excel</a>	
		</div>
		<br/>
		<table class="table table-bordered"  id="catelist">
			<thead>
				<tr>
					<th>省份</th>
					<th>城市</th>
					<th>地区</th>
					<th>写字楼名</th>
					<th>地址</th> 
					<th>状态</th>
					<th>开发时间</th>
					<th>开始时间</th>
					<th>结束时间</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			   if($service_buildings){ 
			        foreach ($service_buildings as $key=>$val){?>	
					<tr>
						<td><?php echo $val->province;?></td>
						<td><?php echo $val->city;?></td>
						<td><?php echo $val->area;?></td>
						<td><?php echo $val->name;?></td>
						<td><?php echo $val->address;?></td>
						<td>
						<?php if(!$val->status){ echo '开发中 ';}else if($val->status == 1){ echo '供应中';}else if($val->status == 2){ echo '停止供应';}else if($val->status == 3){echo '活动写字楼';}else if($val->status == 4){echo '虚拟写字楼';}?></td>
						<td><?php echo $val->develop_time;?></td>
						<td><?php echo $val->start_time;?></td>
						<td><?php echo $val->end_time;?></td>
						
						<td tid="<?php echo $val->id;?>"> 
						      <a href="/store/service_buildings_add/<?php echo $val->id;?>">修改</a>&nbsp;&nbsp;|&nbsp;&nbsp;
							<a href="javascript:void(0)" class="cate_del">删除</a>
						</td>
					</tr>
			   <?php } }?>	
			</tbody>
		</table>			
		
 
	</div>
	 <script type="text/javascript">
$(function(){
	$('#catelist').dataTable({	   
	      "oLanguage": {//语言国际化
	        "sUrl": "/js/jquery.dataTable.cn.txt"
	      },
	    });
	$("#catelist").delegate(".cate_del","click",function(){
		if(confirm("确认删除这个类别吗？")){
			var tid = $(this).closest("td").attr("tid");
			window.location.href="/store/store_delete/service_buildings/" + tid;
		}
	});
	$(".cate_recomment").click(function(){
		var status = $(this).attr('data-id');
		var id = $(this).parents('td').attr('tid');
		var submitData = {id:id,status:status,type:'service_buildingss'};
	      $.post('/store/ajax_update_category', submitData,function(data) { 
				if (data.success == 'yes') { 
				    alert('操作成功');
				    window.location.reload();
				}else{
					alert('操作失败'); 
				}
				 
			},"json");
	});

	
});

</script>
</body>	
</html>