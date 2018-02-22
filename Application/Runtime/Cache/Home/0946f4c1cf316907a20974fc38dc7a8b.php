<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <title>消费明细</title>
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
    <style>
        table{
            width:300px;
            border-collapse:collapse;
            /*overflow:hidden;*/
        }
        tr{
            white-space:normal;
        }
        th,td{
            height:30px;
            border:#333333 solid 1px;
        }
    </style>
</head>
<body>
<header class="bar_nav">
    <a class="icon_left fl" onclick="history.go(-1)"></a>
    <h1 class="title">消费明细</h1>
</header>
<section class="section">
    <div class="my_purse">
        <table border="0">
            <thead>
            <tr>
                <th>描述</th>
                <th>消费金额</th>
                <th>时间</th>
            </tr>
            </thead>
            <tbody>
            <?php
 foreach($lists as $v){ ?>
                <tr>
                    <td><?=$v['ordertype']==1?'即时语音':'网约律师'?></td>
                    <td><?=$v['payamount']?></td>
                    <td class="time"><?=date('Y-m-d H:i',$v['paytime'])?></td>
                </tr>
            <?php
 } ?>
            </tbody>
        </table>
    </div>
</section>
</body>
</html>