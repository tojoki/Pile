<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <title>开发票</title>
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
</head>
<body>
<header class="bar_nav">
    <a class="icon_left fl" onclick="location.href='/lawyer/Home/Wallet/index'"></a>
    <h1 class="title">开发票</h1>
    <a class="fr"><i class="share_icon"></i></a>
</header>
<section class="section">
    <div class="invoice_con">
    <?php
 foreach($lists as $k=>$v){ ?>
        <div class="invoice_con_head">
            <span class="rl"><?php echo ($k); ?></span>
            <span class="fr" onclick="location.href='/lawyer/Home/Wallet/invoiceHistory'">开票历史</span>
        </div>
        <ul class="invoice_lists">
        <?php
 foreach($v as $v2){ ?>
            <li class="clearfix">
                    <span class="active_null test"></span>
                    <input name='oid' value="<?php echo ($v2["oid"]); ?>" type='hidden'>
                <div class="right">
                    <div class="await_assess_content">
                        <ol>
                            <li><lable>订单类别:</lable><span class="special_color"><?=$v2['ordertype']==1?'即时语音':'网约律师';?></span></li>
                            <li><lable>咨询类别:</lable><span ><?=$v2['fname'].'  '.$v2['cname']?></span></li>
                        <?php
 if($v2['ordertype']==2){ ?>
                            <li><lable>咨询者姓名:</lable><span ><?=$v2['rname']?></span></li>
                            <li><lable>咨询者电话:</lable><span ><?=$v2['mobile']?></span></li>
                            <li><lable>约见时间:</lable><span >
                                <?=date('m月d日H:i',$v2['starttime']).'咨询'.floor($v2['period']/3600).'小时';?></span></li>
                            <li><lable>约见地点:</lable><span >
                                <?=$v2['province']==$v2['city']?$v2['address']:$v2['province'].$v2['city'].$v2['address']?></span></li>
                        <?php
 }else{ ?>
                            <li><lable>咨询时间:</lable><span >
                                <?=date('m月d日H:i',$v2['starttime']).'-'.date('m月d日H:i',$v2['endtime'])?></span></li>
                            <li><lable>咨询时长:</lable><span  class="special_color">
                                <?=floor($v2['period']/3600).'小时'.floor(($v2['period']%3600)/60).'分钟'?>
                            </span></li>
                        <?php
 } ?>
                            <li><lable>咨询律师:</lable><span ><?=$v2['lawyer_name']?></span></li>
                            <li><lable>支付费用:</lable><span  class="special_color price_single"><?=$v2['payamount']?>元</span></li>
                        </ol>
                    </div>
                </div>
            </li>
        <?php
 } ?>
        </ul>

    <?php
 } ?>
    </div>
    <div class="invoice_con_footer">
        <span class="active_null check_all"></span>
        <ul>
            <li>全选</li>
            <li>
                <p>总计: <strong>￥<span class="price_total"></span></strong></p>
                <p>共<em id='total'>0</em>个订单</p>
            </li>
        </ul>
        <a class="next_btn">下一步</a>
    </div>
    <div style="height: 1.2rem"></div>
</section>
<script>
    window.onload=function(){
        sum();
    }
    //计算订单个数
    $('.test').on('click',function(){
        var total=$('#total').html();
        if(!$(this).hasClass('check_icon')){
            total=total*1+1;
        }else{
            total=total*1-1;
        }
        $('#total').html(total);
    });
    $('.next_btn').on('click',function(){
        var ids=[];
        $('.check_icon').each(function(){
            //非全选按钮
            if(!$(this).hasClass('check_all')){
                ids[ids.length]=$(this).next().val();
            }
        });
        if(!ids.length){
            alert('请至少选择一个订单');
            return false;
        }
        var money=$('.price_total').parent().text();
        location.href='/lawyer/Home/Wallet/subInvoice?ids='+ids+'&money='+money;
    });
</script>
</body>
</html>