<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends BaseController {
	public function index() {
            $size = 5;
//            //最新用户
//            $users = M('user')->field('nickname,ctime')->order('uid desc')->limit(0,$size)->select();
//            $this->assign('users',$users);
//            //最新医生
//            $doctors = M('doctor')->field('nickname,ctime')->order('uid desc')->limit(0,$size)->select();
//            $this->assign('doctors',$doctors);
//            //医生认证申请
//            $applys = M('doctor')->where('idcard is not null AND isauth=0')->field('nickname,ctime')
//                    ->order('applytime desc')->limit(0,$size)->select();
//            $this->assign('applys',$applys);
//            //用户反馈
//            $feeds = M('user_feed')->field('txt,ctime')->order('feedid desc')->limit(0,$size)->select();
//            $this->assign('feeds',$feeds);
//            //用户留言
//            $msgs = M('user_leavemsg')->field('txt,ctime')->order('msgid desc')->limit(0,$size)->select();
//            $this->assign('msgs',$msgs);
            
            $this -> display();
	}

	public function pwd() {
		$User = M('admin');
		$user2 = session('admin');
		if ($_POST) {
			$data['user'] = I('post.user');
			$data['password'] = md5(I('post.oldpassword'));
			$newpassword = md5(I('post.newpassword'));
			$repassword = md5(I('post.repassword'));
			$result = $User -> where($data) -> find();

			if ($result) {
				if ($newpassword != $repassword) {
					$this -> error("两次输入新密码不一致");
				} else {
					$msg = $User -> where($data) -> setField('password', $newpassword);
					if ($msg) {
						$this -> success("修改成功", U('Login/index'));
						return;
					} else {
						$this -> error("修改失败");
						return;
					}
				}
			} else {
				$this -> error("账号或密码不正确");
			}
		}
		$this -> assign('user2', $user2);
		$this -> display();
	}

	public function del() { 
           
		delFileByDir(APP_PATH.'Runtime/');
		$this->success('删除缓存成功！',U('index/index'));
	}

}
