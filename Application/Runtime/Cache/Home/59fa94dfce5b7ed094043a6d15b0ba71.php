<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<title>实名认证</title>
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
		<a class="icon_left fl" onclick="location.href='/lawyer/Home/Setting/safe'"></a>
		<h1 class="title">手机号</h1>
	</header>
	<section class="section pad_bot17">
		<div class="att_message">
			<img src="/lawyer/Public/Home/images/att_02.png">
			<p class="col333">您当前的手机号为&nbsp;<?php echo ($mobile); ?></p>
			<p class="col999">更换后个人信息不变，下次可以使用新手机号登录</p>
		</div>
		<div class="log_out"><button>更换手机号</button></div>
	</section>
</body>
<script type="text/javascript">
	$('.log_out').on('click',function(){
		location.href='/lawyer/Home/Setting/changeMobile';
	});
</script>
</html>