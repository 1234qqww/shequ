<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:91:"D:\xy\project\shequshop\public/../application/admin\view\commodity\commodity_jifen_add.html";i:1565678584;}*/ ?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>添加分类</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css" media="all">
</head>
<body>

<div class="layui-form" lay-filter="layuiadmin-form-role" id="layuiadmin-form-role" style="padding: 20px 30px 0 0;">
    <div class="layui-form-item">
        <label class="layui-form-label">分类名称</label>
        <div class="layui-input-inline">
            <input type="text"  name="name"  lay-verify="required" value="" autocomplete="off" class="layui-input" >
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-inline">
            <input type="number" name="order" lay-verify="required" value="" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux">数字越小排序越靠前</div>
    </div>


    <div class="layui-form-item">
        <label class="layui-form-label">是否显示</label>
        <div class="layui-input-block">
            <input type="checkbox" name="is_show"  lay-skin="switch" lay-text="是|否">
        </div>
    </div>

    <div class="layui-form-item layui-hide">
        <button class="layui-btn" lay-submit lay-filter="add" id="add">提交</button>
    </div>
</div>
<script src="/static/admin/layui/layui.js"></script>
<script src="/static/admin/js/app.js"></script>
<script>
    layui.config({
        base: '/static/admin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'form','hhtc'], function(){
        var $ = layui.$
            ,form = layui.form
            ,hhtc=layui.hhtc

    })

</script>
</body>
</html>