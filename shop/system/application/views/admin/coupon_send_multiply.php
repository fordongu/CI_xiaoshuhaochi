<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css" media="screen" />
<link rel="stylesheet" href="/resource/css/admin/admin.css" media="screen" />
<link rel="stylesheet" href="/jquery-ui/css/smoothness/jquery-ui-1.10.0.custom.min.css" media="screen" />
<link rel="stylesheet" href="/resource/css/plugin/jquery-ui-timepicker-addon.css" media="screen" />
<link rel="stylesheet" href="/resource/css/admin/appmsg.css" media="screen" />
<link rel="stylesheet" href="/resource/css/admin/coupon-setting.css" media="screen" />
<link rel="stylesheet" href="/jquery-ui/css/uploadify.css" media="screen" />
<script type="text/javascript" src="/resource/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/resource/js/plugin/operamasks-ui.min.js"></script>
<script type="text/javascript" src="/jquery-ui/js/jquery-ui-1.10.0.custom.min.js"></script> 
<title>批量优惠券发放</title>
<style>
label{
	display: inline-block;
}
.help-inline{
	vertical-align: top;
}
.row{
	padding-top: 20px;
	padding-bottom: 20px;
}
</style>
</head>
<script>
 $(function(){
 
var validator = $("#appmsg-form").validate({
			rules: {
				 
				count:{required:true}
			},
			messages: {
				 
				count:{required:"发放张数必填"}
			},
			showErrors: function(errorMap, errorList) {
				if (errorList && errorList.length > 0) {
					$.each(errorList,
					function(index, obj) {
						var item = $(obj.element);
						if(item.is(".cover")){
							alert(obj.message);
						}
						// 给输入框添加出错样式
						item.closest(".control-group").addClass('error');
						item.attr("title",obj.message);
					});
				} else {
					var item = $(this.currentElements);
					item.closest(".control-group").removeClass('error');
					item.removeAttr("title");
				}
			}
		}); 

	$('#service_buildings').change(function(){
		    var building_id = $(this).val();
		     
	      var submitData = {building_id:building_id};
	      $.post('/admin/ajax_get_company_by_building', submitData,function(data) { 
				if (data.success == 'yes') { 
				    
				    if (data.company) {  
					    var company = data.company;
					    var strs = ''; 
					    for(var i=0;i<company.length;i++){
					    	strs+="<input type='checkbox' class='company_checkbox' value='"+company[i].id+"' name='company[]'>"+company[i].name+"&nbsp;&nbsp;&nbsp;&nbsp;";	
					    }
					    strs+="&nbsp;&nbsp;&nbsp;&nbsp;<span onclick='check_all(this)' data_id='0' style='cursor:pointer;'>全选</span";
					    $('#company_div').html(strs);   						    
					}else{
						alert(data.msg);
					}
				} 
				
				
			},"json");		     
 	})

	 	 
 })
   
    function check_all(span){
	     
		var flag = $(span).attr('data_id');
		if(flag == 0){
			$(span).attr('data_id',1);
			$('.company_checkbox').attr('checked',true);
	    }else{
	    	$(span).attr('data_id',0);
	    	$('.company_checkbox').attr('checked',false);
		}
 	}
</script>
<body>
	<div class="row">

		<div class="span7">
			<div class="msg-editer-wrapper">
				<div class="msg-editer">
					<form id="appmsg-form" class="form" method="post" action="/admin/coupon_send_multiply">
						 
					  	 
						<div class="control-group">
						<label class="control-label">写字楼</label>    
						    <div class="controls">
						      <select name="service_buildings" id="service_buildings">
						         <option value=''>请选择</option>
						        <?php foreach($buildings as $k=>$v){?>
						          <option value='<?php echo $v->id;?>'><?php echo $v->name;?></option>
						        <?php }?> 
							  </select>	 
							</div>
						</div> 
						
						<div class="control-group">
						<label class="control-label">公司</label>    
						    <div class="controls" id="company_div">
						       
							</div>
						</div> 
						
						<div class="control-group">
						<label class="control-label">优惠券类型</label>    
						    <div class="controls">
								<select name="coupon_id" id="coupon_id">
								   <?php foreach($coupons as $k=>$v){?>
								      <option value="<?php echo $v->tc_id;?>" ><?php echo $coupons_types[$v->tc_title];?></option>
								   <?php }?>
								</select>
							</div>
						</div>  
						
						<div class="control-group">
						<label class="control-label">发放张数</label>    
						    <div class="controls">
								<input type="text" name="count" id="count"  value="" />
							</div>
						</div>  
					  	<div class="control-group">
						    <div class="controls">
						      <button id="save-btn" type="submit" class="btn btn-primary btn-large">保存</button>
						      <button id="cancel-btn" type="button" class="btn btn-large">取消</button>
						   </div>
					    </div>
					</form> 
				</div>
				<span class="abs msg-arrow a-out" style="margin-top: 0px;"></span>
				<span class="abs msg-arrow a-in" style="margin-top: 0px;"></span>
			</div>
		</div>
	</div>
</body>
</html>