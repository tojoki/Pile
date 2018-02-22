<?php
namespace Home\Controller;
use Think\Controller;
use Think\Log;
/**
 * 微信前台基类
 */
header("Content-type:text/html;charset=utf-8");

class BaseController extends Controller {
    
    protected $config;

    public function index(){ 

    }
    protected function check_require($keys){
        $keyarr = explode(",",$keys);
        $data = array();
          foreach($keyarr as $key){
            $value = I($key);
            if(empty($value)){
                exit($this->response('','缺少必填项:'.$key,9));
            }
            $data[$key] = $value;
    }
        return $data;
    }

    // protected function _initialize(){
    //     $user =  session('USER_PROFILES');
    //     if(empty($user)){
    //         header('location: /Home/Login/login');
    //     }
    // }
    //     $user_agent = $_SERVER['HTTP_USER_AGENT'];
    //     if (strpos($user_agent, 'MicroMessenger') === false) {
    //         $user = $this->get_session_user();
    //         if( !$user ) {
    //             //cookie自动登录
    //             $token = $_COOKIE['qc_cwbdyj'];
    //             if(!empty($token)) {
    //                 if($user_info = M('user')->where(array('token'=>$token))->find()) {
    //                     if($user_info['is_lock'] == 0) {
    //                         $token = getRandChar(20);
    //                         $pwd = $token.substr(md5($token.$user_info['password']),5,10);
    //                         setcookie("qc_cwbdyj",$pwd,NOW_TIME+86400*365,'/'); //30天
    //                         $data = array(
    //                             'last_login_time' => NOW_TIME,
    //                             'token' => $token
    //                         );
    //                         M('user')->where('userid='.$user_info['userid'])->save($data);
    //                         $user_info['is_cookie'] = 1;
    //                         session("USER_PROFILES",$user_info);
    //                         $this->user = $user_info;

    //                     }
    //                 } 
    //             }
    //         }
    //     } else {
    //         session('qc_qqInfo', null); //qq登录信息
    //         session('qc_wbInfo', null); //微博登录信息
    //         //微信浏览器登录直接走授权
    //         $this->config = M ( "wxconfig" )->where ( array (
    //                 "id" => "1" 
    //         ) )->find ();
    //         $this->config['wxInfo'] = session('qc_wxInfo');
    //         if($this->config['wxInfo'] == null || $this->config['wxInfo'] == '') {
    //             $code = $_GET['code'];
    //             if(empty($code)){
    //                 $this->Oauth();
    //                 exit;
    //             } else {
    //                 $token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->config ["appid"].'&secret='.$this->config ["appsecret"].'&code='.$code.'&grant_type=authorization_code';
    //                 $rt = $this->curlGet($token_url);
    //                 $jsonrt         = json_decode($rt, 1);
    //                 $data = array();
    //                 $data['openid'] = $jsonrt['openid'];
    //                 $data['access_token'] = $jsonrt['access_token'];
    //                 session('qc_wxInfo', $data);
    //                 $this->checkUser($data);
    //             }
    //         } else {
    //             $this->checkUser($this->config['wxInfo']);
    //         }
    //     }
    // }

    //检查用户
    protected function checkUser($data) {
        $user = $this->get_session_user();
        if( !$user ) {
            if($user = M('user')->where("wxid='".$data['openid']."'")->find()) {
                session("USER_PROFILES",$user);
            } else {
                session('qc_action',__SELF__);
                $this->redirect('/Home/Login/binding');
                exit;
            }
        }
    }

    protected function Oauth() {
        $url = $this->get_url();
        header('location:https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->config["appid"].'&redirect_uri='.$url.'&response_type=code&scope=snsapi_base&state=oauth#wechat_redirect');
    }

    private function get_url() {
        $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
        $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
        $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
        $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
        return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
    }


    // get远程
    protected function curlGet($url){
        $ch = curl_init();
        $header = "Accept-Charset: utf-8";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $temp = curl_exec($ch);
        return $temp;
    }

    private function addflow($data) {
        $data['ctime'] = time();
        $data['ymd'] = date('Ymd');
        $data['yy'] = date('Y');
        $data['mm'] = date('m');
        $data['dd'] = date('d');
        $data['ww'] = date('W');
        M('qc_flowlog')->add($data);
    }
    
    protected function setjsApi(){
        //分享参数
        $signPackage = $this->getSignPackage();
        $this->assign('signPackage',$signPackage);
    }

    protected function wxLogin(){
        if(session('USER_PROFILES')) return false;
        $code = I("get.code");
        $wechatAuth = $this->getWechatAuth();
        if($code){
            // Log::write($code,Log::INFO);

            try{
                $token = $wechatAuth -> getAccessToken("code",$code);
            }catch(\Exception $e){
                $redirect = "http://".$_SERVER['SERVER_NAME'].'/'.__INFO__;
                header("location:$redirect");
                exit;
            }

            // Log::write(var_export($token,true),Log::INFO);
            $userModel = M("user");
            $user = $userModel->field('nickname,leader_id,userid')->where( 'wxid = "%s"', $token['openid'] )->find();

            if((empty($user) || $user['nickname'] == NULL) && I('scope')  == ''){
                $redirect = "http://".$_SERVER['SERVER_NAME'].'/'.__INFO__.'?scope=snsapi_userinfo';
                $RequestCodeURL = $wechatAuth -> getRequestCodeURL($redirect,null,'snsapi_userinfo');
                header("location:$RequestCodeURL");
                exit;
            }
            if(!$user){ //未注册
                $wx_profiles = $wechatAuth -> getUserInfo($token['openid']);
                $data = array(
                    'nickname'=>$wx_profiles['nickname'],
                    'sex'=>$wx_profiles['sex'],
                    'headimg'=>$wx_profiles['headimgurl'],
                    'register_time'=>NOW_TIME,
                    'last_login_time'=>NOW_TIME,
                    'defaultcity'=>$wx_profiles['country'].$wx_profiles['province'].$wx_profiles['city'],
                    'wxid'=>$token['openid'],
                    );
                $userModel->add($data);
            }elseif($user['nickname'] == NULL){ //资料不全
                $wx_profiles = $wechatAuth -> getUserInfo($token['openid']);
                $data = array(
                    'nickname'=>$wx_profiles['nickname'],
                    'sex'=>$wx_profiles['sex'],
                    'headimg'=>$wx_profiles['headimgurl'],
                    'last_login_time'=>NOW_TIME,
                    'defaultcity'=>$wx_profiles['country'].$wx_profiles['province'].$wx_profiles['city'],
                    );
                $userModel->where( 'wxid = "%s"', $token['openid'] )->save($data);
            }else{//登录
                $userModel -> where( 'wxid = "%s"', $token['openid'] ) -> save(array('last_login_time'=>NOW_TIME));
            }

            $userdata = $userModel->where( 'wxid = "%s"', $token['openid'] )->find();  
            //更新上下级关系
            if(I('get.leaderid')){
                $newleadid = I('get.leaderid/d');       
                // dump($userdata);                     
                // dump($newleadid);   
                if($newleadid && empty($user['leader_id']) && $user['userid'] != $newleadid){
                    $userModel->where('wxid = "%s"', $token['openid'])->save(array('leader_id'=>$newleadid));
                    $userdata['leader_id'] = $newleadid;
                }
            }                

            session("USER_PROFILES",$userdata);

        }else{
            $redirect = "http://".$_SERVER['SERVER_NAME'].__SELF__;
            // if(!I('scope')){
            //     $RequestCodeURL = $wechatAuth -> getRequestCodeURL($redirect, null, 'snsapi_base');
            // }else{
            //     $RequestCodeURL = $wechatAuth -> getRequestCodeURL($redirect);
            // }
            // Log::write($RequestCodeURL,'RequestCodeURL');
            $RequestCodeURL = $wechatAuth -> getRequestCodeURL($redirect, null, 'snsapi_base');
            header("location:$RequestCodeURL");
            exit;
        }
    }

    /**
     * 用户二维码生成
     * @date   2016-06-07
     * @param  int     $userid 用户ID
     * @return string          用户二维码图片地址
     */
    protected function userQrcode($userid){
        $qrModel = M('qrcode');        
        $userQr = $qrModel->where('userid = %s',$userid)->find();

        if($userQr && is_file('.'.$userQr['img']) && $userQr['expire_in'] > NOW_TIME){
            $qrFile = $userQr['img'];
        }else{
            $qrDir = './Uploads/qrcode/'.date('Y-m-d').'/';
            is_dir($qrDir) || mkdir($qrDir);
            $qrFile = $qrDir.'userqr-'.$userid.'.jpg';
            $expire_seconds = 60*60*24*30;
            $wechatAuth = $this->getWechatAuth();
            $ret = $wechatAuth->qrcodeCreate($userid,$expire_seconds);
            //保存图片
            $content = file_get_contents($wechatAuth->showqrcode($ret['ticket']));
            file_put_contents($qrFile, $content);

            $qrFile = ltrim($qrFile,'.');
            $data = array(
                'ticket' => $ret['ticket'],
                'url' => $ret['url'],
                'expire_in' => time() + $expire_seconds,
                'img' => $qrFile,
            );
            
            if($userQr){
                $qrModel->where('userid = %s',$userid)->save($data);                
            }else{
                $data['userid'] = $userid;
                $qrModel->add($data);
            }
        }
       
        return $qrFile;
    }
    
    protected function get_session_user(){
        return session('USER_PROFILES');
    }
    protected function get_fresh_user(){
        $user =  session('USER_PROFILES');
        if(!empty($user)){
            return M('user')->where('uid='.$user['uid'])->find();
        }else{
            return false;
        }
    }    
    protected function format_money($money){
        return number_format($money,2,'.','');
    }
    /*
     * 调起微信支付
     * orderid 订单号
     * amount 金额(分)
     * back 支付完成跳转页面 exp: /meet/paysucc
     */
    protected function invoke_wxpay($params, $type = 'hx'){
        $user = $this->get_session_user();
        $u = M('user')->where('userid='.$user['userid'])->field('wxid')->find();
        $openid = $u['wxid'];
        $querystr = "openid=$openid&oid=".$params['orderid']."&amount=".$params['amount']."&back=".$params['back'];
        if($type == 'hx') {
            $baseUrl = 'http://'.$_SERVER['HTTP_HOST']."/pay/weixin/way/meetpay.php?".$querystr;
        } elseif($type == 'ymm') {
            $baseUrl = 'http://'.$_SERVER['HTTP_HOST']."/pay/weixin/way/ymmeetpay.php?".$querystr;
        } else {
            $baseUrl = 'http://'.$_SERVER['HTTP_HOST']."/pay/weixin/way/ymeetpay.php?".$querystr;
        }
        Header("Location: $baseUrl");
    }

    protected function invoke_pay($params){
        $user = $this->get_session_user();
        $openid = $user['wxid'];
        $querystr = "openid=$openid&oid=".$params['orderid']."&amount=".$params['amount']."&back=".$params['back'];
        $baseUrl = 'http://'.$_SERVER['HTTP_HOST']."/pay/weixin/way/yemeetpay.php?".$querystr;
        Header("Location: $baseUrl");
    }
    protected function invoke_alipay($params){
        $querystr = "oid=".$params['orderid']."&amount=".$params['amount']."&back=".$params['back'];
        $baseUrl = 'http://'.$_SERVER['HTTP_HOST'].__ROOT__."/pay/alipay/orderpay.php?".$querystr;
        Header("Location: $baseUrl");
    }
    protected function invoke_zhifubao($params){
        $querystr = "oid=".$params['orderid']."&amount=".$params['amount']."&back=".$params['back'];
        $baseUrl = 'http://'.$_SERVER['HTTP_HOST'].__ROOT__."/pay/alipay/orderpay2.php?".$querystr;
        Header("Location: $baseUrl");
    }
    /**
    * 获取jsapi参数
    * @date   2016-06-27
    */
    protected function getSignPackage() {
        $jsapiTicket = $this->getJsApiTicket();
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $timestamp = time();
        $nonceStr  = uniqid();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);
        $wxcfg = M('wxconfig')->find();
        $signPackage = array(
          "appId"     => $wxcfg['appid'],
          "nonceStr"  => $nonceStr,
          "timestamp" => $timestamp,
          "url"       => $url,
          "signature" => $signature,
          "rawString" => $string,
          "link" => getDomain().__ACTION__.'/leaderid/'.session('USER_PROFILES.userid'),
        );
        return $signPackage;
    }

    /**
     * 返回微信高级接口对象
     * @Author 刘晓雨    2016-05-31
     * @return Object  
     */
    function getWechatAuth(){
        $wxcfg = M('wxconfig')->find();
        empty($wxcfg) && exit('请在后台设置微信相关参数');
        if((NOW_TIME-200) > $wxcfg['expire'] || empty($wxcfg['access_token'])){
            $wechatAuth = new \Com\WechatAuth($wxcfg['appid'], $wxcfg['appsecret']);
            $result = $wechatAuth->getAccessToken();
            if(isset($result['errcode'])) err($result);
            $wxcfg['expires_in']   = $upd['expires_in']   = NOW_TIME + $result['expires_in'];
            $wxcfg['access_token'] = $upd['access_token'] = $result['access_token'];
            if(!M('wxconfig')->where('id=1')->save($upd))exit('更新微信配置缓存失败');
            unset($wechatAuth);
        }
        return new \Com\WechatAuth($wxcfg['appid'], $wxcfg['appsecret'], $wxcfg['access_token']);
    }


    function getJsApiTicket(){
        $ticket = '';
        $wxcfg = M('wxconfig')->find();
        empty($wxcfg) && exit('请在后台设置微信相关参数');
        if((NOW_TIME-200) > $wxcfg['JsApiTicket_expires_in'] || empty($wxcfg['JsApiTicket'])){
            $wechatAuth = $this->getWechatAuth();
            $result = json_decode($wechatAuth->getJsApiTicket(),true);
            if($result['errcode'] !== 0) err($result);
            $wxcfg['JsApiTicket_expires_in'] = $upd['JsApiTicket_expires_in']    = NOW_TIME + $result['expires_in'];
            $wxcfg['JsApiTicket']            = $upd['JsApiTicket']    = $ticket = $result['ticket'];
            if(!M('wxconfig')->where('id=1')->save($upd))exit('更新微信配置缓存失败');
            unset($wechatAuth);
        }else{
            $ticket = $wxcfg['JsApiTicket'];
        }

        return $ticket;
    }

}