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
            form.submit();
        },
		debug:true,
		rules: {			
			goodsName: {
				required: true
			},
			price: {
				required:true,
				number:true,
			},
			marketprice: {
				required:true,
				number:true,
			},
		},
		messages: {
			goodsName: {
				required: e + "请输入商品名称",
			},

		}
	})
});