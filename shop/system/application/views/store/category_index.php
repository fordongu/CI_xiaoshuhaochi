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
<title>类别管理</title>
</head>
<body>
 
		<h3>类别管理</h3>	
    <div class="tb-toolbar">		
		<a href="/store/category_add/0" class="btn btn-small btn-primary">新增大类</a>
		 
	</div><br/> 
		<table class="table table-bordered" id="catelist">
			<thead>
				<tr>
					<th>类别名</th> 
					<th>父类别</th>
					<th>星期开关</th>
					<th>星期</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			   if (!empty($categorys)){
			      foreach ($categorys as $key=>$val){?>	
					<tr>
						<td><?php echo $val->name;?></td> 
						<td><?php if ($val->pname){echo $val->pname;}else{echo '-';}?></td> 
						<td tid="<?php echo $val->id;?>"><i <?php if($val->status){?>class="icon-ok" <?php }else{?>class="icon-remove"<?php }?>></i></td>
						<td><?php echo $val->weeks;?></td>
						<td tid="<?php echo $val->id;?>">
						    <?php if ($val->pid==0){?><a href="/store/category_add/<?php echo $val->id;?>/">新增小类</a>&nbsp;&nbsp;|&nbsp;&nbsp;<?php }?>
							<a href="/store/category_add/<?php echo $val->pid;?>/<?php echo $val->id;?>">修改</a>&nbsp;&nbsp;|&nbsp;&nbsp;
							<a href="javascript:void(0)" class="cate_del">删除</a>
						</td>
						 
					</tr>
			   <?php }
			   }else{?>
			   	  <tr><td colspan="3">没有任何记录</td></tr> 
			  <?php }
			   ?>	
			</tbody>
		</table>			
  
<script type="text/javascript">
$(function(){
	
	$('#catelist').dataTable({	   
	      "oLanguage": {//语言国际化
	        "sUrl": "/js/jquery.dataTable.cn.txt"
	      },
	      "aoColumnDefs": [
{
 sDefaultContent: '',
 aTargets: [ '_all' ]
  }
],
	    });
	$("#catelist").delegate(".cate_del","click",function(){
		if(confirm("确认删除这个类别吗？")){
			var tid = $(this).closest("td").attr("tid");
			window.location.href="/store/store_delete/category/" + tid;
		}
	});

	$("i").click(function(){ 
		var flag = $(this).attr('class');
		var value=0;
		if(flag=='icon-remove'){
			 value= 1; 
		} 
		var $this = $(this);
		var id = $(this).parents('td').attr('tid');
		var submitData = {id:id,value:value,table:'categorys',field:'status'};
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

	
});

</script>
</body>	
</html>