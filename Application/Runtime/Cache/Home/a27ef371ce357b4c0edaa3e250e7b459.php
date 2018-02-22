<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <title>优惠券</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/lawyer/Public/Home/css/reset.css">
    <link rel="stylesheet" href="/lawyer/Public/Home/css/style.css">
    <script src="/lawyer/Public/Home/js/jquery-1.9.1.min.js"></script>
    <script src="/lawyer/Public/Home/js/public.js"></script>
</head>
<body>
<header class="bar_nav">
    <a class="icon_left fl" onclick="history.go(-1)"></a>
    <h1 class="title">我的优惠券</h1>
</header>
<section class="section">
    <div style="height: .4rem"></div>
    <div class="coupan_list">
    <?php
 foreach($lists as $v){ ?>
        <div class="coupan_checkofbg">
            <h3 class="coupan_name"><?=$v['name']?></h3>
            <span class="collar_time">领券后15天内有效</span>
            <span class="collar_time">领券时间：<?=date('Y-m-d H:i',$v['starttime'])?></span>
            <p class="period_time">有效期至<?=date('Y-m-d H:i',$v['deadtime'])?></p>
            <span class="coupan_price">￥<em><?=$v['amount']?></em>元</span>
            <i></i>
        </div>
    <?php
 } ?>
    </div>
</section>
</body>
</html>