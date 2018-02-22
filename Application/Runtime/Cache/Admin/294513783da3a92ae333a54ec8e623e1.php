<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
<title><?php echo C('SITENAME');?></title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/lawyer/Public/Admin/css/bootstrap.min.css?v=3.3.5" rel="stylesheet">
    <link href="/lawyer/Public/Admin/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="/lawyer/Public/Admin/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/lawyer/Public/Admin/css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="/lawyer/Public/Admin/css/plugins/colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
    <link href="/lawyer/Public/Admin/css/plugins/cropper/cropper.min.css" rel="stylesheet">
    <link href="/lawyer/Public/Admin/css/plugins/switchery/switchery.css" rel="stylesheet">
    <link href="/lawyer/Public/Admin/css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">
    <link href="/lawyer/Public/Admin/css/plugins/nouslider/jquery.nouislider.css" rel="stylesheet">

    <link href="/lawyer/Public/Admin/css/plugins/datepicker/foundation-datepicker.css" rel="stylesheet">
    <link href="/lawyer/Public/Admin/css/plugins/clockpicker/clockpicker.css" rel="stylesheet">
    <link href="/lawyer/Public/Admin/css/animate.min.css" rel="stylesheet">  
    <link href="/lawyer/Public/Admin/css/style.min.css?v=4.0.0" rel="stylesheet">	
    <link href="/lawyer/Public/Admin/css/uploadfile.css" rel="stylesheet">
    <script src="/lawyer/Public/Admin/js/jquery.min.js"></script>
    <script src="/lawyer/Public/Admin/layer/layer.js"></script>
    <script src="/lawyer/Public/Admin/js/common.js"></script>
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
                            <!-- <span><img alt="image" class="img-circle" src="/lawyer/Uploads/<?php echo ($admin['userimg']); ?>" width="70px" height="70px"/></span> -->
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
					                ><a href="<?php echo U($vo['m'].'/'.$vo['a']);?>"><i class="icon <?php echo ($vo["ico"]); ?>"></i> <span><?php echo ($vo["title"]); ?></span>
					                	<span class="label label-danger pull-right">NEW</span></a></li>
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

		<div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-12">
                <h2>新闻列表</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="#"><i class="fa fa-home"></i> 主页</a>
                    </li>
                    <li>
                        <a>首页管理</a>
                    </li>
                    <li>
                        <strong>新闻列表</strong>
                    </li>
                </ol>
            </div>              
        </div>
                <div class="row">
            <!-- <div class="col-sm-1">
            <a href="<?php echo U('add');?>" class="btn btn-primary btn-sm">添加活动</a>
            </div> -->
            <div class="col-sm-10"><br/>
                <form action="/lawyer/Admin/News/lists" class="form-inline" method="get">
                    <div class="form-group">
                        <input type="text" class="form-control input-sm" id="title" placeholder="标题" name="title" value="<?php echo ($title); ?>" size="30">
                    </div>
                    <div class="form-group">
                        <select name="type" class="form-control input-sm">
                            <option value="" >类型</option>
                            <option value="1" <?php if($type == '1'): ?>selected="selected"<?php endif; ?>>新闻</option>
                            <option value="2" <?php if($type == '2'): ?>selected="selected"<?php endif; ?>>通知</option>
                            <option value="3" <?php if($type == '3'): ?>selected="selected"<?php endif; ?>>热点</option>
                            <option value="4" <?php if($type == '4'): ?>selected="selected"<?php endif; ?>>推广</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success btn-sm">搜索</button>
                    <a href="<?php echo U('news/addnews');?>" class="btn btn-primary btn-sm" style='float:right;'>添加新闻</a>
                </form>
            </div>
        </div><br/>
		<div class="row">
			<div class="col-sm-12">
				<div class="ibox float-e-margins">
					<div class="ibox-content">
						<table class="table table-bordered">
							<thead>
                                                            <tr class="long-tr">
                                                                <th width="20%">标题</th>
                                                                <th width="15%">封面</th>
                                                                <th width="12%">类型</th>
                                                                <th width="15%">发布者</th>
                                                                <th width="15%">发布时间</th>
                                                                <th>操作</th>
                                                            </tr>
							</thead>
							<tbody>
								<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="long-td">
                                                                            <td><?php echo ($vo["title"]); ?></td>
                                                                            <td>
                                                                                <div style="width:100%;max-height: 80px;overflow: hidden;">
                                                                                    <?php if($vo['posters']): $imgs = explode(',', $vo['posters']); ?>
                                                                                        <img src="<?php echo ($imgs[0]); ?>" onerror="this.src='/lawyer/Public/Admin/img/no_img.jpg'" style="width:90%;" />
                                                                                        <?php else: ?>无<?php endif; ?>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <?php switch($vo["catid"]): case "1": ?>新闻<?php break;?> 
                                                                                    <?php case "2": ?>通知<?php break;?>
                                                                                    <?php case "3": ?>热点<?php break;?>
                                                                                    <?php case "4": ?>推广<?php break; endswitch;?>
                                                                            </td>
                                                                            <td><?php echo ($vo["author"]); ?></td>
                                                                            <td><?php echo (date('Y-m-d H:i',$vo["releasetime"])); ?></td>
                                                                            <td>
                                                                                <a href="<?php echo U('addnews',array('nid'=>$vo['nid']));?>" class="btn-sm btn-primary btn-mini">
                                                                                       编辑</a>&nbsp;&nbsp;
                                                                                       <a href="javascript:;" data-tid="<?php echo ($vo["nid"]); ?>" class="btn-sm btn-primary comments">
                                                                                                    评论</a>
                                                                                <?php if($vo['isrcmd'] == 0): ?><a href="<?php echo U('rcmd',array('nid'=>$vo['nid'],'isrcmd'=>1));?>" class="btn-sm btn-primary btnrcmd">
                                                                                                 推荐
                                                                                    </a>
                                                                                    <?php else: ?>
                                                                                    <a href="<?php echo U('rcmd',array('nid'=>$vo['nid'],'isrcmd'=>0));?>" class="btn-sm btn-primary btnrcmd">
                                                                                                 取消推荐
                                                                                    </a><?php endif; ?>&nbsp;&nbsp;
                                                                                <a href="javascript:;" onclick="return del(<?php echo ($vo["nid"]); ?>);" class="btn-sm btn-danger">
                                                                                        删除</a>
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

		<script type="text/javascript">
		function del(id){
                    layer.confirm('确认删除该新闻？', {icon: 3}, function(index){
                        layer.close(index);
                        $.post("<?php echo U('delnews');?>",{nid:id},function(data){
                            layer.msg(data.msg,{skin:"layui-layer-hui",time:1500,end:function(){
                                if(data.status == 0){
                                    window.location.reload();
                                }   
                            }});
                        });
                    });
		}
                $("a.btnrcmd").click(function(){
                    var url = $(this).attr('href');
                    $.get(url,{},function(data){
                         layer.msg(data.msg,{skin:"layui-layer-hui",time:1500,end:function(){
                              if(data.status == 0){
                                  window.location.href = "<?php echo U('lists');?>";
                              }
                         }});
                    });
                    return false;
                });
                
                $(".comments").click(function(){
                    var tid = $(this).data("tid");
                    url ="<?php echo U('comments');?>?tid="+tid;
                    var index = layer.open({
                        type: 2,
                        title:'新闻评论列表',
                        content: url,
                        area: ['800px', '600px'],
                        shadeClose: true,
                        skin: 'layui-layer-rim',
                        maxmin: true,
                        scrollbar: true,
                    });
                });
		</script>

		<div class="footer" style="position: fixed;z-index: 999;bottom: 0;width: 89%;">
	<div class="pull-right"><?php echo C('address');?></div>
</div>
</div>
</div>
<script type="text/javascript" src="/lawyer/Public/Admin/js/bootstrap.min.js?v=3.3.5"></script>
<script type="text/javascript" src="/lawyer/Public/Admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script type="text/javascript" src="/lawyer/Public/Admin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="/lawyer/Public/Admin/js/plugins/layer/layer.min.js"></script>
<script type="text/javascript" src="/lawyer/Public/Admin/js/hplus.min.js?v=4.0.0"></script>
<script type="text/javascript" src="/lawyer/Public/Admin/js/contabs.min.js"></script>
<script type="text/javascript" src="/lawyer/Public/Admin/js/plugins/pace/pace.min.js"></script>    
<script type="text/javascript" src="/lawyer/Public/Admin/js/plugins/chosen/chosen.jquery.js"></script>
<script type="text/javascript" src="/lawyer/Public/Admin/js/plugins/iCheck/icheck.min.js"></script>
<script type="text/javascript" src="/lawyer/Public/Admin/js/plugins/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript" src="/lawyer/Public/Admin/js/jquery.form.js"></script>
<script>
    $(document).ready(function(){$(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",})});
</script>
	</body>
</html>