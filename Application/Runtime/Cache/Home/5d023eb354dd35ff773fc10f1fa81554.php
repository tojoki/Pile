<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<title>更换手机号</title>
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
		<a class="icon_left fl" onclick="location.href='/lawyer/Home/Setting/mobile'"></a>
		<h1 class="title">更换手机号</h1>
	</header>
	<section class="section pad_bot17">
		<div class="attor_news col999">更换后个人信息不变，下次可以使用新手机号登录</div>
		<ul class="attor_change_num"><!-- auth_code_hou -->
			<li><i>现用手机号：</i><i><?php echo ($mobile); ?></i><span class="auth_code_zhi end_order1">获取验证码</span></li>
			<li><input type="text" placeholder="请输入验证码" name='code1'></li>
		</ul>
		<ul class="attor_change_num">
			<!-- <li>现用手机号：<input type="text" placeholder="请输入手机号"><span class="node auth_code_zhi">获取验证码</span></li>
			<li><input type="text" placeholder="请输入验证码"></li> -->
			<form action="" class="hear_loading_form">
				<li>
					<input name='newMobile' type="text" id="iphone" placeholder="请输入手机号" maxlength="11">
					<span class="auth_code_zhi end_order">获取验证码</span>
				</li>
				<li><input class="phonenub" type="text" id="yzma" placeholder="输入验证码" maxlength="6"  name='code2'></li>
			</form>
		</ul>
		<input type="hidden" value="<?php echo ($mobile); ?>" name='oldMobile'>
		<div class="log_out"><button>完成</button></div>
	</section>

<div class="tishiyu" style="width: 100px;height: auto;line-height: 40px;background: rgba(0, 0, 0, 0.6);text-align: center;color: #fff;font-size: 16px;position: fixed;top: 50%;left: 50%;-webkit-transform: translate(-50%, -50%);display:none;option:0.6">请输入正确的手机号码</div>
</body>
<script>
$(function  () {
// 	//获取短信验证码
// 	var validCode=true;
// 	$(".end_order").click (function  () {
// 		var time=60;
// 		var code=$(this);
// 		if (validCode) {
// 			validCode=false;
// 			code.addClass("messa_sub");
// 		var t=setInterval(function  () {
// 			--time;
// 			code.html(time+"秒");
// 			if (time == 0) {
// 				clearInterval(t);
// 				code.html("重新获取");
// 				validCode=true;
// 				code.removeClass("messa_sub");
// 			}
// 		},1000)
// 		}

// 	})
// })
//获取短信验证码
var validCode1=true;
$(".end_order1").click (function  () {
	var mobile=$('input[name=oldMobile]').val();
	var reg = /^0?1[3|4|5|8][0-9]\d{8}$/;
	if(!reg.test(mobile)){
		alert("手机号必须为11位数字");
  		return false;
	}else{
		var time=60;
		var code=$(this);

		$.ajax({
			url:"<?=U('Login/sendcode')?>",
			data:'phone='+mobile+'&type=3',
			type:'post',
			success:function(data){
				alert(data.info);
				if(data.status){
					if (validCode1) {
						validCode1=false;
						code.addClass("msgs1");
					var t=setInterval(function  () {
						--time;
						code.html(time+"秒");
						if (time<=0) {
							clearInterval(t);
						code.html("重新获取");
							validCode1=true;
						code.removeClass("msgs1");
						}
					},1000)
					}
				}
				
				
			},
			dataType:'json'
		});
		
			
	}
	
});
//获取短信验证码
var validCode=true;
$(".end_order").click (function  () {
	var mobile=$('input[name=newMobile]').val();
	var reg = /^0?1[3|4|5|8][0-9]\d{8}$/;
	if(!reg.test(mobile)){
		alert("手机号必须为11位数字");
  		return false;
	}else{
		var time=60;
		var code=$(this);

		$.ajax({
			url:"<?=U('Login/sendcode')?>",
			data:'phone='+mobile+'&type=2',
			type:'post',
			success:function(data){
				alert(data.info);
				if(data.status){
					if (validCode) {
						validCode=false;
						code.addClass("msgs1");
					var t=setInterval(function  () {
						--time;
						code.html(time+"秒");
						if (time<=0) {
							clearInterval(t);
						code.html("重新获取");
							validCode=true;
						code.removeClass("msgs1");
						}
					},1000)
					}
				}
				
				
			},
			dataType:'json'
		});
		
			
	}
	
});

$('.log_out').on('click',function(){
	var code1=$('input[name=code1]').val();
	if(code1==''){
        alert('请输入验证码');
        return false;
    }
	var newMobile=$('input[name=newMobile]').val();
	var reg = /^0?1[3|4|5|8][0-9]\d{8}$/;
	if(!reg.test(newMobile)){
		alert("新手机号必须为11位数字");
  		return false;
	}
	var code2=$('input[name=code2]').val();
	if(code2==''){
        alert('请输入验证码');
        return false;
    }
	var oldMobile=$('input[name=oldMobile]').val();
	$.ajax({
		url:'/lawyer/Home/Setting/changeMobile',
		data:'oldMobile='+oldMobile+'&code1='+code1+'&newMobile='+newMobile+'&code2='+code2,
		type:'post',
		success:function(data){
			alert(data.info);
			if(data.status){
				location.href=data.url;
			}
		},
		dataType:'json'
	});
});
});
</script>
</html>