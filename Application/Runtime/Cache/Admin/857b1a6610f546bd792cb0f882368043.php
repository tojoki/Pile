<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
<title><?php echo C('SITENAME');?></title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/pile/Public/Admin/css/bootstrap.min.css?v=3.3.5" rel="stylesheet">
    <link href="/pile/Public/Admin/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="/pile/Public/Admin/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/pile/Public/Admin/css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="/pile/Public/Admin/css/plugins/colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
    <link href="/pile/Public/Admin/css/plugins/cropper/cropper.min.css" rel="stylesheet">
    <link href="/pile/Public/Admin/css/plugins/switchery/switchery.css" rel="stylesheet">
    <link href="/pile/Public/Admin/css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">
    <link href="/pile/Public/Admin/css/plugins/nouslider/jquery.nouislider.css" rel="stylesheet">

    <link href="/pile/Public/Admin/css/plugins/datepicker/foundation-datepicker.css" rel="stylesheet">
    <link href="/pile/Public/Admin/css/plugins/clockpicker/clockpicker.css" rel="stylesheet">
    <link href="/pile/Public/Admin/css/animate.min.css" rel="stylesheet">  
    <link href="/pile/Public/Admin/css/style.min.css?v=4.0.0" rel="stylesheet">	
    <link href="/pile/Public/Admin/css/uploadfile.css" rel="stylesheet">
    <script src="/pile/Public/Admin/js/jquery.min.js"></script>
    <script src="/pile/Public/Admin/layer/layer.js"></script>
    <script src="/pile/Public/Admin/js/common.js"></script>
</head>

	<style>
.pages a,.pages span {
    display:inline-block;
    padding:4px 7px;
    margin:0 2px;
    border:1px solid #D5D4D4;
    -webkit-border-radius:1px;
    -moz-border-radius:1px;
    border-radius:1px;
}
.pages a,.pages li {
    display:inline-block;
    list-style: none;
    text-decoration:none; color:#077ee3;
}

.pages a:hover{
    border-color:#077ee3;
}
.pages span.current{
    background:#077ee3;
    color:#FFF;
    font-weight:700;
    border-color:#077ee3;
}

.long-tr th{
	text-align: center
}
.long-td td{
	text-align: center
}

</style>

	<style>
	.tab-content{
		padding: 20px;
	}
	.pointPackItem{
		margin-bottom: 5px!important;
	}
	.ico{
		padding: 0 10px;
	}
	</style>
	<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
		    <div id="wrapper">
        <!--左侧导航开始-->
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="nav-close"><i class="fa fa-times-circle"></i>
            </div>
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <!-- <span><img alt="image" class="img-circle" src="/pile/Uploads/<?php echo ($admin['userimg']); ?>" width="70px" height="70px"/></span> -->
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                               <span class="block m-t-xs"><strong><?php echo ($admin['username']); ?></strong></span>
                                <span class="text-muted text-xs block">
                                	<?php if($admin["role"] == 0 ): ?>超级管理员
                                		<?php else: ?>
	                                	<?php if(is_array($list2)): $i = 0; $__LIST__ = $list2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i; if($admin["role"] == $vo2["id"] ): echo ($vo2["name"]); endif; ?>
											<?php if($admin["role"] == 0 ): ?>超级管理员<?php endif; endforeach; endif; else: echo "" ;endif; endif; ?>
                                	<b class="caret"></b></span>
                                </span>
                            </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="<?php echo U('Index/pwd');?>">修改密码</a>
                                </li>
                                <li><a href="<?php echo U('Index/del');?>">清除缓存</a>
                                </li>
                                <li><a href="<?php echo U('Site/index');?>">设置</a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="javascript:;"  id="logout">退出系统</a>
                                </li>
                            </ul>
                        </div>
                        <div class="logo-element">H+
                        </div>
                    </li>
                               
													
					  <li> 
					    <?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['pid'] == 1): if($vo['single'] == 1): ?><li            
					                <?php if((strtolower($nownav['m']) == strtolower($vo['m']))): ?>class="active"<?php endif; ?>
					                ><a href="<?php echo U($vo['m'].'/'.$vo['a']);?>">
						                <i class="icon <?php echo ($vo["ico"]); ?>"></i> 
						                <span><?php echo ($vo["title"]); ?></span>
					                	<!-- <span class="label label-danger pull-right">NEW</span> -->
					                 </a>
					                </li>
					        <?php else: ?>
                                
					            <li class="submenu
					                <?php if((strtolower($nownav['m']) == strtolower($vo['m']))): ?>active<?php endif; ?>
					                "
					             > <a href="#"><i class="icon <?php echo ($vo["ico"]); ?>"></i> <span><?php echo ($vo["title"]); ?></span><span class="fa arrow"></a>
					              <ul class="nav nav-second-level">
					                  <?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$subnode): $mod = ($i % 2 );++$i; if($subnode['pid'] == $vo['id']): ?><li  
			                                   <?php if((strtolower($nownav['m']) == strtolower($subnode['m']) ) && (strtolower($nownav['a']) == strtolower($subnode['a']) )): ?>class="active"<?php endif; ?>
			                                ><a href="<?php echo U($subnode['m'].'/'.$subnode['a']);?>"><?php echo ($subnode['title']); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
					              </ul><?php endif; endif; endforeach; endif; else: echo "" ;endif; ?>
					  </li>									
					
                </ul>
            </div>
        </nav>
    <div id="page-wrapper" class="gray-bg dashbard-1">
    <div class="row border-bottom">
	<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
		<div class="navbar-header"><a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
			<form role="search" class="navbar-form-custom" method="post" action="search_results.html">
				<div class="form-group">
					<!-- <input type="text" placeholder="请输入您需要查找的内容 …" class="form-control" name="top-search" id="top-search"> -->
				</div>
			</form>
		</div>
		<ul class="nav navbar-top-links navbar-right">
			<li>
				<span class="m-r-sm text-muted welcome-message">
					<a href="<?php echo U('Index/index');?>" title="返回首页"><i class="fa fa-home"></i></a>欢迎使用<?php echo C('SITENAME');?>
					<span class="label label-danger pull-right"><?php echo ($Os); ?></span>
				</span>
			</li>
			
			<li>
				<a href="javascript:;"  id="loginout">
					<i class="fa fa-sign-out"></i> 退出
				</a>
			</li>
		</ul>
	</nav>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#loginout").click(function(){
		layer.confirm('你确定要退出吗？', {icon: 3}, function(index){
	    layer.close(index);
	    window.location.href="<?php echo U('Login/loginout');?>";
	});
	});
});
</script>

		<div class="row">
			<div class="col-sm-12">
				<div class="ibox float-e-margins">
					<div class="ibox-content no-padding">
						<ul class="list-group">
							<li class="list-group-item">
								<p class="text-success"><a href="<?php echo U('Index/index');?>" title="返回首页" class="tip-bottom"><i class="fa fa-home"></i> 首页</a> /
									<a href="" class="tip-bottom">设置管理</a> /<a href="<?php echo U('Site/index');?>" class="current">基础设置</a></p>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>基础设置</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
<form id="form-wizard" action="<?php echo U('Site/index');?>" method="post" class="form-horizontal">
					<div class="ibox-content">
                                <div class="tab-wrapper tab-primary">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#base" data-toggle="tab">基础设置</a>
                                        </li>
                                        <li class=""><a href="#point" data-toggle="tab">积分设置</a>
                                        </li>
                                        <li class=""><a href="#exp" data-toggle="tab">成长值</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
<!-- 基础设置 -->
                                        <div class="tab-pane active" id="base">

<div class="form-group">
	<label class="col-sm-2 control-label">网站名称</label>
	<div class="col-sm-6">
		<input type="text" name="sitename" value="<?php echo C('sitename');?>" placeholder="输入网站名称" class="form-control">
	</div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group">
	<label class="col-sm-2 control-label">URL地址</label>
	<div class="col-sm-6">
		<input type="text" name="siteurl" value="<?php echo C('siteurl');?>" placeholder="输入网站绑定的URL地址" class="form-control">
	</div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group">
	<label class="col-sm-2 control-label">SEO关键字</label>
	<div class="col-sm-6">
		<input type="text" name="keyword" value="<?php echo C('keyword');?>" placeholder="输入SEO关键字" class="form-control">
	</div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group">
	<label class="col-sm-2 control-label">网站描述信息</label>
	<div class="col-sm-6">
		<input type="text" name="content" value="<?php echo C('content');?>" placeholder="输入网站描述信息" class="form-control">
	</div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group">
	<label class="col-sm-2 control-label">联系QQ</label>
	<div class="col-sm-6">
		<input type="text" name="qq" value="<?php echo C('qq');?>" placeholder="输入联系QQ" class="form-control">
	</div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group">
	<label class="col-sm-2 control-label">联系电话</label>
	<div class="col-sm-6">
		<input type="text" name="linktel" value="<?php echo C('linktel');?>" placeholder="输入联系电话" class="form-control">
	</div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group">
	<label class="col-sm-2 control-label">版权信息</label>
	<div class="col-sm-6">
		<textarea type="text" name="address"  placeholder="输入版权信息" class="form-control"><?php echo C('address');?></textarea>
	</div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group">
	<label class="col-sm-2 control-label">备案信息</label>
	<div class="col-sm-6">
		<textarea type="text" name="copyright" placeholder="输入网址的备案信息" class="form-control"><?php echo C('copyright');?></textarea>
	</div>
</div>


                                        </div>
<!-- 基础设置 -->
<!-- 积分兑换设置 -->
                                        <div class="tab-pane" id="point">
<div id="pointPack">
<div class="form-group">
	<label class="col-sm-2 control-label">充值</label>
	<div class="col-sm-6">
		<?php
 $pointPack = C('pointPack'); ?>
		<?php if(is_array($pointPack)): $i = 0; $__LIST__ = $pointPack;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="form-inline">
			<div class="form-group pointPackItem">
			    <input type="text" name="pointPack[<?php echo ($i); ?>][money]" class="form-control input-sm" placeholder="资产" value="<?php echo ($v["money"]); ?>" size="10"> 元
			    <span class="fa fa-arrow-circle-right ico"></span>
			    <input type="text" name="pointPack[<?php echo ($i); ?>][point]" class="form-control input-sm" placeholder="积分" value="<?php echo ($v["point"]); ?>" size="10"> 积分
			    <!-- <button type="button" class="btn btn-danger btn-sm fa fa-trash-o" style="margin: 0;" alt="删除" title="删除"></button> -->
			</div>
		</div><?php endforeach; endif; else: echo "" ;endif; ?>		
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">积分兑换资产(卖出)</label>
	<div class="col-sm-6">
		<div class="form-inline">
		<?php
 $sellPoint = C('sellPoint'); ?>
		<?php if(is_array($sellPoint)): $i = 0; $__LIST__ = $sellPoint;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="form-group pointPackItem">
			    <input type="text" name="sellPoint[<?php echo ($i); ?>][point]" class="form-control input-sm" id="title" placeholder="积分" value="<?php echo ($v["point"]); ?>" size="10"> 积分
			    <span class="fa fa-arrow-circle-right ico"></span>
			    <input type="text" name="sellPoint[<?php echo ($i); ?>][money]" class="form-control input-sm" id="title" placeholder="资产" value="<?php echo ($v["money"]); ?>" size="10"> 元
			    <!-- <button type="button" class="btn btn-danger btn-sm fa fa-trash-o" style="margin: 0;" alt="删除" title="删除"></button> -->
			</div><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
		
	</div>
</div>
<div class="hr-line-dashed"></div>

<div class="form-group">
	<label class="col-sm-2 control-label">积分兑换规则</label>
	<div class="col-sm-6">
		<textarea type="text" name="point_rule" placeholder="输入积分兑换规则" class="form-control"><?php echo C('point_rule');?></textarea>
	</div>
</div>
<div class="hr-line-dashed"></div>

<div class="form-group">
	<label class="col-sm-2 control-label">注册送积分</label>
	<div class="col-sm-4">
		<div class="input-group">
		<input type="text" name="point_register" class="form-control" id="point_register" placeholder="" value="<?php echo C('point_register');?>">
		<div class="input-group-addon">积分</div>
		</div>
	</div>
</div>
<div class="hr-line-dashed"></div>

<div class="form-group">
	<label class="col-sm-2 control-label">充值1元赠送</label>
	<div class="col-sm-4">
		<div class="input-group">
		<input type="text" name="point_pay" class="form-control" id="point_pay" placeholder="" value="<?php echo C('point_pay');?>">
		<div class="input-group-addon">积分</div>
		</div>
	</div>
</div>

</div>


                                        </div>
<!-- 积分兑换设置 -->


<!-- 成长值 经验设置 -->
										<div class="tab-pane" id="exp">
<div class="form-group">
	<label class="col-sm-2 control-label">注册</label>
	<div class="col-sm-4">
		<div class="input-group">
		<input type="text" name="exp_register" class="form-control" id="point" placeholder="" value="<?php echo C("exp_register");?>">
		<div class="input-group-addon">成长值</div>
		</div>
	</div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group">
	<label class="col-sm-2 control-label">上传头像</label>
	<div class="col-sm-4">
		<div class="input-group">
		<input type="text" name="exp_headimg" class="form-control" id="exp_headimg" placeholder="" value="<?php echo C("exp_headimg");?>">
		<div class="input-group-addon">成长值</div>
		</div>
	</div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group">
	<label class="col-sm-2 control-label">设置用户名</label>
	<div class="col-sm-4">
		<div class="input-group">
		<input type="text" name="exp_nickname" class="form-control" id="exp_nickname" placeholder="" value="<?php echo C("exp_nickname");?>">
		<div class="input-group-addon">成长值</div>
		</div>
	</div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group">
	<label class="col-sm-2 control-label">初次设置支付密码</label>
	<div class="col-sm-4">
		<div class="input-group">
		<input type="text" name="exp_paypassword" class="form-control" id="exp_paypassword" placeholder="" value="<?php echo C("birthdayCard.point");?>">
		<div class="input-group-addon">成长值</div>
		</div>
	</div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group">
	<label class="col-sm-2 control-label">在圈子发帖</label>
	<div class="col-sm-4">
		<div class="input-group">
		<input type="text" name="exp_moment" class="form-control" id="exp_moment" placeholder="" value="<?php echo C("exp_moment");?>">
		<div class="input-group-addon">成长值</div>
		</div>
	</div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group">
	<label class="col-sm-2 control-label">每日成长值上限</label>
	<div class="col-sm-4">
		<div class="input-group">
		<input type="text" name="exp_daily_URV" class="form-control" id="exp_daily_URV" placeholder="" value="<?php echo C("exp_daily_URV");?>">
		<div class="input-group-addon">成长值</div>
		</div>
	</div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group">
	<label class="col-sm-2 control-label">充值1元赠送</label>
	<div class="col-sm-4">
		<div class="input-group">
		<input type="text" name="exp_pay" class="form-control" id="exp_pay" placeholder="" value="<?php echo C("exp_pay");?>">
		<div class="input-group-addon">成长值</div>
		</div>
	</div>
</div>
<div class="hr-line-dashed"></div>

										</div>
<!-- 生日卡设置 -->
<div class="hr-line-dashed"></div>
<div class="form-group">
	<div class="col-sm-4 col-sm-offset-2">
		<button class="btn btn-primary" type="submit">保存信息</button>&nbsp;&nbsp;&nbsp;
		<a class="btn btn-danger" href="<?php echo U('Index/index');?>">取消</a>
	</div>
</div>                                          
                                    </div>
                                </div>
                            </div>
					</form>
				</div>
			</div>
		</div>
		<div class="footer" style="position: fixed;z-index: 999;bottom: 0;width: 89%;">
	<div class="pull-right"><?php echo C('address');?></div>
</div>
</div>
</div>
<script type="text/javascript" src="/pile/Public/Admin/js/bootstrap.min.js?v=3.3.5"></script>
<script type="text/javascript" src="/pile/Public/Admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script type="text/javascript" src="/pile/Public/Admin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="/pile/Public/Admin/js/plugins/layer/layer.min.js"></script>
<script type="text/javascript" src="/pile/Public/Admin/js/hplus.min.js?v=4.0.0"></script>
<script type="text/javascript" src="/pile/Public/Admin/js/contabs.min.js"></script>
<script type="text/javascript" src="/pile/Public/Admin/js/plugins/pace/pace.min.js"></script>    
<script type="text/javascript" src="/pile/Public/Admin/js/plugins/chosen/chosen.jquery.js"></script>
<script type="text/javascript" src="/pile/Public/Admin/js/plugins/iCheck/icheck.min.js"></script>
<script type="text/javascript" src="/pile/Public/Admin/js/plugins/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript" src="/pile/Public/Admin/js/jquery.form.js"></script>
<script>
    $(document).ready(function(){$(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",})});
</script>
	</body>
<script type="text/javascript" src="/pile/Public/Common/js/uploadify/jquery.uploadify.min.js"></script>		
<link rel="stylesheet" href="/pile/Public/Common/js/uploadify/uploadify.css"> 
<script type="text/javascript">
	$("#photo_file").uploadify({
		'swf': '/pile/Public/Common/js/uploadify/uploadify.swf?t=<?php echo ($nowtime); ?>',
		'uploader': '<?php echo U("Upload/upload");?>',
		'cancelImg': '/pile/Public/Common/js/uploadify/uploadify-cancel.png',
		'buttonText': '上传图片',
		'height': 35,
		'fileTypeExts': '*.gif;*.jpg;*.png',
		'queueSizeLimit': 1,
		'onUploadSuccess': function(file, data, response) {
			$("#thumb").val('/pile/Uploads' + data);
			$("#upload_img").attr('src', '/pile/Uploads' + data).show();
		}
	});
</script>
</html>