<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<title>设置</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="format-detection" content="telephone=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="stylesheet" href="/lawyer/Public/Home/css/reset.css">
	<link rel="stylesheet" href="/lawyer/Public/Home/css/lawyer.css">
	<script src="/lawyer/Public/Home/js/jquery-1.9.1.min.js"></script>
	<script src="/lawyer/Public/Home/js/public.js"></script>
</head>
<body class="bg_white bgf8">
	<header class="bar_nav">
		<a class="icon_left fl" onclick="location.href='<?=U("Index/index")?>'"></a>
		<h1 class="title">设置</h1>
	</header>
	<section class="section pad_bot17">
		<ul class="attor_sett">
			<li onclick='safe();'>账号与安全<i></i></li>
			<li onclick='address();'>常用地址<i></i></li>
		</ul>
		<ul class="attor_sett">
			<li onclick='direction();'>用户指南<i></i></li>
		</ul>
		<ul class="attor_sett">
			<li onclick='rules();'>法律条款<i></i></li>
			<li onclick='feedback();'>意见反馈<i></i></li>
			<li onclick='contact();'>联系我们<i></i></li>
		</ul>

		<div class="log_out"><button>退出登录</button></div>
	</section>
</body>
<script type="text/javascript">
    function safe(){
        location.href='/lawyer/Home/Setting/safe';
    }
    function coupon(){
        location.href='/lawyer/Home/Setting/coupon';
    }
    function invoices(){
        location.href='/lawyer/Home/Setting/invoices';
    }
    function direction(){
        location.href='/lawyer/Home/Setting/direction';
    }
    function rules(){
        location.href='/lawyer/Home/Setting/rules';
    }
    function feedback(){
        location.href='/lawyer/Home/Setting/feedback';
    }
    function contact(){
        location.href='/lawyer/Home/Setting/contact';
    }
    function address(){
        location.href='/lawyer/Home/Setting/address';
    }
    $('.log_out').on('click',function(){
    	if(!confirm('确认退出吗?')){
    		return false;
    	}
    	location.href="<?=U('Login/logout')?>";
    });
</script>
</html>