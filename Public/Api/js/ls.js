/**
 * Created by Administrator on 2016/12/2.
 */
$(function(){
//投诉
    $('.ts_content ul li,.recall_cause li').on('click',function(){
        $(this).toggleClass('active').siblings().removeClass('active');
    });

 //   3_我的_3钱包_4发票
    $('.active_null').on('click',function(){
        $(this).toggleClass('check_icon');
    })
    $('.check_all').on('click',function(){
     $(this).hasClass('check_icon')?$('.invoice_lists .active_null').addClass('check_icon'):
         $('.invoice_lists .active_null').removeClass('check_icon');
    })
    $('.invoice_lists .active_null').on('click',function(){
        ($('.invoice_lists .active_null').size()!=$('.invoice_lists .check_icon').size()) ?
            $('.check_all').removeClass('check_icon'): $('.check_all').addClass('check_icon');
        sum();
    })
});
//开发票金额总计
function sum(){
    var sm=0;
    $('.invoice_lists li').each(function(){
        if($(this).find('.active_null').hasClass('check_icon')){
            sm=Number(sm)+Number($(this).find('.price_single').text().slice(0,-2));
        }
        $('.invoice_con_footer').find('.price_total').html(sm+"元");
    })
}
var start={
    appraisal_choose:function(){ //3_我的_2订单_3订单详情_评价
        $('.appraisal_choose').on('click','li',function(){
            $(this).toggleClass('active');
        });
        $('.appraisal_stars ').on('click','img',function(){
            $(this).attr('src','images/fq_00.png');
            $(this).prevAll('img').attr('src','images/fq_00.png');
            $(this).nextAll('img').attr('src','images/fq_000.png');
        });
    },
    init:function(){
        //3_我的_2订单_1全部订单
        $('.order_stutas_nav ul li').on('click',function(){
            var this_idx=$(this).index();//当前被点击li的下标
            //导航条切换
            $(this).find('span').addClass('order_stutas_nav_active').parents('li').siblings().find('span').removeClass('order_stutas_nav_active');
           //订单状态主题切换
            $('.order_stutas_list').eq(this_idx).show().siblings('.order_stutas_list ').hide();
        });
        //3_我的_2订单_2发起沟通_语音通话
    },
    lasttime:function(){
        var time=$('.wait_answer_call p:nth-child(2) em');
        var t=60;
        var timer=setInterval(function(){
            time.text(--t+"’");
            t=="0"&&clearInterval(timer);
        },1000)
    },
    go:function(){
        start.lasttime();
        start.appraisal_choose();
        start.init();
    }
};
window.onload=function(){
    start.go();
};
function getNowFormatDate() {//获取当前时间
    var date = new Date();
    var seperator1 = "-";
    var year = date.getFullYear();
    var month = date.getMonth() + 1;
    var strDate = date.getDate();
    if (month >= 1 && month <= 9) {
        month = "0" + month;
    }
    if (strDate >= 0 && strDate <= 9) {
        strDate = "0" + strDate;
    }
    var currentdate = year + seperator1 + month + seperator1 + strDate;
    return currentdate;
}