<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<title>地址管理</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="format-detection" content="telephone=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="stylesheet" href="/lawyer/Public/Home/css/reset.css">
	<link rel="stylesheet" href="/lawyer/Public/Home/css/lawyer.css">
	<link rel="stylesheet" href="/lawyer/Public/Home/css/style.css">
	<script src="/lawyer/Public/Home/js/sui/zepto.min.js" type="text/javascript"></script>
	<script src="/lawyer/Public/Home/js/sui/sm.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="/lawyer/Public/Home/js/sui/sm-city-picker.min.js" ></script>
	<script src="/lawyer/Public/Home/js/public.js"></script>
	<!--<script src="/lawyer/Public/Home/js/lawyer.js"></script>-->
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=oI1msZrKGh5ouhtOnlxZM3rbzurBzld5"></script>
<script>
$(function(){
	
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
</script>
</head>
<body class=" bgf8">
	<header class="bar_nav">
		<a class="icon_left fl" onclick="history.go(-1)"></a>
		<h1 class="title">地址管理</h1>
		<a class="fr"><span class="cancel_call">删除</span></a>
	</header>
	<section class="section pad_bot17">
		<ul class="attor_sett default_manage">
			<li>联系人<span class="co000">
				<input type="text" name='uname' placeholder="请输入联系人" value="<?php echo ($info["uname"]); ?>"></span></li>
			<li>联系电话<span class="co000">
				<input type="text" name='mobile' placeholder="请输入联系电话" maxlength="11" value="<?php echo ($info["mobile"]); ?>"></span></li>
			<li>选择地区<i></i><span class="co000 region"><input type="text" value="<?php echo ($info["area"]); ?>" id="city-picker" readonly></span></li>
			<li>详细地址<span class="co000">
				<input type="text" name='detail' placeholder="请输入详细地址" value="<?php echo ($info["detail"]); ?>"></span></li>
			<li><div class="default_regin"><span class="click_te1 <?=$info['isdefault']==1?'click_texi':'';?> "></span>设为默认地址</div></li>
		</ul>
		<input name='addrid' id='addrid' value="<?php echo ($info["addrid"]); ?>" type='hidden'>
		<div class="log_out"><button>保存</button></div>
	</section>
<div class="dialog_modal"></div>
</body>
<script type="text/javascript">
	$('.click_te1').click(function(){   //  选择默认地址
		var isdefault="<?=$info['isdefault']?>";
		//如果是非默认地址 再让他选择 如果是默认地址 那就不让更改
		if(isdefault==0){
			$(this).parents('.attor_site').siblings().find('.click_te1').removeClass('click_texi');
			$(this).toggleClass('click_texi');
		}
		
	});

	$('.log_out').on('click',function(){
		var uname=$('input[name=uname]').val();
		if(uname==''){
			alert('请输入联系人');
			return false;
		}
		var mobile=$('input[name=mobile]').val();
		if(mobile==''){
			alert('请输入联系电话');
			return false;
		}
		// var reg = /^0?1[3|4|5|8][0-9]\d{8}$/;//11位手机号
  // 		if (!reg.test(mobile)) {
  //     		alert("请输入联系电话");
  //     		return false;
  // 		};	
		var area=$('#city-picker').val();
		if(area==''){
			alert('请选择地区');
			return false;
		}
		var detail=$('input[name=detail]').val();
		if(detail==''){
			alert('请输入详细地址');
			return false;
		}
		var address=area+detail;
		if($('.click_te1').hasClass('click_texi')){
			var isdefault=1;
		}else{
			var isdefault=0;
		}
		var addrid=$('#addrid').val();
		// 创建地址解析器实例
		var myGeo = new BMap.Geocoder();
		// 将地址解析结果显示在地图上,并调整地图视野
		myGeo.getPoint(address, function(point){
			if (point) {
				$.ajax({
					url:'/lawyer/Home/Setting/editAddress',
					data:'isdefault='+isdefault+'&uname='+uname+'&mobile='+mobile+'&area='+area+'&detail='+detail+'&lng='+point.lng+'&lat='+point.lat+'&addrid='+addrid,
					type:'post',
					success:function(data){
						alert(data.info);
						if(data.status){
							location.href=data.url;
						}
					},
					dataType:'json'
				});
			}else{
				alert("您选择的地址无法解析!");
			}
		}, "");
		
	});
</script>
</html>