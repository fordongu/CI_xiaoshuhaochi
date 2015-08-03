<!DOCTYPE html>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="/resource/css/admin/admin.css" />
<link rel="stylesheet" href="/css/jquery.dataTables.css" />
<script type="text/javascript" src="/resource/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
<title>活动管理</title>

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
	        
	            var submitData={
		 			tc_id:event_id		 		 
		 		};
	       
		 		 $.post('/admin/coupon_delete',submitData,function(data){
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
		<h3>活动列表</h3>
	</div>
<div class="tb-toolbar">
		<a href="/admin/event_add" class="btn btn-small btn-primary">新增</a>		 
	</div>		
 
	<table class="table table-hover table-striped" id="catelist">
		<thead>
			<tr>
			    <th>活动名</th> 
				<th>价格</th>
				<th>开始时间</th>
				<th>结束时间</th> 
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		if ($events){
		foreach ($events as $key=>$val){?>
			<tr data_d="<?php echo $val->id;?>">
			
			    <td><?php echo $val->name;?></td>
			    <td><?php echo $val->price;?>元</td> 
			    <td><?php echo $val->start_time;?></td> 
				<td><?php echo $val->end_time;?></td> 
				 
				<td>
				     <a href="/admin/event_add/<?php echo $val->id;?>">修改</a>&nbsp;&nbsp;|&nbsp;&nbsp;	
				     <a href="Javascript:void(0)" class="delete_events">删除</a>	
				</td>     
			</tr>
			 
		<?php 
          }
		}else {
			echo '暂时没有任何活动';
		}
		?>
			
		
		</tbody>
	</table>
</body>
</html>