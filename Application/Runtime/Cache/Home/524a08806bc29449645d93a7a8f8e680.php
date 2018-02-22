<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<title>注册</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="format-detection" content="telephone=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="stylesheet" href="/lawyer/Public/Home/css/reset.css">
	<link rel="stylesheet" href="/lawyer/Public/Home/css/style.css">
	<script src="/lawyer/Public/Home/js/jquery-1.9.1.min.js"></script>
	<script src="/lawyer/Public/Home/js/public.js"></script>
	<script src="/lawyer/Public/Home/js/main.js"></script>
	<script>
		$(function  () {
			//获取短信验证码
			var validCode=true;
			$(".end_order").click (function  () {
				var mobile=$('input[name=mobile]').val();
				var reg = /^0?1[3|4|5|8][0-9]\d{8}$/;
				if(!reg.test(mobile)){
					alert("手机号必须为11位数字");
		      		return false;
				}else{
					var time=60;
					var code=$(this);

					$.ajax({
						url:"<?=U('Login/sendcode')?>",
						data:'phone='+mobile+'&type=0',
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
				
			})
		})
	</script>
</head>
<body class="bg_white">
	<header class="bar_nav">
		<a class="icon_left fl" onclick="location.href='/lawyer/Home/Login/login'"></a>
		<h1 class="title">注册</h1>
	</header>
	<section class="section">
		<div class="login_logo"><img src="/lawyer/Public/Home/images/logo.png" alt=""></div>
		<form action="">
			<div class="login_input"><i class="tel_icon"></i>
				<input type="text" placeholder="手机号码" name='mobile'>
			</div>
			<div class="login_input login_pdright">
				<i class="code_icon"></i>
				<input type="text" placeholder="验证码" name='code'>
				<a href="#" class="fr end_order">获取验证码</a>
			</div>
			<div class="login_input login_pdright">
				<i class="pwd_icon"></i>
				<input type="password" placeholder="输入6-15位字母和数字的组合密码" value="" id="pwd">
				<i class="eyes_icon" state="off" id="eyes"></i>
			</div>
			<div class="login_input login_pdright">
				<i class="pwd_icon"></i>
				<input type="password" placeholder="确认密码" value="" id="config_pwd">
				<i class="eyes_icon" state="off" id="conf_eyes"></i>
			</div>
			<div class="rem_pwd">
				<input type="checkbox" class="rem_checkoff" id='agree'>我已阅读并同意法桥的
				<a href="/lawyer/Home/Login/agreement" class="protocol"><用户协议></a>
			</div>
			<div class="sub_btn sub_lpad"><a class="login_submit dis_gray" id='reg'>注册</a></div>
		</form>
	</section>
</body>
<script type="text/javascript">
	$('#agree').on('click',function(){
		var checked=$(this).prop('checked');
		if(checked){
			$('#reg').removeClass('dis_gray');
		}else{
			$('#reg').addClass('dis_gray');
		}
	});
	$('.login_submit').on('click',function(){
		var mobile=$('input[name=mobile]').val();
		var reg = /^0?1[3|4|5|8][0-9]\d{8}$/;
		if(!reg.test(mobile)){
			alert("手机号必须为11位数字");
      		return false;
		}
		var code=$('input[name=code]').val();
		var pwd=$('#pwd').val();
		var config_pwd=$('#config_pwd').val();
		$.ajax({
			url:'/lawyer/Home/Login/register',
			data:'mobile='+mobile+'&code='+code+'&pwd='+pwd+'&config_pwd='+config_pwd,
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
</script>
</html>