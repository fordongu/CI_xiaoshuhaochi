$(function(){
	 var validator = $("#couponform").validate({
		 	onfocusout: false,
			rules: {
				title1: {required: true,maxlength: 64},title2: {required: true,maxlength: 64},title3: {required: true,maxlength: 64},
				cover1: {required: true},cover2: {required: true},cover3: {required: true},
				startDate:{required:true,startDate:true},endDate:{required:true,afterDate:true},amount:{required:true,number:true,range:[1,1000]},
				keyword: {required: true,maxlength: 64},repeatTips: {required: true,maxlength: 64},nostartTips: {required: true,maxlength: 64}
			},
			messages: {
				title1: {required: "不能为空",maxlength: "不能超过64个字"},title2: {required: "不能为空",maxlength: "不能超过64个字"},title3: {required: "不能为空",maxlength: "不能超过64个字"},
				cover1: {required: "必须插入一张活动图片"},cover2: {required: "必须插入一张中奖公告图片"},cover3: {required: "必须插入一张发放完毕通知图片"},
				startDate:{required:"不能为空"},endDate:{required:"不能超过64个字"},amount:{required: "不能为空",number:"必须是数字",range:$.validator.format("数量必须是大于{0}且小于{1}.")},
				keyword: {required: "不能为空",maxlength: "不能超过64个字"},repeatTips: {required: "不能为空",maxlength: "不能超过64个字"},nostartTips: {required: "不能为空",maxlength: "不能超过64个字"}
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
			},
			submitHandler: function() {
				var $form = $("#couponform");
				var $btn = $("#save-btn");
				if($btn.hasClass("disabled")) return;
				var submitData = {
						activityname: $("input[name='activityName']", $form).val(),
						title1: $("input[name='title1']", $form).val(),
						title2: $("input[name='title2']", $form).val(),
						title3: $("input[name='title3']", $form).val(),
						cover1: $("input[name='cover1']", $form).val(),
						cover2: $("input[name='cover2']", $form).val(),
						cover3: $("input[name='cover3']", $form).val(),
						summary1: $("textarea[name='summary1']", $form).val(),
						summary2: $("textarea[name='summary2']", $form).val(),
						summary3: $("textarea[name='summary3']", $form).val(),
						startDate: $("input[name='startDate']", $form).val(),
						endDate: $("input[name='endDate']", $form).val(),
						keyword: $("input[name='keyword']", $form).val(),
						amount: $("input[name='amount']", $form).val(),
						repeatTips: $("input[name='repeatTips']", $form).val(),
						nostartTips: $("input[name='nostartTips']", $form).val(),
						action: $("input[name='action']", $form).val(),
						aid: $("input[name='aid']", $form).val(),
						wuid: $("input[name='wuid']", $form).val(),
						type: $("input[name='type']", $form).val()
				};

				$btn.addClass("disabled");
				
				$.post('/main/coupon_setting', submitData,function(data) {
					
					$btn.removeClass("disabled");
					if(data.error == "invalid"){
						alert("非法操作");
						window.location.href = "/main/markets_lists";
						return;
					}
					if(data.error == "keyword"){
						alert("关键词已被使用或包含其他活动已设置关键词，请重新设置活动关键词");
						$("input[name='keyword']").focus();
						return;
					}
					if(data.error == "status"){
						alert("活动已开始，不能修改");
						window.location.href = "/main/markets_lists";
						return;
					}
					if (data.success == "yes") {
						alert("保存成功");
						window.location.href = "/main/markets_lists";
					}  else{
						alert("保存失败");
					}
				},"json");
				return false;
			}
		});
});