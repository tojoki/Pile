<?php
namespace Admin\Controller;
use Api\Common\Constant;
use Common\Common\ExpressUtil;
class ShopController extends BaseController {
    
    public function index(){
        
    }
    
    /**
     * 商品分类
     */
    public function category(){
        $model = M("shopCategory");
        $list = $model -> where("parent_id = 0") -> order("`order` DESC") -> select();
        foreach($list as $k => $v){
            $list[$k]['child'] = $model->where("parent_id=".$v['cat_id'])->order("`order` DESC") -> select();
        }
        // dump($list);
        $this->assign("list", $list);
        $this->display();
    }
    
    /**
     * 商品分类添加
     */
    public function cate_add(){
        $model = M("shopCategory");
        if(IS_POST){
            if($error = admin_require_check('cat_name')) err($error);
            $data = array(
                'cat_name' => I('post.cat_name/s'),
                'parent_id' => I('post.parent_id/d'),
                'order' => I('post.order/d'),
                'dateline' => NOW_TIME,
                'admin_name' => session('admin.username'),
                );            
            if($model->add($data)){
                succ("添加成功");
            }else{
                err("添加失败");
            }
        }

        $baseclass = $model -> where("pid = 0") -> order("`sortorder` DESC") -> select();
        $this->assign("baseclass",$baseclass);
        $this->display();
    }
    /**
     * 商品分类编辑
     */
    public function cate_edit(){
        if($error = admin_require_check('cat_id')) $this->error($error);
        $cat_id   = I("cat_id/d");
        $model    = M("shopCategory");
        $map      = array("cat_id" => $cat_id);
        if(IS_AJAX){
            if($error = admin_require_check('cat_name')) err($error);
            $data = array(
                'cat_name' => I('post.cat_name/s'),
                'parent_id' => I('post.parent_id/d'),
                'order' => I('post.order/d'),
                'dateline' => NOW_TIME,
                'admin_name' => session('admin.username'),
                );   
            if($model ->where($map) -> save($data)){
                succ("编辑成功");
            }else{
                err("编辑失败");
            }
        }
        $cate = $model->where($map) ->find();
        $baseclass = $model -> where("parent_id = 0") -> order("`order` DESC") -> select();
        $this->assign("baseclass",$baseclass);
        $this->assign("data", $cate);
        $this->display('cate_add');
    }
    /**
     * 商品分类删除
     */
    public function cate_del(){
        if($error = admin_require_check('cat_id')) $this->error($error);
        $cat_id   = I("cat_id/d");
        if(M("shopCategory")->where('cat_id = %d',$cat_id) ->delete()){
            succ("删除成功");
        }else{
            err("删除失败");
        }
    }
    /*
     * 店铺列表
     */
    public function lists(){
        $count = M('shop')->count();
        $order = 'sid desc';
        $Page = new \Think\Page($count,10);
        $list = M('shop')->alias('a')
                ->order($order)->limit($Page->firstRow,$Page->listRows)->select();
        $this->assign('page', $Page->show()); 
        $this->assign('list', $list);
        $this->display();
    }
    
    public function addactivity(){
        $gid = I('aid');
        if(IS_POST){
            $data = array(
                'posters'=>I('pictures'),'sid'=>I('sid'),
                'title'=>I('title'),'starttime' =>  strtotime(I('starttime')),
                'endtime'=>  strtotime(I('endtime')),'address'=>  I('address'),
                'sortval'=>  intval(I('sortval'))
            );
            if($gid){
               $data['etime'] = time();
               M("shop_activity")->where('aid=%d',$gid)->save($data);
            }else{
               $data['ctime'] = time();
               M("shop_activity")->add($data); 
            }
            $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
        }
        if($gid){
            $goods = M('shop_activity')->find($gid);
            $goods['posters'] = $goods['posters']?explode(',', $goods['posters']):array();
            $this->assign('data',$goods);
        }
        $shops = M('compare_shops')->field('sid,sname')->limit(0,100)->select();
        $this->assign('shops',$shops);
        $this->display();
    }
    
    public function delactivity() {
        M('shop_activity')->where(array('aid' => I('aid')))->delete();
        //删除关联数据
        $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
    }
    
    
    public function addshops(){
        $gid = I('sid');
        if(IS_POST){
            $data = array(
                'poster'=>I('poster'),'memo'=>I('memo'),
                'sname'=>I('sname'),'linkman' =>I('linkman'),
                'linkphone'=>I('linkphone'),'address'=>  I('address'),
                'introduce'=>I('introduce'),'stype'=>I('stype'),
            );
            if($gid){
               $data['etime'] = time();
               M("shop")->where('sid=%d',$gid)->save($data);
            }else{
               $data['ctime'] = time();
               M("shop")->add($data); 
            }
            $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
        }
        if($gid){
            $goods = M('shop')->find($gid);
            $this->assign('data',$goods);
        }
        $this->assign('shoptype',  Constant::$shoptype);
        $this->display();
    }
    
    public function delshop() {
        M('shop')->where(array('sid' => I('sid')))->delete();
        //删除关联数据
        $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
    }
    
    
    /*
     * 促销商品列表
     */
    public function goods(){
        $title = I('title');
        $where = '1=1';
        if($title){
            $where .= " AND gname like '%$title%'";
        }
        $count = M('shop_goods')->where($where)->count();
        $order = 'gid desc';
        $Page = new \Think\Page($count,10);
        $list = M('shop_goods')->alias('g')
                ->where($where)
                ->order($order)->limit($Page->firstRow,$Page->listRows)->select();
        $this->assign('page', $Page->show()); 
        $this->assign('list', $list);
        $this->display();
    }
    public function addgoods(){
        $gid = I('gid');
        if(IS_POST){
            $data = array(
                'sid'=>I('sid'),'gname'=>I('gname'),'poster'=>I('poster'),
                'pictures'=>I('posters'),'sid'=>I('sid'),'stock'=>I('stock'),
                'subtitle'=>I('subtitle'),'mprice'=>I('mprice'),'price'=>I('price'),
                'endtime'=>  strtotime(I('endtime')),'address'=>  I('address'),
                'issale'=>I('issale'),'detail'=>I('detail')
            );
            if($gid){
               $data['etime'] = time();
               M("shop_goods")->where('gid=%d',$gid)->save($data);
            }else{
               $data['ctime'] = time();
               M("shop_goods")->add($data); 
            }
            $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
        }
        if($gid){
            $goods = M('shop_goods')->find($gid);
            $goods['posters'] = $goods['pictures']?explode(',', $goods['pictures']):array();
            $this->assign('data',$goods);
        }
        $shops = M('shop')->field('sid,sname')->limit(0,100)->select();
        $this->assign('shops',$shops);
        $this->display();
    }
    
    public function goodsstatus() {
        M('shop_goods')->where(array('gid' => I('gid')))
                ->save(array('issale'=>  intval(I('status')),'etime'=>time()));
        $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
    }
    
    public function delgoods() {
        M('shop_goods')->where(array('gid' => I('gid')))->delete();
        //删除关联数据
        $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
    }
    
    
    /*
     * 夺宝商品列表
     */
    public function bonusgoods(){
        $title = I('title');
        $where = 'ismain=1';
        if($title){
            $where .= " AND gname like '%$title%'";
        }
        $count = M('shop_bonusgoods')->where($where)->count();
        $order = 'gid desc';
        $Page = new \Think\Page($count,10);
        $list = M('shop_bonusgoods')->alias('g')
                ->where($where)
                ->order($order)->limit($Page->firstRow,$Page->listRows)->select();
        $this->assign('page', $Page->show()); 
        $this->assign('list', $list);
        $this->display();
    }
    
    public function addbonusgoods(){
        $gid = I('gid');
        $title = '添加商品';
        if(IS_POST){
            $data = array(
                'gname'=>I('gname'),'poster'=>I('poster'),
                'pictures'=>I('posters'),'items'=>I('items'),
                'price'=>I('price'),'isbonus'=>0,'ismain'=>1,
                'issale'=>I('issale'),'detail'=>I('detail')
            );
            M()->startTrans();
            if($gid){
               $data['etime'] = time();
               $result = M("shop_bonusgoods")->where('gid=%d',$gid)->save($data);
            }else{
               $data['ctime'] = time();
               $data['seq'] = 0;
               $data['currissue'] = 1;
               //添加主记录
               $gid = M("shop_bonusgoods")->add($data); 
               $saledata = $data;
               $saledata['seq'] = 1;
               $saledata['ismain'] = 0;
               $saledata['mainid'] = $gid;
               //开期 第一期
               $salegid =  M("shop_bonusgoods")->add($saledata); 
               $codedata = gen_bonus_goods_code($saledata['price'],  Constant::base_bonus_code); 
               //第一期 号码信息
               $codeinfo = M('shop_goods_code')->add(array(
                  'gid'=>$salegid,'codelist' => json_encode($codedata),
               ));
               $result = $gid && $salegid && $codeinfo;
            }
            if($result){
                M()->commit();
                $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
            }else{
                M()->rollback();
                $this->ajaxReturn(array('status'=>1,'msg'=>'操作失败'));
            }
        }
        if($gid){
            $goods = M('shop_bonusgoods')->find($gid);
            $goods['posters'] = $goods['pictures']?explode(',', $goods['pictures']):array();
            $this->assign('data',$goods);
            $title = '修改商品';
        }
        $this->assign('title',$title);
        $this->display();
    }
    
    /*
     * 
     */
    public function bgoodsstatus(){
        $status = intval(I('status'));
        M('shop_bonusgoods')->where(array('gid' => I('gid')))
                ->save(array('issale'=> $status,'etime'=>time()));
        if($status === 1){
            //判断是否需要开新期
        }
        $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
    }
    
    /*
     * 订单列表
     */
    public function orders(){
        $where = 'o.status>0';
        $orderid = I('orderid');
        if($orderid){
            $where .= " AND o.orderid like '%$orderid%'";
        }
        $nickname = I('nickname');
        if($nickname){
            $where .= " AND u.nickname like '%$nickname%'";
        }
        $type = intval(I('type'));
        if($type){
            $where .= " AND o.ordertype like '%$type%'";
        }
        $status = intval(I('status'));
        switch ($status) {
            case 1://待发货
                $where .= " AND ((o.status =1 AND o.ordertype=1) or ( o.status =1 AND o.ordertype=2 AND o.isbonus=1 AND o.isfilladdress=1))";
                break;
            case 2://待收货
                $where .= " AND o.status =2";
                break;
            case 3://已收货
                $where .= " AND o.status =3";
                break;
            default:
                break;
        }
        $count = M('shop_order')->alias('o')
                ->join('left join __USER__ u ON u.uid=o.uid')
                ->where($where)->count();
        $order = 'o.ctime desc';
        $Page = new \Think\Page($count,10);
        $list = M('shop_order')->alias('o')
                ->join('left join __USER__ u ON u.uid=o.uid')
                ->field('o.*,u.nickname')
                ->where($where)
                ->order($order)->limit($Page->firstRow,$Page->listRows)->select();
        $this->assign('page', $Page->show()); 
        $this->assign('list', $list);
        $this->display();
    }
    
    public function orderProcess(){
        if($error = admin_require_check('orderid')) $this->error($error);
        $orderModel = M('shop_order');
        $condi['orderid'] = I('orderid');

        if(IS_POST){
            $express_no = I('express_no');
            $company = I('company');
            $rs = M('shop_order')->where(array('orderid'=>I('orderid')))
                    ->save(array(
                        'status'=>2,'handletime'=>time(),'mname'=>$this->get_username(),
                        'expressno'=>$express_no,'expressway'=>$company
                    ));
            if($rs){
                $this->success("操作成功");
            }else{
                $this->error("操作失败");
            }
            exit();
        }
        $data = $orderModel->alias('od')
        ->field("od.*,u.nickname,u.phone")
        ->join('LEFT JOIN __USER__ u ON u.uid = od.uid')
        ->where($condi)->find();
        $this->assign('expway',  ExpressUtil::$send_way);
        if($data['status']>0){
            $data['expressway'] = ExpressUtil::$send_way[$data['expressway']]['name'];
        }
        $this->assign("data",$data);
        $this->display("process");
    }
}