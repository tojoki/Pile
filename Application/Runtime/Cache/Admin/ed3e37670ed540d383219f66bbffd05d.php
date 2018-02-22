<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<title>用户资料修改</title>
<link href="/xj_property/Public/Admin/css/bootstrap.min.css" rel="stylesheet">
<link href="/xj_property/Public/Admin/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
<link href="/xj_property/Public/Admin/bootstrap-table/bootstrap-editable.css" rel="stylesheet">
<link href="/xj_property/Public/Admin/css/plugins/iCheck/custom.css" rel="stylesheet">
<link href="/xj_property/Public/Admin/css/style.min.css?v=4.0.0" rel="stylesheet">
<script src="/xj_property/Public/Admin/js/jquery.min.js"></script>
<script src="/xj_property/Public/Admin/js/bootstrap.min.js?v=3.3.5"></script>
<script type="text/javascript" src="/xj_property/Public/Admin/js/plugins/layer/layer.min.js"></script>
<style type="text/css">
    .rightText{text-align:left;color:#555; line-height: 30px; font-weight: 400;}
    .hr{
        height: 0px; line-height: 0px; font-size: 0px; border-bottom: 1px solid #f5f5f5;margin-bottom: 5px;
    }
    .form-group{margin-bottom: 5px!important;}
    .switchery{height: 20px!important; width: 40px!important;} 
    .switchery > small{height: 20px!important;width: 20px!important;}
    .radio{padding-top: 0!important;}
    .tags{ text-align: left;  padding: 10px 0; text-align: center; background: #fff}
    .tags span{
    padding: 1px 2px; background: #3E6886;border-radius: 2px; margin: 2px; font-size: 12px;color:#fff;
    }
    .btns a{
    margin:0 5px 5px 0; display: inline-block;  
    -webkit-transition: all .1s linear;
    }
    .headimg_wrap{position: relative; width: 100%; overflow: hidden;}
    .blurbg_wrap{width:100%;height: 120px;overflow: hidden; position: relative;}

    .headimg_bg{width:120%;/*height: 150px;*/z-index: 1; position: absolute;left: -10px;top:-10px;}
    .headimg_bg2{width:120%;height: 150px;z-index: 2; background: #fff;position: absolute;top:0;left: 0; opacity: .0;}
    .headimg{width: 80px; height: 80px;border-radius: 50px; position: absolute;z-index: 10; margin:auto;left:0; right:0; top:0; bottom:0; border:3px solid #fff; box-shadow: 1px 1px 3px rgba(0,0,0,.2); }
    .blur { 
        filter: url(blur.svg#blur); /* FireFox, Chrome, Opera */
        -webkit-filter: blur(80px); /* Chrome, Opera */
        -moz-filter: blur(80px);
        -ms-filter: blur(80px);    
            filter: blur(80px);
        filter: progid:DXImageTransform.Microsoft.Blur(PixelRadius=80, MakeShadow=false); /* IE6~IE9 */
    }
</style>
</head>
	<body class="fixed-sidebar full-height-layout gray-bg">
        <div class="row">
            <div class="col-md-12">
                <div class="headimg_wrap">
                    <div class="blurbg_wrap">
                        <img src="<?php echo ($data["avator"]); ?>" class="headimg_bg blur"/>
                        <div class="headimg_bg2"></div>
                        <img src="<?php echo ($data["avator"]); ?>" class="headimg"/>
                    </div>
                </div> 
            </div>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form class="form-horizontal form-border" id="form" method="post">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">账号/手机号</label>
                                <div class="col-sm-2 rightText"><?php echo ($data["phone"]); ?></div>
                                <input type="hidden" class="form-control input-sm" name="userid" id="userid" value="<?php echo ($data["uid"]); ?>">
                            </div>
                            <div class="hr"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">姓名</label>
                                <div class="col-sm-2 rightText"><?php echo ($data["username"]); ?></div>
                            </div>
                            <div class="hr"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">身份证号</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control input-sm" name="idcard" id="idcard" placeholder="身份证号" value="<?php echo ($data["idcard"]); ?>">
                                </div>
                            </div>
                            <div class="hr"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">所属公司</label>
                                <div class="col-sm-6 rightText">
                                    <input type="text" class="form-control input-sm" name="company" id="company" placeholder="所属公司" value="<?php echo ($data["company"]); ?>">
                                </div>
                            </div>
                            <div class="hr"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">部门</label>
                                <div class="col-sm-2 rightText"><?php echo ($data["department"]); ?></div>
                            </div>
                            <div class="hr"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">职务</label>
                                <div class="col-sm-6 rightText">
                                    <input type="text" class="form-control input-sm" name="job" id="job" placeholder="职务" value="<?php echo ($data["job"]); ?>">
                                </div>
                            </div>
                            <div class="hr"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">车证编号</label>
                                <div class="col-sm-6 rightText">
                                    <input type="text" class="form-control input-sm" name="car_num" id="car_num" placeholder="车证编号" value="<?php echo ($data["car_num"]); ?>">
                                </div>
                            </div>
                            <div class="hr"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">工位号</label>
                                <div class="col-sm-6 rightText">
                                    <input type="text" class="form-control input-sm" name="employee_num" id="employee_num" placeholder="工位号" value="<?php echo ($data["employee_num"]); ?>">
                                </div>
                            </div>
                            <div class="hr"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">所属区域</label>
                                <div class="col-sm-2 rightText"><?php echo ($data["title"]); ?></div>
                            </div>
                            <div class="hr"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">审核状态</label>
                                <div class="col-sm-6 rightText">
                                <?php
 if($data['authstatus']==0){ ?>
                                    <div class="radio i-checks">
                                        <label><input type="radio" value="1" name="authstatus"><i></i> 通过</label>
                                        <label><input type="radio" value="2" name="authstatus"> <i></i> 驳回</label>
                                        <label><input type="radio" value="0" name="authstatus"> <i></i> 暂不操作</label>
                                    </div>  
                                <?php
 }else if($data['authstatus']==1){ echo '已认证'; }else if($data['authstatus']==2){ echo '被驳回'; } ?>
                                </div>
                            </div>
                                
                            <div class="hr"></div>
                            <div class="form-group">
                                <div class="col-sm-offset-10 col-sm-10">
                                    <button type="submit" class="btn btn-primary">保存</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
	</body>
<script src="/xj_property/Public/Admin/js/plugins/switchery/switchery.js"></script><!--IOS开关样式-->
<link href="/xj_property/Public/Admin/css/plugins/switchery/switchery.css" rel="stylesheet">
<script type="text/javascript" src="/Public/Admin/js/plugins/iCheck/icheck.min.js"></script>
<script type="text/javascript" src="/xj_property/Public/Admin/js//plugins/Validform/Validform_v5.3.1_min.js"></script>
<link rel="stylesheet" type="text/css" href="/xj_property/Public/Admin/css/plugins/Validform/validform.css" />

<script type="text/javascript">
$(document).ready(function(){$(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",})});

    var elem = document.querySelector('.js-switch');
    var switchery = new Switchery(elem, {
        color: '#1AB394',
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
</script>
</html>