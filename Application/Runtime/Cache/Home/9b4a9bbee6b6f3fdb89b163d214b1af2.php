<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<title>下载法桥</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="format-detection" content="telephone=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="stylesheet" href="/lawyer/Public/Home/css/reset.css">
	<link rel="stylesheet" href="/lawyer/Public/Home/css/style.css">
	<script src="/lawyer/Public/Home/js/jquery-1.9.1.min.js"></script>
	<script src="/lawyer/Public/Home/js/public.js"></script>
	<script>
	$(function(){
		//分享给好友
		// $(".download_type").on("click","a",function(){
		// 	$(".modal_bg").fadeIn();
		// 	$(".modal_bg").click(function(){
		// 		$(this).fadeOut();
		// 	});
		// });
		var ua = navigator.userAgent.toLowerCase();
	    if(ua.match(/MicroMessenger/i)!="micromessenger") {
	    	$('.modal_bg').hide();
	    }else{
	    	$(".download_type").on("click","a",function(){
				$(".modal_bg").show();
				$(".modal_bg").click(function(){
					$(this).hide();
				});
			});
	    }
	});
</script>
</head>
<body style="background:#fafafa">
	<header class="bar_nav">
		<a class="icon_left fl" onclick="history.go(-1)"></a>
		<h1 class="title">法桥客户端下载</h1>
	</header>
	<section class="section">
		<div class="download_bg">
			<div class="login_logo"><img src="/lawyer/Public/Home/images/logo.png" alt=""></div>
			<div class="download_type">
				<a href='#'><i class="android_icon"></i>Android版 下载</a>
				<a href='#'><i class="ios_icon"></i>IOS版 下载</a>
			</div>
		</div>
		<div class="fq_wx"><img src="/lawyer/Public/Home/images/fq_wx.png" alt=""></div>
	</section>
<!-- 分享  -->
<div class="modal_bg forth_wait" style='display:none;'>
	<div class="bg_white wait_cont">
		<span class="share_arrbg"></span>
		<div class="sum_img"><img src="/lawyer/Public/Home/images/fq_22.png" alt=""></div>
		<p class="limit_skip">哎呀，微信限制跳转了</p>
		<p class="limit_skip"><em>点击右上角</em>,选择在<a href="">浏览器中打开</a>即可下载</p>
	</div>
</div>
</body>

</html>