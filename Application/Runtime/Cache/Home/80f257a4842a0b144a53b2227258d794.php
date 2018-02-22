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
    <style>
        .active{background: #0068B7;color: #fff!important;}
    </style>
</head>
<body>
<header class="bar_nav">
    <a class="icon_left fl" onclick="location.href='/lawyer/Home/Wallet/invoicesList'"></a>
    <h1 class="title">开发票</h1>
</header>
<section class="section">
   <div class="invoice_con clearfix">
       <h3>发票信息</h3>
       <ul class="add_content">
           <li><lable>公司抬头:</lable><span>
            <input name='company_name' type='text' class='com' value="<?php echo ($info["company_name"]); ?>">
          </span></li>
           <li><lable>发票内容:</lable><span>********************</span></li>
           <li><lable>发票金额:</lable><span class="special_color"><?php echo ($info["amount"]); ?>元</span></li>
       </ul>
       <h3>邮寄地址</h3>
       <div class="send_addr" onclick="choose();">
           <div class="consignee clearfix">
               <span class="fl">收货人: <em><?php echo ($info["uname"]); ?></em></span>
               <span class="fr"><?php echo ($info["mobile"]); ?></span>
           </div>
           <p><lable>收货地址: </lable><span> <?php echo ($info["area"]); echo ($info["detail"]); ?></span></p>
       </div>
       <div class="postage"><lable>邮费:</lable><strong class="special_color">货到付款</strong></div>
       <p class="fr ins-btn">开票说明</p>
       <div class="submit_btn"><a class="login_submit">提交</a></div>
   </div>
    <div class="dialog_modal" style="top:0.88rem;background:rgba(0,0,0,.8);" >
        <div class="invoice_instr">
                <span class="closed"><img src="/lawyer/Public/Home/images/ls_18.png" alt=""/></span>
              <p style="margin-top: .8rem">
                  1.如果您选择在线支付邮费，法桥将为您提供内容为“服务费|的发票，未支付的订单将在15分钟后自动取消，您可以重新提交申请。</p>
              <p>  2.如果您填写了电子邮箱，电子行程单将在您提交后5分钟内发送给您。</p>
              <p>  3.每次申请发票合计满200元时包邮，暂不支持港、澳、台地区邮寄。</p>
              <p>  4.普通用户申请的发票，我们最晚会在3个工作日内寄出。</p>
              <p>  5.如果您选择在线支付邮费，法桥将为您提供内容为“服务费|的发票，未支付的订单将在15分钟后自动取消，您可以重新提交申请。</p>
              <p>  6.如果您填写了电子邮箱，电子行程单将在您提交后5分钟内发送给您。</p>
              <p>  7.每次申请发票合计满200元时包邮，暂不支持港、澳、台地区邮寄。</p>
              <p>  8.普通用户申请的发票，我们最晚会在3个工作日内寄出。</p>
        </div>
    </div>
</section>
<div class="panel-overlay" >
    <div class="no_payblock ">
        <div class="invoice_alert bg_white">
            <ul>
                <li><lable>公司抬头:</lable><span class='com_name'></span></li>
                <li><lable>收件人:</lable><span><?php echo ($info["uname"]); ?>&nbsp;<?php echo ($info["mobile"]); ?></span></li>
                <li><lable>所在区域:</lable><span><?php echo ($info["area"]); ?></span></li>
                <li><lable>收件地址:</lable><span><?php echo ($info["detail"]); ?></span></li>
                <li><lable>邮递费用:</lable><span>货到付款</span></li>
            </ul>
            <div class="btn_group clearfix">
                <a class="fl">取消</a>
                <a class="fr active">确认提交</a>
            </div>
        </div>
    </div>
</div>
<script>
    $('.ins-btn').on('click',function(){
        $('.dialog_modal').fadeIn();
        $('.closed').on('click',function(){
            $('.dialog_modal').fadeOut();
        })
    });
    //点击提交 重新获取一下公司抬头 防止更改
    $('.submit_btn').on('click',function(){
        var invoice_id="<?=$info['invoice_id']?>";
        var company_name=$('input[name=company_name]').val();
        if(company_name==''){
          alert('请输入公司抬头');
          return false;
        }
        $('.com_name').html(company_name);

        $('.panel-overlay').fadeIn();
        //确认提交
        $('.btn_group .fr').on('click',function(){
            $.ajax({
              url:'/lawyer/Home/Wallet/ensureInvoice',
              data:'invoice_id='+invoice_id+'&company_name='+company_name,
              type:'post',
              success:function(data){
                alert(data.info);
                if(data.status){
                  location.href=data.url;
                }
              },
              dataType:'json'
            });
            $('.panel-overlay').fadeOut();
            //
        });
        $('.btn_group .fl').on('click',function(){
            $('.panel-overlay').fadeOut();
            //dosomething
        });
    });
    function choose(){
      var company_name=$('input[name=company_name]').val();
      var invoice_id="<?=$info['invoice_id']?>";
      location.href='/lawyer/Home/Wallet/chooseAddress?invoice_id='+invoice_id+'&company_name='+company_name;
    }
</script>
</body>
</html>