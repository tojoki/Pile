<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<title>活动详情</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="format-detection" content="telephone=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="stylesheet" href="/lawyer/Public/Home/css/reset.css">
	<link rel="stylesheet" href="/lawyer/Public/Home/css/lawyer.css">
	<link rel="stylesheet" href="/lawyer/Public/Home/css/style.css">
	<script src="/lawyer/Public/Home/js/jquery-1.9.1.min.js"></script>
	<script>jQuery.noConflict()</script>
	<script type="text/javascript" src="/lawyer/Public/Home/js/sui/zepto.min.js" ></script>
	<script type="text/javascript" src="/lawyer/Public/Home/js/sui/sm.min.js"></script>
	<script src="/lawyer/Public/Home/js/public.js"></script>

	<script>
	    $(function(){
	    	$(".get_coupon").click(function(){
	    		var activity_id="<?=$info['activity_id']?>";
	    		$.ajax({
	    			url:'/lawyer/Home/Activity/getCoupon',
	    			data:'activity_id='+activity_id,
	    			type:'post',
	    			success:function(data){
	    				if(data.status){
	    					$.toast('领取成功！<br />请在我的优惠券中查看！',1000);
	    				}else{
	    					$.toast('领取失败！',1000);
	    				}
	    			},
	    			dataType:'json'
	    		});
	    	}); 	
	    	
	    });
   </script>
<style>
.modal{position:fixed;}
</style>
</head>
<body class="bg_white bgf8">
	<header class="bar_nav">
		<a class="icon_left fl" onclick="history.go(-1)"></a>
		<h1 class="title"><?=$info['title']?></h1>
	</header>
	<section class="section">
		<div class="Activity_details">
		<?php
 if($info['cover']){ ?>
			<img src="/lawyer/<?=$info['cover']?>">
		<?php
 } echo html_entity_decode($info['content']); ?>
		</div>
		<div class="get_coupon"><button>领取优惠券</button></div>

	</section>
</body>
</html>