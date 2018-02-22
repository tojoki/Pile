<?php
/**
 * JSON 返回失败数据
 */
function err($msg = ""){
    return_json($msg, "FAIL");
}
/**
 * JSON 返回成功数据
 * @param  string $param1    提示信息
 * @param  string $param2    返回数据
 */
function succ($param1 = "", $param2 = ""){
	if(is_array($param1)){
		return_json("", "SUCCESS", $param1);
	}else{
		return_json($param1, "SUCCESS", $param2);
	}
}
/**
 * JSON 返回数据
 * @param  string $msg       提示信息
 * @param  string $code      状态码
 * @param  array $result     返回数据
 */
function return_json($msg = '', $code = "SUCCESS", $result = ""){
	if(empty($msg)) $msg = $code == "SUCCESS" ? "返回成功" : "返回失败";
    $response = array(
                        "returnMsg"   => $msg,
                        "returnCode"  => $code, 
                        );
    $result && $response["result"] = $result;
    // echo "<pre>";
    // print_r($response);
    // echo "</pre>";
    echo json_encode($response);
    exit();
}
/**
 * 生成MD5密码
 * @Author 刘晓雨    2016-03-03
 * @param  string $password  密码
 * @param  string $salt      混淆字符串
 * @return array or string
 */
function md5password($password, $salt=''){
	if($salt == ''){
		$salt = strtoupper(substr(md5(create_code(4)),0,8));
		$password = md5(md5($password).$salt);
		return array($password,$salt);
	}else{
		return md5(md5($password).$salt);
	}
}

/**
 * 生成验证码
 * @Author 刘晓雨     2016-03-02
 * @param  integer $length    验证码长度
 * @return String             验证码
 */
function create_code($length = 6){
	$code = '';
	for($i = 0; $i < $length; $i++){
		$code .= mt_rand(0,9);
	}
	return $code;
}

/**
 * 必填项检测
 * @Author 刘晓雨    2016-03-03
 * @param  String $keys      "key,name,code"
 * @return Array             
 */
function require_check($keys){
	$request = array();
	$keys = explode(",",$keys);
	foreach($keys as $key){
		$value = I($key);
		if(stripos($key,"/")) $key = substr($key,0,stripos($key,"/"));
		if(empty($value)){
			err("缺少必填项:".$key);
		}else{
			$request[$key] = $value;
		}
	}
	return $request;
}

/**
 * 必填项检测
 * @Author 刘晓雨    2016-03-03
 * @param  String $keys      "key,name,code"
 * @return Array             
 */
function admin_require_check($keys){
	$request = array();
	$keys = explode(",",$keys);
	foreach($keys as $key){
		$value = I($key);
		if(stripos($key,"/")) $key = substr($key,0,stripos($key,"/"));
		if(empty($value)){
			return $key."不能为空";
		}
	}
	return false;
}

/**
 * 生成订单号
 * @Author 刘晓雨    2016-04-13
 * @return [type] [description]
 */
function build_order_no(){
    return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}

/**
 * 关键词过滤
 * @Author 刘晓雨    2016-04-12
 * @param  str $text      原字符串
 * @param  str $rpStr     替换后的字符
 */
function wordFilter($text,$rpStr="*"){
    $l1 = explode("\r\n",file_get_contents("./Public/wordFilter/baidu_guolv.txt",true));
    $l2 = explode("\r\n",file_get_contents("./Public/wordFilter/baidu_mingan.txt",true));
    $arr = array_merge($l1,$l2);
    foreach($arr as $v){
        $v = trim($v);
        if($v == '') continue;
        $replace = '';
        $length = abslength($v);
        for($i=0;$i<$length;$i++){
            $replace .= $rpStr;
        }

        $text = str_replace($v,$replace,$text);
    }
    return $text;
}

/**
* 统计中文字符串长度
* @param $str 要计算长度的字符串
*/
function abslength($str)
{
    if(empty($str)){
        return 0;
    }
    if(function_exists('mb_strlen')){
        return mb_strlen($str,'utf-8');
    }
    else {
        preg_match_all("/./u", $str, $ar);
        return count($ar[0]);
    }
}
/**
 * 判断点是否多边形内部
 * @param  array  $polygon   多边形经纬数组
 * @param  array  $lnglat    点经纬度数组
 * @return boolean            
 * $polygon = array(
        array(
            "lat" => 31.027666666667,
            "lng" => 121.42277777778
        ),
        array(
            "lat" => 31.016361111111,
            "lng" => 121.42797222222
        ),
        array(
            "lat" => 31.023666666667,
            "lng" => 121.45088888889
        ),
        array(
            "lat" => 31.035027777778,
            "lng" => 121.44575
        )
    );
    $lnglat = array(
        "lat" => 31.037666666667,
        "lng" => 121.43277777778
    );
 */
function isPointInPolygon($polygon,$lnglat){
    $count = count($polygon);
    $px = $lnglat['lat']; //纬度
    $py = $lnglat['lng']; //经度

    $flag = FALSE;

    for ($i = 0, $j = $count - 1; $i < $count; $j = $i, $i++) { 
        $sy = $polygon[$i]['lng'];
        $sx = $polygon[$i]['lat'];
        $ty = $polygon[$j]['lng'];
        $tx = $polygon[$j]['lat'];

        if ($px == $sx && $py == $sy || $px == $tx && $py == $ty)
            return TRUE;

        if ($sy < $py && $ty >= $py || $sy >= $py && $ty < $py) {
            $x = $sx + ($py - $sy) * ($tx - $sx) / ($ty - $sy);
            if ($x == $px)
                return TRUE;
            if ($x > $px)
                $flag = !$flag;
        }
    }
    return $flag;
}

function getpage($count, $pagesize = 8, $urlParam = '') {
	$p = new Think\Page($count, $pagesize);
	if($urlParam){
		foreach($urlParam as $key=>$val) {
			$p->parameter[$key]   =   $val;
		}
	}
	$p -> setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
	$p -> setConfig('prev', '上一页');
	$p -> setConfig('next', '下一页');
	$p -> setConfig('last', '末页');
	$p -> setConfig('first', '首页');
	$p -> setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
	$p -> lastSuffix = false;
	return $p;
}

function tranTime2($time) { 
    $rtime = date("d/m/Y", $time); 
    $htime = date("H:i", $time); 
    $time = time() - $time; 
    if ($time < 60) { 
        $str = '刚刚'; 
    } elseif ($time < 60 * 60) { 
        $min = floor($time / 60); 
        $str = $min . '分钟前'; 
    } elseif ($time < 60 * 60 * 24) { 
        $h = floor($time / (60 * 60)); 
        $str = $h . '小时前 '; 
    } elseif ($time < 60 * 60 * 24 * 3) { 
        $d = floor($time / (60 * 60 * 24)); 
        if ($d == 1) 
            $str = '昨天 '; 
        else 
            $str = '前天 '; 
    } 
    else { 
        $str = $rtime; 
    } 
    return $str; 
}   

function tranTime($time) { 
    $rtime = date("Y-m-d H:i", $time); 
    $htime = date("H:i", $time); 
    $time = time() - $time; 
    if ($time < 60) { 
        $str = '刚刚'; 
    } elseif ($time < 60 * 60) { 
        $min = floor($time / 60); 
        $str = $min . '分钟前'; 
    } elseif ($time < 60 * 60 * 24) { 
        $h = floor($time / (60 * 60)); 
        $str = $h . '小时前 ' . $htime; 
    } elseif ($time < 60 * 60 * 24 * 3) { 
        $d = floor($time / (60 * 60 * 24)); 
        if ($d == 1) 
            $str = '昨天 ' . $htime; 
        else 
            $str = '前天 ' . $htime; 
    } 
    else { 
        $str = $rtime; 
    } 
    return $str; 
}	


// 获取ip地址	
function getIpaddr($ip,$newIP){
    if(!isset($newIP)){
    	$newIP = new \Org\Util\IP();
	}
    if ($ip == '127.0.0.1' || $ip == '0.0.0.0')
    	$data = '本机地址';
    else
    {
        $ip = $newIP -> find($ip);
        for ($i=1; $i < count($ip) ; $i++) {
            if($ip[$i] != $ip[$i-1])$data  = $data .$ip[$i];
        }
    }
    return $data;
}

// 获取操作系统
function getOS() {
	$os = '';
	$Agent = $_SERVER['HTTP_USER_AGENT'];
	if (eregi('win', $Agent) && strpos($Agent, '95')) {
		$os = 'Win 95';
	} elseif (eregi('win 9x', $Agent) && strpos($Agent, '4.90')) {
		$os = 'Win ME';
	} elseif (eregi('win', $Agent) && ereg('98', $Agent)) {
		$os = 'Win 98';
	} elseif (eregi('win', $Agent) && eregi('nt 5.0', $Agent)) {
		$os = 'Win 2000';
	} elseif (eregi('win', $Agent) && eregi('nt 6.0', $Agent)) {
		$os = 'Win Vista';
	} elseif (eregi('win', $Agent) && eregi('nt 6.1', $Agent)) {
		$os = 'Win 7';
	} elseif (eregi('win', $Agent) && eregi('nt 5.1', $Agent)) {
		$os = 'Win XP';
	} elseif (eregi('win', $Agent) && eregi('nt 6.2', $Agent)) {
		$os = 'Win 8';
	} elseif (eregi('win', $Agent) && eregi('nt 6.3', $Agent)) {
		$os = 'Win 8.1';
	} elseif (eregi('win', $Agent) && eregi('nt 10', $Agent)) {
		$os = 'Win 10';
	} elseif (eregi('win', $Agent) && eregi('nt', $Agent)) {
		$os = 'Win NT';
	} elseif (eregi('win', $Agent) && ereg('32', $Agent)) {
		$os = 'Win 32';
	} elseif (ereg('Mi', $Agent)) {
		$os = '小米';
	} elseif (eregi('Android', $Agent) && ereg('LG', $Agent)) {
		$os = 'LG';
	} elseif (eregi('Android', $Agent) && ereg('M1', $Agent)) {
		$os = '魅族';
	} elseif (eregi('Android', $Agent) && ereg('MX4', $Agent)) {
		$os = '魅族4';
	} elseif (eregi('Android', $Agent) && ereg('M3', $Agent)) {
		$os = '魅族';
	} elseif (eregi('Android', $Agent) && ereg('M4', $Agent)) {
		$os = '魅族';
	} elseif (eregi('Android', $Agent) && ereg('Huawei', $Agent)) {
		$os = '华为';
	} elseif (eregi('Android', $Agent) && ereg('HM201', $Agent)) {
		$os = '红米';
	} elseif (eregi('Android', $Agent) && ereg('KOT', $Agent)) {
		$os = '红米4G版';
	} elseif (eregi('Android', $Agent) && ereg('NX5', $Agent)) {
		$os = '努比亚';
	} elseif (eregi('Android', $Agent) && ereg('vivo', $Agent)) {
		$os = 'Vivo';
	} elseif (eregi('Android', $Agent)) {
		$os = 'Android';
	} elseif (eregi('linux', $Agent)) {
		$os = 'Linux';
	} elseif (eregi('unix', $Agent)) {
		$os = 'Unix';
	} elseif (eregi('iPhone', $Agent)) {
		$os = '苹果';
	} else if (eregi('sun', $Agent) && eregi('os', $Agent)) {
		$os = 'SunOS';
	} elseif (eregi('ibm', $Agent) && eregi('os', $Agent)) {
		$os = 'IBM OS/2';
	} elseif (eregi('Mac', $Agent) && eregi('PC', $Agent)) {
		$os = 'Macintosh';
	} elseif (eregi('PowerPC', $Agent)) {
		$os = 'PowerPC';
	} elseif (eregi('AIX', $Agent)) {
		$os = 'AIX';
	} elseif (eregi('HPUX', $Agent)) {
		$os = 'HPUX';
	} elseif (eregi('NetBSD', $Agent)) {
		$os = 'NetBSD';
	} elseif (eregi('BSD', $Agent)) {
		$os = 'BSD';
	} elseif (ereg('OSF1', $Agent)) {
		$os = 'OSF1';
	} elseif (ereg('IRIX', $Agent)) {
		$os = 'IRIX';
	} elseif (eregi('FreeBSD', $Agent)) {
		$os = 'FreeBSD';
	} elseif ($os == '') {
		$os = 'Unknown';
	}
	return $os;
}

/**
 * 验证码检查
 */
function check_verify($code, $id = "") {
	$verify = new \Think\Verify();
	return $verify -> check($code, $id);
}

/**
 * 获取当前日期
 */
function getNowDate() {
	return date("Y-m-d");
}

/**
 * 手机号码
 */
function isPhone($val) {

	if (ereg("^1[1-9][0-9]{9}$", $val))
		return true;
	return false;

}

/*
 * 获取浏览器信息
 */
function getUserBrowser() {
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'Maxthon')) {
		$browser = 'Maxthon';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 12.0')) {
		$browser = 'IE12.0';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 11.0')) {
		$browser = 'IE11.0';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 10.0')) {
		$browser = 'IE10.0';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 9.0')) {
		$browser = 'IE9.0';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 8.0')) {
		$browser = 'IE8.0';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.0')) {
		$browser = 'IE7.0';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.0')) {
		$browser = 'IE6.0';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'NetCaptor')) {
		$browser = 'NetCaptor';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape')) {
		$browser = 'Netscape';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Lynx')) {
		$browser = 'Lynx';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera')) {
		$browser = 'Opera';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome')) {
		$browser = 'Chrome';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox')) {
		$browser = 'Firefox';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari')) {
		$browser = 'Safari';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'iphone') || strpos($_SERVER['HTTP_USER_AGENT'], 'ipod')) {
		$browser = 'iphone';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'ipad')) {
		$browser = 'iphone';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'android')) {
		$browser = 'android';
	} else {
		$browser = 'other';
	}
	return $browser;
}

function getAgent() {
	$agent = $_SERVER['HTTP_USER_AGENT'];
	return $agent;
}

function is_ip($str) {
	$ip = explode('.', $str);
	for ($i = 0; $i < count($ip); $i++) {
		if ($ip[$i] > 255) {
			return false;
		}
	}
	return preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $str);
}

/**
 * 字符串截取，支持中文和其他编码
 */
function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = '...') {
	if (function_exists("mb_substr")){
		$slice = mb_substr($str, $start, $length, $charset);
    } else if (function_exists('iconv_substr')) {
		$slice = iconv_substr($str, $start, $length, $charset);
		if (false === $slice) {
			$slice = '';
		}
	} else {
		$re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
		$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
		$re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
		$re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
		preg_match_all($re[$charset], $str, $match);
		$slice = join("", array_slice($match[0], $start, $length));
	}
    if($slice == $str){
        return $slice;
    }else{
        return $suffix ? $slice . $suffix : $slice;
    }
}

/*
 * 删除缓存方法
 */
function delFileByDir($dir) {
	$dh = opendir($dir);
	while ($file = readdir($dh)) {
		if ($file != "." && $file != "..") {

			$fullpath = $dir . "/" . $file;
			if (is_dir($fullpath)) {
				delFileByDir($fullpath);
			} else {
				unlink($fullpath);
			}
		}
	}
	closedir($dh);
}

/**
 * 获取网站域名
 */
function getDomain(){
    $scheme = isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : 'http';
    $domain = empty($_SERVER['HTTP_HOST']) ? $scheme. '://' .$_SERVER['SERVER_NAME'] : $scheme. '://' .$_SERVER['HTTP_HOST'];
    return $domain;
}
/**
 * 获取当前URL
 */
function getUrl(){
    return "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
}

function gen_order_id($prefix=''){
    return $prefix.date("ymdHis",time()).gen_vcode(6);
}
function gen_vcode($size){
    $code = "";
    for($i=0;$i<$size;$i++){
        $code = $code.mt_rand(0, 9);
    }
    return $code;
}


function shop_order_status($status){
    switch ($status) {
        case 0:
            return '待付款';
            break;
        case 1:
            return '已付款';
            break;
        case 2:
            return '待收货';
            break;
        case 3:
            return '待评价';
            break;
         case 4:
            return '已完成';
            break;
        case -1:
            return '申请预约';
            break;
        case 20:
            return '用户取消';
            break;
        case 21:
            return '讲师取消';
            break;
        case 30:
            return '交易关闭';
            break;
        default:
            break;
    }
    return '';
}
function shop_order_goods_status($status){
    switch ($status) {
        case 1:
            return '申请退货中';
            break;
        case 2:
            return '退货中';
            break;
        case 3:
            return '退货成功';
            break;
        case -1:
            return '退货关闭';
            break;
        case 21:
            return '退款中';
            break;
        case 22:
            return '退款成功';
            break;
        case -21:
            return '退款关闭';
            break;

        default:
            break;
    }
    return '';
}

function gen_code(){
    return md5(uniqid(mt_rand(), true));
}


function format_money($val){
    return number_format($val, 2, '.', '');
}

function pay_way_str($payway){
    switch ($payway) {
        case Api\Common\Constant::pay_way_alipay:
            return '支付宝';
            break;
        case Api\Common\Constant::pay_way_weixin:
            return '微信';
            break;
        case Api\Common\Constant::pay_way_balance:
            return '余额';
            break;
        default:
            break;
    }
    return '';
}



function sortByRandom($a, $b) { 
    $val = rand(0,1);
    return ($val > 0) ? 1 : -1;
}

function gen_bonus_goods_code($limit = 0,$base = 1000000){
    $data = array();
    for($i=1;$i<=$limit;$i++){
        array_push($data, $i+$base);
    }
    usort($data, 'sortByRandom');   
    return $data;
}

function get_millisecond(){
    list($t1, $t2) = explode(' ', microtime());     
    return (float)sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);  
}

function order_status($type,$isbonus,$isfilladdress,$status){
    if($type == '1'){//抢购
        return orderstatus($status);
    }else if($type == '2'){//夺宝
        switch ($isbonus) {
            case '0':
                return '等待结果';
            case '1':
                if($isfilladdress == '0'){
                    return '秒杀成功';
                }else{
                    return orderstatus($status);
                }
            case '2':
                return '未获得';
            default:
                break;
        }
    }
    return '';
}

function orderstatus($status){
        switch ($status) {
            case '0':
                return '待付款';
            case '1':
                return '待发货';
            case '2':
                return '待收货';
            case '3':
                return '已收货';
            default:
                break;
        }
        return '';
    }

function sub_phone($phone){
    return substr($phone, 0,4).'****'.substr($phone, 7);
}

function cal_workyears($startyear){
    $nowyear = date('Y');
    return abs($nowyear-$startyear)+1;
}

function filter_idstrs($ids){
    $arr = explode(',', $ids);
    $tmp = array();
    foreach ($arr as $key => $value) {
        array_push($tmp, intval($value));
    }
    return implode(',', $tmp);
}

    function update_config($new_config,$filename) {
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

    function getWechatAuth(){
        $wxcfg = C('WECHAT_CONFIG');
        empty($wxcfg) && exit('请在后台设置微信相关参数');
        if((NOW_TIME-200) > $wxcfg['expires_in'] || empty($wxcfg['access_token'])){
            $wechatAuth = new \Com\WechatAuth($wxcfg['appid'], $wxcfg['appsecret']);
            $result = $wechatAuth->getAccessToken();

            if(isset($result['errcode'])) err($result);
            $wxcfg['expires_in']   = NOW_TIME + $result['expires_in'];
            $wxcfg['access_token'] = $result['access_token'];
            update_config(array('WECHAT_CONFIG'=>$wxcfg), 'wechat.php') || exit('更新微信配置缓存失败');
            unset($wechatAuth);
        }
        return new \Com\WechatAuth($wxcfg['appid'], $wxcfg['appsecret'], $wxcfg['access_token']);
    }

    function getJsApiTicket(){
        $ticket = '';
        $wxcfg = C('WECHAT_CONFIG');
        empty($wxcfg) && exit('请在后台设置微信相关参数');
        if((NOW_TIME-200) > $wxcfg['JsApiTicket_expires_in'] || empty($wxcfg['JsApiTicket'])){
            $wechatAuth = getWechatAuth();
            $result = json_decode($wechatAuth->getJsApiTicket(),true);
            if($result['errcode'] !== 0) err($result);
            $wxcfg['JsApiTicket_expires_in']   = NOW_TIME + $result['expires_in'];
            $wxcfg['JsApiTicket'] = $ticket = $result['ticket'];
            update_config(array('WECHAT_CONFIG'=>$wxcfg), 'wechat.php') || exit('更新微信配置缓存失败');
            unset($wechatAuth);
        }else{
            $ticket = $wxcfg['JsApiTicket'];
        }

        return $ticket;
    }

//极光推送
/*
    将数据先转换成json,然后转成array
*/
    function json_array($result){
       $result_json=json_encode($result);
       return json_decode($result_json,true);
    }
/*
    向所有设备推送消息 
    @param string $message 需要推送的消息 
*/
    function sendNotifyAll($message,$app_key,$master_secret){
        vendor('JPush.JPush');
        // $app_key='44d1453e915c876b3b3cb530';
        // $master_secret='9ab7665b5901cbefd890bd28';
        $client=new \JPush($app_key,$master_secret);
        $result=$client
                ->push()
                ->setPlatform('all')
                ->addAllAudience()
                ->setNotificationAlert($message)
                ->send();
        return json_array($result);
    }
/*
    向特定设备推送消息 
    @param array $ids 特定设备的设备标识 
    @param string $message 需要推送的消息 
*/
    function sendNotifySpecial($ids,$message,$app_key,$master_secret){
        vendor('JPush.JPush');
        // $app_key='44d1453e915c876b3b3cb530';
        // $master_secret='9ab7665b5901cbefd890bd28';
        $client=new \Jpush($app_key,$master_secret);
        $result=$client
                ->push()
                ->setPlatform('all')
                // ->addTag($ids)               //使用标签
                // ->addTagAnd($ids)        //使用标签
                // ->addAlias($ids)        //使用别名
                ->addRegistrationId($ids)//使用registration_id
                ->setNotificationAlert($message)
                ->send();
        return json_array($result);
    }
/*
    向指定设备推送自定义消息 
    @param string $message 发送消息内容 
    @param array $ids 特定设备的id 
    @param int $did 状态值1 
    @param int $mid 状态值2 
*/
    function sendSpecialMsg($ids,$message,$did,$mid,$app_key,$master_secret){
        vendor('JPush.JPush');
        // $app_key='44d1453e915c876b3b3cb530';
        // $master_secret='9ab7665b5901cbefd890bd28';
        $client=new \Jpush($app_key,$master_secret);
        $result=$client
                ->push()
                ->setPlatform('all')
                // ->addTag($ids)
                // ->addTagAnd($ids)
                // ->addAlias($ids)
                ->addRegistrationId($ids)
                ->addAndroidNotification($message,'',1,array('did'=>$did,'mid'=>$mid))
                ->addIosNotification($message,'','+1',true,'',array('did'=>$did,'mid'=>$mid))
                ->send();
        return json_array($result);
    }
/*
    得到各类统计数据 
    @param array $msgIds 推送消息返回的msg_id列表 
*/
    function reportNotify($msgIds,$app_key,$master_secret){
        vendor('JPush.JPush');
        // $app_key='44d1453e915c876b3b3cb530';
        // $master_secret='9ab7665b5901cbefd890bd28';
        $client=new \Jpush($app_key,$master_secret);
        $response=$client->report()->getReceived($msgIds);
        return json_array($response);
    }
?>