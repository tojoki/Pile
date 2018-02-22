
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
			if($("#thumb").val() == '') {
				layer.msg("请上传图片",{skin:"layui-layer-hui",shade: [0.5, '#000'],shadeClose:true});
				return false;
			}
			if($("#mid").val() == 0) {
				layer.msg("请选择商家",{skin:"layui-layer-hui",shade: [0.5, '#000'],shadeClose:true});
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
			mid:{
				required: true
			},	
			title: {
				required: true
			},
			recommend: {
				required:true
			},
			notice: {
				required:true
			},
			fromUrl: {
				required:true,
				url:true,
			}
		},
		messages: {
			
			title: {
				required: e+"请输入活动标题"
			},
			recommend: {
				required:  e+"请输入活动介绍"
			},
			notice: {
				required: e +"请输入抢购须知"
			},
			fromUrl: {
				required: e+"请输入活动链接"
			},
			
		}
	})
});