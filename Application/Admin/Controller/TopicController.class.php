<?php
namespace Admin\Controller;
/*
 * 话题管理
 */
class TopicController extends BaseController {
    
    public function index(){}

    public function category(){
        $where = 'status=0';
        $count = M('topic_category')->where($where)->count();
        $order = 'sortval,catid desc';
        $Page = new \Think\Page($count,20);
        $list = M('topic_category')->where($where)
                ->order($order)->limit($Page->firstRow,$Page->listRows)->select();
        $this->assign('page', $Page->show()); 
        $this->assign('list', $list);
        $this->display();
    }
    
    public function addcat(){
        $gid = I('catid');
        if(IS_POST){
            $data = array(
                'cname'=>I('cname'),
                'sortval'=>I('sortval'),
                'ctime'=>time()
            );
            if($gid){
               $data['etime'] = time();
               M("topic_category")->where('catid=%d',$gid)->save($data);
            }else{
               $data['ctime'] = time();
               M("topic_category")->add($data); 
            }
            $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
        }
        if($gid){
            $cat = M("topic_category")->find($gid);
            $this->assign('data',$cat);
        }
        $this->display();
    }

    public function delcat() {
        M('topic_category')->where(array('catid' => I('catid')))
                ->save(array('status'=>1,'etime'=>time()));
        $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
    }
    
    public function rcmdcat() {
        M('topic_category')->where(array('catid' => I('catid')))
                ->save(array('isrcmd'=>I('status'),'etime'=>time()));
        $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
    }
    
    
    /*
     * 话题列表
     */
    public function topiclist(){
        $where = "1=1";
        $title = I("title");//关键字
        if($title){
            $where .= " AND t.title like '%$title%'";
            $this->assign('title',$title);
        }
        $words=$_GET['words'];
        if($words){
            $where = " u.nickname like '%$words%' ";
            $this->assign('words',$words);
        }
        $ctime = I("ctime");//注册时间
        if($ctime){
            $where .= " AND t.ctime >=".strtotime($ctime);
            $this->assign('ctime',$ctime);
        }
        $stime = I("stime");//注册时间
        if($stime){
            $where .= " AND t.ctime <".strtotime($stime);
            $this->assign('stime',$stime);
        }
        $count = M('topic')->alias('t')->join('inner join __USER__ u on t.uid=u.uid ')->where($where)->count();
        $Page = new \Think\Page($count, 12);
        $show = $Page->show();
        $field = "t.*,u.nickname,c.cname";
        $data = M('topic')->alias('t')
                ->join('inner join __USER__ u on t.uid=u.uid ')
                ->join('left join __TOPIC_CATEGORY__ c on t.catid=c.catid ')
                ->where($where)->field($field)
                ->order('t.tid desc')->limit($Page->firstRow,$Page->listRows)->select();
        for($i=0;$i<count($data);$i++){
            $data[$i]['pictures'] = $data[$i]['pictures']?explode(',', $data[$i]['pictures']):array();
        }
        $this->assign("data", $data);
        $this->assign('page',$show);
        $this->display();
    }
    
    /*
     * 删除话题
     */
    public function deltopic(){
        M('topic')->where('tid=%d',  intval(I('tid')))->delete();
        $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
    }
    
    /*
     * 推荐话题
     */
    public function rcmdtopic(){
        $state = intval(I('state'));
        $savedata = array('isrcmd'=>$state);
        if($state){
          $savedata['rcmdtime']  = time();
        }
        M('topic')->where('tid=%d',  intval(I('tid')))->save($savedata);
        $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
    }
    /*
     * 话题评论列表
     */
    public function comments(){
        $tid = intval(I('tid'));
        $size = 10;
        $where = 'c.tid = '.$tid;
        $order = 'c.cid desc';
        $field = "c.cid,c.txt,c.ctime,u.nickname,u.avator";
        $title = I('title');
        if($title){
            $where .= " AND u.nickname like '%$title%'";
            $this->assign('title',$title);
        }
        
        $count = M('topic_commts')->alias('c')
                ->join('left join __USER__ u on u.uid=c.uid')
                ->where($where) ->count();
        $Page  = new \Think\Page($count,$size);
        $m = M('topic_commts')->alias('c')
                ->join('left join __USER__ u on u.uid=c.uid');
        $data = $m->where($where)->field($field)->limit($Page->firstRow.','.$Page->listRows)->order($order)->select();
        $this->assign('data',$data);
        $this->assign('page',$Page->show());
        $this->assign('tid',$tid);
        $this->display();
    }
    
    public function delcommt(){
        $cid = intval(I('cid'));
        M('topic_commts')->where('cid=%d',$cid)->delete();
        $this->ajaxReturn(array('status'=>0,msg=>'操作成功'));
    }
    
}