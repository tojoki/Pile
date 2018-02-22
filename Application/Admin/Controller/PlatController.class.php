<?php
namespace Admin\Controller;
use Api\Common\Constant;
use Common\Common\ExpressUtil;
class PlatController extends BaseController {
    
    public function index(){
        
    }
    
    /**
     * 商品分类
     */
    public function category(){
        $model = M("category");
        $list = $model -> where("pid = 0") ->  select();
        foreach($list as $k => $v){
            $list[$k]['child'] = $model->where("pid=".$v['catid'])-> select();
        }
        $this->assign("list", $list);
        $this->display();
    }
    
    /**
     * 商品分类添加
     */
    public function cate_add(){
        $model = M("category");
        if(IS_POST){
            if($error = admin_require_check('cat_name')) err($error);
            $data = array(
                'catname' => I('post.cat_name/s'),
                'pid' => I('post.parent_id/d'),
                'sortorder' => I('post.order/d'),
                'type' => I('post.type/d'),
                'ctime' => NOW_TIME,
                'admin_name' => session('admin.username'),
                );           
            //如果是二级分类 那么把类型改成和父级一样 再把父级的价格改成0
            if($data['pid']!=0){
                $data['type']=$model->where('catid='.$data['pid'])->getField('type');
                $model->where('catid='.$data['pid'])->save(array('sortorder'=>0));
            }
            if($model->add($data)){
                succ("添加成功");
            }else{
                err("添加失败");
            }
        }

        $baseclass = $model -> where("pid = 0") ->  select();
        $this->assign("baseclass",$baseclass);
        $this->display();
    }
    /**
     * 商品分类编辑
     */
    public function cate_edit(){
        if($error = admin_require_check('cat_id')) $this->error($error);
        $cat_id   = I("cat_id/d");
        $model    = M("category");
        $map      = array("catid" => $cat_id);
        if(IS_AJAX){
            if($error = admin_require_check('cat_name')) err($error);
            $data = array(
                'catname' => I('post.cat_name/s'),
                'pid' => I('post.parent_id/d'),
                'sortorder' => I('post.order/d'),
                'type' => I('post.type/d'),
                'etime' => NOW_TIME,
                'admin_name' => session('admin.username'),
                );  
            //如果是二级分类 那么把类型改成和父级一样 再把父级的价格改成0 
            if($data['pid']!=0){
                $data['type']=$model->where('catid='.$data['pid'])->getField('type');
                $model->where('catid='.$data['pid'])->save(array('sortorder'=>0));
            }else{
                //如果该一级分类下有二级分类 那么把所有二级分类改成和这个一样 且自身的价格不可改 就是0
                $test=$model->where('pid='.$cat_id)->select();
                if($test){
                    $model->where('pid='.$cat_id)->save(array('type'=>$data['type']));
                    $data['sortorder']=0;
                }
            }
            if($model ->where($map) -> save($data)){
                succ("编辑成功");
            }else{
                err("编辑失败");
            }
        }
        $cate = $model->where($map) ->find();
        $baseclass = $model -> where("pid = 0") ->  select();
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
        if(M("category")->where('catid = %d',$cat_id) ->delete()){
            //如果有二级 也删掉
            $test=M('category')->where('pid='.$cat_id)->select();
            if($test){
                M('category')->where('pid='.$cat_id)->delete();
            }
            succ("删除成功");
        }else{
            err("删除失败");
        }
    }
    
    public function price(){
        if(IS_POST){
            $data = array(
                'voice_platform_fee1'=>I('voice_platform_fee1'),
                'voice_platform_fee2'=>I('voice_platform_fee2'),
                'voice_platform_fee3'=>I('voice_platform_fee3'),
                'voice_time_fee1'=>I('voice_time_fee1'),
                'voice_time_fee2'=>I('voice_time_fee2'),
                'voice_time_fee3'=>I('voice_time_fee3'),
                'net_platform_fee1'=>I('net_platform_fee1'),
                'net_platform_fee2'=>I('net_platform_fee2'),
                'net_platform_fee3'=>I('net_platform_fee3'),
                'net_time_fee1'=>I('net_time_fee1'),
                'net_time_fee2'=>I('net_time_fee2'),
                'net_time_fee3'=>I('net_time_fee3'),
                'lawyer_date_fee'=>I('lawyer_date_fee')
            );
            M('config')->where("name = 'fee'")->save(array(
                'value'=>json_encode($data)
            ));
            $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
        }
        $prices = M('config')->where("name = 'fee'")->find();
        if(empty($prices)){
            $prices = array();
        }else{
            $prices = json_decode($prices['value'],true);
        }
        //print_r($prices);
        $this->assign('data',$prices);
        $this->display();
    }
}