<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <title>我的钱包</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/lawyer/Public/Home/css/reset.css">
    <link rel="stylesheet" href="/lawyer/Public/Home/css/style.css">
    <link rel="stylesheet" href="/lawyer/Public/Home/css/fq.css">
    <script src="/lawyer/Public/Home/js/jquery-1.9.1.min.js"></script>
    <script src="/lawyer/Public/Home/js/public.js"></script>
    <script src="/lawyer/Public/Home/js/ls.js"></script>
</head>
<style type="text/css">
    .my_purse a{color:#333;}
</style>
<body>
<header class="bar_nav">
    <a class="icon_left fl" onclick="location.href='<?=U("Index/index")?>'"></a>
    <h1 class="title">我的钱包</h1>
</header>
<section class="section">
    <div class="my_purse">
        <ul>
            <li onclick='purchase();'><a href="#">消费明细</a></li>
            <li onclick='coupon();'><a href="#">优惠劵</a></li>
        </ul>
        <ul>
            <li onclick='invoicesList();'><a href="#">发票</a></li>
        </ul>
    </div>
</section>
</body>
<script type="text/javascript">
    function purchase(){
        location.href='/lawyer/Home/Wallet/purchase';
    }
    function coupon(){
        location.href='/lawyer/Home/Wallet/coupon';
    }
    function invoicesList(){
        location.href='/lawyer/Home/Wallet/invoicesList';
    }
</script>
</html>