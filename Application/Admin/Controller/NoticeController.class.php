<?php
namespace Admin\Controller;
use Admin\Common\Constant;

/**
 * 公告管理
 */
class NoticeController extends BaseController {
    /**
     * 物业公告
     */
    public function lists(){
        $list = M('notice')->select();
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
     * 用户公告 - 添加公告
     */
    public function add(){
        $id = I('id');
        if(IS_POST){
            $data['title'] = I('title');
            $data['intro'] = I('intro');
            $data['cover'] = I('cover');
            $data['content'] = I('content');
            $data['ctime']=time();

            if($id){
                $res = M('notice')->where(array('notice_id'=>$id))->save($data);
                $is_push=false;//无需推送
            }else{
                $res = M('notice')->add($data);
                $is_push=true;//需要推送
            }

            if($res){
                if($is_push){
                    //查询所有用户 添加消息并推送
                    $msg_data['title']='有新发布的公告,快去查看吧';
                    $msg_data['ctime']=time();
                    $uids=M('user')->field('uid,registration_id')->select();
                    foreach($uids as $v){
                        $msg_data['uid']=$v['uid'];
                        M('user_msg')->add($msg_data);
                        //如果有极光id才推送 防止报错页面卡死
                        if($v['registration_id']){
                            $regid=array($v['registration_id']);
                            sendNotifySpecial($regid,$msg_data['title'],Constant::user_app_key,Constant::user_master_secret);    
                        }
                    }
                }
                
                exit($this->ajaxReturn(array('status'=>0,'msg'=>'操作成功','url'=>'/Admin/Notice/lists')));
            }else{
                exit($this->ajaxReturn(array('status'=>1,'msg'=>'操作失败','url'=>'/Admin/Notice/add')));
            }
        }
        if($id){
            $info = M('notice')->where(array('notice_id'=>$id))->find();
            // var_dump($info);die;
            $this->assign('info',$info);
        }
        $this->display();
    }

    /**
     * 物业公告 - 删除公告
     */
    public function del_user(){
        $id = I('id');
        $res = M('notice')->delete($id);
        if($res){
            $this->ajaxReturn(array('msg'=>'删除成功','status'=>0));
        }else{
            $this->ajaxReturn(array('msg'=>'删除失败','status'=>0));
        }
    }

    public function upload() {
        $basepath = '/images/'.date('ym',time()).'/';
        $upload = new \Think\Upload();// 实例化上传类    
        $upload->maxSize   =     3145728 ;// 设置附件上传大小    
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型    
        $upload->savePath  =     $basepath; // 设置附件上传目录
        $upload->rootPath = 'Public/Uploads/';

        // 上传文件     
        $info   =   $upload->uploadOne($_FILES['file']);
        if(!$info) {
          // 上传错误提示错误信息        
          // Log::write('upload file error:'.$upload->getError());
          $this->ajaxReturn(array('status'=>1,'msg'=>'文件上传失败'));
        }else{
          $this->ajaxReturn(array('status'=>2,'path'=>'Public/Uploads'.$info['savepath'].$info['savename']));
        }
    }
    //设为轮播
    public function set_banner(){
        $notice_id=I('id');
        $edit=M('notice')->where('notice_id='.$notice_id)->save(array('is_banner'=>1));
        if($edit){
            $this->ajaxReturn(array('msg'=>'设置成功','status'=>0));
        }else{
            $this->ajaxReturn(array('msg'=>'设置失败','status'=>0));
        }
    }
    //取消轮播
    public function unset_banner(){
        $notice_id=I('id');
        $edit=M('notice')->where('notice_id='.$notice_id)->save(array('is_banner'=>0));
        if($edit){
            $this->ajaxReturn(array('msg'=>'取消成功','status'=>0));
        }else{
            $this->ajaxReturn(array('msg'=>'取消失败','status'=>0));
        }
    }

    //设为推荐
    public function set_recommend(){
        $notice_id=I('id');
        //先把其他的改成0
        $unset=M('notice')->where('notice_id!='.$notice_id)->save(array('is_recommend'=>0));
        $edit=M('notice')->where('notice_id='.$notice_id)->save(array('is_recommend'=>1));
        if($edit){
            $this->ajaxReturn(array('msg'=>'设置成功','status'=>0));
        }else{
            $this->ajaxReturn(array('msg'=>'设置失败','status'=>0));
        }
    }
    //取消推荐
    public function unset_recommend(){
        $notice_id=I('id');
        $edit=M('notice')->where('notice_id='.$notice_id)->save(array('is_recommend'=>0));
        if($edit){
            $this->ajaxReturn(array('msg'=>'取消成功','status'=>0));
        }else{
            $this->ajaxReturn(array('msg'=>'取消失败','status'=>0));
        }
    }
    
}