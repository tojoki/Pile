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
		<h1 class="title">实名认证</h1>
	</header>
	<section class="section">
		<div class="att_message">
			<img src="/lawyer/Public/Home/images/att_01.png">
			<p>信息审核中，结果将在7个工作日内通知您</p>
		</div>
		<div class="att_message_name">
			<span><?=$info['rname']?></span>
			<span>
			<?php
 $num=substr($info['idcard'], 3,12); echo str_replace($num, '************', $info['idcard']); ?>
			</span>
		</div>
	</section>
</body>
</html>