<?php
namespace Admin\Controller;
header('Content-type:text/html;charset=utf-8');
class PushController extends BaseController {
    public function index() {

    }
    
    public function lists(){
        $size = 10;
        $where = "1=1";
        $title = I('title');
        if($title){
            $where .= " AND txt like '%$title%'";
        }
        $catid = intval(I('type'));
        if($catid){
            $where .= " AND catid = $catid";
        }
        $logModel = M('pushlist');
        $order = "pushid desc";
        $count = $logModel->where($where)->count();
        $Page = new \Think\Page($count,$size);
        $list = $logModel
            ->where($where)->limit($Page->firstRow,$Page->listRows)->order($order)->select();
        $this->assign('list',$list);
        $this->assign('page',$Page->show());
        $this->display();
    }
    
    public function addpush(){
        if(IS_POST){
            $data = array(
                'catid'=>  intval(I('catid')),
                'txt'=>I('content'),
                'dataid'=>  I('checkid'),
                'dataname'=>I('checkname'),
                'ctime'=>time(),
            );
            switch ($data['catid']) {
                case 1:
                    $tags = 'msgcity';
                    break;
                case 2:
                    $tags = 'msgbonus';
                    break;
                case 3:
                    $tags = 'msgactivity';
                    break;
                case 4:
                    $tags = 'msgbuy';
                    break;
                default:
                    break;
            }
            M("pushlist")->add($data); 
            $this->pushinfo($data['txt'], $tags, $data['catid'], $data['dataid']);
            $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
        }
        $this->display();
    }
    
    public function delpush(){
        $pushid = intval(I('pushid'));
        M('pushlist')->where('pushid=%d',$pushid)->delete();
        $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
    }


    public function pagedata(){
        $stype = I('stype');
        $search = I('search');
        if(I("limit")){
            $limit = I("limit"); 
            $offset = I("offset");
            switch ($stype) {
                case 1://城市信息
                    $model = M('news');
                    $field = 'nid as id,title';
                    $order = 'nid desc';
                    $where = "1=1";
                    if($search){
                        $where .= " AND title like '%$search%'";
                    }
                    break;
                case 4://抢购商品
                    $model = M('shop_goods');
                    $field = 'gid as id,gname as title';
                    $order = 'gid desc';
                    $where = "1=1";
                    if($search){
                        $where .= " AND gname like '%$search%'";
                    }
                    break;
                case 2://夺宝商品
                    $model = M('shop_bonusgoods');
                    $field = 'gid as id,gname as title';
                    $order = 'gid desc';
                    $where = "ismain=0 AND price>sales";
                    if($search){
                        $where .= " AND gname like '%$search%'";
                    }
                    break;
                case 3://活动
                    $model = M('billboard');
                    $field = 'bid as id,title';
                    $order = 'bid desc';
                    $nowtime = time();
                    $where = "isdel=0 AND starttime<$nowtime AND endtime>$nowtime";
                    if($search){
                        $where .= " AND title like '%$search%'";
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
}
