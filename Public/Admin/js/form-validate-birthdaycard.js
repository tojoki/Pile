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

            form.submit();

        },
		debug:true,
		rules: {			
			title: {
				required: true
			},
			year: {
				required:true
			},
			
		},
		messages: {
			
			title: {
				required: e + "标题不能为空"
			},
			year: {
				required: e + "年份请选择"
			},
			

		}
	})
});