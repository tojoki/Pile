<?php

namespace Admin\Controller;

use Think\Controller;

header('Content-type:text/html;charset=utf-8');

class NewsController extends BaseController {


    public function index() {
    }
    
    /*
     * 新闻列表
     */
    public function lists() {
        $where = '1=1';
        $title = I('title');
        if($title){
            $where .= " AND title like '%$title%'";
            $this->assign('title',$title);
        }
        $type = intval(I('type'));
        if($type){
            $where .= " AND catid =$type";
            $this->assign('type',$type);
        }
        $count = M('news')->where($where)->count();
        $order = 'nid desc';
        $Page = new \Think\Page($count,10);
        $list = M('news')->alias('a')->where($where)
                ->order($order)->limit($Page->firstRow,$Page->listRows)->select();
        $this->assign('page', $Page->show()); 
        $this->assign('list', $list);
        $this->display();
    }
    
    public function addnews(){
        $gid = I('nid');
        if(IS_POST){
            $releasetime = I('releasetime');
            $data = array(
                'posters'=>I('pictures'),'catid'=>I('catid'),
                'title'=>I('title'),'author' =>  I('author'),
                'releasetime'=>  strtotime(I('endtime')),'content'=>  I('content'),
                'sortval'=>  intval(I('sortval'))
            );
            if($releasetime){
               $data['releasetime'] = strtotime($releasetime);
            }else{
               $data['releasetime'] = time();
            }
            if($gid){
               $data['etime'] = time();
               M("news")->where('nid=%d',$gid)->save($data);
            }else{
               $data['ctime'] = time();
               M("news")->add($data); 
            }
            $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
        }
        if($gid){
            $goods = M('news')->find($gid);
            $goods['posters'] = $goods['posters']?explode(',', $goods['posters']):array();
            $this->assign('data',$goods);
        }
        $this->display();
    }
    
    public function delnews() {
        M('news')->where(array('nid' => I('nid')))->delete();
        $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
    }
    
    public function rcmd() {
        $nid = I('nid');$isrcmd = I('isrcmd');
        M('news')->where(array('nid' => $nid))->save(array('isrcmd'=>$isrcmd,'etime'=>time()));
        $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
    }
    
    /*
     * 话题评论列表
     */
    public function comments(){
        $tid = intval(I('tid'));
        $size = 10;
        $where = 'c.nid = '.$tid;
        $order = 'c.cid desc';
        $field = "c.cid,c.txt,c.ctime,u.nickname,u.avator";
        $title = I('title');
        if($title){
            $where .= " AND u.nickname like '%$title%'";
            $this->assign('title',$title);
        }
        
        $count = M('news_commts')->alias('c')
                ->join('left join __USER__ u on u.uid=c.uid')
                ->where($where) ->count();
        $Page  = new \Think\Page($count,$size);
        $m = M('news_commts')->alias('c')
                ->join('left join __USER__ u on u.uid=c.uid');
        $data = $m->where($where)->field($field)->limit($Page->firstRow.','.$Page->listRows)->order($order)->select();
        $this->assign('data',$data);
        $this->assign('page',$Page->show());
        $this->assign('tid',$tid);
        $this->display();
    }

}
