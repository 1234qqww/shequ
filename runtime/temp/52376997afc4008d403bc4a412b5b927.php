<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:79:"D:\xy\project\shequshop\public/../application/admin\view\good\good_listadd.html";i:1561605904;}*/ ?>


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
</head>
<body>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
            <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">商户名</label>
                        <div class="layui-input-block">
                            <input type="text" name="name" placeholder="请输入商户名" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">联系人</label>
                        <div class="layui-input-block">
                            <input type="text" name="contacts" placeholder="请输入商户名" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">联系方式</label>
                        <div class="layui-input-block">
                            <input type="text" name="tel" placeholder="请输入联系方式" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <button class="layui-btn layuiadmin-btn-admin" lay-submit lay-filter="search">
                            <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                        </button>
                    </div>
                </div>
            </div>

            <table id="list" lay-filter="list"></table>
            <script type="text/html" id="action">
                <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-edit"></i>通过</a>
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon layui-icon-delete"></i>驳回</a>
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
            , {field: 'name', align: 'center', title: '商户名称'}
            , {field: 'contacts', align: 'center', title: '联系人'}
            , {field: 'tel', align: 'center', title: '联系方式'}
            , {field: 'address', align: 'center', title: '详细地址'}
            , {field: 'date',align: 'center',title: '申请入驻时间'}
            , {field: 'detail',align: 'center', title: '商铺简介'}
            , {title: '操作', width: 150, align: 'center', fixed: 'right', toolbar: '#action'}
        ]];
        //加载数据
        base_table(table, 'list', '/admin/good/good_listadd', cols);
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
            if (obj.event == 'del') {
                layer.confirm('确定驳回此商户？', function (index) {
                    var post_json = {id: data.id};
                    hhtc.ajax('<?php echo url("good/del_good"); ?>', post_json, function (res) {
                        if (res.code == 1) {
                            layer.msg(res.msg, {icon: 1}, function () {
                                table.reload('list');
                                layer.close(index);
                            })
                        } else {
                            layer.alert(res.msg, {icon: 2});
                        }
                    })
                });
            } else if (obj.event == 'edit') {
                layer.open({
                    type: 2
                    , title: ''
                    , content: '/admin/good/good_add/id/' + data.id
                    , area: ['100%', '100%']
                    , btn: ['确定', '取消']
                    , yes: function (index, layero) {
                        var iframeWindow = window['layui-layer-iframe' + index]
                            , submit = layero.find('iframe').contents().find("#edit");
                        //监听提交
                        iframeWindow.layui.form.on('submit(edit)', function (data) {

                            hhtc.ajax("<?php echo url('good/good_add'); ?>", data.field, function (res) {
                                if (res.code == 1) {
                                    layer.msg(res.msg, {icon: 1}, function () {
                                        table.reload('list');
                                        layer.close(index); //关闭弹层
                                    })
                                } else {
                                    layer.alert(res.msg, {icon: 2});
                                }
                            })
                        });
                        submit.trigger('click');
                    }
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

