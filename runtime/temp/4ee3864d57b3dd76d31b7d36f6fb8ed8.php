<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"D:\xy\project\shequshop\public/../application/admin\view\system\qudao.html";i:1564985513;}*/ ?>


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
                                <input name="appid" id="appid" placeholder="请配置小程序appid" type="text" class="layui-input"
                                       lay-verType="tips" lay-verify="required" value="<?php echo config('qudao.appid'); ?>" required/>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">AppSecre</label>
                            <div class="layui-input-block">
                                <input name="appsecret" id="appsecret" placeholder="请配置小程序秘钥" type="text" class="layui-input"
                                       lay-verType="tips" lay-verify="required" value="<?php echo config('qudao.appsecret'); ?>" required/>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">mchid</label>
                            <div class="layui-input-block">
                                <input name="mchid" id="mchid" placeholder="请配置商户号" type="text" class="layui-input"
                                       lay-verType="tips" lay-verify="required" value="<?php echo config('qudao.mchid'); ?>" required/>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">Secret</label>
                            <div class="layui-input-block">
                                <input name="secret" id="secret" placeholder="请配置商户秘钥" type="text" class="layui-input"
                                       lay-verType="tips" lay-verify="required" value="<?php echo config('qudao.secret'); ?>" required/>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">双向证书</label>
                            <button type="button" class="layui-btn" id="test3"><i class="layui-icon"></i>上传文件</button>
                            <input type="text" hidden id="autograph" name="autograph" value="<?php echo config('qudao.autograph'); ?>">
                            <div style="display:inline;margin-left:10px">apiclient_key.pem</div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">双向证书</label>
                            <button type="button" class="layui-btn" id="test4"><i class="layui-icon"></i>上传文件</button>
                            <input type="text" hidden id="templatecode" name="templatecode" value="<?php echo config('qudao.templatecode'); ?>">
                            <div style="display:inline;margin-left:10px">apiclient_cert.pem</div>
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
    //单图上传
    layui.use('upload', function(){
        var $ = layui.jquery
            ,upload = layui.upload;
        //添加驾驶证配图
        //添加驾驶证配图
        upload.render({
            elem: '#test3'
            ,url: "<?php echo url('subject/updates'); ?>"
            ,accept: 'file' //普通文件
            ,done: function(res){
            $('#autograph').val(res.url)
            layer.msg('上传成功')
        }
    });
        upload.render({
            elem: '#test4'
            ,url: "<?php echo url('subject/updates'); ?>"
            ,accept: 'file' //普通文件
            ,done: function(res){
            $('#templatecode').val(res.url)
            layer.msg('上传成功')
        }
    });
        var uploadInst = upload.render({
            elem: '#test1'
            ,url: "{<?php echo url("","",true,false);?>}"
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    $('#demo1').attr('src', result); //图片链接（base64）
                });
            }
            ,done: function(res){
                $("input[name='logo']").val(res.url);
            }
        });
    })
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