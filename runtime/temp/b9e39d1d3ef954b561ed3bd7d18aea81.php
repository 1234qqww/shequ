<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:79:"D:\xy\project\wuliu\public/../application/admin\view\merchant\add_merchant.html";i:1561099528;}*/ ?>


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
        var defaults = {
            s1: 'prov',
            s2: 'city',
            s3: 'area',
            v1: null,
            v2: null,
            v3: null,
        };
        var defaultss = {
            s1: 'provs',
            s2: 'citys',
            s3: 'areas',
            v1: null,
            v2: null,
            v3: null,
        };
        // var defaults = {
        //     s1: 'provid',
        //     s2: 'cityid',
        //     s3: 'areaid',
        //     v1: null,
        //     v2: null,
        //     v3: null
        // };


    </script>
</head>
<body>
<div class="layui-form" lay-filter="layuiadmin-form-role" id="layuiadmin-form-role" style="padding: 20px 30px 0 0;" >
    <div class="layui-form-item">
        <label class="layui-form-label">商户头像</label>
        <div class="layui-input-block">
            <button type="button" class="layui-btn" id="touxiang"><i class="layui-icon"></i>点我</button>
            <input type="hidden" id="img_urls" name="merportrait" value=""/>
            <div class="layui-upload-list">
                <img src=""  class="layui-upload-img" style="width: 200px;height:12rem;display: none"   id="demo1" alt=""/>
                <p id="demoTexts"></p>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">商户背景图</label>
        <div class="layui-input-block">
            <button type="button" class="layui-btn" id="beijing"><i class="layui-icon"></i>点我</button>
            <input type="hidden" id="beijings" name="beijing" value=""/>
            <div class="layui-upload-list">
                <img src=""  class="layui-upload-img" style="width: 200px;height:12rem;display: none"   id="demo10" alt=""/>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">商户名</label>
        <div class="layui-input-inline">
            <input type="text" name="mername" lay-verify="required" placeholder=请输入商户名   autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">联系人</label>
        <div class="layui-input-inline">
            <input type="text" name="contacts" lay-verify="required" placeholder=请输入联系人   autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">电话</label>
        <div class="layui-input-inline">
            <input type="text" name="telephone" lay-verify="required" placeholder=请输入电话   autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">手机</label>
        <div class="layui-input-inline">
            <input type="text" name="mobile" lay-verify="required" placeholder=请输入手机号   autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">始发地</label>
        <div class="layui-input-inline">
            <select name="prov" id="prov" lay-filter="prov">
                <option value="">请选择省</option>
            </select>
        </div>
        <div class="layui-input-inline">
            <select name="city" id="city" lay-filter="city">
                <option value="">请选择市</option>
            </select>
        </div>
        <div class="layui-input-inline">
            <select name="area" id="area" lay-filter="area">
                <option value="">请选择县/区</option>
            </select>
        </div>
        <div class="layui-input-inline">
            <input type="text" name="address" lay-verify="required" placeholder=请输入始发地详细地址  autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">直达路线</label>
        <div class="layui-input-inline">
            <input type="text" name="setout" lay-verify="required" placeholder=请输入起点如成都   autocomplete="off" class="layui-input">
        </div>
        <div class="layui-input-inline">
            <input type="text" name="arrive" lay-verify="required" placeholder=请输入终点如上海   autocomplete="off" class="layui-input">
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
            <input type="text" name="addresss" lay-verify="required" placeholder=请输入卸货地详细地址  autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">卸货联系人</label>
        <div class="layui-input-inline">
            <input type="text" name="xhcontacts" lay-verify="required" placeholder=请输入卸货联系人 autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">卸货联系人电话</label>
        <div class="layui-input-inline">
            <input type="text" name="xhtelephone" lay-verify="required" placeholder=请输入卸货联系人电话   autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">卸货联系人手机</label>
        <div class="layui-input-inline">
            <input type="text" name="xhmobile" lay-verify="required" placeholder=请输入卸货联系人手机号   autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" >辐射区域</label>
        <div class="layui-input-inline" >
            <input type="text" name="route[]"  placeholder="请输出辐射区域" class="layui-input" >
            <button type="button"  class="layui-btn layui-btn-danger" style="position: absolute;left: 195px;top: 0px;" ><i class="layui-icon">&#xe654;</i></button>
        </div>
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">简介</label>
        <div class="layui-input-block">
            <textarea placeholder="请输入商户简介" class="layui-textarea" name="brief"></textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" >认证资质</label>
        <div class="layui-input-block">
            <button type="button" class="layui-btn" id="upload1s" ><i class="layui-icon"></i>上传</button>
            <div class="layui-upload-list" id="demo2"></div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" >店内实景</label>
        <div class="layui-input-block">
            <button type="button" class="layui-btn" id="upload" ><i class="layui-icon"></i>上传</button>
            <div class="layui-upload-list" id="demo3"></div>
        </div>
    </div>
    <div class="layui-form-item layui-hide">
        <button class="layui-btn" lay-submit lay-filter="add" id="add">上传</button>
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
        });
        $('#beijing').click(function () {
            hhtc.upload_one(function(res){
                $("input[name='beijing']").val(res);
                $('#demo10').show();
                $("#demo10").attr('src',res);
            })
        })
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