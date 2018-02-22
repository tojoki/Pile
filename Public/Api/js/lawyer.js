//   st
$(function(){
	//   input 只可输入数字英文
	$(".phonenub").bind("blur focus keydown keyup",function(){
		$(this).val($(this).val().replace(/\D/gi,""));
	});


	$('.click_te1').click(function(){   //  选择默认地址
		$(this).parents('.attor_site').siblings().find('.click_te1').removeClass('click_texi');
		$(this).toggleClass('click_texi');
	})
	$('.click_te2').click(function(){   //  删除地址
		$('.dialog_overlay').show();
		var $this_s = $(this)
		//   确定 删除地址
		$('.confirm').click(function(){  
			$('.dialog_overlay').hide();
			$this_s.parents('.attor_site').remove();
		})
	})

	$('.calloff').click(function(){   //   取消
		$('.dialog_overlay').hide();
	})

	//  3_我的_5设置_6意见反馈   提交
	$('.couple_back_mbox').on('click',function(){
		$('.dialog_overlay').show();
	})
























});   //   end





















