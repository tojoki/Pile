<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<title>版本管理</title>
<link rel="stylesheet" type="text/css" href="/lawyer/Public/Admin/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="/lawyer/Public/Admin/bootstrap-table/bootstrap-table.min.css" />
<link rel="stylesheet" type="text/css" href="/lawyer/Public/Admin/bootstrap-table/bootstrap-editable.css" />
<link rel="stylesheet" type="text/css" href="/lawyer/Public/Admin/css/plugins/iCheck/custom.css" />
<link rel="stylesheet" type="text/css" href="/lawyer/Public/Admin/css/style.min.css?v=4.0.0" />
<script type="text/javascript" src="/lawyer/Public/Admin/js/jquery.min.js"></script>
<script type="text/javascript" src="/lawyer/Public/Admin/js/bootstrap.min.js?v=3.3.5"></script>
<script type="text/javascript" src="/lawyer/Public/Admin/js/plugins/layer/layer.min.js"></script>

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
                            <form class="form-horizontal form-border" action="/lawyer/Admin/Benefit/editRule" id="form" method="post">
                            <input name="rule_id" value="<?php echo ($info["rule_id"]); ?>" type="hidden" />
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">规则名称</label>
                                        <div class="col-sm-4 rightText">
                                            <input type="text" name="name" id="name" placeholder="输入版本名称" class="form-control" value="<?php echo ($info["name"]); ?>">
                                        </div>
                                    </div>
                                    <div class="hr"></div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">面值</label>
                                        <div class="col-sm-4 rightText">
                                            <input type="text" name="amount" id="amount" placeholder="输入版本号" class="form-control" value="<?php echo ($info["amount"]); ?>">
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
<script type="text/javascript" src="/lawyer/Public/Admin/js/plugins/switchery/switchery.js"></script><!--IOS开关样式-->
<script type="text/javascript" src="/lawyer/Public/Admin/js/plugins/iCheck/icheck.min.js"></script>
<script type="text/javascript" src="/lawyer/Public/Common/js/uploadify/jquery.uploadify.min.js"></script>
<script type="text/javascript" src="/lawyer/Public/Admin/js/plugins/chosen/chosen.jquery.js"></script>
<script type="text/javascript" src="/lawyer/Public/Admin/js//plugins/Validform/Validform_v5.3.1_min.js"></script>

<link rel="stylesheet" type="text/css" href="/lawyer/Public/Admin/css/plugins/switchery/switchery.css" />
<link rel="stylesheet" type="text/css" href="/lawyer/Public/Admin/css/plugins/Validform/validform.css" />
<link rel="stylesheet" type="text/css" href="/lawyer/Public/Common/js/uploadify/uploadify.css" />
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/plugins/chosen/chosen.css" />


<script type="text/javascript">
$(document).ready(function(){
    $(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",})


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
            ele : '#amount',
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