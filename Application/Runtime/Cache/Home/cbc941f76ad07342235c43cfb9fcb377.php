<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<title>地址管理</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="format-detection" content="telephone=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="stylesheet" href="/lawyer/Public/Home/css/reset.css">
	<link rel="stylesheet" href="/lawyer/Public/Home/css/lawyer.css">
	<script src="/lawyer/Public/Home/js/jquery-1.9.1.min.js"></script>
	<script src="/lawyer/Public/Home/js/public.js"></script>
	<!--<script src="/lawyer/Public/Home/js/lawyer.js"></script>-->
</head>
<body class="bg_white bgf8">
	<header class="bar_nav">
		<a class="icon_left fl" onclick="location.href='/lawyer/Home/Setting/index'"></a>
		<h1 class="title">地址管理</h1>
	</header>
	<section class="section pad_bot17">
	<?php
 foreach($addressList as $v){ ?>
		<ul class="attor_site">
			<li><span>收货人：<?php echo ($v["uname"]); ?></span><span><?php echo ($v["mobile"]); ?></span></li>
			<li><strong>收货地址：<?php echo ($v["area"]); echo ($v["detail"]); ?></strong></li>
			<li class="attor_site_li">
				<div>
					<span class="click_te1 <?=$v['isdefault']==1?'click_texi':'';?> "></span>默认地址
				</div>
				<div>
					<span class="click_te2"><img src="/lawyer/Public/Home/images/att_03.png" alt="删除"></span>
					<input name='addrid' value="<?php echo ($v["addrid"]); ?>" type='hidden'>
					<span class="click_te3"><img src="/lawyer/Public/Home/images/att_04.png" alt="编辑"></span>
				</div>
			</li>
		</ul>
	<?php
 } ?>
		<div class="log_out log_fix">
			<button onclick="location.href='/lawyer/Home/Setting/addAddress'"><i class="new_address"></i>添加新地址</button></div>
		<div class="dialog_overlay">
			<div class="address_Capacity">
				<div class="address_Capacity_deta">您确认删除吗</div>
				<div class="address_Capacity_dis"><button class="confirm">确定</button><button class="calloff">取消</button></div>
			</div>
		</div>
	</section>
</body>
<script type="text/javascript">
$(function(){
	//   input 只可输入数字英文
	$(".phonenub").bind("blur focus keydown keyup",function(){
		$(this).val($(this).val().replace(/\D/gi,""));
	});


	$('.click_te1').click(function(){   //  选择默认地址
		//如果已经是默认地址 那就不操作
		if($(this).hasClass('click_texi')){
			return false;
		}else{
			var addrid=$(this).parent().next().children().eq(1).val();
			$.ajax({
				url:'/lawyer/Home/Setting/address',
				data:'addrid='+addrid,
				type:'post',
				success:function(data){
					if(data.status){
						// location.reload();
						$('input[name=addrid][value='+addrid+']').parent().prev().children().eq(0).parents('.attor_site').siblings().find('.click_te1').removeClass('click_texi');
						$('input[name=addrid][value='+addrid+']').parent().prev().children().eq(0).toggleClass('click_texi');
					}
				},
				dataType:'json'
			});
			// $(this).parents('.attor_site').siblings().find('.click_te1').removeClass('click_texi');
			// $(this).toggleClass('click_texi');
		}
		
	})
	$('.click_te2').click(function(){   //  删除地址
		var addrid=$(this).next().val();
		$('.dialog_overlay').show();
		var $this_s = $(this)
		//   确定 删除地址
		$('.confirm').click(function(){  
			$.ajax({
				url:'/lawyer/Home/Setting/delAddress',
				data:'addrid='+addrid,
				type:'post',
				success:function(data){
					if(data.status){
						$('.dialog_overlay').hide();
						location.reload();
					}else{
						alert(data.info);
					}
				},
				dataType:'json'
			});
			
			// $this_s.parents('.attor_site').remove();

		})
	})

	$('.calloff').click(function(){   //   取消
		$('.dialog_overlay').hide();
	})

	//编辑
	$('.click_te3').click(function(){   //  编辑
		var addrid=$(this).prev().val();
		location.href='/lawyer/Home/Setting/editAddress?addrid='+addrid;
	})
});





</script>
</html>