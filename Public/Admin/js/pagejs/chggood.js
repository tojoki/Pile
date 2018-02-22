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
            beforeSubmit:function(form){
                var txt = ue.getContent();
                if(txt == ''){
                    show_hint('请填写商品详情');
                    return false;
                }
                var flag = true;
                return flag;
            },
            ajaxPost:true,
            callback:function(data){
                layer.msg(data.msg,{skin:"layui-layer-hui",time:1500,end:function(){
                    if(data.status == 0){
                        window.location.href = succpath;
                    }
                }});
            }
        });
        //编辑器
        var ue = UE.getEditor('editor');
});


