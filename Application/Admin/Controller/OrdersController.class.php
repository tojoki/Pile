<?php
namespace Admin\Controller;
header('Content-type:text/html;charset=utf-8');
/**
 * 订单管理
 */
class OrderController extends BaseController {

    /**
     * 订单列表
     */
    private $status = array('-2'=>'系统取消','-1'=>'用户取消','0'=>'待接单','1'=>'已抢单','2'=>'已接单','3'=>'待付款','4'=>'已付款','5'=>'已评价');

    public function index(){
        $orderid = I('orderid');
        if (!empty($orderid)) {
            $where['orderid'] = $orderid;
        }
        $ordertype = I('ordertype');
        if (!empty($ordertype)) {
            $where['ordertype'] = $ordertype;
        }
        $status = I('status');
        if ($status != '') {
            $where['status'] = $status;
        }
        $list = M('order')->where($where)->select();
        // echo M()->_sql();die;
        foreach ($list as $key => $value) {
            $list[$key]['lawyer_name'] = M('lawyer')->where(array('uid'=>$value['lawyerid']))->getField('rname');
            $list[$key]['u_name'] = M('user')->where(array('uid'=>$value['uid']))->getField('rname');
            $list[$key]['ordertype'] = $value['ordertype'] == 1 ? '即时语音' : '网约律师';
            $list[$key]['status'] = $this->status[$value['status']];
            $list[$key]['ctime'] = date('Y-m-d H:i:s',$value['ctime']);
        }
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
        $this->display();
    }

    public function details(){
        $orderid = I('orderid');
        $data = M('order')->where(array('orderid'=>$orderid))->find();
        $lawyer = M('lawyer')->where(array('uid'=>$data['lawyerid']))->find();
        $user = M('user')->where(array('uid'=>$data['uid']))->find();
        $data['lawyer_name'] = $lawyer['rname'];
        $data['lawyer_phone'] = $lawyer['phone'];
        $data['u_name'] = $user['rname'];
        $data['u_phone'] = $user['phone'];
        $data['status'] = $this->status[$data['status']];
        $this->assign('data',$data);
        $this->display();
    }


    
}
