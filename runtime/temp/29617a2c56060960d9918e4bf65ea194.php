<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"D:\xy\project\shequshop\public/../application/admin\view\banner\banner.html";i:1561097855;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>首页背景设置</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/admin/style/admin.css" media="all">
</head>
<body>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md6">
        <div class="layui-card">
            <div class="layui-card-header">我的页面广告设置</div>
            <div class="layui-card-body" pad15>
                <div class="layui-form" wid100 lay-filter="">
                    <div class="layui-form-item">
                        <label class="layui-form-label"></label>
                        <div class="layui-input-block">
                            <button type="button" class="layui-btn" id="upload1s">上传图片</button>
                            <input type="hidden" id="img_urls" name="bannerimg"
                                   value="<?php echo config('banner_config.bannerimg'); ?>"/>
                            <input type="hidden" name="configname" value="banner_config"/>
                            <div class="layui-upload-list">
                                <img src="<?php echo config('banner_config.bannerimg'); ?>" class="layui-upload-img"
                                     width="400px" height="200px" id="demo2" alt=""/>
                                <p id="demoTexts"></p>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit lay-filter="set_banner">确认保存</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="layui-col-md6">
            <div class="layui-card">
                <div class="layui-card-header">商家页面广告设置</div>
                <div class="layui-card-body" pad15>
                    <div class="layui-form" wid100 lay-filter="">
                        <div class="layui-form-item">
                            <label class="layui-form-label"></label>
                            <div class="layui-input-block">
                                <button type="button" class="layui-btn" id="upload1ss">上传图片</button>
                                <input type="hidden" id="img_urlss" name="bannerimg" value="<?php echo config('zhuanxian_config.bannerimg'); ?>"/>
                                <input type="hidden" name="configname" value="zhuanxian_config"/>
                                <div class="layui-upload-list">
                                    <img src="<?php echo config('zhuanxian_config.bannerimg'); ?>" class="layui-upload-img"
                                         width="400px" height="200px" id="demo1" alt=""/>

                                </div>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button class="layui-btn" lay-submit lay-filter="set_zhuanxian">确认保存</button>
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
<script src="/static/js/jquery.js" type="text/javascript" charset="utf-8"></script>
<script>
    var $ = false;
    layui.config({
        base: '/static/admin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'form', "upload", 'hhtc'], function () {
        var $ = layui.$
                , form = layui.form
                , upload = layui.upload
                , hhtc = layui.hhtc;
        $ = layui.jquery;

        $('#upload1s').click(function () {

            hhtc.upload_one(function (obj) {
                document.getElementById("img_urls").value = obj;
                $('#demo2').attr('src', obj);
            })
        });
        $('#upload1ss').click(function () {

            hhtc.upload_one(function (obj) {
                document.getElementById("img_urlss").value = obj;
                $('#demo1').attr('src', obj);
            })
        });



        form.render();
        //背景图
        form.on('submit(set_banner)', function (obj) {
            var result = ajax_post($, 'banner', obj.field);
            if (result.code == 1) {
                layer.msg(result.msg, {icon: 1}, function () {
                    location.reload();
                });
            } else {
                layer.alert(result.msg, {icon: 2})
            }
        });

        form.on('submit(set_zhuanxian)', function (obj) {
            var result = ajax_post($, 'zhuanxian', obj.field);
            if (result.code == 1) {
                layer.msg(result.msg, {icon: 1}, function () {
                    location.reload();
                });
            } else {
                layer.alert(result.msg, {icon: 2})
            }
        });


    });
</script>
</body>
</html>