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
    
	$("i").click(function(){ 
		var flag = $(this).attr('class');
		var value=0;
		if(flag=='icon-remove'){
			 value= 1; 
		} 
		var $this = $(this);
		var id = $(this).parents('td').attr('tid');
		var submitData = {id:id,value:value,table:'users',field:'tu_status'};
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
		<h3>用户列表</h3>
	</div>
<div class="tb-toolbar">
		<a href="/admin/user_add" class="btn btn-small btn-primary">新增</a>	&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="/admin/data_export/user" class="btn btn-small btn-primary">导出excel</a>	 
	</div>		
 
	<table class="table table-hover table-striped" id="catelist">
		<thead>
			<tr> 
				<th>姓名</th>
				<th>电话</th> 
				<th>性别</th>
				<th>默认写字楼</th>
				<th>默认公司</th>
				<th>类型</th>
				<th>黑名单</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		if ($users){
		foreach ($users as $key=>$val){?>
			<tr data_d="<?php echo $val->tu_id;?>">
			    <td><?php echo $val->tu_nickname;?></td>
			    <td><?php echo $val->tu_mobile;?></td>  
				<td><?php if($val->tu_gender){echo '女';}else{echo '男';}?></td> 
				<td><?php echo $val->building_name;?></td> 
				<td><?php echo $val->tu_company;?></td>  
				<td><?php if($val->tu_source){echo '微信用户';}else{echo '网站用户';}?></td>
				<td tid="<?php echo $val->tu_id;?>"><i <?php if($val->tu_status){?>class="icon-ok" <?php }else{?>class="icon-remove"<?php }?>></i></td>
				<td>
				     <a href="/admin/user_add/<?php echo $val->tu_id;?>">修改</a>&nbsp;&nbsp;|&nbsp;&nbsp;	
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