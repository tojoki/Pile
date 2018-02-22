<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<title>获取优惠券</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="format-detection" content="telephone=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="stylesheet" href="/lawyer/Public/Home/css/reset.css">
	<link rel="stylesheet" href="/lawyer/Public/Home/css/style.css">
	<script src="/lawyer/Public/Home/js/jquery-1.9.1.min.js"></script>
	<script src="/lawyer/Public/Home/js/public.js"></script>
</head>
<body class="bg_white">
	<header class="bar_nav">
		<a class="icon_left fl" href='/lawyer/Home/Index/index'></a>
		<h1 class="title">精准咨询</h1>
		<a class="fr"><i class="share_icon"></i></a>
	</header>
	<section class="section">
		<div class="accurate_ask">
			<div class="accura_bg">
				<h3>hello，送你10元法桥律师券，为首次咨询买单。</h3>
				<form action="" method='post' id='form'>
					<div class="accur_input">
						<input type="text" placeholder="请输入手机号" name='mobile'>
					</div>
					<div class=""><a href="#" class="login_submit">确定</a></div>
				</form>
			</div>
			<div class="accur_img"><img src="/lawyer/Public/Home/images/fq_13.png" alt=""></div>
		</div>
	</section>
</body>
<script type="text/javascript">
	$('.login_submit').on('click',function(){
		var mobile=$('input[name=mobile]').val();
		var reg = /^0?1[3|4|5|8][0-9]\d{8}$/;
		if(!reg.test(mobile)){
			alert("手机号必须为11位数字");
      		return false;
		}
		$.ajax({
			url:'/lawyer/Home/Index/getCoupon',
			data:'mobile='+mobile,
			type:'post',
			success:function(data){
				alert(data.info);
			},
			dataType:'json'
		});
	});
</script>
</html>