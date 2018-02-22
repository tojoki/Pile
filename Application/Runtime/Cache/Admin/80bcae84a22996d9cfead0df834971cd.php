<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
<title><?php echo C('SITENAME');?></title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/Public/Admin/css/bootstrap.min.css?v=3.3.5" rel="stylesheet">
    <link href="/Public/Admin/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="/Public/Admin/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/Public/Admin/css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="/Public/Admin/css/plugins/colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
    <link href="/Public/Admin/css/plugins/cropper/cropper.min.css" rel="stylesheet">
    <link href="/Public/Admin/css/plugins/switchery/switchery.css" rel="stylesheet">
    <link href="/Public/Admin/css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">
    <link href="/Public/Admin/css/plugins/nouslider/jquery.nouislider.css" rel="stylesheet">

    <link href="/Public/Admin/css/plugins/datepicker/foundation-datepicker.css" rel="stylesheet">
    <link href="/Public/Admin/css/plugins/clockpicker/clockpicker.css" rel="stylesheet">
    <link href="/Public/Admin/css/animate.min.css" rel="stylesheet">  
    <link href="/Public/Admin/css/style.min.css?v=4.0.0" rel="stylesheet">	
    <link href="/Public/Admin/css/uploadfile.css" rel="stylesheet">
    <script src="/Public/Admin/js/jquery.min.js"></script>
    <script src="/Public/Admin/layer/layer.js"></script>
    <script src="/Public/Admin/js/common.js"></script>
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

    <link rel="stylesheet" type="text/css" href="/Public/Admin/js/plugins/datetimepick/css/lq.datetimepick.css"/>
    <style type="text/css">
        .headimg_wrap{position: relative; width: 166px; overflow: hidden;}
        .blurbg_wrap{width:200px;height: 100px;overflow: hidden; position: relative;}

        .headimg_bg{width:220px;height: 120px;z-index: 1; position: absolute;left: -10px;top:-10px;}
        .headimg_bg2{width:200px;height: 100px;z-index: 2; background: #fff;position: absolute;top:0;left: 0; opacity: .6;}
        .headimg{width: 40px; height: 40px;border-radius: 0px; position: absolute;z-index: 10; margin:auto;left:0; right:0; top:0; bottom:0; border:1px solid #fff; box-shadow: 1px 1px 3px rgba(0,0,0,.2); }
        .blur { 
            filter: url(blur.svg#blur); /* FireFox, Chrome, Opera */

            -webkit-filter: blur(10px); /* Chrome, Opera */
            -moz-filter: blur(10px);
            -ms-filter: blur(10px);    
                filter: blur(10px);
            filter: progid:DXImageTransform.Microsoft.Blur(PixelRadius=10, MakeShadow=false); /* IE6~IE9 */
        }

        .infoDetail p{
            text-align: left;margin:0;line-height: 28px;font-family:"Helvetica Neue",HelveticaNeue,"Microsoft YaHei",Arial,Helvetica,sans-serif; color:#555;
        }
        .infoDetail p span{text-align:right;width:70px; display: inline-block; font-weight: 400; color:#888; }
        .tags{ text-align: left; margin-top: 10px; }
        .tags span{
            padding: 1px 2px; background: #5397BF;border-radius: 2px; margin: 2px;display: inline-block; font-size: 12px;color:#fff;
        }
        .btns a{
            margin:0 5px 5px 0; display: inline-block;  
            -webkit-transition: all .1s linear;
        }
        .btns a{background: #fff; color:#333;border:1px solid #888;}
        /*.btns a.openWindow:hover{background: #1c84c6; color:#fff;border:1px solid #1c84c6;}*/
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
                            <!-- <span><img alt="image" class="img-circle" src="/Uploads/<?php echo ($admin['userimg']); ?>" width="70px" height="70px"/></span> -->
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
                                <p class="text-success"><a href="<?php echo U('Index/index');?>" title="返回首页" class="tip-bottom"><i class="fa fa-home"></i> 首页</a> /Pile
                                    <!-- <a href="<?php echo U('Admin/User/index');?>" class="tip-bottom">公告管理</a> /
                                    <a href="javascript:;" class="tip-bottom">猜你喜欢</a> -->
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
			</div>
		</div>
        <div class="row">
            <div class="col-sm-1">
                <a href="<?php echo U('add');?>" class="btn btn-primary btn-sm">添加</a>
            </div>
        </div>
        <br/>
		<div class="row">
			<div class="col-sm-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5><i class="fa fa-tasks"></i> Pile</h5>
					</div>
					<div class="ibox-content">
						<table class="table table-bordered">
							<thead>
								<tr class="long-tr">
									<th width="">#</th>
                                    <th width="">名称</th>
                                    <th width="">封面</th>
                                    <th width="">发售日</th>
                                    <th width="25%">操作</th>
								</tr>
							</thead>
							<tbody>
								<?php if(is_array($data)): $key = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?><tr class="long-td">
                                        <td><?php echo ($key); ?></td>
                                        <td><?php echo ($vo["name"]); ?></td>
                                        <td>
                                            <?php if($vo['cover1'] != null): ?><img src="/<?php echo ($vo['cover1']); ?>" width="100"/><?php endif; ?>
                                            <?php if($vo['cover2'] != null): ?><img src="/<?php echo ($vo['cover2']); ?>" width="100"/><?php endif; ?>
                                        </td>
                                        <td><?php echo (date("Y-m-d",$vo["rtime"])); ?></td>
					                    <td class="btns">
                                                <a href="<?php echo U('content',array('id'=>$vo['id']));?>" class="btn-sm btn-primary edit" style='background-color:#1b93e1;border-color:#1b93e1;color:#FFF;'>
                                                    <i class="fa fa-pencil"></i> 内容
                                                </a>
                                                <a href="<?php echo U('add',array('id'=>$vo['id']));?>" class="btn-sm btn-primary edit" style='background-color:#ff9496;border-color:#ff9496;color:#FFF;'>
                                                    <i class="fa fa-pencil"></i> 修改
                                                </a>
                                                <a href="javascript:;" data-id="<?php echo ($vo["id"]); ?>" class="btn-sm btn-danger del" style="background-color:#ed5565;border-color:#ed5565;color:#FFF;">
                                                    <i class="fa fa-trash-o"></i>删除
                                                </a>
                                        </td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
							</tbody>
						</table>
						<div class="pages" style=" text-align: right;">
							<?php echo ($page); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="footer" style="position: fixed;z-index: 999;bottom: 0;width: 89%;">
	<div class="pull-right"><?php echo C('address');?></div>
</div>
</div>
</div>
<script type="text/javascript" src="/Public/Admin/js/bootstrap.min.js?v=3.3.5"></script>
<script type="text/javascript" src="/Public/Admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script type="text/javascript" src="/Public/Admin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="/Public/Admin/js/plugins/layer/layer.min.js"></script>
<script type="text/javascript" src="/Public/Admin/js/hplus.min.js?v=4.0.0"></script>
<script type="text/javascript" src="/Public/Admin/js/contabs.min.js"></script>
<script type="text/javascript" src="/Public/Admin/js/plugins/pace/pace.min.js"></script>    
<script type="text/javascript" src="/Public/Admin/js/plugins/chosen/chosen.jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/js/plugins/iCheck/icheck.min.js"></script>
<script type="text/javascript" src="/Public/Admin/js/plugins/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript" src="/Public/Admin/js/jquery.form.js"></script>
<script>
    $(document).ready(function(){$(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",})});
</script>
	</body>
    <script type="text/javascript" src="/Public/Admin/js/plugins/datetimepick/js/lq.datetimepick.js"></script>
    <script type="text/javascript" src="/Public/Admin/js/plugins/datetimepick/js/selectUi.js"></script>
    <script type="text/javascript">
        $(".del").click(function(){
            var thi= $(this);            
            var id = thi.data("id");
            layer.confirm('确定删除？', {icon: 3}, function(index){
                $.getJSON('<?php echo U('del_user','','');?>/id/'+id,function(data){
                    layer.msg(data.msg,{skin:"layui-layer-hui",time:1000,end:function(){
                        if(data.status == 0){
                            window.location.reload();
                        }
                    }});
                });
            });
        });
    </script>
</html>