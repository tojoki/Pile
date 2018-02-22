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

        <link rel="stylesheet" type="text/css" href="/lawyer/Public/Admin/css/goods/goods.base.css" />
        <script type="text/javascript" src="/lawyer/Public/Admin/js/plugins/webuploader/webuploader.min.js"></script>
        <link rel="stylesheet" type="text/css" href="/lawyer/Public/Admin/css/plugins/webuploader/webuploader.css" />
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
                <h2>编辑新闻</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo U('Index/index');?>" title="返回首页" class="tip-bottom"> 主页</a>
                    </li>
                    <li>
                        <a href="javascript:;" class="tip-bottom">首页管理</a>
                    </li>
                    <li>
                        <strong>编辑新闻</strong>
                    </li>
                </ol>
            </div>              
        </div>
        <br/>
		<div class="row">
			<div class="col-sm-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
                                            <h5>编辑新闻</h5>
                                            <div class="ibox-tools">
                                                <a class="collapse-link">
                                                    <i class="fa fa-chevron-up"></i>
                                                </a>
                                            </div>
					</div>
					<div class="ibox-content">
						<form class="form-horizontal" method="post" action="/lawyer/Admin/News/addnews" name="basic_validate" id="myform">
                                                        <?php if(!empty($data)): ?><input name="nid" type="hidden" value="<?php echo ($data["nid"]); ?>"/><?php endif; ?>
                                                       <div class="form-group">
                                                            <label class="col-sm-2 control-label">类型</label>
                                                            <div class="col-sm-3">
                                                                <select name="catid" datatype="*" nullmsg="请选择类型" class="form-control">
                                                                    <option value="" >请选择</option>
                                                                    <option value="1" <?php if($data['catid'] == '1'): ?>selected<?php endif; ?> >新闻</option>
                                                                    <option value="2" <?php if($data['catid'] == '2'): ?>selected<?php endif; ?>>通知</option>
                                                                    <option value="3" <?php if($data['catid'] == '3'): ?>selected<?php endif; ?>>热点</option>
                                                                    <option value="4" <?php if($data['catid'] == '4'): ?>selected<?php endif; ?>>推广</option>
                                                                </select>
                                                            </div>
							</div>
                                                        <div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">标题</label>
								<div class="col-sm-6">
									<input type="text" datatype="*" nullmsg="请填写标题" name="title" placeholder="标题" class="form-control" value="<?php echo ($data["title"]); ?>">
								</div>
							</div>
                                                        <div class="hr-line-dashed"></div>
                                                        <div class="form-group">
                                                                <label class="col-sm-2 control-label">发布者</label>
                                                                <div class="col-sm-3">
									<input type="text" datatype="*" nullmsg="请填写发布者" name="author" placeholder="发布者" class="form-control" value="<?php echo ($data["author"]); ?>">
								</div>
                                                                <label class="col-sm-1 control-label">发布时间</label>
                                                                <div class="col-sm-2">
                                                                    <input type="text"  name="releasetime" placeholder="发布时间" id="releasetime" readonly  value="<?php if($data) echo date('Y-m-d H:i',$data['releasetime']); ?>"  class="form-control">
                                                                </div>
                                                        </div>
                                                        <input type="hidden" name="pictures" id="pictures"  nullmsg="请上传封面图片"  value="<?php echo ($data["posters"]); ?>"/>
                                                        <div class="hr-line-dashed"></div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">封面图片</label>
                                                            <div class="col-sm-10">  
                                                                <div class="row">  
                                                                    <div class="col-sm-10" id="uploadImgWrap">
                                                                    <?php if(is_array($data["posters"])): $i = 0; $__LIST__ = $data["posters"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pic): $mod = ($i % 2 );++$i;?><div class="uploadImgItem" draggable="false"><img src="<?php echo ($pic); ?>"  realpath="<?php echo ($pic); ?>" draggable="false"><p class="state succ">已上传</p><i class="fa fa-close delBtn"></i><div class="progress progress-striped active" style="display: none;"><div class="progress-bar" role="progressbar" style="width: 100%;"></div></div></div><?php endforeach; endif; else: echo "" ;endif; ?>
                                                                    </div>
                                                                </div> 
                                                                <div class="row">
                                                                    <div class="btns col-sm-10">
                                                                        <div id="picker" class="pull-left">选择图片</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
<!--							<div class="hr-line-dashed"></div>
                                                        <div class="form-group">
                                                                <label class="col-sm-2 control-label">排序值</label>
								<div class=" col-sm-2">
									<input type="text" name="sortval" datatype="n" nullmsg="请填写排序值" errormsg="排序值格式错误" placeholder="排序值" class="form-control m-t-none" value="<?php echo ((isset($data["sortval"]) && ($data["sortval"] !== ""))?($data["sortval"]):0); ?>">
								</div>
							</div>-->
                                                        <div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-2 control-label">新闻内容</label>
								<div class="col-sm-10">
                                                                    <script type="text/plain" id="editor" name="content" style="width:90%;height:300px;"><?php echo htmlspecialchars_decode($data['content']);?></script>
                                                                </div>
							</div>
                                                        <div class="hr-line-dashed"></div>
							<div class="form-group">
								<div class="col-sm-4 col-sm-offset-2">
                                                                    <button class="btn btn-primary" type="submit">保存</button>
                                                                    <a class="btn btn-white" href="javascript:history.back();">取消</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
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
        <script src='/lawyer/Public/Admin/js/plugins/laydate/laydate.js' /></script>
	<script type="text/javascript" src="/lawyer/Public/Common/js/uploadify/jquery.uploadify.min.js"></script>		
	<link rel="stylesheet" href="/lawyer/Public/Common/js/uploadify/uploadify.css"> 
        <script type="text/javascript" src='/lawyer/Public/Admin/js/plugins/Validform/Validform_v5.3.1_min.js'></script>
        <style type="text/css" src='/lawyer/Public/Admin/css/plugins/Validform/validform.css'></style>
        <script type="text/javascript" charset="utf-8" src="/lawyer/Public/Common/Ueditor/ueditor.config.js"></script>
	<script type="text/javascript" charset="utf-8" src="/lawyer/Public/Common/Ueditor/ueditor.all.min.js"></script>
	<script type="text/javascript">
            var uploadUrl = '<?php echo U("Upload/upload");?>'; //图片上传地址
            var swfpath = '/lawyer/Public/Admin/js/plugins/webuploader/Uploader.swf';
            var succpath = "<?php echo U('lists');?>";
            $.extend($.Datatype,{
            "price" : /^[0-9]+(\.[0-9]{1,2})?$/
          });
            $("#photo_file").uploadify({
                'swf': '/lawyer/Public/Common/js/uploadify/uploadify.swf',
                'uploader': '<?php echo U("Upload/upload");?>',
                'cancelImg': '/lawyer/Public/Common/js/uploadify/uploadify-cancel.png',
                'buttonText': '上传图片',
                'height': 35,
                'fileTypeExts': '*.gif;*.jpg;*.png',
                'queueSizeLimit': 1,
                'onUploadSuccess': function(file, data, response) {
                    $("#poster").val('/Uploads' + data);
                    $("#upload_img").attr('src', '/lawyer/Uploads' + data).show();
                }
            });
            function dialog(msg){
                layer.msg(msg,{skin:"layui-layer-hui",time:1500});
            }
           
            function show_result_msg(msg,o,cssctl){
                if(o.type>2){
                    layer.msg(msg,{skin:"layui-layer-hui",time:1500});
                    return false;
                }
            }
            function show_hint(msg){
                layer.msg(msg,{skin:"layui-layer-hui",time:1500});
            }
            $(document).ready(function(){
                    var valid = $("#myform").Validform({
                    tiptype:show_result_msg,
                    tipSweep:true,
                    postonce:true,
                    ajaxPost:true,
                    beforeSubmit:function(form){
                        var txt = ue.getContent();
                        if(txt == ''){
                            show_hint('请填写新闻详情');
                            return false;
                        }
                        var goods_pics = '';
                        $("#uploadImgWrap img").each(function(i,img){
                            if(goods_pics == ''){
                                goods_pics = $(this).attr('realpath');
                            }else{
                                goods_pics += ',' + $(this).attr('realpath');
                            }
                        });
                        $('#pictures').val(goods_pics);
                        return true;
            },
                    callback:function(data){
                        layer.msg(data.msg,{skin:"layui-layer-hui",time:1500,end:function(){
                            if(data.status == 0){
                                window.location.href = succpath;
                            }
                        }});
                    }
                });
            });
            
            //时间
            var options = {        
            event:'click',
            format: 'YYYY-MM-DD hh:mm', //日期格式 hh:mm:ss
            istime: true, //是否开启时间选择
            isclear: true, //是否显示清空
            istoday: true, //是否显示今天
            issure: true, //是否显示确认
            festival: false, //是否显示节日
            choose: function(dates){ //选择好日期的回调

            }
        };
        options.elem = '#releasetime';
        laydate(options).skin('molv');
        
        var $list = $('#uploadImgWrap'),
        $btn  = $('#ctlBtn'),
        state = 'pending',
        uploader;
        //图片上传webuploader
    var uploader = WebUploader.create({
        auto : true,
        swf: swfpath,
        server: uploadUrl,
        pick: '#picker',
        resize: true,
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        }
    });
    // 当有文件添加进来的时候
    uploader.on( 'fileQueued', function( file ) {        
        console.log(file.id);
        var $li = $(
                '<div id="' + (file.id) + '" class="uploadImgItem">' +
                    '<img>' +
                    // '<div class="info">' + file.name + '</div>' +
                    '<p class="state"></p>'+
                    '<i class="fa fa-close delBtn"></i>'+
                '</div>'
                ),
            $img = $li.find('img');
        $list.append( $li );
        // 创建缩略图
        // thumbnailWidth x thumbnailHeight 为 100 x 100
        uploader.makeThumb( file, function( error, src ) {
            if ( error ) {
                $img.replaceWith('<span>不能预览</span>');
                return;
            }
            $img.attr( 'src', src );
        }, 100, 100 );
    });

    // 文件上传过程中创建进度条实时显示。
    uploader.on( 'uploadProgress', function( file, percentage ) {
        var $li = $( '#'+file.id ),
            $percent = $li.find('.progress .progress-bar');

        // 避免重复创建
        if ( !$percent.length ) {
            $percent = $('<div class="progress progress-striped active">' +
              '<div class="progress-bar" role="progressbar" style="width: 0%">' +
              '</div>' +
            '</div>').appendTo( $li ).find('.progress-bar');
        }

        $li.find('p.state').text('上传中');
        $percent.css( 'width', percentage * 100 + '%' );
    });
    uploader.on( 'uploadSuccess', function( file , rsObj) {
        // console.log(rsObj._raw);
        $( '#'+file.id+' img').attr('realpath','/Uploads'+rsObj._raw);
        $( '#'+file.id ).find('p.state').text('已上传').addClass('succ');
    });

    uploader.on( 'uploadError', function( file ) {
        $( '#'+file.id ).find('p.state').text('上传出错').addClass('err');
    });

    uploader.on( 'uploadComplete', function( file ) {
        $( '#'+file.id ).find('.progress').fadeOut();
    });

    $(document).on('click','.delBtn',function(){
        $(this).parents('.uploadImgItem').remove();
    });
    
    //编辑器
        var ue = UE.getEditor('editor');
	</script>
	</body>
</html>