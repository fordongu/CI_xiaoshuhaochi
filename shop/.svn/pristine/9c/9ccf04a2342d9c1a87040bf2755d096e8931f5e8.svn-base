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

<title>商品管理</title>
<style>
a:hover{
	text-decoration: none;
}
</style>
</head>
<body>

	<div>	
		<h3>商品管理</h3>	
		<div class="count">
			<span class="member-count">商品总数: <?php echo $total_amount;?></span>
		</div>
		<div class="tb-toolbar">		
			<a href="/store/good_add" class="btn btn-small btn-primary">新增商品</a>	
				&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="/admin/data_export/goods" class="btn btn-small btn-primary">导出excel</a>
		</div>
		<br/>
		<table class="table table-bordered"  id="catelist">
			<thead>
				<tr>
				    <th>ID</th>
					<th>商品名</th>
					<th>商品大类</th>
					<th>商品小类</th>
					<th>商品价格</th>  
					<th>供应商</th>  
					<th>状态</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			   if($goods){ 
			        foreach ($goods as $key=>$val){?>	
					<tr>
					    <td><?php echo $val->id;?></td>
						<td><?php echo $val->name;?></td>
						<td><?php echo $val->cate_name;?></td>
						<td><?php echo $val->sub_cate_name;?></td>
						<td><?php echo $val->price;?></td>
						<td><?php echo $val->supplier_name;?></td> 
						<td><?php if($val->status==0){ echo '准备';}else if($val->status=='1'){ echo '上架';}else{ echo '下架';}?></td>
						<td tid="<?php echo $val->id;?>"> 
						      <a href="/store/good_add/<?php echo $val->id;?>">修改</a>&nbsp;&nbsp;|&nbsp;&nbsp;
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
			window.location.href="/store/store_delete/good/" + tid;
		}
	});
	$(".cate_recomment").click(function(){
		var status = $(this).attr('data-id');
		var id = $(this).parents('td').attr('tid');
		var submitData = {id:id,status:status,type:'goods'};
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