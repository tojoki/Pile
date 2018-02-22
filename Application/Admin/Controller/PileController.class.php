<?php
namespace Admin\Controller;
use Api\Common\Constant;

class PileController extends BaseController {

    public function lists(){
        $list = M('disc')->order('rtime desc')->select();
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
    
    public function add(){
        $id = I('id');
        if(IS_POST){
            // var_dump($_POST);die;
            $data["name"]=I('name');
            $data["rtime"]=strtotime(I('rtime'));
            $data["type"]=I('type');
            $data["code"]=I('code');
            $data["price"]=intval(I('price'));
            $data["info"]=trim(I('info'));
            $data["description"]=trim(I('description'));
            $data["version"]=I('version');
            $data["cover1"]=I('cover1');
            $is_cover=I('is_cover');
            if($is_cover){
                $data["cover2"]=I('cover2');
            }else{
                $data["cover2"]=null;
            }

            if($id){
                $res = M('disc')->where(array('id'=>$id))->save($data);
            }else{
                $res = M('disc')->add($data);
            }

            if($res){
                exit($this->ajaxReturn(array('status'=>0,'msg'=>'操作成功','url'=>'/Admin/Pile/lists')));
            }else{
                exit($this->ajaxReturn(array('status'=>1,'msg'=>'操作失败','url'=>'/Admin/Pile/add')));
            }
        }
        if($id){
            $info = M('disc')->where(array('id'=>$id))->find();
            if($info['cover2']){
                $info['is_cover']=1;
            }
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
        $res = M('disc')->delete($id);
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

    public function content(){
        $disc_id=I('get.id');
        $disc_name=M('disc')->where('id='.$disc_id)->getField('name');
        $lists=M('tunes')->where('disc_id='.$disc_id)->select();
        $this->assign('disc_id',$disc_id);
        $this->assign('disc_name',$disc_name);
        $this->assign('lists',$lists);
        $this->display();
    }

    public function add_content(){
        if(IS_POST){
            $disc_id = I('disc_id');
            M('tunes')->where('disc_id='.$disc_id)->delete();

            $name = I('name');//名称
            $type = I('type');//类型
            foreach ($name as $key => $value) {
                $data = array(
                'type' => $type[$key],
                'name' => $value,
                'disc_id'=>$disc_id
                );
                $film = M('tunes')->add($data);
            } 
            $this->success('添加成功',U('content',array('id'=>$disc_id)));
        }else{
            $disc_id = I('id');
            $lists=M('tunes')->where('disc_id='.$disc_id)->select();
            $this->assign("lists",$lists);
            $this->assign("disc_id",$disc_id);
            $this->display();   
        }
        
    }
}