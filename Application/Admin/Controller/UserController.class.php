<?php
/**
 * 用户管理
 */
namespace Admin\Controller;
header('Content-type:text/html;charset=utf-8');
use Admin\Common\Constant;
class UserController extends BaseController {
    /**
     */
    public function index() {
        $userModel = D("User");
        //查询条件
        // dump(I());
        $condi = array();
        $urlParam = array();

        $keyword = I("keyword");//关键字
        if($keyword){
            $condi['phone|username|uid'] = array("LIKE","%".$keyword."%");
            $urlParam['keyword'] = $keyword;
        }

        $tag = I("tag");//关键字
        if($tag){
            $condi['tag'] = array("LIKE","%".$tag."%");
            $urlParam['keyword'] = $tag;
        }

        $sTime = I("stime");//注册时间
        $eTime = I("etime");
        if($sTime && $eTime){
            $condi['ctime'] = array(array("EGT",strtotime($sTime)),array("ELT",(strtotime($eTime)+86399)));
        }
        elseif($sTime){
            $condi['ctime'] = array("EGT",strtotime($sTime));
        }elseif($eTime){
            $condi['ctime'] = array("ELT",strtotime($eTime));
        }
        $urlParam['stime'] = $sTime;
        $urlParam['etime'] = $eTime;
        $place_id  = I("place_id");
        if($place_id != ''){
            $condi['place_id'] = $place_id;
            $urlParam['place_id'] = $place_id;
        }
        $count = $userModel->where($condi)->count(); // 查询满足要求的总记录数 
        $pagesize = 10;
        $p = getpage($count, $pagesize,$urlParam);
        $show = $p->show();
        $list = $userModel->alias('u')
                ->join('left join web_place p on p.id=u.place_id')
                ->where($condi)
            ->page(I("get.p"))
            ->order('uid desc')
            ->limit($pagesize)
            ->select();
        // echo M()->getlastsql();
        $this->assign('list', $list);
        $this->assign('page', $show);
        //查询区域
        $placeList=M('place')->where('is_del=0')->select();
        $this->assign('placeList', $placeList);
        $this->display();
    }
    
    /**
     * 用户编辑
     * @Author 刘晓雨    2016-04-21
     */
    public function userEdit(){
        if($error = admin_require_check("userid")) $this->error($error);         
        $userid = I("userid");
        if(IS_AJAX){    
            $uid=I('userid');
            $user_data['idcard']=I('idcard');
            $user_data['company']=I('company');
            $user_data['job']=I('job');
            $user_data['car_num']=I('car_num');
            $user_data['employee_num']=I('employee_num');
            //如果用户状态是已审通过/被驳回 那么不再接收认证状态
            $authstatus=M('user')->where('uid='.$uid)->getField('authstatus');
            if($authstatus==0){
                $user_data['authstatus']=I('authstatus');
            }
            $user_data['etime']=time();
            $edit=M('user')->where('uid='.$uid)->save($user_data);
            if($edit){
                //审核通过或驳回都要给用户推送 未操作就不用管
                if($user_data['authstatus']){
                    if($user_data['authstatus']==1){
                        $msg_data['title']='您的认证已通过';
                    }else if($user_data['authstatus']==2){
                        $msg_data['title']='您的认证被驳回';
                    }
                    //发消息/推送
                    $msg_data['uid']=$uid;
                    $msg_data['ctime']=time();
                    M('user_msg')->add($msg_data);
                    //查询是否有registration_id 如果有 就推送
                    $registration_id=M('user')->where('uid='.$uid)->getField('registration_id');
                    if($registration_id){
                        $regid=array($registration_id);
                        sendNotifySpecial($regid,$msg_data['title'],Constant::user_app_key,Constant::user_master_secret);
                    }
                }                
                succ('操作成功');
            }else{
                err('操作失败');
            }
            exit;
        }
        $data = M('user')->alias('u')
                ->join('left join web_place p on p.id=u.place_id')
                ->find($userid);
        $this->assign('data',$data);
        $this->display();
    }

    //改变内外围
    public function change_limit(){
        $uid=I('uid');
        $is_limit=M('user')->where('uid='.$uid)->getField('is_limit');
        if($is_limit){
            $data['is_limit']=0;
        }else{
            $data['is_limit']=1;
        }
        M('user')->where('uid='.$uid)->save($data);
        $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
    }
    /*
     * 用户病例
     */
    public function cases(){
        $size = 10;
        $uid = intval(I('userid'));
        $type = intval(I('type'));
        if(empty($type)){
            $type = 1;
        }
        $where = "uid=$uid AND category=".($type-1);
        $logModel = M('user_cases');
        $order = "cid desc";
        $count = $logModel->where($where)->count();
        $Page = new \Think\Page($count,$size);
        $list = $logModel
            ->field("datestr,pictures,ctime")
            ->where($where)->limit($Page->firstRow,$Page->listRows)->order($order)->select();
        $this->assign('list',$list);
        $this->assign('userid',$uid);
        $this->assign('type',$type);
        $this->assign('page',$Page->show());
        $this->display();
    }
    /*
     * 用户用药记录
     */
    public function medicine(){
        $size = 10;
        $uid = intval(I('userid'));
        $where = "uid=$uid";
        $logModel = M('user_medicine');
        $order = "mid desc";
        $count = $logModel->where($where)->count();
        $Page = new \Think\Page($count,$size);
        $list = $logModel
            ->where($where)->limit($Page->firstRow,$Page->listRows)->order($order)->select();
        $this->assign('list',$list);
        $this->assign('userid',$uid);
        $this->assign('page',$Page->show());
        $this->display();
    }

    /**
     * 用户禁用
     * @Author 刘晓雨    2016-04-21
     */
    public function userLock(){
        if($error = admin_require_check("userid")) $this->error($error); 
        $condi['uid'] = I("userid");
        $data['status'] = I("state",0);
        if(M("user")->where($condi)->save($data)){
            $this->success("更改成功");
        }else{
            $this->error("更改失败");
        }
    }

    public function breathlog(){
        $size = 10;
        $uid = intval(I('userid'));
        $where = "uid=$uid";
        $stime = I("stime");
        if($stime){
            $where .= " AND datestr >=".date('Ymd',strtotime($stime));
            $this->assign('stime',$stime);
        }
        $etime = I("etime");
        if($etime){
            $where .= " AND datestr <".date('Ymd',strtotime($etime));
            $this->assign('etime',$etime);
        }
        
        $logModel = M('record');
        $order = "rid desc";
        $count = $logModel->where($where)->count();
        $Page = new \Think\Page($count,$size);
        $list = $logModel
            ->where($where)->limit($Page->firstRow,$Page->listRows)->order($order)->select();
        for($i=0;$i<count($list);$i++){
           $list[$i]['nosesymptom'] = $this->local_nose_symptom($list[$i]['nosesymptom']);
           $list[$i]['breathsymptom'] = $this->local_nose_symptom($list[$i]['breathsymptom']);
       }
        $this->assign('list',$list);
        $this->assign('userid',$uid);
        $this->assign('type',$type);
        $this->assign('page',$Page->show());
        $this->display();
    }
    
    public function testlog(){
        $size = 10;
        $uid = intval(I('userid'));
        $type = intval(I('type'))?intval(I('type')):1;
        $where = "uid=$uid AND category=$type";
        $this->assign('type',$type);
        $stime = I("stime");
        
        if($stime){
            $where .= " AND ctime >=".strtotime($stime);
            $this->assign('stime',$stime);
        }
        $etime = I("etime");
        if($etime){
            $where .= " AND ctime <".strtotime($etime);
            $this->assign('etime',$etime);
        }
        
        $logModel = M('report');
        $order = "rid desc";
        $count = $logModel->where($where)->count();
        $Page = new \Think\Page($count,$size);
        $list = $logModel
            ->where($where)->limit($Page->firstRow,$Page->listRows)->order($order)->select();
        for($i=0;$i<count($list);$i++){
           $list[$i]['nosesymptom'] = $this->local_nose_symptom($list[$i]['nosesymptom']);
           $list[$i]['breathsymptom'] = $this->local_nose_symptom($list[$i]['breathsymptom']);
       }
        $this->assign('list',$list);
        $this->assign('userid',$uid);
        $this->assign('type',$type);
        $this->assign('page',$Page->show());
        $this->display();
    }

    //发票列表
    public function invoice(){
        $count = M("invoice")->where('status>0')->count();
        $Page = new \Think\Page($count, 20);
        $show = $Page->show();
        $model = M("invoice")->alias('i')
                ->join('left join web_user u on u.uid=i.uid')
                // ->where($params)
                ->field("u.phone,u.nickname,i.*")
                ->order('i.ctime desc')->limit($Page->firstRow,$Page->listRows)->select();
        $this->assign("model", $model);
        $this->assign("page", $show);
        $this->display();
    }
    //发开票
    public function ensure_invoice(){
        $invoice_id=I('post.invoice_id');
        M('invoice')->where('invoice_id='.$invoice_id)->save(array('status'=>2));
        $this->ajaxReturn(array('status'=>0,'msg'=>''));
    }
    
    private function local_nose_symptom($val){
       $arr = explode(',', $val);
       $result = array();
       for($i=0;$i<count($arr);$i++){
           if(self::$nose_symptom[$i.$arr[$i]]){
               array_push($result, self::$nose_symptom[$i.$arr[$i]]);
           }
       }
       return implode(',', $result);
   }
   
   private function local_breath_symptom($val){
       $arr = explode(',', $val);
       $result = array();
       for($i=0;$i<count($arr);$i++){
           if(self::$breath_symptom[$i.$arr[$i]]){
               array_push($result, self::$breath_symptom[$i.$arr[$i]]);
           }
       }
       return implode(',', $result);
   }
   
   private static $nose_symptom = array(
     '01'=>'喷嚏','11'=>'流涕','21'=>'鼻塞','31'=>'鼻痒'  
   );
   
   private static $breath_symptom = array(
     '01'=>'喷嚏','11'=>'流涕','21'=>'鼻塞','31'=>'鼻痒','41'=>'夜间因哮喘憋醒'
   );

      /*
     * 用户申请
     */
    public function user(){
        $params = "t.authstatus>1";
        $good = M("user");
        $count = $good->alias('t')->where($params)->count();
        $Page = new \Think\Page($count, 20);
        $show = $Page->show();
        $model = M("user")->alias('t')
                ->where($params)
                ->field("t.uid,t.phone,t.authstatus,t.ctime,t.gender")
                ->order('t.uid desc')->limit($Page->firstRow,$Page->listRows)->select();
        $this->assign("model", $model);
        $this->assign("page", $show);
        $this->display();
    } 
    public function userdetail(){
        $tid = I('uid');
        $showop = I('showop');
        $teacher = M('user')->alias('t')
                ->where(array('uid'=>$tid))
                ->field("t.*")->find();
        $this->assign('teacher',$teacher);
        $this->assign('showop',$showop);
        $this->display();
    }
    //审核律师
    public function authuser(){
        $applyid = I('applyid');
        $status = I('status');
        $memo = I('memo');
        $teacher = M('user')->alias('t')
                ->where(array('uid'=>$applyid))->find();
        $uname = $this->get_username();
        $info = '';
        $rs = true;
        //检查用户状态
        M()->startTrans();
        if(intval($status) - 1 ==0){
            //审核通过
            $info = '['.$uname.']审核通过';
            //修改用户类型
            $rs = $rs && M('user')->where(array('uid'=>$applyid))->save(array(
                'authstatus'=>1,'etime'=>time(),
            ));
            $msg = '您的实名认证已通过';
            
        }else if(intval($status)-3 == 0){
            //驳回
            $info = '['.$uname.']驳回';
            $rs = $rs && M('user')->where(array('uid'=>$applyid))->save(array(
                'etime'=>time(),'authstatus'=>3,
            ));
            $msg = '您的实名认证被驳回';
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
       //  //发送消息
       // // $this->sendmsg($applyid, $msg, Constant::msg_type_sys);
       //  $data = array(
       //      'userid'=>$applyid,'type'=>3,
       //      'content'=>$msg,'addtime'=>time()
       //  );
       //  M('user_message')->add($data);
       //  //发送推送
       //  //$this->pushinfo($msg, $applyid, 0, '');
        
        $this->ajaxReturn(array('status'=>0,'msg'=>''));
    }


   
    

}
