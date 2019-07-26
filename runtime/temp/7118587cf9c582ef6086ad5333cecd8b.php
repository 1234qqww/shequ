<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:79:"D:\xy\project\shequshop\public/../application/admin\view\subject\add_topic.html";i:1562836233;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>添加话题</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/easyweb/assets/libs/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/admin/style/admin.css" media="all">
    <script type="text/javascript" src="/static/admin/layui/layui.js"></script>
    <script type="text/javascript" src="/easyweb/assets//js/common.js?v=304"></script>
    <script type="text/javascript" src="/easyweb/assets/libs/jquery/jquery-3.2.1.min.js"></script>
    <script src="/static/js/jquery.js"></script>
    <style>
        .control-label {
            position: relative;
            height: 42px;
            line-height: 42px;
            border-bottom: 1px solid #f6f6f6;
            color: #333;
            border-radius: 2px 2px 0 0;
            font-size: 14px;
        }
        .controls input{
            height: 28px;
            line-height: 28px;
            padding: 0 10px;
            font-size: 12px;
            border-radius: 2px;
            cursor: pointer;
            white-space: nowrap;
            text-align: center;
            margin-right: 20px;
            border: 1px solid #e6e6e6;
        }
        .table-bordered {
            border: 1px solid #eceeef;
        }
        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
        }
        table {
            border-collapse: collapse;
            background-color: transparent;
        }
        .table-bordered thead td, .table-bordered thead th {
            border-bottom-width: 2px;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #eceeef;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #eceeef;
        }
        .table tr{
            line-height: 30px;
        }
        .table td, .table th {
            padding: .55rem;
            vertical-align: top;
            border-top: 1px solid #eceeef;
        }
        th {
            text-align: left;
        }
    </style>
</head>
<body>
<div class="layui-form" lay-filter="layuiadmin-form-role" id="layuiadmin-form-role" style="padding: 20px 30px 0 0;">
    <form id="modelUserForm" lay-filter="modelUserForm" class="layui-form model-form">
        <div class="layui-form-item">
            <label class="layui-form-label">标题</label>
            <div class="layui-input-block">
                <input name="head" id="head" placeholder="请输入标题" type="text" class="layui-input" maxlength="20"
                       lay-verType="tips" lay-verify="required" value="<?php echo !empty($info)?$info->title:''; ?>" required/>
                <input type="hidden" value="<?php echo !empty($info)?$info->id:''; ?>">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图片</label>
            <div class="layui-input-block">
                <button type="button" class="layui-btn" id="test1">上传图片</button>
                <span style="font-size: 12px;color: #cccccc">建议图片大小为：100*100</span>
                <div class="layui-upload-list">
                    <img class="layui-upload-img" id="demo1"  style="width:100px;height:100px">
                    <p id="demoText1"></p>
                    <input type="hidden" id="logo" name="headimg">
                </div>
            </div>
        </div>
        <div class="layui-form-item" id="videoUp">
            <label class="layui-form-label" style="height: 137px; line-height: 117px">视频</label>
            <input name="classVideo" id="videourl"  value="" autocomplete="off" class="layui-input" type="hidden">
            <div class=" layui-upload-drag" id="video" style="border-left: 0px;" type="video">
                <i class="layui-icon">&#xe654;</i>
                <p>点击上传</p>
                <video id="demo9" src="" style="position: absolute;height: 137px;width: 137px;margin: -106px auto auto -60px;"/>
            </div>
            <input type="button" value="预览" onclick="openVideo()" style="margin-left: 30px">
        </div>
    </form>
</div>
<script>
    layui.use(['layer', 'form', 'table', 'util', 'admin', 'formSelects'], function () {
        var $ = layui.jquery;
        var layer = layui.layer;
        var form = layui.form;
        var table = layui.table;
        var util = layui.util;
        var admin = layui.admin;
        var formSelects = layui.formSelects;

        //监听指定开关
        form.on('switch(switchTest)', function(data){
            if(this.checked){
                $(this).val(1);
            }else{
                $(this).val(0);
            }
        });
    });
</script>
<!--上传图片-->
<script>
    var url = "/static/uploads/";
    layui.use('upload', function(){
        var $ = layui.jquery
            ,upload = layui.upload;
        //添加图片
        var uploadInst = upload.render({
            elem: '#test1'
            ,url: '<?php echo url("/update"); ?>'
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    $('#demo1').attr('src', result); //图片链接（base64）
                });
            }
            ,done: function(res){
                $("input[name='headimg']").val(res.data);
            }
        });
        // 上传视屏
        var uploadInst=upload.render({
            elem: '#video'
            ,url: "<?php echo url('subject/upload_file'); ?>"
            ,field:"layuiVideo"
            ,data:{"dir":"media"}
            ,accept: 'video' //视频,
            ,exts:'rm|mp4'
            // ,before:function (obj) {
            //     $('#demo9').css('display','block').attr('src', "http://p6nngxvb7.bkt.clouddn.com/FsyjSltTtkVtzepa_w7zsnS_S7zO"); //链接（base64）http://p6nngxvb7.bkt.clouddn.com/FsyjSltTtkVtzepa_w7zsnS_S7zO
            // }
            ,done: function(res){
                if(res.code==1){
                    layer.alert(res.message,5);
                }
                if(res.error>0){
                    return layer.msg(res.message);
                }
                if(res.error==0){
                    alert("res.url:"+res.url);
                    $("#videourl").val(res.url);
                    $("#demo9").attr("src",res.url);
                    layer.alert("上传成功",{offset:['200px','450px'],icon:6});
                }
            }
            ,error:function () {
                //演示失败状态，并实现重传
                var demoText = $('#demoText');
                demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                demoText.find('.demo-reload').on('click', function () {
                    uploadInst.upload();
                });
            }
        });
    })
</script>
</body>
</html>