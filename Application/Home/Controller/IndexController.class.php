<?php
namespace Home\Controller;
use Think\Controller;
use Api\Common\Constant;
class IndexController extends BaseController{
    /*
     * 响应
     * $data 数据
     * $status 状态码
     * $msg  信息
     */
    protected function response($data=NULL,$msg='success',$status=0){
      $this->ajaxReturn(array('status'=>$status,'time'=>time(),'msg'=>$msg,'data'=>$data));
    }
    
    protected function succ_back($msg=''){
        $this->response(NULL,$msg);
    }

    protected function error_back($msg='',$status=1){
        $this->response(NULL, $msg, $status);
    }

    public function index(){
      if($_GET['type'] && $_GET['type']!=''){
        $where['type']=$_GET['type'];
      }
      $list=M('disc')->where($where)->order('rtime desc')->select();
      $count = count($list);
      $Page = new \Think\Page($count,12);
      $Page -> setConfig('header', '<span class="page">共 %TOTAL_ROW% 件</span>');
      $Page -> setConfig('prev', '<span class="prev">前の12件</span>');
      $Page -> setConfig('next', '<span class="next">后の12件</span>');
      $Page -> setConfig('last', '<span class="next">末</span>');
      $Page -> setConfig('first', '<span class="prev">首</span>');
      $Page -> setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
      $list = array_slice($list,$Page->firstRow,$Page->listRows);
      $show = $Page->show();
      $this->assign('list',$list);
      $this->assign('page',$show);
      $this->display();
    }

    public function info(){
      $id=I('get.id');
      $info=M('disc')->where('id='.$id)->find();
      $lists=M('tunes')->where('disc_id='.$id)->select();
      $cdList=$dvdList=$bdList=array();
      foreach($lists as $v){
        if($v['type']==1){
          $cdList[]=$v;
        }
        if($v['type']==2){
          $dvdList[]=$v;
        }
        if($v['type']==3){
          $bdList[]=$v;
        }
      }
      
      $this->assign('cdList',$cdList);
      $this->assign('dvdList',$dvdList);
      $this->assign('bdList',$bdList);
      $this->assign('info',$info);
      $this->display();
    }
    
}
