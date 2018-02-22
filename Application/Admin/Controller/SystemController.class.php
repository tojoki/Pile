<?php
namespace Admin\Controller;
use Api\Common\Constant;
class SystemController extends BaseController {
	//角色
	private $createrole_fields = array('name', 'status', 'remark', 'pid');
	private $editrole_fields = array('name', 'status', 'remark');
	//用户
	private $createuser_fields = array('user', 'password', 'username', 'userimg', 'role', 'note', 'state', 'add_time', 'last_logintime', 'last_loginip');
	private $edituser_fields = array('user', 'role', 'username', 'userimg', 'note', 'state', 'update_time');
	//系统消息
	private $createnotice_fields = array('title', 'info ', 'add_time', );
	private $editnotice_fields = array('title', 'info', 'update_time');

	public function role() {
		$role = D('role');
		$count = $role -> count();
		$p = getpage($count, C('PAGE_SIZE'));
		$show = $p -> show();
		$list = $role -> page(I('get.p')) -> order('id desc') -> limit(C('PAGE_SIZE')) -> select();
		$this -> assign('page', $show);
		// 赋值分页输出
		$this -> assign('list', $list);
		$this -> display();
	}

	public function userlist() {
		$role = D('role');
		$admin = D('admin');
		$count = $admin -> count();
		$p = getpage($count, C('PAGE_SIZE'));
		$show = $p -> show();
		$list = $admin -> page(I('get.p')) -> order('id desc') -> limit(C('PAGE_SIZE')) -> select();
		$list2 = $role -> select();
		$this -> assign('page', $show);
		// 赋值分页输出
		$this -> assign('list', $list);
		$this -> assign('list2', $list2);
		$this -> display();
	}

	public function setting() {
		$access = D('access');
		$treenode = D('treenode');
		if ($_POST) {
			$ID = I('post.id');
			$getrule = I('post.rule');
			$access -> where(array('role_id' => $ID)) -> delete();
			for ($i = 0; $i < count($getrule); $i++) {
				$data['role_id'] = $ID;
				$data['node_id'] = $getrule[$i];
				$result = $access -> add($data);
			}
			//$getruel 是一个数组
			//$getrules = implode(',', $getrule) . ',';
			//$result = $access->where('role_id=' . $ID . '')->setField('node_id', $getrules);
			if ($result) {
				$this -> success("权限修改成功", U('System/role'), 2);
			} else {
				$this -> error("权限修改失败.....");
			}
		}
		//$msg = $group ->where('id = '.$id.'' )->find();
		//$this->assign('array',$msg);
		else {
			$id = I('get.id');
			$nodeids = $access -> where('role_id = ' . $id . '') -> field('node_id') -> select();
			$ids;
			foreach ($nodeids as $val) {
				$ids = '#' . $ids . $val['node_id'] . '#';
			}
			//var_dump($ids);exit;

			$data = $treenode -> field('id,title,pid,menuflag')->where(array('is_hide'=>0)) -> select();

			$this -> assign('list', $data);
			$this -> assign('group', $ids);
			$this -> assign('role', $id);
			$this -> display();
		}
	}

	public function addrole() {
		if (IS_POST) {
			$data = $this -> addroleCheck();
			$obj = D('role');

			if ($obj -> add($data)) {
				$this -> success("保存成功", U('System/role'));
				return;
			} else {
				$this -> error('操作失败！');
				return;
			}
		}
		$this -> display();
	}

	private function addroleCheck() {
		$param = I('post.');
		$data = $this -> checkFields($param["data"], $this -> createrole_fields);
		$data['name'] = trim(I('post.name', '', 'htmlspecialchars'));
		if ( D('role') -> getRoleName($data['name'])) {
			$this -> error('角色名已经存在');
			exit ;
		}
		if (empty($data['name'])) {
			$this -> error('角色名不能为空');
		}
		if (htmlspecialchars($data['status']) == "启用") {
			$data['status'] = 1;
		}
		if (htmlspecialchars($data['status']) == "停用") {
			$data['status'] = 0;
		}
		$data['remark'] = trim(I('post.remark', '', 'htmlspecialchars'));
		$data['pid'] = 0;
		return $data;
	}

	public function adduser() {
		$role = D('role');
		$list = $role -> where(array('status' => 1)) -> select();
		if (IS_POST) {
			$data = $this -> adduserCheck();
			$obj = D('admin');
			$user = M('role_user');
			$result = $obj -> add($data);
			if ($result) {
				$data2['role_id'] = htmlspecialchars($data['role']);
				$data2['user_id'] = $result;
				$user -> add($data2);
				$this -> success("保存成功", U('System/userlist'));
				return;
			} else {
				$this -> error('操作失败！');
				return;
			}
		}
		$this -> assign('list', $list);
		$this -> display();
	}

	private function adduserCheck() {
		$param = I('post.');
		$data = $this -> checkFields($param["data"], $this -> createuser_fields);
		$add_time = strtotime(date("Y-m-d H:i:s", time()));
		$ip = get_client_ip();
		$data['user'] = trim(I('post.user', '', 'htmlspecialchars'));
		if ( D('admin') -> getAdminName($data['user'])) {
			$this -> error('用户名已经存在');
			exit ;
		}
		if (empty($data['user'])) {
			$this -> error('用户名不能为空');
		}
		$data['password'] = trim(I('post.password', '', 'htmlspecialchars'));
		if (empty($data['password'])) {
			$this -> error('密码不能为空');
		}
		$data['password'] = md5($data['password']);
		$data['role'] = htmlspecialchars($data['role']);
		$data['note'] = trim(I('post.note', '', 'htmlspecialchars'));
		$data['username'] = trim(I('post.username', '', 'htmlspecialchars'));
		$data['userimg'] = trim(I('post.userimg', '', 'htmlspecialchars'));
		if (htmlspecialchars($data['state']) == "正常") {
			$data['status'] = 1;
		}
		if (htmlspecialchars($data['state']) == "停用") {
			$data['status'] = 0;
		}
		$data['add_time'] = $add_time;
		$data['last_logintime'] = $add_time;
		$data['last_loginip'] = $ip;
		return $data;
	}

	public function editrole($id = 0) {
		if ($id = (int)$id) {
			$obj = D('role');
			if (!$detail = $obj -> find($id)) {
				$this -> error('请选择要编辑的角色');
			}
			if (IS_POST) {
				$data = $this -> editroleCheck();
				$data['id'] = $id;
				if ($obj -> save($data)) {
					$this -> success('操作成功', U('System/role'));
				} else {
					$this -> error('操作失败');
				}
			} else {
				$this -> assign('detail', $detail);
				$this -> display();
			}
		} else {
			$this -> error('请选择要编辑的角色');
		}
	}

	private function editroleCheck() {
		$param = I('post.');
		$data = $this -> checkFields($param['data'], $this -> editrole_fields);
		$data['name'] = trim(I('post.name', '', 'htmlspecialchars'));
		if (empty($data['name'])) {
			$this -> error('角色名不能为空');
		}
		$data['remark'] = trim(I('post.remark', '', 'htmlspecialchars'));
		$data['status'] = htmlspecialchars($data['status']);
		return $data;
	}

	public function edituser($id = 0) {
		if ($id = (int)$id) {
			$obj = D('admin');
			$role = D('role');
			$user = M('role_user');
			$list = $role -> select();
			if (!$detail = $obj -> find($id)) {
				$this -> error('请选择要编辑的用户');
			}
			if (IS_POST) {
				$data = $this -> edituserCheck();
				$data['id'] = $id;
				if ($obj -> save($data)) {
					$data2['role_id'] = htmlspecialchars($data['role']);
					$user -> where(array('user_id' => $id)) -> save($data2);
					$this -> success('操作成功', U('System/userlist'));
				} else {
					$this -> error('操作失败');
				}
			} else {
				$this -> assign('list', $list);
				$this -> assign('detail', $detail);
				$this -> display();
			}
		} else {
			$this -> error('请选择要编辑的用户');
		}
	}

	private function edituserCheck() {
		$param = I('post.');
		$data = $this -> checkFields($param['data'], $this -> edituser_fields);
		$update_time = strtotime(date("Y-m-d H:i:s", time()));
		$data['user'] = trim(I('post.user', '', 'htmlspecialchars'));
		if (empty($data['user'])) {
			$this -> error('用户名不能为空');
		}
		$data['role'] = htmlspecialchars($data['role']);
		$data['note'] = trim(I('post.note', '', 'htmlspecialchars'));
		$data['state'] = htmlspecialchars($data['state']);
		$data['username'] = trim(I('post.username', '', 'htmlspecialchars'));
		$data['userimg'] = trim(I('post.userimg', '', 'htmlspecialchars'));
		$data['update_time'] = $update_time;
		return $data;
	}

	public function delrole() {
		$role = D('role');
		$id = I('get.id');
		$result = $role -> where('id =' . $id . '') -> delete();
		if ($result) {
			$this -> success('删除成功', U('System/role'));
		} else {
			$this -> error('删除失败');
		}
	}

	public function deluser() {
		$admin = D('admin');
		$id = I('get.id');
		$result = $admin -> where('id =' . $id . '') -> delete();
		if ($result) {
			$this -> success('删除成功', U('System/userlist'));
		} else {
			$this -> error('删除失败');
		}
	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/*
	 * 系统消息
	 */
	public function indexNotice() {
		$notice = D('notice');
		$count = $notice -> count();
		$p = getpage($count, C('PAGE_SIZE'));
		$show = $p -> show();
		$list = $notice -> page(I('get.p')) -> order('id desc') -> limit(C('PAGE_SIZE')) -> select();
		$this -> assign('page', $show);
		// 赋值分页输出
		$this -> assign('list', $list);
		$this -> display();
	}

	public function addNotice() {
		if (IS_POST) {
			$data = $this -> addCheck();
			$obj = D('notice');
			if ($obj -> add($data)) {
				$this -> success("保存成功", U('System/indexNotice'));
				return;
			} else {
				$this -> error('操作失败！');
				return;
			}
		}
		$this -> display();
	}

	private function addCheck() {
		$param = I('post.');
		$data = $this -> checkFields($param["data"], $this -> createnotice_fields);
		$add_time = strtotime(date("Y-m-d H:i:s", time()));
		$data['title'] = trim(I('post.title', '', 'htmlspecialchars'));
		if ( D('notice') -> getNoticeTitle($data['title'])) {
			$this -> error('消息已经存在');
			exit ;
		}
		if (empty($data['title'])) {
			$this -> error('消息标题不能为空');
		}
		$data['info'] = $_POST['info'];
		if (empty($data['info'])) {
			$this -> error('消息内容不能为空');
		}
		$data['add_time'] = $add_time;
		return $data;
	}

	public function editNotice($id = 0) {
		if ($id = (int)$id) {
			$obj = D('notice');
			if (!$detail = $obj -> find($id)) {
				$this -> error('请选择要编辑的系统消息');
			}
			if (IS_POST) {
				$data = $this -> editCheck();
				$data['id'] = $id;
				if ($obj -> save($data)) {
					$this -> success('操作成功', U('System/indexNotice'));
				} else {
					$this -> error('操作失败');
				}
			} else {
				$this -> assign('detail', $detail);
				$this -> display();
			}
		} else {
			$this -> error('请选择要编辑的系统消息');
		}
	}

	private function editCheck() {
		$param = I('post.');
		$data = $this -> checkFields($param['data'], $this -> editnotice_fields);
		$update_time = strtotime(date("Y-m-d H:i:s", time()));
		$data['title'] = trim(I('post.title', '', 'htmlspecialchars'));
		if (empty($data['title'])) {
			$this -> error('消息标题不能为空');
		}
		$data['info'] = $_POST['info'];
		if (empty($data['info'])) {
			$this -> error('消息内容不能为空');
		}
		$data['update_time'] = $update_time;
		return $data;
	}

	public function delNotice() {
		$notice = D('notice');
		$id = I('get.id');
		$result = $notice -> where('id =' . $id . '') -> delete();
		if ($result) {
			$this -> success('删除成功', U('System/indexNotice'));
		} else {
			$this -> error('删除失败');
		}
	}

	/*******************************************轮播管理*********************************************/

    /*
     * 轮播列表
     */
    public function carousel_list()
    {
		$carousel_list = D('carousel_list');		
		$count = $carousel_list -> count();
		$p = getpage($count, C('PAGE_SIZE'));
		$show = $p -> show();
		$list = $carousel_list -> page(I('get.p')) -> limit(C('PAGE_SIZE')) ->order('id desc')-> select();
		$this -> assign('list', $list);
		$this -> assign('page', $show);
		$this -> display();
    }

    /*
     * 添加轮播操作
     */
    public function runadd()
    {
        if (!IS_AJAX) {
            $this->error('提交方式不正确', 0, 0);
        } else {

            $file = I('file0');//获取图片路径
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize = 3145728;// 设置附件上传大小
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath = './Uploads/carousel/'; // 设置附件上传根目录
            $upload->savePath = ''; // 设置附件上传（子）目录
            $upload->saveRule = 'time';
            $info = $upload->upload();

            if ($info) {
                $img_url = '/carousel/' . $info[file0][savepath] . $info[file0][savename];//如果上传成功则完成路径拼接

            } elseif (!$file) {
                $img_url = '';//否则如果字段为空，表示没有上传任何文件，赋值空
            } else {
                $this->error($upload->getError());//否则就是上传错误，显示错误原因
            }
          

            $data = array(
                'id' => I('id'),
                'title' => I('title'),
                'img' => $img_url,
                'state' => I('state'),
            	'orderby' => I('orderby'),
            	'note' => I('note'),
                'addtime' => time(),

            );

            M('carousel_list')->add($data);
            $this->success('轮播添加成功', U('carousel_list'), 1);
        }
    }



    /*
     * 修改轮播
     */
    public function editcarousel()
    {
        
        $id = I('id');
        $list = M('carousel_list')->where(array('id' => $id))->find();
        $this->assign('list', $list);
        $this->display();

    }

    /*
     * 修改轮播操作
     */
    public function runeditcarousel()
    {
        if (!IS_AJAX) {
            $this->error('提交方式不正确', 0, 0);
        } else {

            $file = I('file1');//获取图片路径
            $checkpic = I('checkpic');
            $oldcheckpic = I('oldcheckpic');

            if ($checkpic != $oldcheckpic) {

                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize = 3145728;// 设置附件上传大小
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                $upload->rootPath = './Uploads/carousel/'; // 设置附件上传根目录
                $upload->savePath = ''; // 设置附件上传（子）目录
                $upload->saveRule = 'time';
                $info = $upload->upload();

                if ($info) {
                    $img_url = '/carousel/' . $info[file0][savepath] . $info[file0][savename];//如果上传成功则完成路径拼接
                } else {
                    $this->error($upload->getError());//否则就是上传错误，显示错误原因
                }
            }

            $data = array(
                'id' => I('id'),
                'title' => I('title'),
                'state' => I('state'),
                'orderby' => I('orderby'),
                'note' => I('note'),
            );
            if ($checkpic != $oldcheckpic) {
                $data['img'] = $img_url;
            }

            M('carousel_list')->save($data);
            $this->success('轮播修改成功', U('carousel_list'), 1);
        }
    }

    /*
     * 删除轮播
     */
    public function del()
    {
        $id = I('id');
        M('carousel_list')->where(array('id' => $id))->delete();
        $this->redirect('carousel_list', array('p' => $p));
    }
    
    
    //*****************************************************
    public function addbanner(){
        if(IS_POST){
            $bid = I('bid');
            $title = I('title');
            $poster = I('poster');
            $catid = I('catid');
            $links = I('links');
            $sortval = I('sortval');
            if($catid>1){
                $links = I('checkid');
                $subtitle = I('checkname');
            }
            $data = array(
                'title'=>$title,'subtitle'=>$subtitle,
                'poster'=>$poster,'catid'=>$catid,
                'links'=>$links,'ctime'=>time(),
                'sortval'=>$sortval
            );
            if($bid){
                $data['etime'] = time();
                M('banner')->where("bid=%d",$bid)->save($data);
            }else{
                $data['ctime'] = time();
                M('banner')->add($data);
            }
            exit($this->ajaxReturn(array('status'=>0,'msg'=>'操作成功')));
        }
        $this->assign('title','添加banner');
        $this->display();
    }
    
        /*
     * 修改
     */
    public function editbanner(){
        $bid = I('bid');
        $this->assign('title','修改banner');
        $product = M('banner')->find($bid);
        if($product['catid'] == 1){
            $this->assign('links',$product['links']);
        }else{
            $this->assign('isedit',1);
        }
        $this->assign('data',$product);
        $this->display('addbanner');
    }
    
    public function banner() {
        $size = 15;
        $goodsModel = M("banner");
        $count = $goodsModel->count(); // 查询满足要求的总记录数 
        $p = getpage($count, $size);
        $show = $p->show();
        $list = $goodsModel->page(I('get.p'))
            ->order("bid DESC")
            ->limit($size)
            ->select();

        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display();
    }
    
    public function delbanner(){
        $bid  = I("bid/d");
        if(M("banner")->where('bid = %d',$bid) ->delete()){
            $this->success("删除成功");
        }else{
            $this->error("删除失败");
        }
    }
    
    public function pagedata(){
        $stype = I('stype');
        $search = I('search');
        if(I("limit")){
            $limit = I("limit"); 
            $offset = I("offset");
            switch ($stype) {
                case 2://店铺
                    $model = M('shop');
                    $field = 'sid as id,sname as title';
                    $order = 'sid desc';
                    $where = "1=1";
                    if($search){
                        $where .= " AND sname like '%$search%'";
                    }
                    break;
                case 3://讲师
                    $model = M('teacher');
                    $field = 'tid as id,rname as title';
                    $order = 'tid desc';
                    $where = "1=1";
                    if($search){
                        $where .= " AND rname like '%$search%'";
                    }
                    break;
                case 4://专家
                    $model = M('expert');
                    $field = 'expertid as id,rname as title';
                    $order = 'tid desc';
                    $where = "1=1";
                    if($search){
                        $where .= " AND rname like '%$search%'";
                    }
                    break;
                default:
                    break;
            }
            $count = $model->where($where)->count();
            $list = $model->field($field)->where($where)
                 ->order($order)->limit($offset,$limit)->select();
            $data['total'] = $count;
            $data['rows']  = $list;
            $this->ajaxReturn($data);
        }
        $this->assign('stype',$stype);
        $this->display();
    }
    
    /*
     * 问卷调查
     */
    public function survey(){
         $verModel = M('survey_questions');
         //分页
         $pageSize = C('PAGE_SIZE');
         $count = $verModel->count();
         $p = getpage($count,$pageSize);
         $show = $p->show();
         $list = $verModel->page(I('p'))->limit($pageSize)->order('qid')->select();
         for($i=0;$i<count($list);$i++){
             $list[$i]['options'] = explode(',', $list[$i]['options']);
         }
         $this->assign('page',$show);
         $this->assign('list',$list);
        $this->display();
    }
    
    public function addquestion(){
        $qid = I('qid');
        if(IS_POST){
            $data = array(
                'title'=>I('title'),'options'=>  implode(',', I('options')),
                'ismulti'=>I('ismulti')
            );
            if($qid){
                $data['etime'] = time();
                M('survey_questions')->where('qid=%d',$qid)->save($data);
            }  else {
                $data['ctime'] = time();
                $nums = M('survey_questions')->count();
                if($nums>=50){
                   $this->ajaxReturn(array('status'=>1,'msg'=>'最多允许添加50道题')); 
                }
                M('survey_questions')->add($data);
            }
            $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
        }
        if($qid){
           $que = M('survey_questions')->where('qid=%d',$qid)->find();
           $que['options'] = explode(',', $que['options']);
           $this->assign('data',$que); 
        }
        $this->display();
    }
    
    public function quedel(){
        $qid = I('qid');
        if(empty($qid)){
            $this->ajaxReturn(array('status'=>1,'msg'=>'缺少参数'));
        }
        $verModel = M('survey_questions');
        $condi['qid'] = $qid;
        if($verModel->where($condi)->delete()){
            $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>'操作失败'));
        }
    }
    
    /**
     * 用户反馈
     */
    public function feeds(){
         $count = M('user_feed')->count();
         $Page = new \Think\Page($count, 12);
         $show = $Page->show();
         $list = M('user_feed')->alias('f')
                 ->join('left join __USER__ u on u.uid=f.uid')
                 ->field('f.*,u.nickname,u.phone')
                 ->limit($Page->firstRow,$Page->listRows)
                 ->order('f.feedid DESC')->select();
		 $index_r=1;
		 foreach($list as $k=>$v){
		 	$list[$k]['index_r']=$index_r;
		 	$index_r++;
		 }
         $this->assign('page',$show);
         $this->assign('list',$list);
         $this->display();
    }

    public function show(){
    	$feedid = intval(I('feedid'));
    	$info=M('user_feed')->alias('f')
    			->join('left join web_user u on u.uid=f.uid')
    			->where('feedid='.$feedid)
    			->field('u.username,u.phone,f.*')
    			->find();
    	$this->assign('info',$info);
        $this->display();
    }
    
    public function delfeed(){
        $feedid = intval(I('feedid'));
        $type_id=1;
        // var_dump($type_id);
        if($type_id==1){
        	M('user_feed')->where('feedid=%d',$feedid)->delete();
        }else if($type_id==2){
        	M('lawyer_feed')->where('feedid=%d',$feedid)->delete();
        }
        $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
    }
    
    /**
     * 版本管理
     */
    public function version(){
         $verModel = M('app_version');
         //分页
         $pageSize = C('PAGE_SIZE');
         $count = $verModel->count();
         $p = getpage($count,$pageSize);
         $show = $p->show();
         $list = $verModel
         			->field("web_app_version.*,web_admin.username AS managername")
         			->join("LEFT JOIN web_admin ON web_admin.id = web_app_version.managerid")
         			->page(I('p'))->limit($pageSize)->order('vid DESC')->select();
         $this->assign('page',$show);
         $this->assign('list',$list);
         $this->display();
    }
    /**
     * 版本添加
     */
    public function versionadd(){
        
        if(IS_AJAX){
            $vid = intval(I('vid'));
            if($vid){
               M('app_version')->where('vid=%d',$vid)->save(array(
                    'filepath'=>I('download'),'ctime'=>time(),
                    'managerid'=>session('admin.id'),'version'=>I('version'),
                    'name'=>I('name'),'describe'=>I('describe'),'type_id'=>I('type_id')
                )); 
            }else{
                M('app_version')->add(array(
                    'filepath'=>I('download'),'ctime'=>time(),
                    'managerid'=>session('admin.id'),'version'=>I('version'),
                    'name'=>I('name'),'describe'=>I('describe'),'type_id'=>I('type_id')
                ));
            }
            
            succ("操作成功");
        }
        $this->display();
    }
    /**
     * 版本修改
     */
    public function versionedit(){
        if($error = admin_require_check('vid')) $this->error($error);
        $verModel = M('app_version');
        $condi['vid'] = I('vid');
        if(IS_AJAX){
            $verModel->create();
            $verModel->dateline = NOW_TIME;
            $verModel->managerid = session('admin.id');
            if($verModel->where($condi)->save()){
                succ('修改成功');
            }else{
                err('修改失败');
            }
            exit;
        }
        $data = $verModel->where($condi)->find();
        $this->assign('data',$data);
        $this->display('versionadd');
    }

    /**
     * 版本删除
     */
    public function versiondel(){
        if($error = admin_require_check('vid')) $this->error($error);
        $verModel = M('app_version');
        $condi['vid'] = I('vid');
        if($verModel->where($condi)->delete()){
            succ("删除成功");
        }else{
            err("删除失败");
        }
    }

}
