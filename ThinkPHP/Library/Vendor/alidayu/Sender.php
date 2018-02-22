<?php
    include "TopSdk.php";
    date_default_timezone_set('Asia/Shanghai'); 
    class Sender{
        const appkey = '23423886';
        const secretKey = '90ea8ae4993b6d3c70336f0997459b8a';
        static $template = array(
          'reg'=>'SMS_12841385',//验证码${code}，您正在注册成为${product}用户，感谢您的支持！
          'backpwd'=>'SMS_12841382',//验证码${code}，您正在尝试变更${product}重要信息，请妥善保管账户信息。
          'editphone'=>'SMS_12841382',
        );
        function send($mobile,$template,$data){
            $c = new TopClient;
            $c->appkey = self::appkey;
            $c->secretKey = self::secretKey;

            $req = new AlibabaAliqinFcSmsNumSendRequest;
            $req->setExtend($mobile);
            $req->setSmsType("normal");
            $req->setSmsFreeSignName("易达");
            $req->setSmsParam(json_encode($data));
            $req->setRecNum($mobile);
            $req->setSmsTemplateCode(self::$template[$template]);
            $resp = $c->execute($req);
            return $resp;
        }
    }
?>