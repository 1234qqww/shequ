<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"D:\xy\project\shequshop\public/../application/admin\view\good\good_adds.html";i:1561628813;}*/ ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layuiAdmin 角色管理 iframe 框</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css" media="all">
</head>
<body>
<div class="layui-form" lay-filter="layuiadmin-form-role" id="layuiadmin-form-role" style="padding: 20px 30px 0 0;">
    <div class="layui-form-item">
        <label class="layui-form-label">商户名称</label>
        <div class="layui-input-inline">
            <input type="text"  name="name"  lay-verify="required" value="" autocomplete="off" class="layui-input" >
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">联系人</label>
        <div class="layui-input-inline">
            <input type="text" name="contacts" lay-verify="required"   value=""  autocomplete="off" class="layui-input" >
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">联系人方式</label>
        <div class="layui-input-inline">
            <input type="text" name="tel" lay-verify="required"   value=""  autocomplete="off" class="layui-input" >
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">详细地址</label>
        <div class="layui-input-inline">
            <input type="text" name="address" lay-verify="required" value="" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux">请确认地址，地址的准确直接影响到经纬度</div>
    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">入驻时间</label>
            <div class="layui-input-inline">
                <input type="text" name="date"  class="layui-input" id="test1" placeholder="yyyy-MM-dd">
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">商户商户头像</label>
        <div class="layui-input-block">
            <button type="button" class="layui-btn" id="pic"><i class="layui-icon"></i>点我</button>
            <input type="hidden" id="touxiang" name="pic" value=""/>
            <div class="layui-upload-list">
                <img src=""  class="layui-upload-img" style="width: 200px;height:12rem"   id="demo10" alt=""/>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">商户背景图</label>
        <div class="layui-input-block">
            <button type="button" class="layui-btn" id="pic_bg"><i class="layui-icon"></i>点我</button>
            <input type="hidden" id="beijing" name="pic_bg" value=""/>
            <div class="layui-upload-list">
                <img src=""  class="layui-upload-img" style="width: 200px;height:12rem"   id="demo1" alt=""/>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">商户介绍</label>
        <div class="layui-input-block">
            <textarea   name="detail" class="layui-textarea" ></textarea>
        </div>
    </div>
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
        <legend>账号信息</legend>
    </fieldset>

    <div class="layui-form-item">
        <label class="layui-form-label">账号</label>
        <div class="layui-input-inline">
            <input type="text" name="username" lay-verify="required" value="" autocomplete="off" class="layui-input" >

        </div>
        <div class="layui-form-mid layui-word-aux">用于商户登录后台</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">密码</label>
        <div class="layui-input-inline">
            <input type="text" name="password" lay-verify="required"  value="" autocomplete="off" class="layui-input">

        </div>
        <div class="layui-form-mid layui-word-aux">请填写6到12位密码</div>
    </div>
    <div class="layui-form-item layui-hide">
        <button class="layui-btn" lay-submit lay-filter="add" id="add">提交</button>
    </div>
</div>
<script src="/static/admin/layui/layui.js"></script>
<script>
    layui.config({
        base: '/static/admin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'form','hhtc','laydate'], function(){
        var laydate = layui.laydate;
        //常规用法
        laydate.render({
            elem: '#test1'
        });


        var $ = layui.$
            ,hhtc=layui.hhtc
            ,form = layui.form ;

        $('#pic').click(function () {
            hhtc.upload_one(function(res){
                $("input[name='pic']").val(res);
                $("#demo10").attr('src',res);
            })
        });

        $('#pic_bg').click(function () {
            hhtc.upload_one(function(res){
                $("#beijing").val(res);
                $("#demo1").attr('src',res);
            })
        })
    })

</script>
</body>
</html>