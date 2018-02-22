<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
    <head>
<title><?php echo C('SITENAME');?></title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/xj_property/Public/Admin/css/bootstrap.min.css?v=3.3.5" rel="stylesheet">
    <link href="/xj_property/Public/Admin/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="/xj_property/Public/Admin/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/xj_property/Public/Admin/css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="/xj_property/Public/Admin/css/plugins/colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
    <link href="/xj_property/Public/Admin/css/plugins/cropper/cropper.min.css" rel="stylesheet">
    <link href="/xj_property/Public/Admin/css/plugins/switchery/switchery.css" rel="stylesheet">
    <link href="/xj_property/Public/Admin/css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">
    <link href="/xj_property/Public/Admin/css/plugins/nouslider/jquery.nouislider.css" rel="stylesheet">

    <link href="/xj_property/Public/Admin/css/plugins/datepicker/foundation-datepicker.css" rel="stylesheet">
    <link href="/xj_property/Public/Admin/css/plugins/clockpicker/clockpicker.css" rel="stylesheet">
    <link href="/xj_property/Public/Admin/css/animate.min.css" rel="stylesheet">  
    <link href="/xj_property/Public/Admin/css/style.min.css?v=4.0.0" rel="stylesheet">	
    <link href="/xj_property/Public/Admin/css/uploadfile.css" rel="stylesheet">
    <script src="/xj_property/Public/Admin/js/jquery.min.js"></script>
    <script src="/xj_property/Public/Admin/layer/layer.js"></script>
    <script src="/xj_property/Public/Admin/js/common.js"></script>
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

        <link rel="stylesheet" type="text/css" href="/xj_property/Public/Admin/css/goods/goods.base.css" />
        <script type="text/javascript" src="/xj_property/Public/Admin/js/plugins/webuploader/webuploader.min.js"></script>
        <link rel="stylesheet" type="text/css" href="/xj_property/Public/Admin/css/plugins/webuploader/webuploader.css" />

        <script type="text/javascript" src='/xj_property/Public/Admin/js/plugins/Validform/Validform_v5.3.1_min.js'></script>
        <style type="text/css" src='/xj_property/Public/Admin/css/plugins/Validform/validform.css'></style>

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
                            <!-- <span><img alt="image" class="img-circle" src="/xj_property/Uploads/<?php echo ($admin['userimg']); ?>" width="70px" height="70px"/></span> -->
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

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-12">
                <h2></h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo U('Index/index');?>" title="返回首页" class="tip-bottom"> 主页</a>
                    </li>
                    <li>
                        <a href="javascript:;" class="tip-bottom">公告管理</a>
                    </li>
                    <li>
                        <strong>物业公告</strong>
                    </li>
                </ol>
            </div>              
        </div>
        <br/>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>物业公告</h5>
                        <div class="ibox-tools"></div>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal" method="post" action="<?php echo U('add');?>" name="basic_validate" id="productForm">

                            <input type="hidden" name="id" value="<?php echo ($info['notice_id']); ?>" />
                            <div class="form-group">
                                <label class="col-sm-2 control-label">标题</label>
                                <div class="col-sm-6">
                                    <input type="text" datatype="*" nullmsg="请填写标题" placeholder="请输入标题" value="<?php echo ($info['title']); ?>"  name="title"  class="form-control">
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">简介</label>
                                <div class="col-sm-6">
                                        <input type="text" datatype="*" nullmsg="请填写简介" placeholder="请输入简介" value="<?php echo ($info['intro']); ?>"  name="intro"  class="form-control">
                                </div>
                            </div>

                            <!-- <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">优惠券面额</label>
                                <div class="col-sm-6">
                                        <input type="text" datatype="*" nullmsg="请填写优惠券面额" placeholder="请输入优惠券面额" value="<?php echo ($info['amount']); ?>"  name="amount"  class="form-control" onkeyup="value=(parseInt((value=value.replace(/\D/g,''))==''||parseInt((value=value.replace(/\D/g,''))==0)?'0':value,10))">
                                </div>
                            </div> -->

                            <div class="hr"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">封面</label>
                                <div class="col-sm-10">
                                    <div class="row" style="float:left;">
                                        <input type="hidden" name="cover" value="<?php echo ($info['cover']); ?>" />
                                        <div class="col-sm-10 my_img">
                                        <?php
 if($info['cover']){ ?>
                                            <img src="/xj_property/<?php echo ($info['cover']); ?>" width="100" />
                                        <?php
 } ?>
                                        </div>
                                    </div>                  
                                    <div class="row">
                                        <div class="btns col-sm-10" style="float:right;width: 85%;">
                                        <input style="margin-top: 60px;background: #3bd;color: #fff;" type="button" class="btn bg-blue margin-left" id="upload" value="+ 浏览上传" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                                <!-- <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                            <label class="col-sm-2 control-label">活动时间</label>
                                            <div class="col-sm-3">
                                                <input type="text"  name="starttime" datatype="*" placeholder="请设置开始时间" id="starttime" readonly nullmsg="请设置开始时间" value="<?php if($info) echo date('Y-m-d H:i:s',$info['starttime']); ?>" class="form-control">
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="text"  name="endtime" datatype="*" placeholder="请设置结束时间" id="endtime" readonly nullmsg="请设置结束时间" value="<?php if($info) echo date('Y-m-d H:i:s',$info['deadtime']); ?>"  class="form-control">
                                            </div>
                                    </div> -->
                                
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">内容</label>
                                    <div class="col-sm-8">
                                            <!-- 加载编辑器的容器 -->
                                            <script type="text/plain" id="container" name="content" style="width:100%;height:300px;"><?php echo htmlspecialchars_decode($info['content']);?></script>
                                    </div>
                                </div>

                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                        <div class="col-sm-6 col-sm-offset-4">
                                            <button class="btn btn-primary" id="save" type="submit">提交</button>
                                            <a class="btn btn-danger" href="javascript:history.back()">取消</a>
                                        </div>
                                </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
        <form id="upload_form" method="post"  action="/xj_property/Admin/Notice/upload" style="display: none;"   enctype="multipart/form-data">
            <input type="file" name="file" id="cower" value="" style="display: none;" />
        </form>
<div class="footer" style="position: fixed;z-index: 999;bottom: 0;width: 89%;">
	<div class="pull-right"><?php echo C('address');?></div>
</div>
</div>
</div>
<script type="text/javascript" src="/xj_property/Public/Admin/js/bootstrap.min.js?v=3.3.5"></script>
<script type="text/javascript" src="/xj_property/Public/Admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script type="text/javascript" src="/xj_property/Public/Admin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="/xj_property/Public/Admin/js/plugins/layer/layer.min.js"></script>
<script type="text/javascript" src="/xj_property/Public/Admin/js/hplus.min.js?v=4.0.0"></script>
<script type="text/javascript" src="/xj_property/Public/Admin/js/contabs.min.js"></script>
<script type="text/javascript" src="/xj_property/Public/Admin/js/plugins/pace/pace.min.js"></script>    
<script type="text/javascript" src="/xj_property/Public/Admin/js/plugins/chosen/chosen.jquery.js"></script>
<script type="text/javascript" src="/xj_property/Public/Admin/js/plugins/iCheck/icheck.min.js"></script>
<script type="text/javascript" src="/xj_property/Public/Admin/js/plugins/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript" src="/xj_property/Public/Admin/js/jquery.form.js"></script>
<script>
    $(document).ready(function(){$(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",})});
</script>
<script src="/xj_property/Public/Admin/js/plugins/validate/jquery.validate.min.js"></script>
<script src='/xj_property/Public/Admin/js/plugins/laydate/laydate.js' /></script>
<script type="text/javascript" charset="utf-8" src="/xj_property/Public/Common/Ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/xj_property/Public/Common/Ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" src="/xj_property/Public/Admin/js/jquery.form.js"></script>
<script type="text/javascript" src="/xj_property/Public/Admin/js/pagejs/banner.js"></script>
</body>
</html>

<script type="text/javascript">
    var succpath="<?php echo U('lists');?>";
    //编辑器
    var ue = UE.getEditor('container');

  //上传头像
  jQuery("#upload").click(function () {
      var options = {
          resetForm:true,
          dataType:'json',
          data:{node:''},
          url:"<?php echo U('upload');?>",
          success:function(data) {
            console.log(data);
              if(data.status == 2){
                  $('.my_img').html('');
                  $('input[name="cover"]').val(data.path);
                  var root="<?='/xj_property/'?>";
                  $('.my_img').append('<img style="width: 118px;height: 100px;" src="'+root+data.path+'" />');
              }
          }
      }


      jQuery("#upload_form").ajaxForm(options);
      $("#cower").click();
  });
  jQuery("#cower").change(function () {
        jQuery("#upload_form").submit();
  });

  var start = {
    elem: '#starttime',
    format: 'YYYY/MM/DD hh:mm:ss',
    min: laydate.now(), //设定最小日期为当前日期
    max: '2099-06-16 23:59:59', //最大日期
    istime: true,
    istoday: false,
    choose: function(datas){
       end.min = datas; //开始日选好后，重置结束日的最小日期
       end.start = datas //将结束日的初始值设定为开始日
    }
  };
  var end = {
    elem: '#endtime',
    format: 'YYYY/MM/DD hh:mm:ss',
    min: laydate.now(),
    max: '2099-06-16 23:59:59',
    istime: true,
    istoday: false,
    choose: function(datas){
      start.max = datas; //结束日选好后，重置开始日的最大日期
    }
  };
  laydate(start);
  laydate(end);
</script>