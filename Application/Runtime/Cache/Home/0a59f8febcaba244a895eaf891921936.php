<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<title>未付款</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="format-detection" content="telephone=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="stylesheet" href="/lawyer/Public/Home/css/reset.css">
	<link rel="stylesheet" href="/lawyer/Public/Home/css/style.css">
	<script src="/lawyer/Public/Home/js/jquery-1.9.1.min.js"></script>
	<script>jQuery.noConflict()</script>
	<script src="/lawyer/Public/Home/js/sui/zepto.min.js" type="text/javascript"></script>
	<script src="/lawyer/Public/Home/js/sui/sm.min.js" type="text/javascript"></script>
	<script src="/lawyer/Public/Home/js/sui/sm-city-picker.min.js" type="text/javascript"></script>
	<script src="/lawyer/Public/Home/js/public.js"></script>
	<script src="/lawyer/Public/Home/js/main.js"></script>
	<script>
		$(function(){	
			//图片左右滑动
			var liWid = $(".event_type li").outerWidth(true);
			var liSize = $(".event_list li").size()+2;
			$(".event_list").width(liWid * liSize);
			//选择地址
			$("#city-picker").cityPicker({
			    toolbarTemplate: '<header class="bar bar-nav">\
			    <button class="button button-link pull-left close-picker">取消</button>\
			    <button class="button button-link pull-right close-picker">确定</button>\
			    <h1 class="title">选择城市</h1>\
			    </header>'
			 });
			$('#city-picker').on('click',function(){
		        $('body').css({'overflow': 'hidden !IMPORTANT', 'height': '100%'});
		        $('.dialog_modal').show();
		        $('.button').on('click',function(){
		            $('.dialog_modal').hide();
		            $('body').css({'overflow': 'auto !IMPORTANT', 'height': '100%'});
		        });
		        $('.dialog_modal').on('click',function(){
		            $('.dialog_modal').hide();
		            $('body').css({'overflow': 'auto !IMPORTANT', 'height': '100%'});
		        });
		        $('.pull-left').on('click',function(){
		            $('.dialog_modal').hide();
		            $('body').css({'overflow': 'auto !IMPORTANT', 'height': '100%'});
		        });
		    });
		    
		})
		//打开左侧
		$(document).on("click", ".forth_ltbg", function() {
		  $.openPanel("#panel-js-demo");		 
		}); 
		$(".panel-overlay").click(function(){
		  	$(this).hide();
		 });

		
	</script>
</head>
<body>
<div class="page">
	<header class="bar_nav">
		<a class="icon_left fl" onclick="history.go(-1)"></a>
		<h1 class="title">法桥律师</h1>
		<a class="fr"><i class="share_icon"></i></a>
	</header>
	<section class="section">
		<div class="forth_voice border_bottom">
			<span class="forth_ltbg"></span>
			<div class="event_type">
				<ul class="event_list">
				<?php
 foreach($cate_arr as $k=>$v){ ?>
					<li>
						<span><?php echo ($k); ?></span>
						<div class="modal_bg">
							<ul class="secend_types">
							<?php
 foreach($v as $k2=>$v2){ ?>
								<li class="<?php echo ($k2); ?>" ><a><?php echo ($v2); ?></a></li>
							<?php
 } ?>
							</ul>
						</div>
					</li>
				<?php
 } ?>
				</ul>
			</div>
			<!-- <div class="forth_rtbg fr"><span class="bg_img"></span></div> -->
		</div>
		<div class="find_layer">
			<h3>您好，您现在要找哪类律师？</h3>
			<p>附近有<em>12</em>位律师</p>
		</div>
		<div class="select_layer">
			<div class="select_head clearfix">
				<span class="fl">即时语音</span>
				<a href="" class="net_layer fr"><i class="lay_icon"></i>网约律师</a>
			</div>
			<div class="select_address">
				<span class="address_home"><i></i>律师所在地:</span>
				<div class="address_input"><input type="text" value="北京 西城区" id="city-picker" readonly></div>
				<a href="1_首页（即时语音）_4查看定位.html" class="look_locat"><i> </i>查看定位</a>
			</div>
			<div class="select_address border_top pdright">
				<span class="address_home practice"><i></i>执业年限:</span>
				<div class="address_input"><input type="text" value="选择律师执业年限" id="layer_time"></div>
			</div>
			<div class="refer_block select_address border_top pdright disnone">
				<span class="address_home refer_time"><i></i>预计咨询时长:</span>
				<div class="address_input refer_input"><input type="text" value="30"><span>分钟</span></div>
			</div>
		</div>
		<div class="select_layer refer_block disnone">
			<ul class="practice_time border_bottom clearfix">
				<li>
					<div class="practice_block">
						<span class="pract_icon"></span>
						<em>5年以下</em>
					</div>
				</li>
				<li>
					<div class="practice_block">
						<span class="pract_icon"></span>
						<em>5-10年</em>
					</div>
				</li>
				<li>
					<div class="practice_block">
						<span class="pract_icon"></span>
						<em>10年以上</em>
					</div>
				</li>
			</ul>
			<div class="coupan_deduct">
				<span class="pract_mondy">约<em>30.8</em>元</span>
				<p class="deduct_money"><i class="deduct_icon"></i>优惠券已抵扣<em>270</em>元</p>
			</div>
		</div>
		<div class="call_layer"><a href="" class="login_submit dis_gray">呼叫律师</a></div>
		<div class="marginlt">
			<div class="coupan_bg">
				<a href="">
					<div class="coupanfl fl">
						<h3 class="coupan_title">10元优惠券</h3>
						<p class="coupan_news">新手免单 精准咨询</p>
						<a href="" class="coupan_detail">查看详情</a>
					</div>
					<div class="fr">
						<div class="coupan_advert"><img src="/lawyer/Public/Home/images/fq_08.png" alt=""></div>
					</div>
				</a>
			</div>
		</div>

	</section>
</div>
<div class="dialog_modal"></div>

<!-- 未付款提示start -->
<div class="dialog_modal" style="display:block;">
	<div class="no_payblock">
		<div class="no_pay bg_white">
			<h3 class="quick_pay border_bottom">您有未付款订单，请立即支付！</h3>
			<a href="" class="quick_btn">立即支付</a>
		</div>
	</div>
</div>
<!-- 未付款提示end -->

<!-- 左侧内容 -->
<div class="panel-overlay"></div>
<div class="panel panel-left panel-cover theme-dark" id='panel-js-demo'>
	<div class="protrait_info">
		<div class="page_protrait"><img src="/lawyer/Public/Home/images/fq_29.png" alt=""></div>
		<span class="protrait_icon"></span>
	</div>
	<p class="users_phone">189****9113</p>
	<div class="users_item">
		<ul class="protrait_list border_top">
			<li class="border_bottom">
				<a href=""><i class="order_icon"></i>订单</a>
			</li>
			<li class="border_bottom">
				<a href=""><i class="wallet_icon"></i>钱包</a>
			</li>
			<li class="border_bottom">
				<a href=""><i class="service_icon"></i>客服</a>
			</li>
			<li class="border_bottom">
				<a href=""><i class="set_icon"></i>设置</a>
			</li>
			<li class="border_bottom">
				<a href=""><i class="download_icon"></i>下载法桥</a>
			</li>
		</ul>
	</div>
	<div class="protrait_bottom">
		<a href="">
			<span class="active_icon"></span>
			活动
		</a>
		<a href="">
			<span class="remmond_icon"></span>
			推荐有奖
		</a>
		<a href="">
			<span class="recruit_icon"></span>
			律师招募
		</a>
	</div>
</div>
</body>
</html>