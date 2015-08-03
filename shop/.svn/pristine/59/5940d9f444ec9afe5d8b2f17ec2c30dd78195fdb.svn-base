<!DOCTYPE html>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="/resource/css/admin/admin.css" />
<link rel="stylesheet" href="/css/jquery.dataTables.css" />
<script type="text/javascript" src="/resource/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
<title>用户管理</title>

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
	        window.location.href='/admin/store_delete/company/'+event_id; 
        })
    })
    
 })
</script>
	<div class="main-title">
		<h3>用户列表</h3>
	</div>
<div class="tb-toolbar">
		<a href="/admin/company_add" class="btn btn-small btn-primary">新增</a>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="/admin/data_export/company" class="btn btn-small btn-primary">导出excel</a>		 
	</div>		
 
	<table class="table table-hover table-striped" id="catelist">
		<thead>
			<tr>
			  
				<th>公司名</th>
				<th>省</th>
				<th>市</th>
				<th>区</th>
				<th>配送区域</th>
				<th>开发时间</th>
				<th>状态</th> 
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		if ($companys){
		foreach ($companys as $key=>$val){?>
			<tr data_d="<?php echo $val->id;?>">
			    
			    <td><?php echo $val->name;?></td> 
				<td><?php echo $val->province;?></td> 
				<td><?php echo $val->city;?></td> 
				<td><?php echo $val->area;?></td> 
				<td><?php echo $val->building_name;?></td>  
				<td><?php echo $val->develop_time;?></td>
				<td><?php if($val->status){ echo '供应中';}else{ echo '开发中';}?></td>
				<td>
				     <a href="/admin/company_add/<?php echo $val->id;?>">修改</a>&nbsp;&nbsp;|&nbsp;&nbsp;	
				     <a href="Javascript:void(0)" class="delete_events">删除</a>	
				</td>     
			</tr>
			 
		<?php 
          }
		}else {
			echo '暂时没有任何公司';
		}
		?>
			
		
		</tbody>
	</table>
</body>
</html>