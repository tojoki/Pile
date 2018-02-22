<?php
namespace Common\Common;
/**
 * @author bird
 */
class ExpressUtil {
    
    const key = 'XDB2staxxpqvsssNBANo0I_3345311513';
    public static $send_way = array(
      array('code'=>'shentong','name'=>'申通快递','phone'=>'95543'),
      array('code'=>'zhongtong','name'=>'中通快递','phone'=>'95311'),
      array('code'=>'yuantong','name'=>'圆通快递','phone'=>'95554'),
      array('code'=>'huitong','name'=>'汇通快递','phone'=>'400-956-5656'),
      array('code'=>'yunda','name'=>'韵达快递','phone'=>'95546'),
      array('code'=>'shunfeng','name'=>'顺丰快递','phone'=>'95338'),
      array('code'=>'ems','name'=>'EMS','phone'=>'95338'),
    );
    
    public static function query($way,$orderid){
        $code = self::$send_way[$way]['code'];
        $url = "http://q.kdpt.net/api?id=".self::key."&com=$code&nu=$orderid&show=json";
        $ch = curl_init();
        $header = "Accept-Charset: utf-8";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $temp = curl_exec($ch);
        return json_decode($temp,1);
    }
}
