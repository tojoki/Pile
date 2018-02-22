function show_result_msg(msg,o,cssctl){
    if(o.type>2){
        layer.msg(msg,{skin:"layui-layer-hui",time:1500});
        return false;
    }
}

$.extend($.Datatype,{
  "price" : /^[0-9]+(\.[0-9]{1,2})?$/
});
function show_hint(msg){
    layer.msg(msg,{skin:"layui-layer-hui",time:1500});
}
$(document).ready(function(){
        var valid = $("#productForm").Validform({
            tiptype:show_result_msg,
            tipSweep:true,
            postonce:true,
            beforeSubmit:function(form){
                var cate_id = $("#cate_id").val();
                if(cate_id == '1'){
                    if($("#links").val() == ''){
                        show_hint('请填写链接地址');
                        return false;
                    }
                }else{
                    if($("#checkid").val() == ''){
                        show_hint('请选择关联数据');
                        return false;
                    }
                }
                return true;
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
        
    //图片单个上传
    var uploaderOne = WebUploader.create({
        auto : true,
        swf: swfpath,
        server: uploadUrl,
        pick: '#uploadOne',
        resize: true,
        fileNumLimit:6,
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        }
    });
    uploaderOne.on( 'uploadSuccess', function( file , rsObj) {
        $( '#GD_IndexImg img' ).attr('src','/Uploads'+rsObj._raw);
        $( '#goods_img' ).val('/Uploads'+rsObj._raw);
        $("#poster").val('/Uploads'+rsObj._raw);
    });
    var $list = $('#uploadImgWrap'),
        $btn  = $('#ctlBtn'),
        state = 'pending';
    

    $(document).on('click','.delBtn',function(){
        $(this).parents('.uploadVideoItem').remove();
    });
    
    $("#cate_id").change(function(){
        var val = $(this).val();
        if(val == '1'){
            $("#checkdiv").hide();
            $("#links").show();
        }else{
            if(isedit == '1'){
               isedit ='0';
            }else{
               $("#checkname").val('');
               $("#checkid").val(''); 
            }
            
            $("#links").hide();
            $("#checkdiv").show();
        }
    });
    $("#cate_id").change();
});


