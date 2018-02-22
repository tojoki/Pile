function show_result_msg(msg,o,cssctl){
    if(o.type>2){
        layer.msg(msg,{skin:"layui-layer-hui",time:1500});
        return false;
    }
}
function dialog(msg,redirect){
    layer.msg(msg,{skin:"layui-layer-hui",time:1500},function(){
        if(redirect){
            window.location.href = redirect;
        }
    });
}

function ajax_request(params){
    $.post(params.url,params.params,function(data){
        if(typeof(params.callback) == 'function'){
            params.callback();
        }
       if(data.status == 0){
           if(params.succshow){
               dialog('操作成功',params.redirect);
           }
       }else{
           dialog(data.msg);
       }
    });
}


