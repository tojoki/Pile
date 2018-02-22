<?php
namespace Admin\Controller;
use Api\Common\Constant;
class BillboardController extends BaseController {
    /*
     * 活动列表
     */
    public function lists(){
        $where = "isdel=0";
        $count = M('billboard')->alias('b')->where($where)->count();
        $Page = new \Think\Page($count, 12);
        $show = $Page->show();
        $field = "b.*";
        $data = M('billboard')->alias('b')
                ->where($where)->field($field)
                ->order('b.seq desc')->limit($Page->firstRow,$Page->listRows)->select();
        $this->assign("data", $data);
        $this->assign('page',$show);
        $this->display();
    }

    public function addactivity(){
        $gid = I('bid');
        if(IS_POST){
            $pictures = I('pictures')?explode(',', I('pictures')):array();
            $data = array(
                'pictures'=>I('pictures'),'poster'=>$pictures[0],
                'title'=>I('title'),'starttime' =>  strtotime(I('starttime')),
                'endtime'=>  strtotime(I('endtime'))
            );
            if($gid){
               $data['etime'] = time();
               M("billboard")->where('bid=%d',$gid)->save($data);
            }else{
               $data['ctime'] = time();
               //计算序列
                $maxseq = M('billboard')->where('isdel=0')->max('seq');
                if(empty($maxseq)){
                    $maxseq = 0;
                }
                $data['seq'] = $maxseq+1;
                M("billboard")->add($data); 
            }
            $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
        }
        if($gid){
            $goods = M('billboard')->find($gid);
            $goods['posters'] = $goods['pictures']?explode(',', $goods['pictures']):array();
            $this->assign('data',$goods);
        }
        //计算序列
        $maxseq = M('billboard')->where('isdel=0')->max('seq');
        if(empty($maxseq)){
            $maxseq = 0;
        }
        $this->assign('seq',$maxseq+1);
        $this->display();
    }
    
    public function del(){
        $bid = I('bid');
        M('billboard')->where('bid=%d',$bid)->save(array('isdel'=>1));
        $this->ajaxReturn(array('status'=>0,msg=>'操作成功'));
    }
    
    /*
     * 参与记录
     */
    public function applys(){
        $bid = intval(I('bid'));
        $where = "a.isdel=0 AND a.bid=$bid";
        $title = I('title');
        if($title){
            $where .= " AND u.nickname like '%$title%' ";
        }
        $count = M('billboard_apply')->alias('a')
                ->join('left join __USER__ u on u.uid=a.uid')
                ->where($where)->count();
        $Page = new \Think\Page($count, 12);
        $show = $Page->show();
        $field = "a.applyid,a.pictures,a.words,a.ctime,a.commts,a.votes,u.nickname,u.phone";
        $data = M('billboard_apply')->alias('a')
                ->join('left join __USER__ u on u.uid=a.uid')
                ->where($where)->field($field)
                ->order('a.votes desc')->limit($Page->firstRow,$Page->listRows)->select();
        for($i=0;$i<count($data);$i++){
            $data[$i]['pictures'] = $data[$i]['pictures']?  explode(',', $data[$i]['pictures']):array();
        }
        $this->assign("data", $data);
        $this->assign('page',$show);
        $this->display();
    }
    
    /*
     * 评论列表
     */
    public function comments(){
        $applyid = intval(I('applyid'));
        $size = 10;
        $where = 'c.applyid = '.$applyid;
        $order = 'c.cid desc';
        $field = "c.cid,c.txt,c.thumbs,c.ctime,u.nickname,u.avator";
        $title = I('title');
        if($title){
            $where .= " AND u.nickname like '%$title%'";
            $this->assign('title',$title);
        }
        
        $count = M('billboard_apply_commt')->alias('c')
                ->join('left join __USER__ u on u.uid=c.uid')
                ->where($where) ->count();
        $Page  = new \Think\Page($count,$size);
        $m = M('billboard_apply_commt')->alias('c')
                ->join('left join __USER__ u on u.uid=c.uid');
        $data = $m->where($where)->field($field)->limit($Page->firstRow.','.$Page->listRows)->order($order)->select();
        $this->assign('data',$data);
        $this->assign('page',$Page->show());
        $this->assign('applyid',$applyid);
        $this->display();
    }
    
    /*
     * 投票列表
     */
    public function voters(){
        $applyid = intval(I('applyid'));
        $size = 10;
        $where = 'c.applyid = '.$applyid;
        $order = 'c.vid desc';
        $field = "c.vid,c.ctime,u.nickname,u.avator,u.phone";
        $title = I('title');
        if($title){
            $where .= " AND u.nickname like '%$title%'";
            $this->assign('title',$title);
        }
        
        $count = M('billboard_vote')->alias('c')
                ->join('left join __USER__ u on u.uid=c.uid')
                ->where($where) ->count();
        $Page  = new \Think\Page($count,$size);
        $m = M('billboard_vote')->alias('c')
                ->join('left join __USER__ u on u.uid=c.uid');
        $data = $m->where($where)->field($field)->limit($Page->firstRow.','.$Page->listRows)->order($order)->select();
        $this->assign('data',$data);
        $this->assign('page',$Page->show());
        $this->assign('applyid',$applyid);
        $this->display();
    }
    
    /*
     * 删除参与记录
     */
    public function delapply(){
        $applyid = intval(I('applyid'));
        M('billboard_apply')->where('applyid=%d',$applyid)->save(array('isdel'=>1));
        $this->ajaxReturn(array('status'=>0,msg=>'操作成功'));
    }
    
    public function delcommt(){
        $cid = intval(I('cid'));
        M('billboard_apply_commt')->where('cid=%d',$cid)->delete();
        $this->ajaxReturn(array('status'=>0,msg=>'操作成功'));
    }
    
    
}