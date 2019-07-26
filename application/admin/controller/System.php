<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
class System extends Base
{
    public function _initialize(){
        parent::_initialize();
        //初始化
        /*if(!session('admin')){
            $this->redirect('Login/login');
        }*/
    }
    public function setting(){
        if(request()->isAjax()){
            $file=$_SERVER['DOCUMENT_ROOT'].'/../application/extra/'.$_POST['configname'].'.php';
            if(!file_exists($file)){
                return $this->error('模板不存在!');
            }

            if(strpos($_POST['imgs'],'base64') !== false){
                $_POST['imgs']=base64toimg($_POST['imgs']);
            }
            if(strpos($_POST['pic_bg'],'base64') !== false){
                $_POST['pic_bg']=base64toimg($_POST['pic_bg']);
            }

            unset($_POST['configname']);
            $str="<?php \r\n return [ \r\n";
            foreach ($_POST as $k => $v) {
                if(is_array($v)){
                    $str.="'".$k."'=>[";
                    foreach($v as $a=>$b){
                        $str.="'".$a."'=>'".$b."',";
                    }
                    $str.="],";
                }else{
                    $str.="'".$k."'=>'".$v."',\r\n";
                }
            }
            $str.="];\r\n ?>";
            if(fwrite(fopen($file,'w'), $str)){
                return $this->success('编辑成功!');
            }else{
                return $this->error('编辑失败!');
            }
        }
        return $this->fetch();
    }
    //小程序设置
    public function qudao(){
        if(request()->isAjax()){
            $file=$_SERVER['DOCUMENT_ROOT'].'/../application/extra/'.$_POST['configname'].'.php';
            if(!file_exists($file)){
                return $this->error('模板不存在!');
            }
            unset($_POST['configname']);
            $str="<?php \r\n return [ \r\n";
            foreach ($_POST as $k => $v) {
                if(is_array($v)){
                    $str.="'".$k."'=>[";
                    foreach($v as $a=>$b){
                        $str.="'".$a."'=>'".$b."',";
                    }
                    $str.="],";
                }else{
                    $str.="'".$k."'=>'".$v."',\r\n";
                }
            }
            $str.="];\r\n ?>";
            if(fwrite(fopen($file,'w'), $str)){
                return $this->success('编辑成功!');
            }else{
                return $this->error('编辑失败!');
            }
        }

        return $this->fetch();
    }

}
