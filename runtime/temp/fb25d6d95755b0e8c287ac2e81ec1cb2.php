<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:80:"D:\xy\project\wuliu\public/../application/admin\view\merchant\edit_merchant.html";i:1561104970;}*/ ?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layuiAdmin 角色管理 iframe 框</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css" media="all">
    <script src="/static/js/jquery.js"></script>
    <script src="/static/admin/layui/layui.js"></script>
    <script type="text/javascript" src="/static/admin/layui/data.js"></script>
    <script type="text/javascript" src="/static/admin/layui/province.js"></script>
    <script type="text/javascript">
        var arr='<?php  echo json_encode($merchant,true) ?>';
        var nav=JSON.parse(arr);

        var defaults = {
            s1: 'prov',
            s2: 'city',
            s3: 'area',
            v1: nav.prov,
            v2: nav.city,
            v3: nav.area,
        };
        var defaultss = {
            s1: 'provs',
            s2: 'citys',
            s3: 'areas',
            v1: nav.provs,
            v2: nav.citys,
            v3: nav.areas,
        };

    </script>
</head>
<body>
<div class="layui-form" lay-filter="layuiadmin-form-role" id="layuiadmin-form-role" style="padding: 20px 30px 0 0;" >
    <div class="layui-form-item">
        <label class="layui-form-label">商户头像</label>
        <div class="layui-input-block">
            <button type="button" class="layui-btn" id="touxiang"><i class="layui-icon"></i>点我</button>
            <input type="hidden" id="img_urls" name="merportrait" value="<?php echo $merchant['merportrait']; ?>"/>
            <div class="layui-upload-list">
                <img src="<?php echo $merchant['merportrait']; ?>"  class="layui-upload-img" style="width: 200px;height:12rem"   id="demo1" alt=""/>
                <p id="demoTexts"></p>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">商户背景图</label>
        <div class="layui-input-block">
            <button type="button" class="layui-btn" id="beijing"><i class="layui-icon"></i>点我</button>
            <input type="hidden" id="beijings" name="beijing" value="<?php echo $merchant['beijing']; ?>"/>
            <div class="layui-upload-list">
                <img src="<?php echo $merchant['beijing']; ?>"  class="layui-upload-img" style="width: 200px;height:12rem;"   id="demo10" alt=""/>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">商户名</label>
        <div class="layui-input-inline">
            <input type="text" name="mername"  value="<?php echo $merchant['mername']; ?>" lay-verify="required" placeholder=请输入商户名   autocomplete="off" class="layui-input">
            <input type="hidden" name="id" value="<?php echo $merchant['id']; ?>">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">联系人</label>
        <div class="layui-input-inline">
            <input type="text" name="contacts" lay-verify="required" value="<?php echo $merchant['contacts']; ?>" placeholder=请输入联系人   autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">电话</label>
        <div class="layui-input-inline">
            <input type="text" name="telephone" lay-verify="required" placeholder=请输入电话  value="<?php echo $merchant['telephone']; ?>" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">手机</label>
        <div class="layui-input-inline">
            <input type="text" name="mobile" lay-verify="required" placeholder=请输入手机号  value="<?php echo $merchant['mobile']; ?>" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">始发地</label>
        <div class="layui-input-inline">
            <select name="prov" id="prov" lay-filter="prov">
                <option value=""></option>
            </select>
        </div>
        <div class="layui-input-inline">
            <select name="city" id="city" lay-filter="city">
                <option value="<?php echo $merchant['city']; ?>"></option>
            </select>
        </div>
        <div class="layui-input-inline">
            <select name="area" id="area" lay-filter="area">
                <option value=""></option>
            </select>
        </div>
        <div class="layui-input-inline">
            <input type="text" name="address" lay-verify="required" placeholder=请输入始发地详细地址 value="<?php echo $merchant['address']; ?>" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">直达路线</label>
        <div class="layui-input-inline">
            <input type="text" name="setout" lay-verify="required" placeholder=请输入起点如成都  value="<?php echo $merchant['setout']; ?>"  autocomplete="off" class="layui-input">
        </div>
        <div class="layui-input-inline">
            <input type="text" name="arrive" lay-verify="required" placeholder=请输入终点如上海 value="<?php echo $merchant['arrive']; ?>"   autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">卸货地</label>
        <div class="layui-input-inline">
            <select name="provs" id="provs" lay-filter="provs">
                <option value="">请选择省</option>
            </select>
        </div>
        <div class="layui-input-inline">
            <select name="citys" id="citys" lay-filter="citys">
                <option value="">请选择市</option>
            </select>
        </div>
        <div class="layui-input-inline">
            <select name="areas" id="areas" lay-filter="areas">
                <option value="">请选择县/区</option>
            </select>
        </div>
        <div class="layui-input-inline">
            <input type="text" name="addresss" lay-verify="required" placeholder=请输入卸货地详细地址 value="<?php echo $merchant['addresss']; ?>" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">卸货联系人</label>
        <div class="layui-input-inline">
            <input type="text" name="xhcontacts" lay-verify="required" placeholder=请输入卸货联系人 value="<?php echo $merchant['xhcontacts']; ?>" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">卸货联系人电话</label>
        <div class="layui-input-inline">
            <input type="text" name="xhtelephone" lay-verify="required" placeholder=请输入卸货联系人电话  value="<?php echo $merchant['xhtelephone']; ?>" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">卸货联系人手机</label>
        <div class="layui-input-inline">
            <input type="text" name="xhmobile" lay-verify="required" placeholder=请输入卸货联系人手机号  value="<?php echo $merchant['xhmobile']; ?>"  autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" >辐射区域</label>
        <div class="layui-input-inline" >
            <?php if(is_array($merchant['route']) || $merchant['route'] instanceof \think\Collection || $merchant['route'] instanceof \think\Paginator): $i = 0; $__LIST__ = $merchant['route'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <input type="text" name="route[]"  value="<?php echo $vo; ?>" placeholder="请输出辐射区域" class="layui-input" >
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <button type="button"  class="layui-btn layui-btn-danger" style="position: absolute;left: 195px;top: 0px;" ><i class="layui-icon">&#xe654;</i></button>
        </div>
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">简介</label>
        <div class="layui-input-block">
            <textarea placeholder="请输入商户简介" class="layui-textarea" name="brief"><?php echo $merchant['brief']; ?></textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" >认证资质</label>
        <div class="layui-input-block">
            <button type="button" class="layui-btn" id="upload1s" ><i class="layui-icon"></i>上传</button>
            <div class="layui-upload-list" id="demo2">
                <?php if(is_array($authent) || $authent instanceof \think\Collection || $authent instanceof \think\Paginator): $i = 0; $__LIST__ = $authent;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$au): $mod = ($i % 2 );++$i;?>
                    <div class="file_son" style="display: inline-block">
                        <img src="<?php echo $au['autuimg']; ?>" style="width: 200px;height:12rem" >
                        <input type="hidden" name="autuimg[]" value="<?php echo $au['autuimg']; ?>"/>
                        <div class="filecaoBox" onclick="dede(this)" style="color: #CF1900;width: 30px;height: 30px;float: right">
                            <i class="layui-icon layui-icon-delete" ></i>
                        </div>
                    </div>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" >店内实景</label>
        <div class="layui-input-block">
            <button type="button" class="layui-btn" id="upload" ><i class="layui-icon"></i>上传</button>
            <div class="layui-upload-list" id="demo3">
                <?php if(is_array($fact) || $fact instanceof \think\Collection || $fact instanceof \think\Paginator): $i = 0; $__LIST__ = $fact;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$fa): $mod = ($i % 2 );++$i;?>
                <div class="file_son" style="display: inline-block">
                    <img src="<?php echo $fa['factimg']; ?>" style="width: 200px;height:12rem" >
                    <input type="hidden" name="factimg[]" value="<?php echo $fa['factimg']; ?>"/>
                    <div class="filecaoBox" onclick="dede(this)" style="color: #CF1900;width: 30px;height: 30px;float: right">
                        <i class="layui-icon layui-icon-delete" ></i>
                    </div>
                </div>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
    </div>
    <div class="layui-form-item layui-hide">
        <button class="layui-btn" lay-submit lay-filter="edit" id="edit">确认</button>
    </div>
</div>
<script>
    layui.config({
        base: '/static/admin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'form','hhtc'], function(){
        var $ = layui.$
            ,hhtc=layui.hhtc
            ,form = layui.form ;
        //认证图片
        $("#upload1s").click(function(){
            hhtc.upload_one(function(res){
                $('#demo2').append('<div class="file_son" style="display: inline-block">' +
                    '<img src="'+ res +'" style="width: 200px;height:12rem">' +
                    '<input type="hidden" name="autuimg[]" value="'+res+'"/>' +
                    ' <div onclick="dede(this)" class="filecaoBox" style="color: #CF1900;width: 30px;height: 30px;float: right">' +
                    '<i class="layui-icon layui-icon-delete" ></i></div></div>')
            })
        });
        //公司实景
        $('#upload').click(function () {
            hhtc.upload_one(function(res){
                $('#demo3').append('<div class="file_son" style="display: inline-block">' +
                    '<img src="'+ res +'" style="width: 200px;height:12rem"><input type="hidden" name="factimg[]" value="'+res+'"/>' +
                    '<div  onclick="dede(this)" class="filecaoBox"  style="color: #CF1900;width: 30px;height: 30px;float: right">' +
                    '<i class="layui-icon layui-icon-delete" ></i>' +
                    '</div>' +
                    '</div>')
            })
        });
        //商户头像
        $("#touxiang").click(function(){
            hhtc.upload_one(function(res){
                $("input[name='merportrait']").val(res);
                $('#demo1').show();
                $("#demo1").attr('src',res);
            })
        })
       //  //删除图片
       // $('.filecaoBox').click(function () {
       //
       //     console.log('111');
       //
       // })


    })
</script>
<script>

    $('.layui-btn-danger').on('click',function () {
        var name = $(this).prev().attr("name");
        // console.log(name);
        $(this).parent().append(
            "<div style='margin-top: 10px;position: relative;'><input type='text' name='"+name+"'  placeholder='请输出辐射区域'  class='layui-input' style=''>" +
            " " +
            "<button type='button'  style='position: absolute;left: 195px;top: 0px;' class='input-delete layui-btn layui-btn-danger '   onclick='deltr(this)'><i class='layui-icon'>&#x1006;</i></button></div>" +
            "")
    });

    function deltr(delbtn) {
        $(delbtn).prev('input').remove();
        $(delbtn).remove();
    }
    function dede(dede) {
        $(dede).parents('.file_son').remove();
    }


</script>
</body>
</html>