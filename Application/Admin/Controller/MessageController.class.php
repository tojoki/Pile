<?php
namespace Admin\Controller;
use Api\Common\Constant;

/**
 * 推送管理 - 消息中心
 */
class MessageController extends BaseController {
    /*
     * 消息中心
     */
    public function lists(){
        $list = M('message')->select();
        $count = count($list);
        $Page = new \Think\Page($count,15);
        $Page -> setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page -> setConfig('prev', '上一页');
        $Page -> setConfig('next', '下一页');
        $Page -> setConfig('last', '末页');
        $Page -> setConfig('first', '首页');
        $Page -> setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
        $list = array_slice($list,$Page->firstRow,$Page->listRows);
        $show = $Page->show();
        $this->assign('data',$list);
        $this->assign('page',$show);
        $this->display();
    }

    /**
     * 消息中心 - 添加消息
     */
    public function add(){
        $id = I('id');
        if(IS_POST){
            $data['title'] = I('title');
            $data['type'] = I('type');  //1用户端 2洗车 3美容美发
            $data['content'] = I('content');
            if($id){
                $res = M('message')->where(array('message_id'=>$id))->save($data);
                $is_push=false;
            }else{
                $data['ctime'] = time();
                $res = M('message')->add($data);
                $is_push=true;
            }

            if($res){
                //如果是添加 那么给相应的端发消息和推送
                if($is_push){
                    $msg_data['title']=$data['title'];
                    $msg_data['txt']=$data['content'];
                    $msg_data['ctime']=time();
                    if($data['type']==1){
                        $ids=M('user')->field('uid,registration_id')->select();
                        foreach($ids as $v){
                            $msg_data['uid']=$v['uid'];
                            M('user_msg')->add($msg_data);
                            if($v['registration_id']){
                                $regid=array($v['registration_id']);
                                sendNotifySpecial($regid,'您有一条新的系统消息',Constant::user_app_key,Constant::user_master_secret);
                            }
                        }
                    }else if($data['type']==2){
                        $ids=M('worker')->where('cate_id=1')->field('worker_id,registration_id')->select();
                        foreach($ids as $v){
                            $msg_data['worker_id']=$v['worker_id'];
                            M('worker_msg')->add($msg_data);
                            if($v['registration_id']){
                                $regid=array($v['registration_id']);
                                sendNotifySpecial($regid,'您有一条新的系统消息',Constant::worker1_app_key,Constant::worker1_master_secret);
                            }
                        }
                    }else if($data['type']==3){
                        $ids=M('worker')->where('cate_id=2')->field('worker_id,registration_id')->select();
                        foreach($ids as $v){
                            $msg_data['worker_id']=$v['worker_id'];
                            M('worker_msg')->add($msg_data);
                            if($v['registration_id']){
                                $regid=array($v['registration_id']);
                                sendNotifySpecial($regid,'您有一条新的系统消息',Constant::worker2_app_key,Constant::worker2_master_secret);
                            }
                        }
                    }
                }
                exit($this->ajaxReturn(array('status'=>0,'msg'=>'操作成功','url'=>'/Admin/message/lists')));
            }else{
                exit($this->ajaxReturn(array('status'=>1,'msg'=>'操作失败','url'=>'/Admin/message/add')));
            }
        }
        if($id){
            $info = M('message')->where(array('message_id'=>$id))->find();
            $this->assign('info',$info);
        }
        $this->display();
    }

    /**
     * 消息中心 - 删除消息
     */
    public function del(){
        $id = I('id');
        $res = M('message')->delete($id);
        if($res){
            $this->ajaxReturn(array('msg'=>'删除成功','status'=>0));
        }else{
            $this->ajaxReturn(array('msg'=>'删除失败','status'=>0));
        }
    }
}