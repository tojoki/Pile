<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<title>版本管理</title>
<link rel="stylesheet" type="text/css" href="/xj_property/Public/Admin/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="/xj_property/Public/Admin/bootstrap-table/bootstrap-table.min.css" />
<link rel="stylesheet" type="text/css" href="/xj_property/Public/Admin/bootstrap-table/bootstrap-editable.css" />
<link rel="stylesheet" type="text/css" href="/xj_property/Public/Admin/css/plugins/iCheck/custom.css" />
<link rel="stylesheet" type="text/css" href="/xj_property/Public/Admin/css/style.min.css?v=4.0.0" />
<script type="text/javascript" src="/xj_property/Public/Admin/js/jquery.min.js"></script>
<script type="text/javascript" src="/xj_property/Public/Admin/js/bootstrap.min.js?v=3.3.5"></script>
<script type="text/javascript" src="/xj_property/Public/Admin/js/plugins/layer/layer.min.js"></script>

<style type="text/css">
    .rightText{text-align:left;color:#555; line-height: 30px; font-weight: 400;}
    .amount{ font-size:18px;color: red; font-family: Arial,Verdana,"\5b8b\4f53";}
    .bd{font-weight: bold; font-family: Arial,Verdana,"\5b8b\4f53";}
    .hr{
        height: 0px; line-height: 0px; font-size: 0px; border-bottom: 1px solid #f5f5f5;margin-bottom: 5px;
    }
    .chosen-container-single .chosen-single{
        line-height: 28px!important;
    }
    .form-group{margin-bottom: 5px!important;}
    .switchery{height: 20px!important; width: 40px!important;} 
    .switchery > small{height: 20px!important;width: 20px!important;}
    .radio{padding-top: 0!important;}
    .red{color: red}
    .green{color:green;}
    
</style>
</head>
	<body class="fixed-sidebar full-height-layout gray-bg">
    <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                            <form class="form-horizontal form-border" action="<?php echo U('system/versionadd');?>" id="form" method="post">
                            <?php if(!empty($data)): ?><input name="vid" value="<?php echo ($data["vid"]); ?>" type="hidden" /><?php endif; ?>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">版本名称</label>
                                        <div class="col-sm-4 rightText">
                                            <input type="text" name="name" id="name" placeholder="输入版本名称" class="form-control" value="<?php echo ($data["name"]); ?>">
                                        </div>
                                    </div>
                                    <div class="hr"></div>

                                    <div class="form-group" style="display:none;">
                                        <label class="col-sm-3 control-label">系统平台</label>
                                        <div class="col-sm-4 ">
                                            <select name="system" id="system" class="form-control chosen-select" id="mid">
                                                <option value="android" <?php if($data["system"] == 'android'): ?>selected="selected"<?php endif; ?>>安卓</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="hr"></div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">版本号</label>
                                        <div class="col-sm-4 rightText">
                                            <input type="text" name="version" id="version" placeholder="输入版本号" class="form-control" value="<?php echo ($data["version"]); ?>">
                                        </div>
                                    </div>
                                    <div class="hr"></div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">版本类型</label>
                                        <div class="col-sm-4 rightText">
                                            <input name='type_id' <?=$data['type_id']==1?'checked':''?> type='radio' value='1' class='type_id'>用户端
                                            <input name='type_id' <?=$data['type_id']==2?'checked':''?> type='radio' value='2' class='type_id'>洗车端
                                            <input name='type_id' <?=$data['type_id']==3?'checked':''?> type='radio' value='3' class='type_id'>美容美发端
                                        </div>
                                    </div>
                                    <div class="hr"></div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">升级内容</label>
                                        <div class="col-sm-5 rightText">
                                            <textarea class="form-control" style="height:120px;" name="describe" id="describe"><?php echo ($data["describe"]); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="hr"></div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">下载文件</label>
                                        <div class="col-sm-3 rightText">

                                            <input type="text" name="download" readonly="readonly" id="download" placeholder="文件地址" class="form-control m-t-none readonly" value="<?php echo ($data["filepath"]); ?>">    

                                        </div>
                                        <div class="col-sm-3">
                                            <input id="file" name="file" type="file" multiple="true" value="" />
                                        </div>
                                    </div>

                                    <div class="hr"></div>
                                    <div class="form-group" style='display: none;'>
                                        <label class="col-sm-3 control-label">升级方式</label>
                                        <div class="col-sm-4 rightText">
                                            <div class="radio i-checks">
                                            <label>
                                            <input type="radio" checked  value="0" name="force" id="force"> <i></i> 选择升级
                                            </label>
                                            <label>
                                            <input type="radio"  value="1" name="force" id="force"> <i></i> 强制升级
                                            </label>
                                            </div>  
                                        </div>
                                    </div>

                                    <div class="hr"></div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-9 col-sm-9">
                                        <?php if(empty($data["state"])): ?><button type="submit" class="btn btn-success">保存</button><?php endif; ?>
                                            <a href="javascript:;" class="btn btn-default closeIframe">关闭</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
	</body>
<script type="text/javascript" src="/xj_property/Public/Admin/js/plugins/switchery/switchery.js"></script><!--IOS开关样式-->
<script type="text/javascript" src="/xj_property/Public/Admin/js/plugins/iCheck/icheck.min.js"></script>
<script type="text/javascript" src="/xj_property/Public/Common/js/uploadify/jquery.uploadify.min.js"></script>
<script type="text/javascript" src="/xj_property/Public/Admin/js/plugins/chosen/chosen.jquery.js"></script>
<script type="text/javascript" src="/xj_property/Public/Admin/js//plugins/Validform/Validform_v5.3.1_min.js"></script>

<link rel="stylesheet" type="text/css" href="/xj_property/Public/Admin/css/plugins/switchery/switchery.css" />
<link rel="stylesheet" type="text/css" href="/xj_property/Public/Admin/css/plugins/Validform/validform.css" />
<link rel="stylesheet" type="text/css" href="/xj_property/Public/Common/js/uploadify/uploadify.css" />
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/plugins/chosen/chosen.css" />


<script type="text/javascript">
$(document).ready(function(){
    $(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",})
    // $(".confirm").click(function(){
    //     layer.confirm('确定更改订单？', {icon: 3}, function(index){
    //         $("#form").submit();
    //     });
    // });
    //文件上传
    $("#file").uploadify({
        'swf': '/xj_property/Public/Common/js/uploadify/uploadify.swf?t=<?php echo ($nowtime); ?>',
        'uploader': '<?php echo U("Upload/uploadFile");?>',
        'cancelImg': '/xj_property/Public/Common/js/uploadify/uploadify-cancel.png',
        'buttonText': '文件上传',
        'height': 35,
        'fileTypeExts': '*.apk',
        'queueSizeLimit': 1,
        'onUploadSuccess': function(file, data, response) {
            $("#download").attr('value', '/Uploads' + data);
        }
    });

    //窗口关闭
    var index = parent.layer.getFrameIndex(window.name);
    $('.closeIframe').click(function(){
        parent.layer.close(index);
    });


    //表单验证
    var valid = $("#form").Validform({
        tiptype:function(msg){
            layer.msg(msg,{skin:"layui-layer-hui",time:1000});
        },
        tipSweep:true,
        postonce:true,
        beforeSubmit:function(form){
          // return false;
        },
        ajaxPost:true,
        callback:function(data){
            layer.msg(data.returnMsg,{skin:"layui-layer-hui",time:1000,end:function(){
                if(data.returnCode == 'SUCCESS')parent.location.reload(); //重载父页面
            }});
        }
    });

    valid.addRule([
        {
            ele : '#name',
            datatype: '*',
        },
        {
            ele : '#version',
            datatype: '*',
        },
        {
            ele : '.type_id',
            datatype: '*',
        },
        {
            ele : '#download',
            datatype: '*',
        },
        {
            ele : '#force',
            datatype: '*',
        },
    ]);

});

//复选框
var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem, {
            color: '#1AB394',
        });

//下拉框
var config = {
    '.chosen-select': {},                    
}
for (var selector in config) {
    $(selector).chosen(config[selector]);
}

</script>
</html>