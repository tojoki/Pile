<?php

namespace Admin\Controller;
use Think\Controller;
class PlaceController extends BaseController {
    //区域设置
    public function lists(){
        $ad = M('place');
        $pageSize = 5;
        $count = $ad->where('is_del=0')->count();
        $p = getpage($count,$pageSize);
        $show = $p->show();
        $list = $ad
         ->where('is_del=0')
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
            $data = M('place')->add($array);
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
            $data = M('place')->where('id='.I('id'))->save($array);
            if($data){
                succ('修改成功');
            }else{
                err('修改失败');
            }
        }else{
            $info=M('place')->where('id='.I('id'))->find();
            $this->assign('info',$info);
            $this->display('add');
        }
    }
    //删除
    public function deel(){
        if($error = admin_require_check('id')) $this->error($error);
        $fbModel = M('place');
        $condi['id'] = I('id');
        //查询当前区域是否有未完成订单 如果有 提示不可删除 如果没有 伪删
        $test1=M('order1')->where('place_id='.$condi['id'].' and is_complete=0')->select();
        $test2=M('order2')->where('place_id='.$condi['id'].' and is_complete=0')->select();
        if($test1 || $test2){
            err('当前区域存在未完成订单,请稍后再删除');
        }else{
            $fbModel->where($condi)->save(array('is_del'=>1));
            succ('删除成功');
        }
    }

}