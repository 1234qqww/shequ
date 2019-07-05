<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:67:"D:\xy\wuliu\public/../application/admin\view\merchant\merchant.html";i:1560759260;}*/ ?>


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
                            <input type="text" name="mername" placeholder="请输入商户名" autocomplete="off" class="layui-input">
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
                            <input type="text" name="phone" placeholder="请输入联系方式" autocomplete="off" class="layui-input">
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
            <script type="text/html" name="shifa">
                {{d.prov}}{{d.city}}{{d.area}}{{address}}
            </script>
            <script type="text/html" name="zhida">
                {{d.setout}}->{{arrive}}
            </script>
            <script type="text/html" name="xiehuo">
                {{d.provs}}{{d.citys}}{{d.areas}}{{addresss}}
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
            {field: 'id', width: 80, title: 'ID', sort: true}
            , {field: 'mername', align: 'center', title: '商户名称'}
            , {field: 'merportrait', align: 'center', title: '商户头像'}
            , {field: 'contacts', align: 'center', title: '联系人'}
            , {field: 'telephone', align: 'center', title: '电话'}
            , {field: 'mobile', align: 'center', title: '手机'}
            , {field: '', align: 'center', title: '始发地', toolbar: '#shifa'}
            , {field: '', align: 'center', title: '直达路线', toolbar: '#zhida'}
            , {field: '', align: 'center', title: '卸货地址', toolbar: '#xiehuo'}
            , {title: '操作', width: 150, align: 'center', fixed: 'right', toolbar: '#action'}
        ]];
        //加载数据
        base_table(table, 'list', '/admin/merchant/merchant', cols);
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
                layer.confirm('确定删除此轮播图？', function (index) {
                    var post_json = {id: data.id};
                    hhtc.ajax('<?php echo url("merchant/merchant"); ?>', post_json, function (res) {
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
                    , title: '编辑轮播图'
                    , content: '/admin/banner/edit_banner/id/' + data.id
                    , area: ['100%', '100%']
                    , btn: ['确定', '取消']
                    , yes: function (index, layero) {
                        var iframeWindow = window['layui-layer-iframe' + index]
                            , submit = layero.find('iframe').contents().find("#edit");
                        //监听提交
                        iframeWindow.layui.form.on('submit(edit)', function (data) {

                            hhtc.ajax("<?php echo url('banner/edit_banner'); ?>", data.field, function (res) {
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
            var active = {
                add: function () {
                    layer.open({
                        type: 2
                        , title: '添加商户'
                        , content: "<?php echo url('merchant/add_merchant'); ?>"
                        , area: ['100%', '100%']
                        , btn: ['确定', '取消']
                        , yes: function (index, layero) {
                            var iframeWindow = window['layui-layer-iframe' + index]
                                , submit = layero.find('iframe').contents().find("#add");
                            //监听提交
                            iframeWindow.layui.form.on('submit(add)', function (data) {
                                var field = data.field; //获取提交的字段
                                $.post("<?php echo url('merchant/add_merchant'); ?>",field,function(res){
                                    layer.close(load1);
                                    console.log(res)
                                    if(res.code==1){
                                        layer.msg(res.msg,{icon:1},function(){
                                            table.reload('list');
                                            layer.close(index); //关闭弹层
                                        })
                                    }else{
                                        layer.alert(res.msg,{icon:2});
                                    }
                                },'json')
                                // hhtc.ajax("<?php echo url('merchant/add_merchant'); ?>", data.field, function (res) {
                                //     if (res.code == 1) {
                                //         layer.msg(res.msg, {icon: 1}, function () {
                                //             table.reload('list');
                                //             layer.close(index); //关闭弹层
                                //         })
                                //     } else {
                                //         layer.alert(res.msg, {icon: 2});
                                //     }
                                // })
                            });
                            submit.trigger('click');
                        }
                    });
                },
                upload: function () {
                    hhtc.upload_one(function (img) {
                        layer.msg('图片路径为:' + img)
                    });
                },
                uploads: function () {
                    hhtc.upload_more(function (img) {
                        var str = '选择了' + img.length + '张图片;路径分别为:<br>';
                        for (i = 0; i < img.length; i++) {
                            str += img[i] + '<br>';
                        }
                        layer.alert(str)
                    });
                }
            }
            $('.layui-btn.layuiadmin-btn-admin').on('click', function () {
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });
    });
</script>
</body>
</html>

