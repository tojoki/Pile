<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<title>律师招募</title>
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
	    	$('.modal_bg').hide();//如果不是微信浏览器 就不显示提示了
	    }else);
			});
	    } 
	});
</script>
<body class="bg_white">
	<header class="bar_nav">
		<a class="icon_left fl" onclick="history.go(-1)"></a>
		<h1 class="title">律师招募</h1>
	</header>
	<section class="section pad_bot17">
		<div class="recruit_f">
			<img src="/lawyer/Public/Home/images/att_24.png" alt="">
		<div class="log_out"><button>律师端下载通道</button></div>
		</div>

	</section>
<!-- 分享  -->
<!-- <div class="modal_bg forth_wait">
	<div class="bg_white wait_cont">
		<span class="share_arrbg"></span>
		<div class="sum_img"><img src="/lawyer/Public/Home/images/fq_22.png" alt=""></div>
		<p class="limit_skip">哎呀，微信限制跳转了</p>
		<p class="limit_skip"><em>点击右上角</em>,选择在<a href="">浏览器中打开</a>即可下载</p>
	</div>
</div> -->

</body>
</html>