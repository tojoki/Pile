<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<title>地址管理</title>
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
		<a class="icon_left fl" onclick="location.href='/lawyer/Home/Wallet/subInvoice?invoice_id=<?=$invoice_id?>'"></a>
		<h1 class="title">地址管理</h1>
	</header>
	<section class="section pad_bot17">
	<?php
 foreach($addressList as $v){ ?>
		<ul class="attor_site" id="<?php echo ($v["addrid"]); ?>">
			<li><span>收货人：<?php echo ($v["uname"]); ?></span><span><?php echo ($v["mobile"]); ?></span></li>
			<li><strong>收货地址：<?php echo ($v["area"]); echo ($v["detail"]); ?></strong></li>
		</ul>
	<?php
 } ?>


		<div class="log_out log_fix">
			<button onclick="location.href='/lawyer/Home/Wallet/addAddress?invoice_id=<?=$invoice_id?>'">
				<i class="new_address"></i>添加新地址</button></div>
	</section>
</body>
<script type="text/javascript">
	$('.attor_site').on('click',function(){
		var addrid=$(this).attr('id');
		var invoice_id='<?=$invoice_id?>';
		$.ajax({
			url:'/lawyer/Home/Wallet/chooseAddress',
			data:'invoice_id='+invoice_id+'&addrid='+addrid,
			type:'post',
			success:function(data){
				location.href=data.url;
			},
			dataType:'json'
		});
	});
</script>
</html>