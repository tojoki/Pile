$.validator.setDefaults({
	groups:{
		username:"prize_odds prize_base"
	},
	highlight: function(e) {
		$(e).closest(".form-group").removeClass("has-success").addClass("has-error");
	},
	success: function(e) {
		e.closest(".form-group").removeClass("has-error").addClass("has-success");
	},
	errorElement: "div",
	errorPlacement: function(e, r) {
			if (r.attr("name") == "prize_odds" || r.attr("name") == "prize_base") {
				e.appendTo(r.parent().parent().parent());
			}  
			else
			{
				e.appendTo(r.is(":radio") || r.is(":checkbox") ? r.parent().parent().parent() : r.parent().parent());
			}
		
	},
	errorClass: "col-sm-2 help-block m-b-none",
	validClass: "",
});
$().ready(function() {
	
	var e = " ";
	$("#myform").validate({
		submitHandler:function(form){
			
			var odds = parseInt($("#prize_odds").val());
			var base = parseInt($("#prize_base").val());
			if(base < odds){
				alert("中奖率不能大于中奖基数");
				return false;
			}
            form.submit();

        },
		debug:true,
		rules: {			
			title: {
				required: true
			},
			starttime: {
				required:true,
				date:true,
			},
			redpack_coupon_expires: {
				required:true,
				min:1,
			},
			endtime: {
				required:function(){
					var starttime = Date.parse($("#starttime").val().replace(/-/g,"/"));
					var endtime = Date.parse($("#endtime").val().replace(/-/g,"/"));
					
					if(starttime > endtime){
						alert("结束时间不能小于开始时间");
						return false;
					}else{
						return true;
					}
				},
				date:true,
			},
			area:{
				required:true,
			},
			prize_base:{
				required:true,
				min:100,
			},
			prize_odds:{
				required:true,
				min:1,
			},
		},
		messages: {
			
			title: {
				required: e + "请输入活动名称",
			},

		}
	})
});