<?php
namespace Admin\Controller;
class AdvertController extends BaseController {
    
    public function index(){

    }

    //登录广告
    public function home(){
        if(IS_POST){
            $gid = I('aid');
            $data = array(
                'poster'=>I('poster'),'catid'=>1,
                'links'=>I('links'),'showtime' =>  I('showtime'),
            );
            if($gid){
               $data['etime'] = time();
               M("advert")->where('aid=%d',$gid)->save($data);
            }else{
               $data['ctime'] = time();
               M("advert")->add($data); 
            }
            $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
        }
        
        $goods = M('advert')->where('catid=1')->order('aid desc')->find();
        $this->assign('data',$goods);
        $this->display();
    }

    public function edit($id = 0) {
        if ($id = (int) $id) {
            $data = M('advert')->where("id=%d",$id)->find();
            $this->assign('data',$data);
            $this->display('add');
        } else {
            $this->error('请选择要编辑的广告');
        }
    }
    
    public function del() {
        $advert = D('advert');
        $id = I('aid');
        $result = $advert->where('aid =' . $id . '')->delete();
        if ($result) {
            $this->ajaxReturn(array('status'=>0,'msg'=>'删除成功'));
        } else {
            $this->ajaxReturn(array('status'=>1,'msg'=>'删除失败'));
        }
    }
    
    
    /*
     * banner广告
     */
    public function banner(){
        $goods = M('advert')->where('catid=2')->order('sortval desc,aid desc')->limit(0,10)->select();
        $this->assign('data',$goods);
        $this->display();
    }
    
    public function addbanner(){
        $gid = I('aid');
        if(IS_POST){
            $data = array(
                'poster'=>I('poster'),'catid'=>2,
                'links'=>I('links'),'sortval'=>  intval(I('sortval'))
            );
            if($gid){
               $data['etime'] = time();
               M("advert")->where('aid=%d',$gid)->save($data);
            }else{
               $nums = M("advert")->where("catid=2")->count();
               if($nums>=10){
                   $this->ajaxReturn(array('status'=>1,'msg'=>'最多允许添加10个轮播广告'));
               }
               $data['ctime'] = time();
               M("advert")->add($data); 
            }
            $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
        }
        if($gid){
            $banner = M('advert')->find($gid);
            $this->assign('data',$banner);
        }
        $this->display();
    }
    
    public function homelist(){
        $goods = M('advert')->where('catid=3')->order('sortval desc,aid desc')->limit(0,10)->select();
        $this->assign('data',$goods);
        $this->display();
    }
    
    public function addlist(){
        $gid = I('aid');
        if(IS_POST){
            $data = array(
                'poster'=>I('poster'),'catid'=>3,
                'links'=>I('links'),'sortval'=>  intval(I('sortval'))
            );
            $datatype = I('datatype');
            if($datatype>1){
                $data['links'] = I('checkid');
                $data['subtitle'] = I('checkname');
            }
            $data['datatype'] = $datatype;
            if($gid){
               $data['etime'] = time();
               M("advert")->where('aid=%d',$gid)->save($data);
            }else{
               $nums = M("advert")->where("catid=3")->count();
               if($nums>=10){
                   $this->ajaxReturn(array('status'=>1,'msg'=>'最多允许添加10个底部广告'));
               }
               $data['ctime'] = time();
               M("advert")->add($data); 
            }
            $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
        }
        if($gid){
            $banner = M('advert')->find($gid);
            $this->assign('data',$banner);
            if($banner['datatype'] == 1){
                $this->assign('links',$banner['links']);
            }else{
                $this->assign('isedit',1);
            }
        }
        $this->display();
    }
    
    
    public function pagedata(){
        $stype = I('stype');
        $search = I('search');
        if(I("limit")){
            $limit = I("limit"); 
            $offset = I("offset");
            switch ($stype) {
                case 2://抢购商品
                    $model = M('shop_goods');
                    $field = 'gid as id,gname as title';
                    $order = 'gid desc';
                    $where = "1=1";
                    if($search){
                        $where .= " AND gname like '%$search%'";
                    }
                    break;
                case 3://夺宝商品
                    $model = M('shop_bonusgoods');
                    $field = 'gid as id,gname as title';
                    $order = 'gid desc';
                    $where = "ismain=0 AND price>sales";
                    if($search){
                        $where .= " AND gname like '%$search%'";
                    }
                    break;
                default:
                    break;
            }
            $count = $model->where($where)->count();
            $list = $model->field($field)->where($where)
                 ->order($order)->limit($offset,$limit)->select();
            $data['total'] = $count;
            $data['rows']  = $list;
            $this->ajaxReturn($data);
        }
        $this->assign('stype',$stype);
        $this->display();
    }
    
    /*
     * 首页图片
     */
    public function homeimage(){
       if(IS_POST){
           $picture1 = I('poster');
           $picture2 = I('poster1');
           M('setting')->where("dkey='home_goods'")->save(array('info'=>$picture1));
           M('setting')->where("dkey='home_bonus_goods'")->save(array('info'=>$picture2));
           $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
       }  else {
            $qiang = M('setting')->where("dkey='home_goods'")->find();
            $bonus = M('setting')->where("dkey='home_bonus_goods'")->find();
            $this->assign('goods',$qiang);
            $this->assign('bonus',$bonus); 
            $this->display();
       }
       
    }
    
	
}

      