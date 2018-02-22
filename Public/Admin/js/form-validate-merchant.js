
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
	$(".merForm").validate({
		submitHandler:function(form){
			if($("#merPhoto").val() == '') {
				layer.msg("请上传商家图片",{skin:"layui-layer-hui",shade: [0.5, '#000'],shadeClose:true});
				return false;
			}
			if(parseInt($("#cityid").val()) < 1){
				layer.msg("请选择城市",{skin:"layui-layer-hui",shade: [0.5, '#000'],shadeClose:true});
				return false;
			}
			form.submit();
        },
		debug:true,
		rules: {			
			merTitle: {
				required: true
			},
			merAddress: {
				required:true
			},
			merTel: {
				required:true
			},
			merDes: {
				required:true
			},
		},
		messages: {
			
			merTitle: {
				required: "请输入商家名称"
			},
			merAddress: {
				required:  "请输入商家地址"
			},
			merTel: {
				min: "请输入商家电话"
			},
			merDes: {
				required: "请输入商家信息"
			},
			
		}
	})
});