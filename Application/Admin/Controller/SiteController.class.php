<?php

namespace Admin\Controller;
use Think\Controller;
class SiteController extends BaseController {
    
    public function _empty(){
        $this->assign("info","不存在操作方法:".ACTION_NAME);
        $this->display( 'Public:error' );
    }
    public function index(){
        if(IS_POST){
            $this->sitesave('site.php');
        }else{
            $this->display();
        }
    }
    public function setting(){
        if(IS_POST){
            $this->sitesave('route.php');
        }else{
            $this->display();
        }
    }
    private  function sitesave($filename){
	
        if($this->update_config($_POST,$filename)){

                $this->success('操作成功',U('site/'.ACTION_NAME));

        }else{

                $this->error('操作失败',U('site/'.ACTION_NAME));

        }
    }

    private function update_config($new_config,$filename) {
	$config_file=CONF_PATH.$filename;
        if (is_file($config_file)&&is_writable($config_file)) {

            $config = require $config_file;

            $config = array_merge($config, $new_config);

            file_put_contents($config_file, "<?php \nreturn " . stripslashes(var_export($config, true)) . ";", LOCK_EX);
            
            @unlink(RUNTIME_FILE);

            return true;

        } else {

            return false;

        }
	
    }
    
    /**
     * 版本管理
     */
    public function version(){
         $verModel = M('app_version');
         //分页
         $pageSize = C('PAGE_SIZE');
         $count = $verModel->count();
         $p = getpage($count,$pageSize);
         $show = $p->show();
         $list = $verModel->field("web_app_version.*,web_admin.username AS managername")->join("LEFT JOIN web_admin ON web_admin.id = web_app_version.managerid")->page(I('p'))->limit($pageSize)->order('code DESC')->select();
         $this->assign('page',$show);
         $this->assign('list',$list);
         $this->display();
    }
    /**
     * 版本添加
     */
    public function versionadd(){
        if(IS_AJAX){
            $verModel = M('app_version');
            $verModel->create();
            $verModel->dateline = NOW_TIME;
            $verModel->managerid = session('admin.id');
            if($verModel->add()){
                succ("添加成功");
            }else{
                err("添加失败");
            }
        }
        $this->display();
    }
    /**
     * 版本修改
     */
    public function versionedit(){
        if($error = admin_require_check('code')) $this->error($error);
        $verModel = M('app_version');
        $condi['code'] = I('code');
        if(IS_AJAX){
            $verModel->create();
            $verModel->dateline = NOW_TIME;
            $verModel->managerid = session('admin.id');
            if($verModel->where($condi)->save()){
                succ('修改成功');
            }else{
                err('修改失败');
            }
            exit;
        }
        $data = $verModel->where($condi)->find();
        $this->assign('data',$data);
        $this->display('versionadd');
    }

    /**
     * 版本删除
     */
    public function versiondel(){
        if($error = admin_require_check('code')) $this->error($error);
        $verModel = M('app_version');
        $condi['code'] = I('code');
        if($verModel->where($condi)->delete()){
            succ("删除成功");
        }else{
            err("删除失败");
        }
    }
    
}