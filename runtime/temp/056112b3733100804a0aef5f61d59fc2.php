<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:84:"D:\xy\project\shequshop\public/../application/admin\view\order\order_wuliu_edit.html";i:1564470513;}*/ ?>


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
        <label class="layui-form-label">请输入快递单号</label>
        <div class="layui-input-inline">
            <input type="hidden" name="id" value="<?php echo $wuliu['id']; ?>">
            <input type="text" name="wuliu_order" lay-verify="required" placeholder=请输入正确的物流单号 value="<?php echo $wuliu['wuliu_order']; ?>"  autocomplete="off" class="layui-input">
        </div>
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
    }).use(['index', 'form','hhtc'], function(){
        var $ = layui.$
            ,hhtc=layui.hhtc
            ,form = layui.form ;
        $("#upload1s").click(function(){
            hhtc.upload_one(function(res){
                $("input[name='imgs']").val(res);
                $("#demo2").attr('src',res);
            })
        })
    })
</script>
</body>
</html>