<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<title>意见反馈</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="format-detection" content="telephone=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="stylesheet" href="/lawyer/Public/Home/css/reset.css">
	<link rel="stylesheet" href="/lawyer/Public/Home/css/lawyer.css">
	<script src="/lawyer/Public/Home/js/jquery-1.9.1.min.js"></script>
	<script src="/lawyer/Public/Home/js/public.js"></script>
	<script src="/lawyer/Public/Home/js/lawyer.js"></script>
</head>
<body class="bg_white bgf8">
	<header class="bar_nav">
		<a class="icon_left fl" onclick="location.href='/lawyer/Home/Setting/index'"></a>
		<h1 class="title">意见反馈</h1>
	</header>
	<section class="section">
		<div class="couple_back">
			<textarea name='feedback' placeholder="请输入您的建议或意见..."></textarea>
		</div>
		<div class="couple_back_mbox"><button>确认提交</button></div>
	</section>
	<div class="dialog_overlay">
		<div class="address_Capacity">
			<div class="address_Capacity_deta">恭喜您已经获取优惠券，请在<br>“我的-钱包-优惠券”中查看</div>
			<div class="address_Capacity_dis"><button class="view_now">立即查看</button><button class="calloff">取消</button></div>
		</div>
	</div>
</body>
<script type="text/javascript">
	$('.couple_back_mbox').on('click',function(){
		var feedback=$('textarea[name=feedback]').val();
		if(feedback==''){
			alert('请输入您的建议或意见');
			return false;
		}
		$.ajax({
			url:'/lawyer/Home/Setting/feedback',
			data:'feedback='+feedback,
			type:'post',
			success:function(data){
				if(data.status){
					$('.dialog_overlay').show();
				}else{
					alert(data.info);
				}
			},
			dataType:'json'
		});
	})
	$('.view_now').on('click',function(){
		location.href="<?=U('Wallet/coupon')?>";
	});
</script>
</html>