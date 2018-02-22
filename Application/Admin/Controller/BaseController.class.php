<?php
namespace Admin\Controller;
use Think\Controller;
use Api\Common\Constant;
class BaseController extends Controller {
    protected $_admin = array();
    protected function _initialize(){
        $this->_admin = session('admin');
      
        if (strtolower(CONTROLLER_NAME) != 'login' && strtolower(CONTROLLER_NAME) != 'public') { 
            if (empty($this->_admin)) {
                header("Location: " . U('login/index'));
                die;
            }
            $this->assign('admin',$this->_admin);
            
            $nownav['m']=strtolower(CONTROLLER_NAME );
            $nownav['a']=strtolower(ACTION_NAME);
                
           
            $this->assign('nownav',$nownav);
            
            //权限处理
            if ($this->_admin['role'] != 0) {
                
                $this->_admin['menu_list'] = D('Access')->getMenuIdsByRoleId($this->_admin['role']);	
                
                $menu_action = strtolower(CONTROLLER_NAME . '/' . ACTION_NAME);
                $menu = D('Treenode')->fetchAll();
                $menu_id = 0;
				
				foreach($this->_admin['menu_list'] as $val)
				{

					
					foreach ($menu as $k => $v) {
						if($v['id']==$val['node_id'])
						{
							if (($v['m'].'/'.$v['a']) == $menu_action) {

								$menu_id = (int) $k;
								
								break;
							}
						}
					
						
					}
                }
					
				
				
                
                if (empty($menu_id)||$menu_id==0) {
                	
                    $this->error('很抱歉您没有权限操作模块:' . $menu[$menu_id]['title']);
                }
            }
            $this->loadMenu();
        }

    }
  
    private  function  loadMenu(){
       
       foreach ($this->_admin['menu_list'] as  $v) {
       	$node_id[]=$v['node_id'];
       }
        //超级管理员
        if($this->_admin['role'] == 0){
            $menu=D('Treenode')->where(array("menuflag"=>1,"is_hide"=>0))->order("sort DESC")->select();
            $this->assign('menu',$menu);
        }else{

            $menu=D('Treenode')->where(array("id"=>array('IN',$node_id),"menuflag"=>1))->select();
            $this->assign('menu',$menu);

        }
    }
    
    protected function checkFields($data = array(), $fields = array()) {
        foreach ($data as $k => $val) {
            if (!in_array($k, $fields)) {
                unset($data[$k]);
            }
        }
        return $data;
    }
    
    protected function get_username(){
        return $_SESSION['admin']['user'];
    }
    
    /*
     * 操作日志
     */
    protected function operator_log($type,$memo){
        M('manage_log')->add(array(
            'uname'=>$this->get_username(),'category'=>$type,
            'memo'=>$memo,'ctime'=>time(),
        ));
    }
    
    /*
     * 积分操作
     */
    public function score_operator($uid,$amount,$type,$memo,$orderid){
        $time = time();
        $user = M('user')->where("uid=%d",array($uid))->field('score,level')->find();
        $level = level_by_score($user['score']+$amount);
        $sql = "update web_user set etime=$time,score=score+$amount,level=$level where uid=$uid";
        if($type == Constant::account_out){
            if($user['score'] <$amount){
                M()->rollback();
                exit($this->error_back('积分不足'));
            }
            $sql = "update web_user set etime=$time,score=score-$amount where uid=$uid";
        }
        
        $r1 = M()->execute($sql);
        $r2 = M('user_score_log')->add(array(
            'uid'=>$uid,'score'=>$amount,'balance'=>$user['score'],
            'optype'=>  $type,'ctime'=>$time,'opinfo'=>$memo,
            'orderid'=>$orderid
        ));
        return $r1 && $r2;
    }
    
    /*
     * 发送消息
     */
    protected function sendmsg($uid,$msg,$type,$dataid=''){
        $data = array(
            'uid'=>$uid,'mtype'=>$type,
            'txt'=>$msg,'state'=>0,'ctime'=>time(),
            'dataid'=>$dataid,
        );
        M('user_msg')->add($data);
    }
    
    protected function pushinfo($content,$uid,$type,$extdata){
        $receive = 'all';
        if($uid){
           $receive = array('tag'=>array($uid)); 
        }
        vendor('JPush.Jpush',NULL,'.class.php');
        $jpush = new \Jpush();
        $result = $jpush->send_pub($receive,$content,$type,$extdata);
    }
   
}