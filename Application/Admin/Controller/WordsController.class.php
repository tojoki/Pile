<?php

namespace Admin\Controller;
use Think\Controller;
class WordsController extends BaseController {
    //文本管理
    public function setting(){
        $count = M('words')->count();
        $Page = new \Think\Page($count, 12);
        $show = $Page->show();
        $list=M('words')->limit($Page->firstRow,$Page->listRows)->select();
        $index_r=1;
        foreach($list as $k=>$v){
        $list[$k]['index_r']=$index_r;
        $index_r++;
        }
        $this->assign('page',$show);
        $this->assign('list',$list);
        $this->display();
    }
    //修改文字
    public function editWords(){
        if(IS_POST){
            $words_id=I('post.words_id');
            $data['content']=I('post.content');
            $edit=M('words')->where('words_id='.$words_id)->save($data);
            $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
        }else{
            $words_id=I('get.words_id');
            $data=M('words')->where('words_id='.$words_id)->find();
            $this->assign('data',$data);
            $this->display();    
        }
        
    }
    //温馨提示
    public function remind(){
        $ad = M('remind');
        $pageSize = 5;
        $count = $ad->count();
        $p = getpage($count,$pageSize);
        $show = $p->show();
        $list = $ad
         ->limit($pageSize)
         ->order('id DESC')
         ->page(I('p'))
         ->select();
         $index_r=1;
         foreach($list as $k=>$v){
            $list[$k]['index']=$index_r;
            $index_r++;
         }

        $this->assign('page', $show); 
        $this->assign('list', $list);
        $this->display();
    }    
    //添加
    public function add(){
        if(IS_POST){
            $title = I('title');
            $array = array(
                'title'=>$title,
                );
            $data = M('remind')->add($array);
            if($data){
                succ('添加成功');
            }else{
                err('添加失败');
            }
        }else{
            $this->display();
        }
    }
    //修改
    public function edit(){
        if(IS_POST){
            $title = I('title');
            $array = array(
                'title'=>$title,
                );
            $data = M('remind')->where('id='.I('id'))->save($array);
            if($data){
                succ('修改成功');
            }else{
                err('修改失败');
            }
        }else{
            $info=M('remind')->where('id='.I('id'))->find();
            $this->assign('info',$info);
            $this->display('add');
        }
    }
    //删除
    public function deel(){
        if($error = admin_require_check('id')) $this->error($error);
        $fbModel = M('remind');
        $condi['id'] = I('id');
        if($fbModel->where($condi)->delete()){
            succ("删除成功");
        }else{
            err("删除失败");
        }
    }
    //电话列表
    public function phone(){
        $info=M('phone')->where('id=1')->find();
        $this->assign('info',$info);
        $this->display();
    }
    //修改
    public function editPhone(){
        if(IS_POST){
            $title = I('title');
            $id = I('id');
            if($id==1){
                $array['property_phone']=$title;
            }else if($id==2){
                $array['service_phone']=$title;
            }
            $data = M('phone')->where('id=1')->save($array);
            if($data){
                succ('修改成功');
            }else{
                err('修改失败');
            }
        }else{
            $id=I('id');
            if($id==1){
                $phone=M('phone')->where('id=1')->getField('property_phone');
            }else if($id==2){
                $phone=M('phone')->where('id=1')->getField('service_phone');
            }
            $this->assign('id',$id);
            $this->assign('info',$phone);
            $this->display();
        }
    }
}