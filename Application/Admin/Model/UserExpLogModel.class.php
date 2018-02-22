<?php
namespace Admin\Model;
use Think\Model;
use Think\Log;
class UserExpLogModel extends CommonModel{
    protected $pk   = 'id';
    protected $tableName =  'user_exp_log';
    public $describe = array(
        'exp_register'=>'首次下载注册',
        'exp_headimg'=>'上传头像',
        'exp_nickname'=>'设置用户名',
        'exp_paypassword'=>'初次设置支付密码',
        'exp_moment'=>'圈子发帖',
        'exp_pay'=>'充值赠送',

    );
    /**
     * 插入经验日志
     * @Author 刘晓雨    2016-04-18
     * @param  int $userid    用户ID
     * @param  str $flag      插入类型
     * @return int            logid
     */
    public function insertLog($userid,$flag,$unqiue = false){
        //验证唯一
        if($unqiue){
            if($this->where(array("userid"=>$userid,"flag"=>$flag))->count()){
                return ;
            }
        }
        if(!$thisExp = $this->_insertCheck($userid,C($flag))) return ;
        $expData = array(
            "userid"=>$userid,
            "exp" => $thisExp,
            "time" => NOW_TIME,
            "flag" => $flag,
        );
        return $this->add($expData);
    }

    private function _insertCheck($userid,$exp){
        //每日经验上限
        $todayStart = mktime(0,0,0,date('m'),date('d'),date('Y'));
        $todayEnd   = mktime(23,59,59,date('m'),date('d'),date('Y'));
        $dailyURV = C('exp_daily_URV');
        $expToday = $this->where("userid = %d AND time > %d AND time < %d",$userid,$todayStart,$todayEnd)->sum('exp');
        if($expToday < $dailyURV){
            $usebleExp = $dailyURV - $expToday;
        }else{
            return false;
        }
        $thisExp = $exp > $usebleExp ? $usebleExp : $exp;
        return $thisExp;

    }
    /**
     * 用户充值赠送经验
     */
    public function insertPayExpLog($userid,$exp){
        if(!$thisExp = $this->_insertCheck($userid,$exp)) return ;
        $expData = array(
            "userid"=>$userid,
            "exp" => $thisExp,
            "time" => NOW_TIME,
            "flag" => 'exp_pay',
        );
        return $this->add($expData);
    }

    /**
     * 获取用户日志
     * @Author 刘晓雨    2016-04-18
     * @param  [type] $condi     [description]
     * @param  [type] $p         [description]
     * @return [type]            [description]
     */
    public function logList($condition,$p,$field="*"){
        $rows = $this->field($field)->where($condition)->order("time DESC")->page($p)->limit(C("PAGE_SIZE"))->select();
        foreach($rows as $k => $v){
            unset($rows[$k]['flag']);
            $rows[$k]['describe'] = $this->describe[$v['flag']];
        }
        return $rows;
    }

    
}
