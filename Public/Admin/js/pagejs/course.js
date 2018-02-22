$.extend($.Datatype,{
  "price" : /^[0-9]+(\.[0-9]{1,2})?$/,
});
$(document).ready(function(){
        var valid = $("#productForm").Validform({
            tiptype:show_result_msg,
            tipSweep:true,
            postonce:true,
            ignoreHidden:true,
            //ajaxPost:true,
            beforeCheck:function(curform){
                $(".clazz:hidden").empty();
            },
            beforeSubmit:function(form){
                var category =parseInt($("#category").val());
                if(category<8){
                    var starttime = Date.parse($("#starttime").val().replace(/-/g,"/"));
                    var endtime = Date.parse($("#endtime").val().replace(/-/g,"/"));
                    var now = new Date();
                    if(starttime<=now){
                        dialog('开始时间不能小于当前时间');
                        return false;
                    }
                    if(starttime >= endtime){
                        dialog("结束时间不能小于开始时间");
                        return false;
                    }
                }
                if($("#uploadImgWrap img").size() == 0){
                    dialog('请上传课程轮播图');
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
                
                var txt = ue.getContent();
                if(txt == ''){
                    dialog('请填写课程介绍');
                    return false;
                }
                flag = true;
                return flag;
                //$("#productForm").ajaxForm();
            },
            callback:function(data){
                layer.msg(data.msg,{skin:"layui-layer-hui",time:1500,end:function(){
                    if(data.status == 0){
                        window.location.href = succpath;
                    }
                }});
            }
        });
        
        //时间
        var options = {        
            event:'click',
            format: 'YYYY-MM-DD', //日期格式 hh:mm:ss
            istime: true, //是否开启时间选择
            isclear: true, //是否显示清空
            istoday: true, //是否显示今天
            issure: true, //是否显示确认
            festival: false, //是否显示节日
            choose: function(dates){ //选择好日期的回调

            }
        };
        options.elem = '#starttime';
        laydate(options).skin('molv');
        options.elem = '#endtime';
        laydate(options).skin('molv');
        //编辑器
        var ue = UE.getEditor('editor');
        
        //图片单个上传
    var uploaderOne = WebUploader.create({
        auto : true,
        swf: swfpath,
        server: uploadUrl,
        pick: '#uploadOne',
        resize: true,
        fileNumLimit:1,
        multi:false,
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        }
    });
    uploaderOne.on( 'uploadSuccess', function( file , rsObj) {
        $( '.uploadposter img' ).attr('src','/Uploads'+rsObj._raw);
        $( '#poster' ).val('/Uploads'+rsObj._raw);
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
    
    $('#category').change(function(){
       var val = parseInt($(this).val());
       $(".clazz").hide();
       switch(val){
           case 1:
           case 2:
           case 3:
           case 4:
           case 5:
           case 6:
           case 7:
                $(".clazz-open").show();
                break;
           case 8:
                $(".clazz-inner").show();
                break;
           case 9:
                $(".clazz-real-goods").show();
                break;
           case 10:
               $(".clazz-vitual-goods").show();
                break;
       }
       
    });
});


