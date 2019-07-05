<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"D:\xy\project\shequshop\public/../application/admin\view\user\user.html";i:1561098452;}*/ ?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layuiAdmin 角色管理</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/admin/style/admin.css" media="all">
    <style>
        .layui-table-cell {
            height: 100%;
            max-width: 100%;
        }
    </style>
</head>
<body>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
            <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">用户名</label>
                        <div class="layui-input-block">
                            <input type="text" name="userName" placeholder="请输入用户名" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <button class="layui-btn layuiadmin-btn-admin" lay-submit lay-filter="search">
                            <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div style="padding-bottom: 10px;">
                <button class="layui-btn layuiadmin-btn-admin" data-type="add">添加</button>
            </div>
            <table id="list" lay-filter="list"></table>

            <script type="text/html" id="touxiang">
                <img src="{{d.userImg}}"  lay-event="showimg" alt="图片丢失">
            </script>

            <script type="text/html" id="action">
                <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-edit"></i>编辑</a>
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon layui-icon-delete"></i>删除</a>
            </script>
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
        ,hhtc: 'hhtc'
    }).use(['index', 'table','laydate','hhtc'], function() {
        var $ = layui.$
            , form = layui.form
            , table = layui.table
            , laydate = layui.laydate
            , hhtc = layui.hhtc;
        var cols = [[
            {field: 'id', width: 40, title: 'ID', sort: true}
            , {field: 'userImg', align: 'center', title: '头像',toolbar: '#touxiang'}
            , {field: 'userName', align: 'center', title: '账户名'}
            , {field: 'openid', align: 'center', title: 'openID'}
            , {field: 'atime', align: 'center', title: '注册时间'}
        ]];
        //加载数据
        base_table(table, 'list', '/admin/user/user', cols);
        form.on('submit(search)', function (data) {
            var field = data.field;
            //执行重载
            table.reload('list', {
                where: field,
                page: {
                    curr: 1 //重新从第 1 页开始
                }
            });
        });
        table.on('tool(list)', function (obj) {
            var data = obj.data;
            if(obj.event='showimg'){
                layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 1,
                    shadeClose: true,
                    area:['180px','180px'],
                    content: '<img style="width: 180px;height:180px" src="'+data.userImg+'">'
                });
            }

        });
        //事件
        $('.layui-btn.layuiadmin-btn-admin').on('click', function () {
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
    });
</script>
</body>
</html>

