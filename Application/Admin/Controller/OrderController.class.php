<?php
namespace Admin\Controller;
header('Content-type:text/html;charset=utf-8');
/**
 * 订单管理
 */
class OrderController extends BaseController {
    //洗车订单
    public function list1(){
        $keyword = I("keyword");//关键字
        if($keyword){
            $condi['u.phone|u.username'] = array("LIKE","%".$keyword."%");
            $urlParam['keyword'] = $keyword;
        }

        $sTime = I("stime");//下单时间
        $eTime = I("etime");
        if($sTime && $eTime){
            $condi['o.ctime'] = array(array("EGT",strtotime($sTime)),array("ELT",(strtotime($eTime)+86399)));
        }
        elseif($sTime){
            $condi['o.ctime'] = array("EGT",strtotime($sTime));
        }elseif($eTime){
            $condi['o.ctime'] = array("ELT",strtotime($eTime));
        }
        $urlParam['stime'] = $sTime;
        $urlParam['etime'] = $eTime;
        $place_id  = I("place_id");
        if($place_id != ''){
            $condi['p_id'] = $place_id;
            $urlParam['p_id'] = $place_id;
        }
        $condi['o.is_del'] = 0;

        $list=M('order1')->alias('o')
                ->join('left join web_user u on u.uid=o.uid')
                ->join('left join web_place p on p.id=o.p_id')
                ->where($condi)
                ->field('o.oid,o.orderid,o.catname,o.status,o.price,o.ctime,o.payway,u.phone,u.username,u.avator,p.title')
                ->order('ctime desc')
                ->select();
        $count = count($list);
        $Page = new \Think\Page($count,15);
        $Page -> setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page -> setConfig('prev', '上一页');
        $Page -> setConfig('next', '下一页');
        $Page -> setConfig('last', '末页');
        $Page -> setConfig('first', '首页');
        $Page -> setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');

        $list = array_slice($list,$Page->firstRow,$Page->listRows);
        // var_dump($list);die;
        $show = $Page->show();
        $this->assign('list',$list);
        $this->assign('page',$show);
        //查询区域
        $placeList=M('place')->where('is_del=0')->select();
        $this->assign('placeList', $placeList);

        $this->display();
    }

    //洗车 订单详情
    public function orderInfo1(){
        $oid=I('oid');
        $info=M('order1')->alias('o')
                ->join('left join web_user u on u.uid=o.uid')
                ->join('left join web_place p on p.id=o.p_id')
                ->where('oid='.$oid)
                ->field('o.*,u.username,u.phone,p.title')
                ->find();
        $this->assign('info', $info);
        $this->display();
    }

    //洗车 评价订单
    public function order_commt1(){
        $oid=I('oid');
        $data['worker_commt']=I('worker_commt');
        M('order1')->where('oid='.$oid)->save($data);
        $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
    }

    //洗车 删除订单
    public function del1(){
        $oid=I('oid');
        M('order1')->where('oid='.$oid)->save(array('is_del'=>1));
        $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
    }
    
    //美容美发订单
    public function list2(){
        $keyword = I("keyword");//关键字
        if($keyword){
            $condi['u.phone|u.username'] = array("LIKE","%".$keyword."%");
            $urlParam['keyword'] = $keyword;
        }

        $sTime = I("stime");//下单时间
        $eTime = I("etime");
        if($sTime && $eTime){
            $condi['o.ctime'] = array(array("EGT",strtotime($sTime)),array("ELT",(strtotime($eTime)+86399)));
        }
        elseif($sTime){
            $condi['o.ctime'] = array("EGT",strtotime($sTime));
        }elseif($eTime){
            $condi['o.ctime'] = array("ELT",strtotime($eTime));
        }
        $urlParam['stime'] = $sTime;
        $urlParam['etime'] = $eTime;
        $place_id  = I("place_id");
        if($place_id != ''){
            $condi['p_id'] = $place_id;
            $urlParam['p_id'] = $place_id;
        }
        $condi['o.is_del'] = 0;

        $list=M('order2')->alias('o')
                ->join('left join web_user u on u.uid=o.uid')
                ->join('left join web_place p on p.id=o.p_id')
                ->where($condi)
                ->field('o.oid,o.orderid,o.catname,o.status,o.price,o.ctime,o.payway,u.phone,u.username,u.avator,p.title')
                ->order('ctime desc')
                ->select();
        $count = count($list);
        $Page = new \Think\Page($count,15);
        $Page -> setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page -> setConfig('prev', '上一页');
        $Page -> setConfig('next', '下一页');
        $Page -> setConfig('last', '末页');
        $Page -> setConfig('first', '首页');
        $Page -> setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');

        $list = array_slice($list,$Page->firstRow,$Page->listRows);
        // var_dump($list);die;
        $show = $Page->show();
        $this->assign('list',$list);
        $this->assign('page',$show);
        //查询区域
        $placeList=M('place')->where('is_del=0')->select();
        $this->assign('placeList', $placeList);

        $this->display();
    }

    //美容美发 订单详情
    public function orderInfo2(){
        $oid=I('oid');
        $info=M('order2')->alias('o')
                ->join('left join web_user u on u.uid=o.uid')
                ->join('left join web_place p on p.id=o.p_id')
                ->where('oid='.$oid)
                ->field('o.*,u.username,u.phone,p.title')
                ->find();
        $this->assign('info', $info);
        $this->display();
    }

    //美容美发 评价订单
    public function order_commt2(){
        $oid=I('oid');
        $data['worker_commt']=I('worker_commt');
        M('order2')->where('oid='.$oid)->save($data);
        $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
    }

    //美容美发 删除订单
    public function del2(){
        $oid=I('oid');
        M('order2')->where('oid='.$oid)->save(array('is_del'=>1));
        $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
    }
}
