<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"D:\xy\project\shequshop\public/../application/admin\view\system\qudao.html";i:1563007390;}*/ ?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>网站设置</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/admin/style/admin.css" media="all">
</head>
<body>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">小程序设置</div>
                <div class="layui-card-body" pad15>
                    <div class="layui-form" wid100 lay-filter="">
                        <div class="layui-form-item">
                            <label class="layui-form-label">AppID</label>
                            <div class="layui-input-block">
                                <input type="hidden" name="configname" value="qudao">
                                <textarea name="appid" class="layui-textarea"><?php echo config('qudao.appid'); ?></textarea>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">AppSecre</label>
                            <div class="layui-input-block">

                                <textarea name="appsecret" class="layui-textarea"><?php echo config('qudao.appsecret'); ?></textarea>
                            </div>
                        </div>
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit lay-filter="set_website">确认保存</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script src="/static/admin/layui/layui.js"></script>
<script src="/static/admin/js/app.js"></script>
<script>
    layui.config({
        base: '/static/admin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index','form'],function(){
        var $=layui.$
            ,form = layui.form
        form.render();
        form.on('submit(set_website)',function(obj){
            var result=ajax_post($,'',obj.field);
            if(result.code==1){
                layer.msg(result.msg,{icon:1});
            }else{
                layer.alert(result.msg,{icon:2})
            }
        })
    });
</script>
</body>
</html>