<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<title>登录</title>
		<link rel="stylesheet" href="/pile/Public/Home/css/public.css" />
		<link rel="stylesheet" href="/pile/Public/Home/css/swiper.min.css" />
		<link rel="stylesheet" href="/pile/Public/Home/css/index.css" />
	</head>
	<body>
		<style>
		.login_box form input[type=button]{
			display: block;
			width: 100%;
			height: 40px;
			line-height: 40px;
			margin-top: 50px;
			text-align: center;
			background: #fff;
			font-size: 16px;
			color: #666;
			opacity: 0.6;
		}
		</style>
		<!--加载-->
		<div class="load_ani">
			<p>拼命加载中</p>
			<span class="rect1"></span>
			<span class="rect2"></span>
			<span class="rect3"></span>
			<span class="rect4"></span>
			<span class="rect5"></span>
		</div>
		
		<div class="login_bg">
			<div class="login_box">
				<img class="login_img" src="/pile/Public/Home/img/logo.png" />
				<form action="" method="post">
					<div class="login_ind_box">
						<div class="login_main">
							<i class="icon_pho"></i>
							<input type="text" name="photo" placeholder="请输入手机号" />
						</div>
						<div class="login_main">
							<i class="icon_pas"></i>
							<input type="password" name="pas" placeholder="请输入密码" />
						</div>
					</div>
					<input type="button" id="sub" value="登录"/>
					<div class="login_register"><a href="<?php echo U('register');?>">立即注册</a>
					<i></i><a href="<?php echo U('findpwd');?>">忘记密码</a></div>
				</form>
			</div>
		</div>
		
		<script type="text/javascript" src="/pile/Public/Home/js/jquery-1.8.3.min.js" ></script>
		<script type="text/javascript" src="/pile/Public/Home/js/jquery.lazyload.js" ></script>
		<script type="text/javascript" src="/pile/Public/Home/js/swiper.min.js" ></script>
		<script type="text/javascript" src="/pile/Public/Home/js/public.js" ></script>
		    <script src="/pile/Public/Home/layer/layer.js"></script>
		<script>
		
			$(function(){
				
				//登录
				$("#sub").click(function(){
					var val = $("input[name=photo]").val();
					var pas = $("input[name=pas]").val();
					//手机号
					if(!validatemobile(val)){
						return false;
					};
					//密码
					if(pas.length == 0){
						promptBox('请输入密码！'); 
      					return false; 
					}
			 $.post("<?php echo U('Home/Login/login2');?>",{phone:val,password:pas},function(data){
            if(data.status){
            	
                layer.msg('登录成功!');
               location.href=data.url;
            }else if(data.data==2){
                 layer.msg("请先完善资料!");
                 var uid=data.id;
        
                 var urls2 = "/Home/Login/auth/uid/"+uid;
                 window.location.href=urls2;
            }else{
            	
                layer.msg(data.info);

            }
        })
				})
				
			})
			
			addLoadEvent(function(){
				
				//内容上下居中
				$(".login_box").css({
					"padding-top":($("body,html").height() - $(".login_box").height())/2 - 20
				})
				
				//删除加载动画
				$(".load_ani").remove();
				
			})
		</script>
	</body>
</html>