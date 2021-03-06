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
<script type="text/javascript" src="/js/admin_manage.js"></script>
<title>供应商管理</title>
</head>
<body>

	<div>	
		<h3>供应商管理</h3>	 
		<div class="tb-toolbar">		
			<a href="/store/supplier_add" class="btn btn-small btn-primary">新增供应商</a>
				&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="/admin/data_export/supplier" class="btn btn-small btn-primary">导出excel</a>	
		</div>
		<br/>
		<table class="table table-bordered" id="catelist">
			<thead>
				<tr>
					<th>供应商名</th>
					<th>开业时间</th>
					<th>菜品</th>			 
					<th>地址</th>
					<th>状态</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			   if($supplier){ 
                            
			        foreach ($supplier as $key=>$val){?>	
					<tr>
						<td><?php echo $val->name;?></td>
						<td><?php echo $val->open_time;?></td>
					 
						<td><?php echo $val->cates;?></td>
						<td><?php echo $val->address;?></td>
						<td><?php if($val->status){echo '营业';}else{ echo '停业';}?></td> 
                                                
						<td>
						    <a href="/store/supplier_add/<?php echo $val->id;?>">修改</a>&nbsp;&nbsp;|&nbsp;&nbsp;
							<a href="javascript:void(0)" class="cate_del" date_supplier_id="<?php echo $val->id;?>">删除</a>
						</td>
					</tr>
			   <?php } }?>	
			</tbody>
		</table>			
		
 <script type="text/javascript">
$(function(){
	
	$('#catelist').dataTable({	   
	      "oLanguage": {//语言国际化
	        "sUrl": "/js/jquery.dataTable.cn.txt"
	      },
	    });
});    
</script>    
</body>	
</html>