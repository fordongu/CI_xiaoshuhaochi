<!DOCTYPE html>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="/resource/css/admin/admin.css" />
<link rel="stylesheet" href="/css/jquery.dataTables.css" />
<script type="text/javascript" src="/resource/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
<title>权限管理</title>

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
 
    $(".delete_events").each(function(){
        $(this).click(function(){ 
                if(!confirm("您确定要删除此条数据吗？")){
 					return false;
                 }
	        var event = $(this).parents("tr");
	        var event_id = event.attr("data_d");
	        
	            var submitData={
		 			tu_id:event_id		 		 
		 		};
	       
		 		 $.post('/admin/user_delete',submitData,function(data){
		 			 alert(data.msg);
		 			 if(data.success=='yes'){
						 window.location.reload();
			 	     }
		 		 }
		 		 ,"json");
        })
    })
    
 })
</script>
	<div class="main-title">
		<h3>权限列表</h3>
	</div>
<div class="tb-toolbar">
		<a href="/admin/authority_add" class="btn btn-small btn-primary">新增</a>	&nbsp;&nbsp;&nbsp;&nbsp;
		  
	</div>		
 
	<table class="table table-hover table-striped" id="catelist">
		<thead>
			<tr> 
				<th>ID</th>
				<th>角色</th>  
				<th>菜单</th> 
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		if ($authority){
		foreach ($authority as $key=>$val){?>
			<tr data_d="<?php echo $val->id;?>">
			    <td><?php echo $val->id;?></td>
			    <td><?php echo $val->role_name;?></td> 
			     <td><?php if ($val->authority){ foreach($val->authority as $k=>$v){echo $oauth_config[$v].'&nbsp;&nbsp;';}}?></td>  
				<td>
				     <a href="/admin/authority_add/<?php echo $val->id;?>">修改</a>&nbsp;&nbsp;|&nbsp;&nbsp;	
				     <a href="Javascript:void(0)" class="delete_events">删除</a>	
				</td>     
			</tr>
			 
		<?php 
          }
		}else {
			echo '暂时没有任何用户';
		}
		?>
			
		
		</tbody>
	</table>
</body>
</html>