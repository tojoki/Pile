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
		<a class="icon_left fl" onclick="history.go(-1)"></a>
		<h1 class="title">实名认证</h1>
	</header>
	<section class="section pad_bot17">
		<div class="attor_news">实名认证信息填写：</div>
		<ul class="attor_sett">
			<li>姓名：<input type="text" placeholder="请填写真实姓名" name='rname'></li>
			<li>身份证号：<input class="phonenub" type="text" placeholder="请填写真实身份证号" name='idcard'></li>
		</ul>
		<div class="attor_deta">
			<span>注：</span>
			<p>实名认证协议实名认证协议实名认证协议实名认证协议实名认证协议实名认证协议实名认证协议实名认证协议实名认证协议实名认证协议实名认证协议实名认证协议实名认证协议实名认证协议实名认证协议实名认证协议实名认证协议实名认证协议实名认证协议实名认证协议实名认证协议实名认证协议</p>
		</div>

		<div class="log_out"><button>立即认证</button></div>
	</section>
</body>
<script type="text/javascript">
	$('.log_out').on('click',function(){
		var rname=$('input[name=rname]').val();
		if(rname==''){
			alert('请填写真实姓名');
			return false;
		}
		var idcard=$('input[name=idcard]').val();
		var reg=/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/;
		if(!reg.test(idcard)){
			alert('请填写真实身份证号');
			return false;
		}
		$.ajax({
			url:'/lawyer/Home/Setting/certify',
			data:'rname='+rname+'&idcard='+idcard,
			type:'post',
			success:function(data){
				alert(data.info);
				if(data.status){
					location.href=data.url;
				}
			},
			dataType:'json'
		});

	});
</script>
</html>