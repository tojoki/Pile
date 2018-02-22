<?php
namespace Admin\Common;
class Constant {
    //用户端
    const user_app_key = 'b173984d546d5ccf280ae81b';
    const user_master_secret = '09e6a84968ec3834aa4ea965';

    //洗车端
    const worker1_app_key = '7637ec5e4277bf8fb48a138b';
    const worker1_master_secret = 'cf25e1eee589da2bee16f88d';

    //美容美发端
    const worker2_app_key = '9873345d573f562e7725a509';
    const worker2_master_secret = '25338085bfb8935273bc6701';

    public static $service_list = array(
        array('nickname'=>'AA客服','phone'=>'10086','account'=>'8018648900000002','avator'=>'/Uploads/logo2.png'),
        array('nickname'=>'BB客服','phone'=>'10086','account'=>'8018648900000003','avator'=>'/Uploads/logo2.png'),
        array('nickname'=>'CC客服','phone'=>'10086','account'=>'8018648900000004','avator'=>'/Uploads/logo2.png'),
        array('nickname'=>'DD客服','phone'=>'10086','account'=>'8018648900000005','avator'=>'/Uploads/logo2.png'),
        array('nickname'=>'EE客服','phone'=>'10086','account'=>'8018648900000006','avator'=>'/Uploads/logo2.png'),
        array('nickname'=>'FF客服','phone'=>'10086','account'=>'8018648900000007','avator'=>'/Uploads/logo2.png'),
    );
}
