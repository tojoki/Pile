<?php
namespace Admin\Controller;
use Api\Common\Constant;

/**
 * 服务管理
 */
class ServiceController extends BaseController {
    /**
     * 列表
     */
    public function lists(){
        $list1 = M('service1')->alias('s')
                    ->join('left join web_place p on s.place_id=p.id')
                    ->field('s.*,p.title')
                    ->where('s.is_del=0')
                    ->select();//洗车
        $list2 = M('service2')->alias('s')
                    ->join('left join web_place p on s.place_id=p.id')
                    ->field('s.*,p.title')
                    ->where('s.is_del=0')
                    ->select();//美容美发
        
        $this->assign('list1',$list1);
        $this->assign('list2',$list2);
        $this->display();
    }
    
    /**
     * 用户公告 - 添加服务(洗车)
     */
    public function add1(){
        $id = I('id');
        if(IS_POST){
            $data['cover'] = I('cover');
            $data['place_id'] = I('place_id');
            $data['address'] = I('address');
            $data['intro'] = I('intro');
            $data['phone'] = I('phone');
            $data['ctime']=time();

            if($id){
                //判断数据库中有没有同地区的id且不是本条数据 如果有 提示不可修改
                $test=M('service1')->where('place_id='.$data['place_id'].' and id!='.$id.' and is_del=0')->find();
                if($test){
                    exit($this->ajaxReturn(array('status'=>1,'msg'=>'本区域已存在相同服务')));
                }
                $res = M('service1')->where(array('id'=>$id))->save($data);
            }else{
                //判断数据库中有没有同地区的id 如果有 提示不可添加
                $test=M('service1')->where('place_id='.$data['place_id'].' and is_del=0')->find();
                if($test){
                    exit($this->ajaxReturn(array('status'=>1,'msg'=>'本区域已存在相同服务')));
                }
                $res = M('service1')->add($data);
            }

            if($res){
                exit($this->ajaxReturn(array('status'=>0,'msg'=>'操作成功')));
            }else{
                exit($this->ajaxReturn(array('status'=>1,'msg'=>'操作失败')));
            }
        }
        if($id){
            $info = M('service1')->where(array('id'=>$id))->find();
            // var_dump($info);die;
            $this->assign('info',$info);
        }
        //查询区域
        $placeList=M('place')->where('is_del=0')->select();
        $this->assign('placeList',$placeList);
        $this->display();
    }

    /**
     * 删除
     */
    public function del_user1(){
        $id = I('id');
        //先查询订单表是否有这个服务的id与服务类型(洗车) 如果有 提示不可删除
        $test=M('order1')->where('service_id='.$id.' and cate_id=1')->select();
        if($test){
            $this->ajaxReturn(array('msg'=>'当前服务已有预约,不可删除','status'=>1));
        }else{
            // $res = M('service1')->delete($id);
            $res = M('service1')->where('id='.$id)->save(array('is_del'=>1));
            if($res){
                $this->ajaxReturn(array('msg'=>'删除成功','status'=>0));
            }else{
                $this->ajaxReturn(array('msg'=>'删除失败','status'=>1));
            }    
        }
        
    }
    /**
     * 用户公告 - 添加服务(美容美发)
     */
    public function add2(){
        $id = I('id');
        if(IS_POST){
            $data['cover'] = I('cover');
            $data['place_id'] = I('place_id');
            $data['address'] = I('address');
            $data['intro'] = I('intro');
            $data['phone'] = I('phone');
            $data['ctime']=time();

            if($id){
                //判断数据库中有没有同地区的id且不是本条数据 如果有 提示不可修改
                $test=M('service2')->where('place_id='.$data['place_id'].' and id!='.$id.' and is_del=0')->find();
                if($test){
                    exit($this->ajaxReturn(array('status'=>1,'msg'=>'本区域已存在相同服务')));
                }
                $res = M('service2')->where(array('id'=>$id))->save($data);
            }else{
                //判断数据库中有没有同地区的id 如果有 提示不可添加
                $test=M('service2')->where('place_id='.$data['place_id'].' and is_del=0')->find();
                if($test){
                    exit($this->ajaxReturn(array('status'=>1,'msg'=>'本区域已存在相同服务')));
                }
                $res = M('service2')->add($data);
            }

            if($res){
                exit($this->ajaxReturn(array('status'=>0,'msg'=>'操作成功')));
            }else{
                exit($this->ajaxReturn(array('status'=>1,'msg'=>'操作失败')));
            }
        }
        if($id){
            $info = M('service2')->where(array('id'=>$id))->find();
            // var_dump($info);die;
            $this->assign('info',$info);
        }
        //查询区域
        $placeList=M('place')->where('is_del=0')->select();
        $this->assign('placeList',$placeList);
        $this->display();
    }
    /**
     * 删除
     */
    public function del_user2(){
        $id = I('id');
        //先查询订单表是否有这个服务的id与服务类型(美容美发) 如果有 提示不可删除
        $test=M('order2')->where('service_id='.$id.' and cate_id=2')->select();
        if($test){
            $this->ajaxReturn(array('msg'=>'当前服务已有预约,不可删除','status'=>1));
        }else{
            // $res = M('service2')->delete($id);
            $res = M('service2')->where('id='.$id)->save(array('is_del'=>1));
            if($res){
                $this->ajaxReturn(array('msg'=>'删除成功','status'=>0));
            }else{
                $this->ajaxReturn(array('msg'=>'删除失败','status'=>1));
            }    
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

    //服务账号
    public function worker(){
        $ad = M('worker');
        $pageSize = 5;
        $count = $ad->count();
        $p = getpage($count,$pageSize);
        $show = $p->show();
        $list = $ad->alias('w')
         ->join('left join web_place p on p.id=w.place_id')
         ->limit($pageSize)
         ->order('worker_id DESC')
         ->page(I('p'))
         ->select();

        $this->assign('page', $show); 
        $this->assign('list', $list);
        $this->display();
    }    
    //添加
    public function add(){
        if(IS_POST){
            $data['worker_name']=I('worker_name');
            $data['phone']=I('phone');
            $password=I('password');
            $re_password=I('re_password');
            if($password!=$re_password){
                err('两次密码不一致');
            }else{
                $data['password']=md5($password);
            }
            $service=I('service');//'cate_id-id的格式'
            $cate_id=substr($service,0,strpos($service, '-'));
            $service_id=substr($service,(strpos($service, '-')+1));
            if($cate_id==1){
                $serviceInfo=M('service1')->where('id='.$service_id)->find();
            }else if($cate_id==2){
                $serviceInfo=M('service2')->where('id='.$service_id)->find();
            }
            $data['place_id']=$serviceInfo['place_id'];
            $data['cate_id']=$cate_id;
            $data['service_id']=$service_id;
            $data['ucode']=gen_code();

            $add = M('worker')->add($data);
            if($add){
                succ('添加成功');
            }else{
                err('添加失败');
            }
        }else{
            //查询服务 并用cate_id(分类id 洗车/美容美发)+id(自身id)返回
            //(不需要区域id 因为通过id可以查出来 但是因为两张表 所以要关联cate_id 如果是1 查service1)
            $list1 = M('service1')->alias('s')
                    ->join('left join web_place p on s.place_id=p.id')
                    ->field('s.*,p.title')
                    ->where('s.is_del=0')
                    ->select();//洗车
            foreach($list1 as $k=>$v){
                $list1[$k]['service']=$v['cate_id'].'-'.$v['id'];
            }
            $list2 = M('service2')->alias('s')
                    ->join('left join web_place p on s.place_id=p.id')
                    ->field('s.*,p.title')
                    ->where('s.is_del=0')
                    ->select();//美容美发
            foreach($list2 as $k=>$v){
                $list2[$k]['service']=$v['cate_id'].'-'.$v['id'];
            }
            $this->assign('list1',$list1);
            $this->assign('list2',$list2);

            $this->display();
        }
    }
    //修改
    public function edit(){
        if(IS_POST){
            $data['worker_name']=I('worker_name');
            $data['phone']=I('phone');
            $password=I('password');
            $re_password=I('re_password');
            if($password!=$re_password){
                err('两次密码不一致');
            }else{
                $data['password']=md5($password);
            }
            $service=I('service');//'cate_id-id的格式'
            $cate_id=substr($service,0,strpos($service, '-'));
            $service_id=substr($service,(strpos($service, '-')+1));
            if($cate_id==1){
                $serviceInfo=M('service1')->where('id='.$service_id)->find();
            }else if($cate_id==2){
                $serviceInfo=M('service2')->where('id='.$service_id)->find();
            }
            $data['place_id']=$serviceInfo['place_id'];
            $data['cate_id']=$cate_id;
            $data['service_id']=$service_id;

            $edit = M('worker')->where('worker_id='.I('id'))->save($data);
            if($edit){
                succ('修改成功');
            }else{
                err('修改失败');
            }
        }else{
            $info=M('worker')->where('worker_id='.I('id'))->find();
            $info['service']=$info['cate_id'].'-'.$info['service_id'];
            $this->assign('info',$info);
            //查询服务 并用cate_id(分类id 洗车/美容美发)+id(自身id)返回
            //(不需要区域id 因为通过id可以查出来 但是因为两张表 所以要关联cate_id 如果是1 查service1)
            $list1 = M('service1')->alias('s')
                    ->join('left join web_place p on s.place_id=p.id')
                    ->field('s.*,p.title')
                    ->where('s.is_del=0')
                    ->select();//洗车
            foreach($list1 as $k=>$v){
                $list1[$k]['service']=$v['cate_id'].'-'.$v['id'];
            }
            $list2 = M('service2')->alias('s')
                    ->join('left join web_place p on s.place_id=p.id')
                    ->field('s.*,p.title')
                    ->where('s.is_del=0')
                    ->select();//美容美发
            foreach($list2 as $k=>$v){
                $list2[$k]['service']=$v['cate_id'].'-'.$v['id'];
            }
            $this->assign('list1',$list1);
            $this->assign('list2',$list2);
            $this->display('add');
        }
    }
    //删除
    public function deel(){
        if($error = admin_require_check('id')) $this->error($error);
        $fbModel = M('worker');
        $condi['worker_id'] = I('id');
        if($fbModel->where($condi)->delete()){
            succ("删除成功");
        }else{
            err("删除失败");
        }
    }    
}