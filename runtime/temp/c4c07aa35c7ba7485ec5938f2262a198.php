<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"D:\xy\project\shequshop\public/../application/admin\view\subject\add_subject.html";i:1562836233;}*/ ?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>添加分类</title>
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
        <input name="userId" type="hidden"/>
        <div class="layui-form-item">
            <label class="layui-form-label">话题分类</label>
            <div class="layui-input-block">
                <input name="title" id="title" placeholder="请输入话题分类" type="text" class="layui-input" maxlength="20"
                       lay-verType="tips" lay-verify="required" value="<?php echo !empty($info)?$info->title:''; ?>" required/>
                <input type="hidden" value="<?php echo !empty($info)?$info->id:''; ?>">
            </div>
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
</body>
</html>