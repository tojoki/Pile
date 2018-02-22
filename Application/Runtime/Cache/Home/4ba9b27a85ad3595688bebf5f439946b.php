<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <title>发票详情</title>
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
    <script src="/lawyer/Public/Home/js/main.js"></script>
    <script src="/lawyer/Public/Home/js/ls.js"></script>
    <style>
        .active{background: #0068B7;color: #fff!important;}
    </style>
</head>
<body>
<header class="bar_nav">
    <a class="icon_left fl" onclick="location.href='/lawyer/Home/Wallet/invoiceHistory'"></a>
    <h1 class="title">发票详情</h1>
</header>
<section class="section">
    <div class="invoice_con clearfix">

        <h3>状态</h3>
        <ul class="add_content">
            <li><lable>状&nbsp;&nbsp;&nbsp;&nbsp;态:</lable><span style="color: #FF9C14">
            <?php
 if($info['status']==1){ echo "待开票"; }else if($info['status']==2){ echo "待收票"; }else if($info['status']==3){ echo "已收票"; } ?>
            </span></li>
        </ul>
        </ul>
        <h3>发票信息</h3>
        <ul class="add_content">
            <li><lable>公司抬头:</lable><span><?=$info['company_name']?></span></li>
            <li><lable>发票内容:</lable><span></span></li>
            <li><lable>发票金额:</lable><span class="special_color"><?=$info['amount']?>元</span></li>
        </ul>
        <h3>邮寄地址</h3>
        <div class="send_addr" style="background:url();background-color:#fff;">
            <div class="consignee clearfix">
                <span class="fl">收货人: <em><?=$info['uname']?></em></span>
                <span class="fr"><?=$info['mobile']?></span>
            </div>
            <p><lable>收货地址: </lable><span> <?=$info['area'].$info['detail']?></span></p>
        </div>
        <div class="postage"><lable>邮费:</lable><strong class="special_color">货到付款</strong></div>
        <?php
 if($info['status']==2){ ?>
            <div class="order_stutas_list_bottom clearfix bg_white" style="margin-top: .5rem">
                <a class="order_stutas_checked">确认收票</a>
            </div>    
        <?php
 } ?>
        
    </div>
</section>
</body>
<script type="text/javascript">
    $('.order_stutas_checked').on('click',function(){
        var invoice_id="<?=$info['invoice_id']?>";
        $.ajax({
            url:'/lawyer/Home/Wallet/invoiceInfo',
            data:'invoice_id='+invoice_id,
            type:'post',
            success:function(data){
                location.reload();
            },
            dataType:'json'
        });
    });
</script>
</html>