<?php

namespace Admin\Controller;
use Think\Controller;
class BenefitController extends BaseController {
    //优惠券列表
    public function couponList(){
        $count1 = M('user_coupon')->count();
        $count2 = M('lawyer_coupon')->count();
        $count=$count1+$count2;
        $Page = new \Think\Page($count, 12);
        $show = $Page->show();
        $sql="(select uc.couponid,uc.title as name,uc.amount,uc.starttime,uc.deadtime,uc.usetime,uc.status,u.nickname,u.phone,1 as type_id 
            from web_user_coupon uc left join web_user u on u.uid=uc.uid) 
            union 
            (select lc.couponid,lc.title as name,lc.amount,lc.starttime,lc.deadtime,lc.usetime,lc.status,l.nickname,l.phone,2 as type_id 
            from web_lawyer_coupon lc left join web_lawyer l on l.uid=lc.uid) 
            order by starttime desc limit $Page->firstRow,$Page->listRows ";
        $list=M()->query($sql);
        $index_r=1;
        foreach($list as $k=>$v){
        $list[$k]['index_r']=$index_r;
        $index_r++;
        }
        $this->assign('page',$show);
        $this->assign('list',$list);
        $this->display();
        
    }
    //优惠券规则
    public function couponRule(){
        $count = M('coupon_rule')->count();
        $Page = new \Think\Page($count, 12);
        $show = $Page->show();
        $sql="select * from web_coupon_rule order by rule_id desc limit $Page->firstRow,$Page->listRows ";
        $list=M()->query($sql);
        $index_r=1;
        foreach($list as $k=>$v){
        $list[$k]['index_r']=$index_r;
        $index_r++;
        }
        $this->assign('page',$show);
        $this->assign('list',$list);
        $this->display();
    }
    //修改规则
    public function editRule(){
        if(IS_POST){
            $rule_id=I('post.rule_id');
            $data['name']=I('post.name');
            $data['amount']=I('post.amount');
            M('coupon_rule')->where('rule_id='.$rule_id)->save($data);
            succ('修改成功');
        }else{
            $rule_id=I('get.rule_id');
            $info=M('coupon_rule')->where('rule_id='.$rule_id)->find();
            $this->assign('info',$info);
            $this->display();
        }
    }

    
}