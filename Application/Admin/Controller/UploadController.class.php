<?php

namespace Admin\Controller;
use Think\Controller;

class UploadController extends Controller {
    public function editor() {
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型     
        $upload->savePath  = '/images/';
        $info=$upload->upload();
        echo json_encode( array( 
         'url'=>$info['upfile']['savepath'].'/'.$info['upfile']['savename'],                           
         'original'=>$info['upfile']['savepath'].'/'.$info['upfile']['savename'],       
         'state'=>'SUCCESS',       
        ));      
    }

    public function upload() {
        $upload = new \Think\Upload();// 实例化上传类
        $key = array_shift(array_keys($_FILES));
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型     
        $upload->savePath = '/images/';
        $info=$upload->upload();
        echo $info[$key]['savepath'].''.$info[$key]['savename']; 
    }

    public function uploadFile() {
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     31457280 ;// 设置附件上传大小
        $upload->exts      =     array('apk');// 设置附件上传类型     
        $upload->savePath = '/app/';
        $info=$upload->upload();
        echo $info['Filedata']['savepath'].''.$info['Filedata']['savename']; 
    }

    public function uploadvideo() {
      $upload = new \Think\Upload();// 实例化上传类
      $upload->maxSize   =     31457280 ;// 设置附件上传大小
      $upload->exts      =     array('mp4');// 设置附件上传类型     
      $upload->savePath = '/video/';
      $info=$upload->upload();   
      $key = array_shift(array_keys($_FILES));
      echo '/Uploads'.$info[$key]['savepath'].''.$info[$key]['savename'];
    }

    public function uploaduserimg() {
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型     
        $upload->savePath = '/userimg/';
        $info=$upload->upload();   
        echo $info['Filedata']['savepath'].''.$info['Filedata']['savename']; 
    }


}
