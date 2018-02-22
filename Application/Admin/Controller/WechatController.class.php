<?php

namespace Admin\Controller;
use Think\Controller;
class WechatController extends BaseController {
    /**
     * 公众号设置
     * @date 2016-06-01
     */
    public function set(){
        if(IS_AJAX){
            $data = array(
                'WECHAT_CONFIG'=>I()
            );
            // var_dump($data);die;
            if(update_config($data,'wechat.php')){
                succ('保存成功');
            }else{
                err('保存失败，文件存在');
            }
        }
        $data = C('WECHAT_CONFIG');
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * 自定义菜单
     * @date   2016-06-01
     */
    public function menu(){
        if(IS_AJAX){
            $menu = array_filter(I("post.wechatMenu"));
            $newmenu = array();
            foreach($menu as $key => $v){
                $arr = array();
                if($v['name'] == "") continue;
                $arr['name'] = $v['name'];
                if($v['sub_button']){
                    foreach($v['sub_button'] as $sub_k => $sub_btn){
                        if($sub_btn['name'] == "") continue;
                        $arr_sub = array();
                        $arr_sub["name"] = $sub_btn['name'];
                        $arr_sub["type"] = $sub_btn['type'];
                        if($sub_btn['type'] == 'view'){
                            $arr_sub["url"] = $sub_btn['value'];
                        }else{
                            $arr_sub["key"] = $sub_btn['value'];
                        }
                        $arr['sub_button'][] = $arr_sub;
                    }

                }else{
                    $arr['type'] = $v['type'];
                    if($v['type'] == 'view'){
                        $arr['url'] = $v['value'];
                    }else{
                        $arr['key'] = $v['value'];
                    }
                }
                array_push($newmenu , $arr);
            }
            if(!count($newmenu)) err('菜单不能为空');
            $data = array('WECHAT_MENU'=>$newmenu);

            if(update_config($data,'wechat.php')){
                succ('保存成功');
            }else{
                err('保存失败，文件存在');
            }
            
        }
        $data = C('WECHAT_MENU');
        $this->assign('wechatMenu',$data);
        $this->display();
    }

    /**
     * 更新微信自定义菜单
     * @date   2016-06-01
     */
    public function updateMenu(){
        $newmenu = C('WECHAT_MENU');        
        $newmenu || exit;
        $wechatAuth = getWechatAuth();
        $result = $wechatAuth->menuCreate($newmenu);
        if($result['errcode'] == "0"){
            succ("更新成功");
        }else{
            err("更新失败:ErrCode".$result['errcode']);
        }
    }
    /**
     * 回复列表
     * @date   2016-06-01
     * @return [type]     [description]
     */
    public function reply(){
        $replyModel = M('wechatReply');
        $pagesize = C('PAGE_SIZE');
        if(!$pagesize){
            $pagesize=10;
        }
        $keyword = I("keyword");//关键字
        if($keyword){
            $condi['mname'] = array("LIKE","%".$keyword."%");
            $urlParam['keyword'] = $keyword;
        }
        $count = $replyModel->where($condi)->count();
        $p = getpage($count, $pagesize,$urlParam);
        $show = $p->show();
        $list = $replyModel->fetchsql(false)
                    ->field('mid,mname,replytype,replycontent,keyword,dateline,ifnull(visit,0) as visit')
                    ->where($condi)->page(I('p'))->limit($pagesize)->select();
        foreach($list as &$v){
            $v['keyword'] = $this->_keyword($v['keyword'],false);
        }
        // var_dump($list);die;
        $this->assign('list',$list);
        $this->assign('page',$show);

        $this->display();
    }
    /**
     * 添加回复
     * @date   2016-06-01
     */
    public function replyAdd(){
        if(IS_AJAX){
            $replyModel = M('wechatReply');
            if($err = admin_require_check('mname,keyword')) err($err);
            if(I('replyType') == 'text'){
                $replyContent = I('replyTextContent');
            }else{
                $replyContent = I('replyNewsContent');
            }

            $is_def  = I('is_default/d');//默认回复
            $is_sub  = I('is_subscribe/d');//关注回复
            //关闭其他的默认回复
            if($is_def){
                $replyModel->save(array('is_default'=>0));
            }
            //关闭其他的关注回复            
            if($is_sub){
                $replyModel->save(array('is_subscribe'=>0));
            }

            $data = array(
                'mname' => I('mname'),
                'keyword' => $this->_keyword(I('keyword')),
                'replyContent' => $replyContent,
                'replyType' => I('replyType'),
                'dateline' => NOW_TIME,
                'is_default' => $is_def,
                'is_subscribe' => $is_sub,
                'service' => I('service/d'),
            );
            if($replyModel->add($data)){
                succ('添加成功',U('Wechat/reply'));
            }else{
                err('添加失败');
            }
        }
        $this->display();
    }
    /**
     * 添加修改
     * @date   2016-06-02
     */
    public function replyEdit(){
        if($err = admin_require_check('mid')) $this->error($err); 
        $replyModel = M('wechatReply');
        $mid = I('mid/d');
        if(IS_AJAX){
            if($err = admin_require_check('mname,keyword')) $this->error($err);             
            if(I('replyType') == 'text'){
                $replyContent = I('replyTextContent');
            }else{
                $replyContent = I('replyNewsContent');
            }
            $is_def  = I('is_default/d');//默认回复
            $is_sub  = I('is_subscribe/d');//关注回复
            //关闭其他的默认回复
            if($is_def){
                $replyModel->save(array('is_default'=>0));
            }
            //关闭其他的关注回复            
            if($is_sub){
                $replyModel->save(array('is_subscribe'=>0));
            }

            $data = array(
                'mname' => I('mname'),
                'keyword' => $this->_keyword(I('keyword')),
                'replyContent' => $replyContent,
                'replyType' => I('replyType'),
                'dateline' => NOW_TIME,
                'is_default' => $is_def,
                'is_subscribe' => $is_sub,
                'service' => I('service/d'),
            );
            if($replyModel->where('mid = %s',$mid)->save($data)){
                succ('保存成功',U('Wechat/reply'));
            }else{
                err('保存失败');
            }
        }
        $reply = $replyModel->where('mid = %s',$mid)->find();
        $reply['keyword'] = $this->_keyword($reply['keyword'],false);
        $this->assign('data',$reply);
        $this->display('replyAdd');
    }


    public function replyDel(){
        $mid = I('mid');
        $wechatReply = M('wechatReply')->where('mid='.$mid)->delete();
        if($wechatReply){
            $this->success('删除成功',U('Wechat/reply'));
        }else{
            $this->error('删除失败');
        }
    }

    /**
     * 处理关键字
     * @date   2016-06-03
     * @param  [type]     $keyword [description]
     * @param  boolean    $import  [description]
     * @return [type]              [description]
     */
    public function _keyword($keyword, $import = true){
        if(!$keyword) return '';
        if($import){
            return str_replace(',','|',','.trim($keyword,',').',');
       }else{
            return str_replace('|',',',trim($keyword,'|'));
       }
    }




}