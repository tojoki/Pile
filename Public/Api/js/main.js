$(function(){

	//显示隐藏密码
	var password=document.getElementById("pwd");
	var eyes=document.getElementById("eyes");
	$("#eyes").on("click",function(){
		var state = this.getAttribute("state");
		if(state==="off"){
			password.setAttribute("type", "text");
       		eyes.setAttribute("state", "on");
		}else{
			password.setAttribute("type", "password");
       		eyes.setAttribute("state", "off");
		}
	});
	//确认密码显示隐藏
	var cpwd=document.getElementById("config_pwd");
	var ceyes=document.getElementById("conf_eyes");
	$("#conf_eyes").on("click",function(){
		var state = this.getAttribute("state");
		if(state==="off"){
			cpwd.setAttribute("type", "text");
       		ceyes.setAttribute("state", "on");
		}else{
			cpwd.setAttribute("type", "password");
       		ceyes.setAttribute("state", "off");
		}
	});
	//删除密码
	$(".clear_input").on("click",function(){
		$("#pwd").val("").focus();
    	$(this).hide();
	});
	//记住密码
	$(".rem_pwd").on("click","input",function(){
		$(this).toggleClass("rem_checkon");
	});
	//选择事件类型
	$(".event_list>li>span").on("click",function(){
		$(this).parent().addClass("active").siblings().removeClass("active");
		$(this).next('.modal_bg').show().parent().siblings('li').find('.modal_bg').hide();

		$(".secend_types").on("click","li",function(){
			var $span=$(this).find("a");
			$(this).addClass("active").siblings().removeClass("active").
				parents(".modal_bg").hide().prev("span").text($span.text());
		});
		$(".modal_bg").on("click",function(){

			$(this).hide();
		});
	});
	//选择执业时间
	$(".address_input").on("click","#layer_time",function(){
		$(".refer_block").show();
		$(".practice_time").on("click","li",function(){
			$(this).addClass("active").siblings().removeClass("active");
			var $time=$("#layer_time");
			var $em=$(".practice_time li.active").find("em");
			$time.val($em.text());
			$(".call_layer").find("a").removeClass("dis_gray");
		});
	});
	//选择支付方式
	$(".cost_type").on("click",function(){
		$(this).find("em").addClass("check_icon");
	});

	//选择优惠券
	$(".coupan_list").on("click",".coupan_checkofbg",function(){
		$(this).toggleClass("coupan_checkonbg").find("i").addClass("check_coupan");
		$(".config_check").css("opacity","1");
		var $decut=$(".decut_hide").find("em");
		sum();
	});
	function sum(){
		var sm=0;
		$('.coupan_price').each(function(){
			if($(this).parents('div').hasClass('coupan_checkonbg')){
				sm=Number(sm)+Number($(this).find('em').html());
			}
			$('.decut_hide').find('em').html(sm);
		})
	}
	//星级评价
	$(".stars_block").click(function(){
		$(".please_evalut").text("您的任何评价都会被严格匿名");
		$(".evalut_content").show();
		$(".evalut_btns a:eq(1)").show();
		$(".evalut_btns a:last-child").addClass("newwork");

	});
	//更多
	$(".more_title").on("click",function(){
		$(".more_modal").fadeIn();
	});
	//输入手机号--领取优惠券button可编辑
	$(".accept_input").on("input",function(){
	  if($(this).val().trim().length){
	    $(".login_submit").removeClass("dis_gray");
	  }else{
	  	$(".login_submit").addClass("dis_gray");
	  }
	});
	//定位弹框 取消
	$(".setup_btn").on("click","a",function(){
		$(".dialog_modal").fadeOut();
	});
	//拨打电话
	$(".call_btn").on("click",function(){
		$(".dialog_modal").fadeIn();
	});
		



	
	















});