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
                if($("#uploadImgWrap img").size() == 0){
                    show_hint('请上传商品封面');
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
                $('#poster').val(goods_pics);
                
                var txt = ue.getContent();
                if(txt == ''){
                    show_hint('请填写商品详情');
                    return false;
                }
                
                if(gid != ''){
                    if($("#totalitems").val()-currissue<0){
                        show_hint('总期数不能小于当前期数：'+currissue);
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
        
        //编辑器
        var ue = UE.getEditor('editor');
        
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
    });
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
});


