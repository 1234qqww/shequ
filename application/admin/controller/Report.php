<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
class Admin extends Base
{
    public function _initialize(){
        parent::_initialize();
    }
    public function index()
    {
        return $this->fetch();
    }


}
