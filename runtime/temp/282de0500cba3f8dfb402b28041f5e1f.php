<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:80:"D:\xy\project\shequshop\public/../application/admin\view\banner\edit_banner.html";i:1560737525;}*/ ?>


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
        <label class="layui-form-label">排序</label>
        <div class="layui-input-block">
            <input type="number" name="order"  lay-verify="required" placeholder="请输入"  value="<?php echo $data['order']; ?>" autocomplete="off" class="layui-input">
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">显示状态</label>
        <div class="layui-input-block">
            <input type="checkbox" name="display" <?php if($data['display']==1): ?>checked<?php endif; ?> lay-skin="switch" lay-text="显示|隐藏">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">更改图片</label>
        <div class="layui-input-block">
            <button type="button" class="layui-btn" id="upload1s">点我</button>
            <input type="hidden" id="img_urls" name="imgs" value="<?php echo $data['imgs']; ?>"/>
            <div class="layui-upload-list">
                <img src="<?php echo $data['imgs']; ?>" class="layui-upload-img"style="width: 200px;height:12rem" id="demo2" alt=""/>
                <p id="demoTexts"></p>
            </div>
        </div>
    </div>
    <div class="layui-form-item layui-hide">
        <button class="layui-btn" lay-submit lay-filter="edit" id="edit">提交</button>
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