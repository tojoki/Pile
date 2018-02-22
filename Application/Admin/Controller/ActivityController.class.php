<?php
namespace Admin\Controller;
use Api\Common\Constant;

/**
 * 活动管理
 */
class ActivityController extends BaseController {
    /**
     * 猜你喜欢
     */
    public function lists(){
        $list = M('activity')->select();
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
     * 用户活动 - 添加活动
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
                $res = M('activity')->where(array('activity_id'=>$id))->save($data);
            }else{
                $res = M('activity')->add($data);
            }

            if($res){
                exit($this->ajaxReturn(array('status'=>0,'msg'=>'操作成功','url'=>'/Admin/Activity/lists')));
            }else{
                exit($this->ajaxReturn(array('status'=>1,'msg'=>'操作失败','url'=>'/Admin/Activity/add')));
            }
        }
        if($id){
            $info = M('activity')->where(array('activity_id'=>$id))->find();
            // var_dump($info);die;
            $this->assign('info',$info);
        }
        $this->display();
    }

    /**
     * 用户活动 - 删除活动
     */
    public function del_user(){
        $id = I('id');
        $res = M('activity')->delete($id);
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
}