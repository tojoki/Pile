<?php
namespace Admin\Model;
use Think\Model;
use Api\Common\HuanXinUtil;
use Think\Log;
class UserModel extends CommonModel{
    protected $pk   = 'uid';
    protected $tableName =  'user';
    protected $token = 'user';

    /**
     * 账户注册检测
     * @Author 刘晓雨     2016-03-03
     * @param  手机号  $phone     
     * @return boolean 
     */
    public function is_reg($phone){
        $count = $this->where("phone='%s'",array($phone))->count();
        return $count ? true : false;
    }

    public function login($phone,$password){
        $condition['phone'] = $phone;
        $userdata = $this->field(self::field)->where("phone='%s' AND password='%s'",array($phone,md5($password)))->find();
        if($userdata){
           $this->where($condition)->save(array("last_login_time"=>time())); 
        }
        return $userdata;
    }
    const field = "uid,phone,avator,nickname,sex,score,level,balance,ctime,ucode,chatpwd,utype,sign,authstatus";
    public function register($phone,$password){
        $chatpwd = create_code(8);
        $data = array(
            "phone"=>$phone,"password"=>md5($password),
            "nickname"=>$phone,'ucode'=>  gen_code(),
            "balance"=>0,'score'=>0,'avator'=>'/Uploads/avator.png',
            'sex'=>0,'last_login_time'=>time(),'ctime'=>time(),'sign'=>'',
            'utype'=>0,'chatpwd'=>$chatpwd,'status'=>0,
        );

        $userid = $this->data($data)->add();

        //注册环信用户        
        $HuanXin = new HuanXinUtil();
        $HuanXin->register($userid,$chatpwd);
        $condition['uid'] = $userid;
        $userdata = $this->field(self::field)->where($condition)->find();
        return $userdata;

    }
    public function backpwd($phone,$password){        
        $data = array(
            "password"=>md5($password),
            "etime"=>time(),
        );
        return $this->where("phone='%s'",array($phone))->save($data);
    }
    
    public function editpwd($userid,$oldpassword,$newpassword){
        $userdata = $this->where("uid=%d AND password='%s'",array($userid,  md5($oldpassword)))->find();
        //用户名不存在
        if(empty($userdata)){
           return 1;
        }
        $this->where("uid=%d AND password='%s'",array($userid,  md5($oldpassword)))
             ->save(array('password'=>  md5($newpassword),'etime'=>time()));
        return 0;
    }

    /**
     * 修改手机号
     * @Author 刘晓雨    2016-03-30
     * @param  [type] $oldPhone  [description]
     * @param  [type] $newPhone  [description]
     * @return [type]            [description]
     */
    public function editPhone($oldPhone,$newPhone){
        $condition['phone'] = $oldPhone;
        return $this->where($condition)->save(array("phone"=>$newPhone));
    }

    //获取用户信息
    public function getUserProfile($userid){
        return $this->where(array("userid"=>$userid))->find();
    }

    //用户积分变动
    public function userPoint($userid,$num,$act="in"){
        if($act == 'in'){
            return $this->where("userid = '{$userid}'")->setInc("point",$num);
        }else{
            return $this->where("userid = '{$userid}'")->setDec("point",$num);
        }
    }
    //用户资产变动
    public function userMoney($userid,$num,$act="in"){
        if($act == 'in'){
            return $this->where("userid = '{$userid}'")->setInc("money",$num);
        }else{
            return $this->where("userid = '{$userid}'")->setDec("money",$num);
        }
    }
    //用户经验变动
    public function userExp($userid,$num,$act="in"){
         if($act == 'in'){
            return $this->where("userid = '{$userid}'")->setInc("exp",$num);
        }else{
            return $this->where("userid = '{$userid}'")->setDec("exp",$num);
        }
    }
    //用户修改
    public function modify($userid,$data){
        $condition['userid'] = $userid;
        return $this->where($condition)->save($data);
    }
    
}
