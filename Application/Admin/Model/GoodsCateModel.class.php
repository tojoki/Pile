<?php
namespace Admin\Model;
use Think\Model;
class GoodsCateModel extends CommonModel{
    protected $pk   = 'cat_id';
    protected $tableName =  'shop_category';
    protected $token = 'category';
   
    public function getAdminName($user){
        $data = $this->find(array('where'=>array('user'=>$user)));
        return $this->_format($data);
    }

    public function getCate($field = '*'){
       
    }

    


}
