<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"D:\xy\project\shequshop\public/../application/admin\view\good\good_add.html";i:1561602047;}*/ ?>

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
            <input type="text"  name="name"  lay-verify="required" value="<?php echo $data['name']; ?>" autocomplete="off" class="layui-input" readonly="readonly">
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">联系人</label>
        <div class="layui-input-inline">
            <input type="text" name="contacts" lay-verify="required"   value="<?php echo $data['contacts']; ?>"  autocomplete="off" class="layui-input" readonly="readonly">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">联系人方式</label>
        <div class="layui-input-inline">
            <input type="text" name="tel" lay-verify="required"   value="<?php echo $data['tel']; ?>"  autocomplete="off" class="layui-input" readonly="readonly">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">详细地址</label>
        <div class="layui-input-inline">
            <input type="text" name="address" lay-verify="required" value="<?php echo $data['address']; ?>" autocomplete="off" class="layui-input" readonly="readonly">

        </div>
        <div class="layui-form-mid layui-word-aux">请确认地址，地址的准确直接影响到经纬度</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">入驻时间</label>
        <div class="layui-input-inline">
            <input type="text" name="date" lay-verify="required"  value="<?php echo $data['date']; ?>" autocomplete="off" class="layui-input" readonly="readonly">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">商户头像</label>
        <div class="layui-upload-list">
            <img src="<?php echo $data['pic']; ?>"  class="layui-upload-img" style="width: 200px;height:12rem;"   id="demo10" alt=""/>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">商户背景图</label>
        <div class="layui-upload-list">
            <img src="<?php echo $data['pic_bg']; ?>"  class="layui-upload-img" style="width: 200px;height:12rem;"   id="demo10" alt=""/>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">商户介绍</label>
        <div class="layui-input-block">
            <textarea   name="detail" class="layui-textarea" readonly="readonly"><?php echo $data['detail']; ?></textarea>
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
    })

</script>
</body>
</html>