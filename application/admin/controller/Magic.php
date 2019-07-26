<?php
namespace app\admin\controller;

use app\admin\model\MagicModel;
use app\admin\model\SubjectModel;
use think\Request;

class Magic extends Base
{

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->magic=new MagicModel();
        $this->subject=new SubjectModel();
    }
    public function magic(){
        $magic=$this->magic->onedata();
        $magic['magic']=json_decode($magic['magic'],true);
        $this->assign('magic',$magic);
        return $this->fetch('magic');
    }
    /**
     * 添加或修改图片
     */
    public function edit(Request $request){
       $param=$request->param();
       $param['magic']=json_encode($param['magic']);
       $param['magic_img']=$this->nowUrl().'/hero_gam.png';
       if(empty($param['id'])){
           $data=$this->magic->add($param);
           return $data?['code'=>0,'msg'=>'添加成功','data'=>$data]:['code'=>1,'msg'=>'添加失败','data'=>$data];
       }else{
           $data=$this->magic->edit($param);
           return $data?['code'=>0,'msg'=>'修改成功','data'=>$data]:['code'=>1,'msg'=>'修改失败','data'=>$data];
       }

    }
    public function images(Request $request){
        $param=$request->param();
        $magic=$param['magic'];
        $this->MergePictures($magic);
        return ['code'=>0,'msg'=>'生成中',''];
    }
    function MergePictures($pic_list){
        $pic_list = array_slice($pic_list, 0, 9); // 只操作前9个图片
        $bg_w = 640; // 背景图片宽度
        $bg_h = 320; // 背景图片高度
        $background = imagecreatetruecolor($bg_w,$bg_h); // 背景图片
        $color = imagecolorallocate($background, 202, 201, 201); // 为真彩色画布创建白色背景，再设置为透明
        imagefill($background, 0, 0, $color);
        imageColorTransparent($background, $color);

        $pic_count = count($pic_list);
        $lineArr = array(); // 需要换行的位置
        $space_x = 3;
        $space_y = 3;
        $line_x = 0;
        switch($pic_count) {
            case 1: // 正中间
                $start_x = intval(0); // 开始位置X
                $start_y = intval(0); // 开始位置Y
                $pic_w = intval($bg_w); // 宽度
                $pic_h = intval($bg_h); // 高度
                break;
            case 2: // 中间位置并排
                $start_x = intval(0); // 开始位置X
                $start_y = intval(0); // 开始位置Y
                $pic_w = intval($bg_w/2); // 宽度
                $pic_h = intval($bg_h); // 高度
                break;
            case 3:
                $start_x = intval(0); // 开始位置X
                $start_y = intval(0); // 开始位置Y
                $pic_w = intval($bg_w/2); // 宽度
                $pic_h = intval($bg_h/2);// 高度
                $line_x = 5;
                break;
            case 4:
                $start_x = intval(0); // 开始位置X
                $start_y = intval(0); // 开始位置Y
                $pic_w = intval($bg_w/2) - 5; // 宽度
                $pic_h = intval($bg_h/2) - 5; // 高度
                $line_x = 4;
                break;
        }
        foreach( $pic_list as $k=>$pic_path ) {
            if(count($pic_list)>=3){

                if($k==0){
                    $pic_w = intval($bg_w/2); // 宽度
                    $pic_h = intval($bg_h);// 高度
                    $kk = $k + 1;
                    if ( in_array($kk, $lineArr) ) {
                        $start_x = $line_x;
                        $start_y = $start_y + $pic_h + $space_y;
                    }
                }else if($k==1){
                    $pic_w = intval($bg_w/2); // 宽度
                    $pic_h = intval($bg_h/2);// 高度
                    $kk = $k + 1;
                    if ( in_array($kk, $lineArr) ) {
                        $start_x = $line_x;
                        $start_y = $start_y + $pic_h + $space_y;
                    }
                }
                else if($k==2){

                    $pic_h = intval($bg_h/2);// 高度
                    $start_y=$pic_h;
                    if(count($pic_list)==3){
                        $pic_w = intval($bg_w/2); // 宽度
                        $start_x=$pic_w;
                    }else if(count($pic_list)==4){
                        $pic_w = intval($bg_w/4); // 宽度
                        $start_x=intval($bg_w/2);
                    }
                }else if($k==3){
                    $pic_w = intval($bg_w/4); // 宽度
                    $pic_h = intval($bg_h/2);// 高度
                    $start_x=$bg_w-$pic_w;
                    $start_y=$pic_h;
                }
            }

            $pathInfo = pathinfo($pic_path);
            switch( strtolower($pathInfo['extension']) ) {
                case 'jpg':
                case 'jpeg':
                    $imagecreatefromjpeg = 'imagecreatefromjpeg';
                    break;
                case 'png':
                    $imagecreatefromjpeg = 'imagecreatefrompng';
                    break;
                case 'gif':
                default:
                    $imagecreatefromjpeg = 'imagecreatefromstring';
                    $pic_path = file_get_contents($pic_path);
                    break;
            }
            $resource = $imagecreatefromjpeg($pic_path);
            // $start_x,$start_y copy图片在背景中的位置
            // 0,0 被copy图片的位置imagecreatefrompng
            // $pic_w,$pic_h copy后的高度和宽度

            imagecopyresized($background,$resource,$start_x,$start_y,0,0,$pic_w,$pic_h,imagesx($resource),imagesy($resource)); // 最后两个参数为原始图片宽度和高度，倒数两个参数为copy时的图片宽度和高度
            $start_x = $start_x + $pic_w + $space_x;
        }
        header("Content-type: image/gif");
        imagepng($background, "./hero_gam.png");
        imagedestroy($background);
    }
    public function nowUrl(){
        $host = ($this->isHTTPS() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']; //获取域名
        return $host;
    }
    public function isHTTPS()
    {
        if (defined('HTTPS') && HTTPS) return true;
        if (!isset($_SERVER)) return FALSE;
        if (!isset($_SERVER['HTTPS'])) return FALSE;
        if ($_SERVER['HTTPS'] === 1) {  //Apache
            return TRUE;
        } elseif ($_SERVER['HTTPS'] === 'on') { //IIS
            return TRUE;
        } elseif ($_SERVER['SERVER_PORT'] == 443) { //其他
            return TRUE;
        }
        return FALSE;
    }


}