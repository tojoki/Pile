<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<title>账号与安全</title>
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
		<a class="icon_left fl" onclick="location.href='/lawyer/Home/Setting/index'"></a>
		<h1 class="title">账号与安全</h1>
	</header>
	<section class="section">
		<ul class="attor_sett">
			<li onclick='mobile();'>手机号<i></i><span class="co000">
			<?php
 $num=substr($info['phone'], 3,4); echo str_replace($num, '****', $info['phone']); ?>
			</span></li>
			<li onclick='certify();'>实名认证<i></i><span class="coff0">
			<?php
 if($info['authstatus']==0){ echo "未认证"; }else if($info['authstatus']==1){ echo "已认证"; }else if($info['authstatus']==2){ echo "审核中"; } ?>
			</span></li>
		</ul>
	</section>
</body>
<script>
	function mobile(){
		location.href='/lawyer/Home/Setting/mobile';
	}
	function certify(){
		var authstatus="<?=$info['authstatus']?>";
		if(authstatus!=1){
			location.href='/lawyer/Home/Setting/certify';
		}
		
	}

</script>
</html>