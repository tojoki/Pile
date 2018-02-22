<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <title></title>
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
<body>
<header class="bar_nav">
    <a class="icon_left fl" onclick="location.href='/lawyer/Home/Wallet/invoicesList'"></a>
    <h1 class="title">开票历史</h1>
</header>
<section class="section">
    <div class="invoice_history">
        <ul>
        <?php
 foreach($lists as $v){ ?>
            <li onclick="location.href='/lawyer/Home/Wallet/invoiceInfo?invoice_id=<?=$v['invoice_id']?>'">
                <strong class="special_color"><?php echo ($v["amount"]); ?>元</strong>
                <p><?php echo (date('Y年m月d日 H:i',$v["ctime"])); ?></p>
                <?php
 if($v['status']==1){ ?>
                    <p>发票还未开出，预计5天内开出</p>
                    <span class="dkp">待开票</span>
                <?php
 }else if($v['status']==2){ ?>
                    <p>发票已发出，请等待收票。</p>
                    <span class="dkp">待收票</span>
                <?php
 }else if($v['status']==3){ ?>
                    <p>发票已收到。</p>
                    <span class="dkp">已收票</span>
                <?php
 } ?>
                
            </li>
        <?php
 } ?>
        </ul>
    </div>
</section>
</body>
</html>