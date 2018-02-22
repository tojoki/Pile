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
                var starttime = Date.parse($("#starttime").val().replace(/-/g,"/"));
                var endtime = Date.parse($("#endtime").val().replace(/-/g,"/"));
                var now = new Date();
                if(starttime<=now){
                    show_hint('开始时间不能小于当前时间');
                    return false;
                }
                if(starttime >= endtime){
                    show_hint("结束时间不能小于开始时间");
                    return false;
                }
                if($("#uploadImgWrap img").size() == 0){
                    show_hint('请上传会议封面');
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
                    show_hint('请填写会议内容');
                    return false;
                }
                
                if($(".meet-seat-list").size() == 0){
                    show_hint('请设置席位');return false;
                }
                var flag = true;
                var price = /^\d+(\.\d{1,2})?$/;
                var num = /^[1-9]+[0-9]*]*$/;
                $(".meet-seat-list input.seat-name").each(function(){
                    if($(this).val() == ''){
                        flag = false;$(this).focus();show_hint('请填写席位名称');return flag;
                    }
                });
                if(!flag){
                   return false; 
                }
                flag = true;
                $(".meet-seat-list input.seat-price").each(function(){
                    if(!$(this).val().match(price)){
                        flag = false;$(this).focus();
                        show_hint('席位价格格式错误');
                        return flag;
                    }
                });
                if(!flag){
                   return false; 
                }
                flag = true;
                $(".meet-seat-list input.seat-num").each(function(){
                    if(!num.test($(this).val())){
                        flag = false;$(this).focus();
                        show_hint('席位数量格式错误');
                        return flag;
                    }
                });
                if(!flag){
                   return false; 
                }
                
                if($(".fill-form-option").size() == 0){
                    show_hint('请添加报名表单项');return false;
                }
                flag = true;
                $(".fill-form-option input.fill-name").each(function(){
                    if($(this).val() == ''){
                        flag = false;$(this).focus();
                        show_hint('请填写报名表单名称');
                        return flag;
                    }
                });
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
        
        //时间
        var options = {        
            event:'click',
            format: 'YYYY-MM-DD hh:mm:ss', //日期格式
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
        //上传
        //添加座位
        $('#add_seats').click(function(){        
            var html = '';
            var id = 0;
            if($('#argTable tbody tr').length>0){
                id = parseInt($('#argTable tbody tr:last').attr('arg_id')) + 1;
            }

            html += '<tr class="meet-seat-list" arg_id="'+ id +'">';
            html += '<td><input type="text" size="10" class="seat-name" name="seats['+id+'][name]" value=""></td>';
            html += '<td><input type="text" size="10" class="seat-price" name="seats['+id+'][oprice]" value=""></td>';
            html += '<td><input type="text" size="10" class="seat-price" name="seats['+id+'][mprice]" value=""></td>';
            html += '<td><input type="text" size="10" class="seat-num" name="seats['+id+'][nums]" value=""></td>';
            html += '<td><input type="text" size="40" name="seats['+id+'][descs]" value=""></td>';
            html += '<td><a href="javascript:;" class="del_arg">删除</a></td>';
            html += '</tr>';
            $('#argTable tbody').append(html);
        });
        //删除座位
        $('#argTable').on('click','.del_arg',function(){
            $(this).parent().parent().remove();
        });
        //添加表单
        $('#add_option').click(function(){        
            var html = '';
            var id = 0;
            if($('#optionTable tbody tr').length>0){
                id = parseInt($('#optionTable tbody tr:last').attr('arg_id')) + 1;
            }
            html += '<tr class="fill-form-option" arg_id="'+ id +'">';
            html += '<td><input type="text" size="30" class="fill-name" name="option['+id+'][name]" value=""></td>';
            html += '<td><input type="text" size="30" name="option['+id+'][val]" value=""></td>';
            html += '<td><input type="checkbox" class="checkbox checkbox-circle" value="1" name="option['+id+'][require]" ></td>';
            html += '<td><a href="javascript:;" class="del_option">删除</a></td>';
            html += '</tr>';
            $('#optionTable tbody').append(html);
        });
        //删除座位
        $('#optionTable').on('click','.del_option',function(){
            $(this).parent().parent().remove();
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


