$(function(){
	 var validator = $("#lottoform").validate({
		 	onfocusout: false,
			rules: {
				title1: {required: true,maxlength: 64},title2: {required: true,maxlength: 64},
				cover1: {required: true},cover2: {required: true},
				startDate:{required:true,startDate:true},endDate:{required:true,afterDate:true},
				keyword: {required: true,maxlength: 64},repeatTips: {required: true,maxlength: 64},
				prize1: {required: true,maxlength: 50},prize2: {required: true,maxlength: 50},prize3: {required: true,maxlength: 50},
				amount1:{required: true,number:true,range:[1,500]},amount2:{required: true,number:true,range:[1,500]},amount3:{required: true,number:true,range:[1,500]},
				totalPeople:{required: true,number:true,range:[1,500000],checkTotalPeople:true},
				playtotal:{required:true,number:true,range:[1,100000]},playperday:{required:true,number:true,range:[1,100000],checkPlayPerday:true}
			},
			messages: {
				title1: {required: "不能为空",maxlength: "不能超过64个字"},title2: {required: "不能为空",maxlength: "不能超过64个字"},
				cover1: {required: "必须插入一张活动图片"},cover2: {required: "必须插入一张中奖公告图片"},
				startDate:{required:"不能为空"},endDate:{required:"不能超过64个字"},amount:{required: "不能为空",number:"必须是数字",range:$.validator.format("数量必须是大于{0}且小于 {1}.")},
				keyword: {required: "不能为空",maxlength: "不能超过64个字"},repeatTips: {required: "不能为空",maxlength: "不能超过64个字"},
				prize1: {required: "不能为空",maxlength: "不能超过50个字"},prize2: {required: "不能为空",maxlength: "不能超过50个字"},prize3: {required: "不能为空",maxlength: "不能超过50个字"},
				amount1:{required: "不能为空",number:"必须是数字",range:$.validator.format("数量必须是大于{0}且小于 {1}.")},
				amount2:{required: "不能为空",number:"必须是数字",range:$.validator.format("数量必须是大于{0}且小于 {1}.")},
				amount3:{required: "不能为空",number:"必须是数字",range:$.validator.format("数量必须是大于{0}且小于 {1}.")},
				totalPeople:{required: "不能为空",number:"必须是数字",range:$.validator.format("数量必须是大于{0}且小于 {1}.")},
				playtotal:{required:"不能为空",number:"必须是数字",range:$.validator.format("数量必须是大于{0}且小于 {1}.")},
				playperday:{required:"不能为空",number:"必须是数字",range:$.validator.format("数量必须是大于{0}且小于 {1}.")}
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
				var $form = $("#lottoform");
				var $btn = $("#save-btn");
				if($btn.hasClass("disabled")) return;
				var submitData = {
						activityname: $("input[name='activityName']", $form).val(),
						title1: $("input[name='title1']", $form).val(),
						title2: $("input[name='title2']", $form).val(),
						cover1: $("input[name='cover1']", $form).val(),
						cover2: $("input[name='cover2']", $form).val(),
						summary1: $("textarea[name='summary1']", $form).val(),
						summary2: $("textarea[name='summary2']", $form).val(),
						startDate: $("input[name='startDate']", $form).val(),
						endDate: $("input[name='endDate']", $form).val(),
						keyword: $("input[name='keyword']", $form).val(),
						amount1: $("input[name='amount1']", $form).val(),
						amount2: $("input[name='amount2']", $form).val(),
						amount3: $("input[name='amount3']", $form).val(),
						totalPeople: $("input[name='totalPeople']", $form).val(),
						prize1: $("input[name='prize1']", $form).val(),
						prize2: $("input[name='prize2']", $form).val(),
						prize3: $("input[name='prize3']", $form).val(),
						playtotal: $("input[name='playtotal']", $form).val(),
						playperday: $("input[name='playperday']", $form).val(),
						repeatTips: $("input[name='repeatTips']", $form).val(),
						action: $("input[name='action']", $form).val(),
						aid: $("input[name='aid']", $form).val(),
						wuid: $("input[name='wuid']", $form).val(),
						type: $("input[name='type']", $form).val()
				};
				$btn.addClass("disabled");
				$.post('/main/lottery_setting', submitData,function(data) {
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
					if(data.error == "statu"){
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
		$.validator.addMethod("checkPlayPerday", function(value) {
			var playtotal = $("input[name='playtotal']").val();
			return parseInt(playtotal) >= value;
		}, '每人每天可以重复刮奖的次数不能大于每人可以参与刮奖的总次数');
});