<?php
namespace Admin\Model;
use Think\Log;
use Api\Common\MsgSendUtil;
use Api\Common\Constant;
class VcodeModel extends CommonModel{
    protected $pk   = 'vid';
    protected $tableName =  'validcode';
    protected $token = 'vcode';

    public function send($phone,$vcode,$type){
        $count = $this->where("mobile='%s' AND ctime>".(time()-12*60*60),array($phone))->count();
        if($count>20){
            return 1;
        }
        $time = time();
        $data = array(
            'mobile'=>$phone,'vtype'=>$type,'code'=>$vcode,
            'ctime'=>$time,'deadtime'=>$time+60 * 5,
        );
        //$template = MsgSendUtil::msg_template_reg;
        switch ($type) {
            // case Constant::short_msg_register://注册
            case 1://注册
                break;
            // case Constant::short_msg_backpwd://找回密码
            case 2://找回密码
                //$template = MsgSendUtil::msg_template_backpwd;
                break;    
            // case Constant::short_msg_bindold:
            case 3:
                //$template = MsgSendUtil::msg_template_editphone;
                break;
            // case Constant::short_msg_bindnew:
            case 4:
                //$template = MsgSendUtil::msg_template_editphone;
                break;
            default:
                break;
        }
        $result = $this->add($data);
//
        Vendor('jsms.JSMS');
        $client=new \JSMS(Constant::user_app_key,Constant::user_master_secret);
        $response = $client->sendMessage($phone, 40470, array('code'=>$vcode));
//
        // $status = MsgSendUtil::send($phone,$vcode);
        // $status = 0;//MsgSendUtil::send($phone,$vcode);
        if($result && $response['http_code'] == 200){
            return 0;
        }
        return 2;
    }

    public function login($phone,$password){
        $condition['phone'] = $phone;
        $userdata = $this->field(self::field)->where("phone='%s' AND password='%s'",array($phone,md5($password)))->find();
        if($userdata){
           $this->where($condition)->save(array("last_login_time"=>time())); 
        }
        return $userdata;
    }
    const field = "uid,phone,avator,nickname,sex,score,balance,ctime,ucode,chatpwd,utype";
    public function register($phone,$password){
        $chatpwd = create_code(8);
        $data = array(
            "phone"=>$phone,"password"=>md5($password),
            "nickname"=>$phone,'ucode'=>  gen_code(),
            "balance"=>0,'score'=>0,'avator'=>'/Uploads/touxiang_default.gif',
            'sex'=>0,'last_login_time'=>time(),
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
}
