$.validator.setDefaults({
	highlight: function(e) {
		$(e).closest(".form-group").removeClass("has-success").addClass("has-error")
	},
	success: function(e) {
		e.closest(".form-group").removeClass("has-error").addClass("has-success")
	},
	errorElement: "div",
	errorPlacement: function(e, r) {
		e.appendTo(r.is(":radio") || r.is(":checkbox") ? r.parent().parent().parent() : r.parent().parent())
	},
	errorClass: "col-sm-2 help-block m-b-none",
	validClass: ""
}), 
$().ready(function() {
	
	var e = "<i class='fa fa-times-circle'></i> ";
	$("#myform").validate({
		submitHandler:function(form){

			var starttime = Date.parse($("#starttime").val().replace(/-/g,"/"));
			var endtime = Date.parse($("#endtime").val().replace(/-/g,"/"));
			var now = new Date();
			
			if(starttime > endtime){
				alert("结束时间不能小于开始时间");
				return false;
			}
			if(parseInt($("#cityid").val()) < 1){
				alert("请选择城市");
				return false;
			}
			if(parseInt($("#mid").val()) < 1){
				alert("请选择商家");
				return false;
			}
            form.submit();

        },
		debug:true,
		rules: {			
			title: {
				required: true
			},
			cityid: {
				min:1,
			},
			mid: {
				min:1,
			},
			starttime: {
				required:true,
				date:true,
			},
			redpack_coupon_expires: {
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
			}
		},
		messages: {
			
			title: {
				required: e + "标题不能为空"
			},
			starttime: {
				required: e + "开始时间不能为空"
			},
			redpack_coupon_expires: {
				min: e + "请输入天数"
			},
			endtime: {
				required: e + "结束时间不能为空"
			}

		}
	})
});