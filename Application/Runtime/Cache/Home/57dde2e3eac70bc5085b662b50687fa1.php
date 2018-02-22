<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<title>活动</title>
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
		<h1 class="title">活动</h1>
	</header>
	<section class="section">
		<ul class="activity_list">
		<?php
 foreach($lists as $v){ ?>
			<li>
				<span>
				<?php
 if($v['cover']){ ?>
					<img src="/lawyer/<?=$v['cover']?>">
				<?php
 }else{ echo '无封面'; } ?>
				</span>
				<div>
					<a href="/lawyer/Home/Activity/info?activity_id=<?=$v['activity_id']?>">
					<h4><?=$v['title']?></h4>
					<strong>活动时间：<?=date('Y-m-d',$v['starttime'])?>-<?=date('Y-m-d',$v['deadtime'])?></strong>
					</a>
				</div>
			</li>
		<?php
 } ?>
		</ul>
	</section>
</body>
</html>