<!DOCTYPE html>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="<?php echo base_url();?>css/bootstrap.css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>resource/css/admin/admin.css" media="screen" />
<script type="text/javascript" src="<?php echo base_url();?>resource/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>bootstrap/js/bootstrap.min.js"></script>
<title>多图文回复列表</title>
 
</head>
<body>
<script>
  $(function(){
 
	  $(".delete").each(function(){
         $(this).click(function(){
            var question_id = $(this).attr("data-id");
            if(confirm("您确认要删除这个用户吗？")){
           	 	var url = "/main/material_delete/multiply/"+question_id;
				location.href = url;
            }else{
				return false;
            }
         })
	  })

	  $("#search_code").click(function(){
			var title = $("#title").val(); 
			var submitData= {title:title};
			$.post('/main/multiply_list/<?php echo $current_page;?>',submitData,function(data){
	        	 
				if(data.success=="no")
				{
	                alert(data.msg);
				}else{
						window.location.reload();
			    } 
				  
				
			},"json"); 
		});


	    $("#reset_code").click(function(){
			 
	    	var submitData= {title:''};
			$.post('/main/multiply_list/<?php echo $current_page;?>',submitData,function(data){
	        	 
				if(data.success=="no")
				{
	                alert(data.msg);
				}else{
						window.location.reload();
			    } 
				  
				
			},"json");
			 
		});
 
  })
</script>
	<div class="main-title">
		<h3>多图文回复列表</h3>
	</div>
		<div id="sn_form" class="form-horizontal">
			<div class="control-group">
		    	<div class="controls">
		    	标题：<input type="text" name="title" id="title" value='<?php echo $title;?>' />
			    	 
			    	<button class="btn btn-primary" id="search_code">查询</button>
			    	<button class="btn btn-primary" id="reset_code">重置</button>
		    	</div>
		  	</div>
		</div>		 
<div class="pagination">
  <ul>

     <?php if($current_page=='1'){?><li class="disabled" ><span>上一页</span></li>
     <?php }else{?>
     <li><a href="/main/multiply_list/<?php echo $current_page-1;?>">上一页</a></li>
     <?php }?>
    <?php for ($i=1;$i<=$total;$i++){?>
       <?php if($current_page==$i){?><li class="active"><span><?php echo $i;?></span></li><?php }else{?>
       <li><a href="/main/multiply_list/<?php echo $i;?>"><?php echo $i;?></a></li><?php }?>
    <?php }?>
    <?php if ($current_page==$total){?>
    <li class="disabled"><span>下一页</span></li>
    <?php }else{?>
     <li><a href="/main/multiply_list/<?php echo $current_page+1;?>">下一页</a></li>
     <?php }?>
  </ul>
  
</div>
<div class="tb-toolbar">
		<a href="/main/multiply_materials" class="btn btn-small btn-primary">新增</a>		 
	</div>
	<table class="table table-hover table-striped">
		<thead>
			<tr>
				<th>回复标题</th>
				<th>回复关键字</th> 
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($materials as $key=>$val){?>
			<tr>
				<td><?php echo $val->tm_title;?></td>
				<td><?php echo $val->tm_keyword;?></td>
				<td><a href="/main/multiply_materials/<?php echo $val->tm_id;?>">编辑</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:void(0)" class="delete" data-id="<?php echo $val->tm_id;?>">删除</a></td>
				 
			</tr>
		<?php }?>
			
		
		</tbody>
	</table>
	<div class="tb-toolbar">
		<a href="/main/multiply_materials" class="btn btn-small btn-primary">新增</a>		 
	</div>
	

<div class="pagination">
  <ul>

     <?php if($current_page=='1'){?><li class="disabled" ><span>上一页</span></li>
     <?php }else{?>
     <li><a href="/main/multiply_list/<?php echo $current_page-1;?>">上一页</a></li>
     <?php }?>
    <?php for ($i=1;$i<=$total;$i++){?>
       <?php if($current_page==$i){?><li class="active"><span><?php echo $i;?></span></li><?php }else{?>
       <li><a href="/main/multiply_list/<?php echo $i;?>"><?php echo $i;?></a></li><?php }?>
    <?php }?>
    <?php if ($current_page==$total){?>
    <li class="disabled"><span>下一页</span></li>
    <?php }else{?>
     <li><a href="/main/multiply_list/<?php echo $current_page+1;?>">下一页</a></li>
     <?php }?>
  </ul>
</div>
</body></html>