$(function(){
            transHtml();
            var newsFormHtml = $('#newsWrap').html();
            replyUI();
            $('#newsWrap').empty(); 

            //图片上传
            $(document).on('change','.uploadfile',function(event){
                var thi = $(this);
                var formData = new FormData(),
                target = event.target || event.srcElement;
                if(target.files.length == 0) return;
                formData.append('file',target.files[0]);
                $.ajax({
                    url             :    uploadUrl,
                    type            :    "POST",
                    data            :    formData,
                    dataType        :    'text',
                    processData     :    false,
                    contentType     :    false,
                    cache           :    false,
                    success         :    function(data,status,jXhr){
                        thi.siblings('img.uploadOne').attr('src','/Uploads'+data);
                        thi.siblings('input.PicUrl').val('/Uploads'+data);
                    }
                });
            });

            $(document).on('click','.uploadOne',function(){
                $(this).siblings('.uploadfile').click();
            });
            $(document).on('click','#newsList div',function(evt){
                // console.log($(evt.target).hasClass('delBtn'));
                if($(evt.target).hasClass('delBtn')){
                    delete newsJson[$(this).attr('index')];
                    transHtml();
                    console.log(newsJson);
                }else{
                    editNews($(this).attr('index'));
                }               
            });
            $('#replyType').change(function(){
                replyUI();
            });
            //打开弹出层
            $("#addNews").click(function(){
                openNewsForm();
            });
            //关闭弹出层
            $(document).on('click','.closeIframe',function(){
                layer.closeAll();
            });
            //表单验证
            var valid = $("#form-wizard").Validform({
                tiptype:show_result_msg,
                tipSweep:true,
                beforeSubmit:function(form){
                    var replyType = form.find('#replyType').val(),
                        rtcEl = form.find('#replyTextContent');
                    if(replyType == 'text' && rtcEl.val() == '' ){
                        layer.msg('请输入回复内容',{skin:"layui-layer-hui",time:1500});
                        rtcEl.addClass('Validform_error').focus();
                        return false;
                    }else{
                        rtcEl.removeClass('Validform_error');
                    }
                    if(replyType == 'news' && ObjCount(newsJson) == 0 ){
                        layer.msg('请设置回复内容',{skin:"layui-layer-hui",time:1500});
                        return false;
                    }
                    $('#replyNewsContent').val(window.JSON.stringify(newsJson));
                },
                ajaxPost:true,
                callback:function(data){
                    layer.msg(data.returnMsg,{skin:"layui-layer-hui",time:1000,end:function(){
                        if(data.returnCode == 'SUCCESS')parent.location.reload(); //重载父页面
                    }});
                }
            });

            //提示信息
            function show_result_msg(msg,o,cssctl){
                if(o.type>2){
                    layer.msg(msg,{skin:"layui-layer-hui",time:1500});
                    return false;
                }
            }
            function replyUI(){
                if($('#replyType').val() == 'text'){
                    $('#textTypeWrap').show();
                    $('#newsTypeWrap').hide();
                }else{
                    $('#textTypeWrap').hide();
                    $('#newsTypeWrap').show();
                }
            }
            function openNewsForm(newsidx){
                var index = layer.open({
                    type: 1,
                    title:"添加图文",
                    content: newsFormHtml,
                    skin: 'layui-layer-rim',
                    area:['600px','400px'],
                    maxmin: true,
                    scrollbar: false,
                });

                if(typeof(newsidx) != 'undefined'){
                    var data = newsJson[newsidx];
                    console.log(data);
                    $('#Title').val(data.Title);
                    $('#PicUrl').val(data.PicUrl);
                    $('.uploadOne').attr('src',data.PicUrl);
                    $('#Description').val(data.Description);
                    $('#Url').val(data.Url);
                }

                //表单验证
                var valid2 = $("#newsform").Validform({
                    tiptype:show_result_msg,
                    tipSweep:true,
                    ajaxPost:true,
                    beforeSubmit:function(form){
                        addAction = true;
                        var temp = {
                            Title : form.find('#Title').val(),
                            PicUrl : form.find('#PicUrl').val(),
                            Description : form.find('#Description').val(),
                            Url : form.find('#Url').val(),
                        };
                        var newsindex = ObjCount(newsJson);
                        if(typeof(newsidx) != 'undefined'){
                            newsJson[newsidx] = temp;                           
                        }else{
                            newsJson[newsindex] = temp;
                        }
                        form.resetForm();
                        layer.close(index);
                        transHtml();
                        return false;
                    },
                    callback:function(form){
                       return false;
                    }
                }); 
            }
            function editNews(index){               
                openNewsForm(index);
            }
            //生成html
            function transHtml(){
                var newsCount = ObjCount(newsJson),
                    html = '';
                if(0 == newsCount){
                    ;
                }else if(1 == newsCount){
                    var data = newsJson[0],
                        d = new Date(),
                        s = (d.getMonth()+1) + '-' + d.getDate();
                        console.log(data);
                    html += '<div class="one" index="0"><h3>'+ data.Title +'</h3><p class="time">'+ s +'</p><img src="'+ data.PicUrl +'"><div class="describe">'+ data.Description+'</div><div class="btm">阅读原文 <span class="pull-right">></span></div> <i class="fa fa-close delBtn"></i></div>';
                }else{  
                    for(i = 0; i < newsCount; i++){
                        if(i == 0){
                            html += '<div class="first" index="'+i+'"><img src="'+ newsJson[i].PicUrl +'"><h3>'+ newsJson[i].Title +'</h3> <i class="fa fa-close delBtn"></i></div>';
                        }else{
                            html += '<div class="item" index="'+i+'"><img src="'+ newsJson[i].PicUrl +'"><h3>'+ newsJson[i].Title +'</h3> <i class="fa fa-close delBtn"></i></div>';
                        }           
                    }
                    
                }
                $('#newsList').html(html);
            }

            function ObjCount(Obj){
                return Object.keys(Obj).length;
            }
            function empty(par){
                if(typeof(par) == 'undefind'){
                    return true;
                }else{
                    return false;
                }
            }
        });