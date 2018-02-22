<?php
/**
 * 律师管理
 */
namespace Admin\Controller;
header('Content-type:text/html;charset=utf-8');
class LawyerController extends BaseController {
    /**
     */
    public function lists() {
        $userModel = D("lawyer");
        //查询条件
        // dump(I());
        $condi = array('authstatus'=>0);
        $urlParam = array();

        $keyword = I("keyword");//关键字
        if($keyword){
            $condi['phone|rname'] = array("LIKE","%".$keyword."%");
            $urlParam['keyword'] = $keyword;
        }
        $sTime = I("stime");//注册时间
        $eTime = I("etime");
        if($sTime && $eTime){
            $condi['ctime'] = array(array("EGT",strtotime($sTime)),array("ELT",strtotime($eTime)));
        }
        elseif($sTime){
            $condi['ctime'] = array("EGT",strtotime($sTime));
        }elseif($eTime){
            $condi['ctime'] = array("ELT",strtotime($eTime));
        }
        $urlParam['stime'] = $sTime;
        $urlParam['etime'] = $eTime;
        $sex  = I("sex");
        if($sex != ''){
            $condi['gender'] = $sex;
            $urlParam['sex'] = $sex;
        }
        $count = $userModel->where($condi)->count(); // 查询满足要求的总记录数 
        $pagesize = 15;
        $p = getpage($count, $pagesize,$urlParam);
        $show = $p->show();
        $list = $userModel->field("uid,phone,rname,gender as sex,age,avator,ctime,last_login_time,status")->where($condi)
            ->page(I("get.p"))
            ->order('uid desc')
            ->limit($pagesize)
            ->select();
        // echo M()->getlastsql();
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display();
    }
    
    /**
     * 用户编辑
     */
    public function userEdit(){
        if($error = admin_require_check("userid")) $this->error($error);         
        $userid = I("userid");
        $userModel = D("lawyer");
        if(IS_POST){    
            $userModel->create();
            $userModel->etime = time();
            $userModel->status = I("status") ? 1 : 0;
           
            if($userModel->where("uid = {$userid}")->save()){
                $this->success("修改成功");
            }else{
                $this->error("修改失败");
            }
            exit;
        }
        $data = M('lawyer')->find($userid);
        $this->assign('data',$data);
        $this->display();
    }

    /**
     * 用户禁用
     */
    public function userLock(){
        if($error = admin_require_check("userid")) $this->error($error); 
        $condi['uid'] = I("userid");
        $data['status'] = I("state",0);
        if(M("lawyer")->where($condi)->save($data)){
            $this->success("更改成功");
        }else{
            $this->error("更改失败");
        }
    }
    
    /*
     * 律师申请
     */
    public function lawyer(){
        $params = "t.authstatus>=1";
        $good = M("lawyer");
        $count = $good->alias('t')->where($params)->count();
        $Page = new \Think\Page($count, 20);
        $show = $Page->show();
        $model = M("lawyer")->alias('t')
                ->where($params)
                ->field("t.uid,t.phone,t.company,t.authstatus,t.ctime,t.rname,t.gender,t.age")
                ->order('t.uid desc')->limit($Page->firstRow,$Page->listRows)->select();
        $this->assign("model", $model);
        $this->assign("page", $show);
        $this->display();
    }
    
    public function lawyerdetail(){
        $tid = I('uid');$showop = I('showop');
        $teacher = M('lawyer')->alias('t')
                ->where(array('uid'=>$tid))
                ->field("t.*")->find();
        $this->assign('teacher',$teacher);
        $this->assign('showop',$showop);
        $this->display();
    }
    //审核律师
    public function authlawyer(){
        $applyid = I('applyid');
        $status = I('status');
        $memo = I('memo');
        $teacher = M('lawyer')->alias('t')
                ->where(array('uid'=>$applyid))->find();
        $uname = $this->get_username();
        $info = '';
        $rs = true;
        $sid = $teacher['sid'];
        //检查用户状态
        M()->startTrans();
        if(intval($status) - 1 ==0){
            //审核通过
            $info = '['.$uname.']审核通过';
            //修改用户类型
            $rs = $rs && M('lawyer')->where(array('uid'=>$applyid))->save(array(
                'authstatus'=>0,'etime'=>time(),'authtime'=>time(),
            ));
            $msg = '您的律师认证已通过';
            
        }else if(intval($status)-2 == 0){
            //驳回
            $info = '['.$uname.']驳回';
            $rs = $rs && M('lawyer')->where(array('uid'=>$applyid))->save(array(
                'etime'=>time(),'authstatus'=>2,
            ));
            $msg = '您的律师认证被驳回';
        }
        //审核信息
        $rs = $rs && M('user_auth')->add(array(
           'applyid'=>$applyid,'type'=>0,
           'info'=>$info,'memo'=>$memo,
           'ctime'=>time(),
        ));
        //修改审核信息
        if($rs){
            M()->commit();
        }else{
            M()->rollback();
            $this->ajaxReturn(array('status'=>1,'msg'=>'操作失败'));
        }
        //发送消息
        $data = array(
            'lawyerid'=>$applyid,'type'=>3,
            'content'=>$msg,'addtime'=>time()
        );
        M('lawyer_message')->add($data);
//发送推送
    //查询出律师的极光id
    $registration_id=M('lawyer')->where('uid='.$applyid)->getField('registration_id');
    if($registration_id){
        $regid=array($registration_id);
        $message_data=$msg;
        sendNotifySpecial($regid,$message_data);    
    }
    
//发送推送
        //$this->pushinfo($msg, $applyid, 0, '');
        $this->ajaxReturn(array('status'=>0,'msg'=>''));
    }
    //律师提现
    public function withdraw(){
        $count = M("lawyer_draw")->count();
        $Page = new \Think\Page($count, 20);
        $show = $Page->show();
        $model = M("lawyer_draw")->alias('ld')
                ->join('left join web_lawyer l on ld.uid=l.uid')
                // ->where($params)
                ->field("l.phone,l.rname as lawyername,ld.*")
                ->order('ld.ctime desc')->limit($Page->firstRow,$Page->listRows)->select();
        $this->assign("model", $model);
        $this->assign("page", $show);
        $this->display();
    }
    //律师提现审核
    public function lawyer_draw_detail(){
        $draw_id = I('drawid');
        $showop = I('showop');
        $teacher = M('lawyer_draw')->alias('ld')
                ->join('left join web_lawyer l on ld.uid=l.uid')
                ->where(array('drawid'=>$draw_id))
                ->field("l.phone,l.rname as lawyername,ld.*")
                ->find();
                // var_dump($teacher);die;
        $this->assign('teacher',$teacher);
        $this->assign('showop',$showop);
        $this->display();
    }
    //执行审核
    public function draw_money(){
        $drawid = I('drawid');
        $status = I('status');
        $memo = I('memo');
        $info = M('lawyer_draw')
                ->where(array('drawid'=>$drawid))->find();       
        $edit=M('lawyer_draw')
                ->where(array('drawid'=>$drawid))->save(array('handletime'=>time(),'memo'=>$memo,'status'=>$status));
        if(intval($status) - 1 ==0){
            $msg = '您的提现申请已通过';
        }else if(intval($status)-2 == 0){
            //驳回 并把金额返回
            $msg = '您的提现申请被驳回';
            M('lawyer')->where('uid='.$info['uid'])->setInc('balance',$info['amount']);
        }
        //发送消息
        $data = array(
            'lawyerid'=>$info['uid'],'type'=>3,
            'content'=>$msg,'addtime'=>time()
        );
        M('lawyer_message')->add($data);
//发送推送
    //查询出律师的极光id
    $registration_id=M('lawyer')->where('uid='.$info['uid'])->getField('registration_id');
    if($registration_id){
        $regid=array($registration_id);
        $message_data=$msg;
        sendNotifySpecial($regid,$message_data);    
    }
    
//发送推送
        $this->ajaxReturn(array('status'=>0,'msg'=>''));
    }
}
