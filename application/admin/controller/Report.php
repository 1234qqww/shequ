<?php
namespace app\admin\controller;

use think\Controller;

class Report extends Controller
{
    public function index(){
        return $this->fetch('index');
    }
}