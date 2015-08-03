$(function(){
	$(".summary1").html($.htmlEncode( $("#summary1").val() ));
	$(".summary2").html($.htmlEncode( $("#summary2").val() ));
	
	//有些活动并没有summary3
	if($("#summary3").length == 1){
		$(".summary3").html($.htmlEncode( $("#summary3").val() ));
	}
	$('#startDate').datetimepicker();
	$('#endDate').datetimepicker();
	
	$('input.file_upload').each(function(){
		var $fileInput = $(this);
		var $cont =  $fileInput.closest(".cont");
		var name = $fileInput.attr("name");
		$fileInput.uploadify({			 
			'swf'      : '/resource/swf/uploadify.swf',
			'uploader' : '/uploads.php',
			'onUploadSuccess' : function(file,data,response)  {
				var jsonData = eval("("+data+")");
				
				$(".cover .i-img",$cont).attr("src",jsonData.fileUrl).show();
				$(".img-area",$cont).show().find(" #img").attr("src",jsonData.fileUrl);
				$(".tad_image",$cont).val(jsonData.fileUrl);
				$(".default-tip",$cont).hide();
				
		    }
		 
		});
	});
	
	
	 $(".title").bind("keyup",function(){
		 var $input = $(this);
		 var $cont =  $input.closest(".cont");
		 $(".i-title",$cont).text($input.val());
	 });
	 $(".msg-txta").bind("keyup",function(){
		 var $input = $(this);
		 var $cont =  $input.closest(".cont");
		 $(".msg-text",$cont).html($.htmlEncode($input.val()));
	 });
	 $(".cover-del").click(function(){
		var $cont =  $(this).closest(".cont");
		$(".default-tip",$cont).show();
		$(".img-area",$cont).hide();
		$(".cover",$cont).val("");
		$(".cover .i-img",$cont).hide();
	 });
		$.validator.addMethod("afterDate", function(value) {
			var $startDate = $("input[name='startDate']");
			var $endDate = $("input[name='endDate']");
			$startDate.datetimepicker('setDate',$startDate.val());
			$endDate.datetimepicker('setDate',$endDate.val());
		    return $endDate.datetimepicker('getDate') > $startDate.datetimepicker('getDate');
		}, '结束时间必须大于开始时间');
		$.validator.addMethod("startDate", function(value) {
			var $startDate = $("input[name='startDate']");
			var $endDate = $("input[name='endDate']");
			$startDate.datetimepicker('setDate',$startDate.val());
			$endDate.datetimepicker('setDate',$endDate.val());
			var tt = $startDate.datetimepicker('getDate') - new Date();
			return (tt/(1000*60)) > 15;
		}, '开始时间必须在15分钟以后');
		$.validator.addMethod("checkTotalPeople", function(value) {
			var totalPeople = $("input[name='totalPeople']").val();
			var totalPrize = parseInt($("input[name='amount1']").val()) + parseInt($("input[name='amount2']").val()) + parseInt($("input[name='amount3']").val()); 
			return parseInt(totalPeople) > totalPrize;
		}, '参加抽奖的总人数必须大于所有奖品的总数');
});