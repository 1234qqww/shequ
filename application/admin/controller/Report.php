<?php
namespace app\admin\controller;

use think\Controller;

class Report extends Controller
{
    public function Report(){
        return $this->fetch('index');
    }
}