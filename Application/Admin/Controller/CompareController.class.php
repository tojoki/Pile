<?php
namespace Admin\Controller;
use Think\Log;
class CompareController extends BaseController {
	
    public function index(){
        
    }

    public function article(){
        $Article = D('Article');
        $count = $Article->count(); 
        $p = getpage($count,C('PAGE_SIZE'));
        $show = $p->show(); 
        $list = $Article->page(I('get.p'))->order('aid desc')->limit(C('PAGE_SIZE'))->select();
        $this->assign('page', $show); 
        $this->assign('list', $list);
        $this->display();
    }
 
    public function articleadd(){
        if(IS_POST){
            $gid = I('aid');
            $data = array(
                'title'=>I('title'),'poster'=>I('poster'),
                'describes'=>I('describes'),'sortval'=>I('sortval'),
                'author'=>I('author'),'content' =>I('content'),
                'category'=>I('category')
            );
            if($gid){
               $data['etime'] = time();
               M("article")->where('aid=%d',$gid)->save($data);
            }else{
               $data['ctime'] = time();
               M("article")->add($data); 
            }
            $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
        }
        $this->display();
    }

    public function editarticle(){
        $gid                = I("aid/d");
        $goodsModel        = M("article");
        $condition['aid']  = $gid;
        $data = $goodsModel->where($condition)->find();
        $this->assign("data",$data);
        $this->display("articleadd");
    }
    /*
     *删除文章
     */   
    public function delarticle() {
        $p = I('p');
        M('article')->where(array('aid' => I('aid')))->delete();
        $this->redirect('article', array('p' => $p));
    }
    
    
    //*************************视频
    
    public function video(){
        $Article = D('video');
        $count = $Article->count(); 
        $p = getpage($count,C('PAGE_SIZE'));
        $show = $p->show(); 
        $list = $Article->page(I('get.p'))->order('vid desc')->limit(C('PAGE_SIZE'))->select();
        $this->assign('page', $show); 
        $this->assign('list', $list);
        $this->display();
    }
    
    public function videoadd(){
        if(IS_POST){
            $gid = I('vid');
            $data = array(
                'title'=>I('title'),'poster'=>I('poster'),
                'describes'=>I('describes'),'sortval'=>I('sortval'),
                'filepath'=>I('filepath')
            );
            if($gid){
               $data['etime'] = time();
               M("video")->where('vid=%d',$gid)->save($data);
            }else{
               $data['ctime'] = time();
               M("video")->add($data); 
            }
            $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
        }
        $this->display();
    }

    public function editvideo(){
        $gid                = I("vid/d");
        $goodsModel        = M("video");
        $condition['vid']  = $gid;
        $data = $goodsModel->where($condition)->find();
        $this->assign("data",$data);
        $this->display("videoadd");
    }
    /*
     *删除文章
     */   
    public function delvideo() {
        $p = I('p');
        M('video')->where(array('vid' => I('vid')))->delete();
        $this->redirect('video', array('p' => $p));
    }
    
    public function category(){
        $count = M('compare_category')->count();
        $order = 'catid desc';
        $Page = new \Think\Page($count,10);
        $list = M('compare_category')->order($order)->limit($Page->firstRow,$Page->listRows)->select();
        $this->assign('page', $Page->show()); 
        $this->assign('list', $list);
        $this->display();
    }
    
    public function addcat(){
        $gid = I('catid');
        if(IS_POST){
            $data = array(
                'catname'=>I('catname'),'poster'=>I('poster'),
                'topid'=>I('topid'),
                'sortval'=>I('sortval'),
                'ctime'=>time()
            );
            if($gid){
               $data['etime'] = time();
               M("compare_category")->where('catid=%d',$gid)->save($data);
            }else{
               $data['ctime'] = time();
               M("compare_category")->add($data); 
            }
            $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
        }
        if($gid){
            $cat = M("compare_category")->find($gid);
            $this->assign('data',$cat);
        }
        $this->display();
    }

    public function delcat() {
        M('medicine_category')->where(array('cid' => I('cid')))->delete();
        $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
    }
    
    
    public function goods(){
        $where = '1=1';
        $title = I('title');
        if($title){
            $where .= " AND (gname like '%$title%' or othername like '%$title%')";
            $this->assign('title',$title);
        }
        $type = intval(I('type'));
        if($type){
            $where .= " AND catid=$type";
        }
        $count = M('compare_goods')->where($where)->count();
        $order = 'm.gid desc';
        $Page = new \Think\Page($count,10);
        $list = M('compare_goods')->alias('m')->where($where)
                ->order($order)->limit($Page->firstRow,$Page->listRows)->select();
        $this->assign('page', $Page->show()); 
        $this->assign('list', $list);
        $this->display();
    }
    
    public function addgoods(){
        $gid = I('gid');
        if(IS_POST){
            $data = array(
                'catid'=>I('catid'),'poster'=>I('poster'),
                'gname'=>I('gname'),'minprice' =>I('minprice'),
                'maxprice'=>I('maxprice'),'sellers'=>  intval(I('sellers')),
                'sortval'=>I('sortval'),'topid'=>I('topid'),
                'othername'=>I('othername')
            );
            if($gid){
               $data['etime'] = time();
               M("compare_goods")->where('gid=%d',$gid)->save($data);
            }else{
               $data['ctime'] = time();
               M("compare_goods")->add($data); 
            }
            $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
        }
        if($gid){
            $goods = M('compare_goods')->find($gid);
            $this->assign('data',$goods);
        }
        $cat = M('compare_category')->limit(0,100)->select();
        if(empty($cat)){
            $cat = array();
        }
        $this->assign('cat',$cat);
        $this->assign('catstr',json_encode($cat));
        $this->display();
    }
    
    public function shops(){
        $count = M('compare_shops')->count();
        $order = 'sid desc';
        $Page = new \Think\Page($count,10);
        $list = M('compare_shops')->alias('m')
                ->order($order)->limit($Page->firstRow,$Page->listRows)->select();
        $this->assign('page', $Page->show()); 
        $this->assign('list', $list);
        $this->display();
    }
    
    public function addshops(){
        $gid = I('sid');
        if(IS_POST){
            $coord = I('coord');
            $coordarr = explode(',', $coord);
            $data = array(
                'poster'=>I('poster'),'memo'=>I('memo'),
                'sname'=>I('sname'),'linkman' =>I('linkman'),
                'linkphone'=>I('linkphone'),'address'=>  I('address'),
                'sortval'=>  intval(I('sortval')),'x'=>$coordarr[0],'y'=>$coordarr[1]
            );
            if($gid){
               $data['etime'] = time();
               M("compare_shops")->where('sid=%d',$gid)->save($data);
            }else{
               $data['ctime'] = time();
               M("compare_shops")->add($data); 
            }
            $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
        }
        if($gid){
            $goods = M('compare_shops')->find($gid);
            $goods['coord'] = $goods['x'].','.$goods['y'];
            $this->assign('data',$goods);
        }
        $this->display();
    }
    
    public function mdtypelist(){
        $fid = intval(I('fid'));
        $category = M('medicine_category')
                ->where("secondcatid=%d",$fid)->field('cid,title')
                ->order('sortval desc')->limit(0,50)->select();
        if(!$category){
            $category = array();
        }
        $this->ajaxReturn(array('status'=>0,'list'=>$category));
    }

    public function editmedicine(){
        $gid                = I("mid/d");
        $goodsModel        = M("medicine");
        $condition['mid']  = $gid;
        $data = $goodsModel->where($condition)->find();
        $this->assign("data",$data);
        $this->display("medicineadd");
    }
    public function delgoods() {
        M('compare_goods')->where(array('gid' => I('gid')))->delete();
        //删除关联数据
        $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
    }
    
    public function delshops() {
        M('compare_shops')->where(array('sid' => I('sid')))->delete();
        //删除关联数据
        $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
    }
    
    /*
     * 物价管理
     */
    public function price(){
        $count = M('compare_shops')->count();
        $order = 'sid desc';
        $Page = new \Think\Page($count,10);
        $list = M('compare_shops')->alias('m')
                ->order($order)->limit($Page->firstRow,$Page->listRows)->select();
        for($i=0;$i<count($list);$i++){
            /*
             * 统计商品总数
             * 统计今日更新 
             * low low low
             */
            $currshop = $list[$i];
            $todaydate = date('Ymd');
            $daycondition = "sid={$currshop['sid']} AND from_unixtime(etime,'%Y%m%d')=$todaydate";
            $total = M('compare_shop_goods')->where('sid=%d',$currshop['sid'])->count();
            $todaynum = M('compare_shop_goods')->where($daycondition)->count();
            $list[$i]['total'] = $total;
            $list[$i]['todaynum'] = $todaynum;
        }
        $this->assign('page', $Page->show()); 
        $this->assign('list', $list);
        $this->display();
    }
    
    public function imports(){
        $shopid = I('shopid');
        $optype = I('optype');
        if(IS_POST){
            $data = array();
            $file = I('file');
            import("Org.Util.PHPExcel");
            $filename=".".$file;
            $PHPExcel=new \PHPExcel();
            import("Org.Util.PHPExcel.Reader.Excel5");
            $PHPReader=new \PHPExcel_Reader_Excel5();
            $PHPExcel=$PHPReader->load($filename);
            $currentSheet=$PHPExcel->getSheet(0);
            $allColumn=$currentSheet->getHighestColumn();
            $allRow=$currentSheet->getHighestRow();
            for($currentRow=1;$currentRow<=$allRow;$currentRow++){
                //'A1' 'B'.$currentRow
                $gname = $currentSheet->getCell('A'.$currentRow)->getValue();
                $gprice = $currentSheet->getCell('B'.$currentRow)->getValue();
                array_push($data, array('gname'=>$gname,'price'=>$gprice));
            }
            
            if($optype == '1'){//导入商品
               $nums = $this->import_goods($data,$shopid);
               $this->ajaxReturn(array('status'=>0,'msg'=>'共导入:'.$nums.'件商品'));
            }else if($optype == '2'){//导入价格
               $nums = $this->import_price($data,$shopid);
               $this->ajaxReturn(array('status'=>0,'msg'=>'共新导入:'.$nums['addnums'].'件商品价格,更新'.$nums['updatenums'].'件商品价格'));
            }
            $this->ajaxReturn(array('status'=>1,'msg'=>'参数错误'));
        }
        $this->assign('shopid',$shopid);
        $this->assign('optype',$optype);
        $this->display();
    }

    public function upload(){
        $path =$this->uploadAttach($_FILES['Filedata'], 'price');
        $this->ajaxReturn(array('status'=>0,'path'=>$path));
    }
    /*
     * 店铺价格商品
     */
    public function shopgoods(){
        $type = I('optype');
        $sid = I('shopid');
        $where = 'sg.sid='.intval($sid);
        switch ($type) {
            case '1'://所有商品
                //$where = '1=1';
                break;
            case '2'://今日新增
                $today = date('Ymd');
                $where .= " AND from_unixtime(sg.etime,'%Y%m%d')='".$today."'";
                break;
            case '3'://缺失商品
                $today = date('Ymd');
                $where .= " AND from_unixtime(sg.etime,'%Y%m%d')<'".$today."'";
                break;
            default:
                break;
        }
        $title = I('title');
        if($title){
            $where .= " AND g.gname like '%$title%'";
        }
        $catid = intval(I('catid'));
        if($catid){
            $where .= " AND g.catid=$catid";
        }
        
        $count = M('compare_shop_goods')->alias('sg')
            ->join('left join __COMPARE_GOODS__ g on sg.gid=g.gid')    
            ->where($where)->count();
        $order = 'sg.ctime desc';
        $Page = new \Think\Page($count,10);
        $list = M('compare_shop_goods')->alias('sg')
                ->join('left join __COMPARE_GOODS__ g on sg.gid=g.gid')    
                ->where($where)->order($order)
                ->field('g.gname,sg.price,sg.etime,g.catid')
                ->limit($Page->firstRow,$Page->listRows)->select();
        $this->assign('page', $Page->show()); 
        $this->assign('list', $list);
        $this->assign('basesize',$Page->firstRow);
        $this->display();
    }

    //上传导入文件
    protected function uploadAttach($file,$dir){  
        $basepath = '/'.$dir.'/'.date('ym',time()).'/';
        $upload = new \Think\Upload();// 实例化上传类    
        $upload->maxSize   =     31457280 ;// 设置附件上传大小    
        $upload->exts      =     array('xlsx','xls');// 设置附件上传类型    
        $upload->savePath  =     $basepath; // 设置附件上传目录
        $upload->rootPath = './Uploads/';
        // 上传文件     
        $info   =   $upload->uploadOne($file);
        if(!$info) {
          // 上传错误提示错误信息        
          Log::write('upload file error:'.$upload->getError());
          $this->ajaxReturn(array('status'=>9,'msg'=>$upload->getError()));
        }else{
          return '/Uploads'.$info['savepath'].$info['savename'];
        }
    }
    
    /*
     * 导入商品
     */
    private function import_goods($data,$sid){
        $savedata = array();
        foreach ($data as $key => $value) {
            //查询商品是否存在
            $goods = M('compare_goods')->field('gid')
                    ->where("gname='%s'",$value['gname'])->find();
            if(empty($goods)){
                continue;
            }
            //查询是否已经导入
            $shopgoods = M('compare_shop_goods')
                    ->where('sid=%d AND gid=%d',$sid,$goods['gid'])->count();
            if($shopgoods){//已导入
                continue;
            }
            //添加
            array_push($savedata, array(
                'sid'=>$sid,'gid'=>$goods['gid'],'price'=>0,
                'ctime'=>time(),'status'=>0,
            ));
            
        }
        if(count($savedata)>0){
            M('compare_shop_goods')->addAll($savedata);
            //计算总数量
            $total = M('compare_shop_goods')->where('sid=%d',$sid)->count();
            M('compare_shops')->where('sid=%d',$sid)->save(array('totalgoods'=>$total));
        }
        return count($savedata);
    }
    
    /*
     * 导入价格
     */
    private function import_price($data,$sid){
        $savedata = array();
        $sqls = array();$updpricesqls = array();
        $today = date('Ymd');
        foreach ($data as $key => $value) {
            //查询商品是否存在
            $goods = M('compare_goods')->field('gid')
                    ->where("gname='%s'",$value['gname'])->find();
            if(empty($goods)){
                continue;
            }
            //查询店铺是否有该物品
            $shopgoods = M('compare_shop_goods')
                    ->where('sid=%d AND gid=%d',$sid,$goods['gid'])->find();
            if(empty($shopgoods)){
                continue;
            }
            //今日是否已导入
//            if(date('Ymd',$shopgoods['etime']) == $today){
//                continue;
//            }
            if(date('Ymd',$shopgoods['etime']) == $today){//今日已导入
                array_push($updpricesqls, "update __COMPARE_SHOP_PRICE__ set price={$value['price']},etime=".time()." WHERE sid={$shopgoods['sid']} AND gid={$shopgoods['gid']}");
            }else{
                array_push($savedata, array(
                    'gid'=>$shopgoods['gid'],'sid'=>$shopgoods['sid'],
                    'price'=>$value['price'],'addtime'=>time(),'adddate'=>$today
                ));
            }
            array_push($sqls, "update __COMPARE_SHOP_GOODS__ set price={$value['price']},etime=".time()." WHERE sid={$shopgoods['sid']} AND gid={$shopgoods['gid']}");
        }
        $rs = TRUE;
        M()->startTrans();
        if(count($savedata)>0){
            $rs = M('compare_shop_price')->addAll($savedata);
        }
        //更新店铺最新价格
        foreach ($sqls as $key => $sql) {
            $rs = $rs && M()->execute($sql);
        }
        //重复导入 只更新价格
        foreach ($updpricesqls as $key => $psql) {
            $rs = $rs && M()->execute($psql);
        }
        //更新导入时间 importtime
        M('compare_shops')->where('sid=%d',$sid)->save(array(
           'importtime' =>time(),
        ));
        
        if($rs){
            M()->commit();
            return array('addnums'=>count($savedata),'updatenums'=>count($updpricesqls));
        }else{
            M()->rollback();
            $this->ajaxReturn(array('status'=>9,'msg'=>'操作失败'));
        }
    }
    
    
    /*
     * 促销活动
     */
    public function lists(){
        $count = M('shop_activity')->count();
        $order = 'aid desc';
        $Page = new \Think\Page($count,10);
        $list = M('shop_activity')->alias('a')
                ->join('left join web_compare_shops s on a.sid=s.sid')
                ->field('a.*,s.sname')
                ->order($order)->limit($Page->firstRow,$Page->listRows)->select();
        $this->assign('page', $Page->show()); 
        $this->assign('list', $list);
        $this->display();
    }
    
    public function addactivity(){
        $gid = I('aid');
        if(IS_POST){
            $data = array(
                'posters'=>I('pictures'),'sid'=>I('sid'),
                'title'=>I('title'),'starttime' =>  strtotime(I('starttime')),
                'endtime'=>  strtotime(I('endtime')),'address'=>  I('address'),
                'sortval'=>  intval(I('sortval'))
            );
            if($gid){
               $data['etime'] = time();
               M("shop_activity")->where('aid=%d',$gid)->save($data);
            }else{
               $data['ctime'] = time();
               M("shop_activity")->add($data); 
            }
            $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
        }
        if($gid){
            $goods = M('shop_activity')->find($gid);
            $goods['posters'] = $goods['posters']?explode(',', $goods['posters']):array();
            $this->assign('data',$goods);
        }
        $shops = M('compare_shops')->field('sid,sname')->limit(0,100)->select();
        $this->assign('shops',$shops);
        $this->display();
    }
    
    public function delactivity() {
        M('shop_activity')->where(array('aid' => I('aid')))->delete();
        //删除关联数据
        $this->ajaxReturn(array('status'=>0,'msg'=>'操作成功'));
    }
    
}
