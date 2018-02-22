<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<title>登录</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="format-detection" content="telephone=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="stylesheet" href="/lawyer/Public/Home/css/reset.css">
	<link rel="stylesheet" href="/lawyer/Public/Home/css/style.css">
	<script src="/lawyer/Public/Home/js/jquery-1.9.1.min.js"></script>
	<script>jQuery.noConflict()</script>
	<script type="text/javascript" src="/lawyer/Public/Home/js/sui/zepto.min.js" ></script>
	<script type="text/javascript" src="/lawyer/Public/Home/js/sui/sm.min.js"></script>
	<script src="/lawyer/Public/Home/js/public.js"></script>
	<script src="/lawyer/Public/Home/js/main.js"></script>
	<script>
	    $(function(){
	    	$(".login_submit").click(function(){
	    		$.toast('手机号或验证码不正确<br />请从新输入！',1000);
	    	}); 	
	    	
	    });
   </script>
</head>
<body class="bg_white">
	<header class="bar_nav">
		<h1 class="title">登录</h1>
	</header>
	<section class="section">
		<div class="login_logo"><img src="/lawyer/Public/Home/images/logo.png" alt=""></div>
		<form action="">
			<div class="login_input"><i class="tel_icon"></i>
				<input type="text" name="mobile">
			</div>
			<div class="login_input login_pdright">
				<i class="pwd_icon"></i>
				<input type="password" name="pwd" id="pwd">
				<i class="clear_input"></i>
				<i class="eyes_icon" state="off" id="eyes"></i>
			</div>
			<div class="rem_pwd">
				<input type="checkbox" name='remember' class="rem_checkoff">记住密码
			</div>
			<div class="sub_btn"><a  class="login_submit">登录</a></div>
			<div class="login_font">
				<a href="0_注册_获取后_忘记密码.html" class="fl forget_pwd">忘记密码？</a>
				<a href="/lawyer/Home/Login/register" class="fr register_btn">注册</a>
			</div>
		</form>
	</section>
</body>
</html>