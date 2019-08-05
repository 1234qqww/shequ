<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:82:"D:\xy\project\shequshop\public/../application/admin\view\marketing\youhuijuan.html";i:1564366624;}*/ ?>


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
        .layui-table-cell{
            height:60px;
            line-height:60px;
        }
        .layui-table img{
            height: 60px;
            width: 60px;
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
                        <label class="layui-form-label">优惠卷名称</label>
                        <div class="layui-input-block">
                            <input type="text" name="name" placeholder="请输入优惠卷名称" autocomplete="off" class="layui-input">
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

            <script type="text/html" id="atime">
                {{layui.util.toDateString(d.start_time, "yyyy-MM-dd")}}-{{layui.util.toDateString(d.end_time, "yyyy-MM-dd")}}
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
            , {field: 'dis_name', align: 'center', title: '优惠卷名称'}
            , {field: 'order', align: 'center', title: '排序'}
            , {field: 'satisfy', align: 'center', title: '使用限制'}
            , {field: 'reduction', align: 'center', title: '优惠金额'}
            , {align: 'center', title: '使用时间',toolbar: '#atime'}
             ,{title: '操作', width: 200, align: 'center', fixed: 'right', toolbar: '#action'}

        ]];
        //加载数据
        base_table(table, 'list', '/admin/marketing/youhuijuan', cols);

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
        table.on('tool(list)',function(obj){
            var data=obj.data;
            if(obj.event=='del'){
                if(obj.event=='del'){
                    layer.confirm('确定删除此优惠卷？', function(index){
                        post_json={id:data.id};
                        var result=ajax_post($,'<?php echo url("marketing/youhuijuan_del"); ?>',post_json);
                        if(result.code==1){
                            layer.msg(result.msg,{icon:1},function(){
                                obj.del();
                                layer.close(index);
                            })
                        }else{
                            layer.alert(result.msg,{icon:2});
                        }
                    });
                }
            }else if(obj.event=='edit'){
                layer.open({
                    type: 2
                    ,title: '编辑优惠卷'
                    ,content:'/admin/marketing/youhuijuan_edit/id/'+data.id
                    ,area: ['100%', '100%']
                    ,btn: ['确定', '取消']
                    ,yes: function(index, layero){
                        var iframeWindow = window['layui-layer-iframe'+ index]
                            ,submit = layero.find('iframe').contents().find("#edit");
                        //监听提交
                        iframeWindow.layui.form.on('submit(edit)', function(data){
                            console.log(data)
                            var field = data.field; //获取提交的字段
                            console.log(field)
                            //提交 Ajax 成功后，静态更新表格中的数据
                            var result=ajax_post($,"<?php echo url('marketing/youhuijuan_edit'); ?>",field);
                            if(result.code==1){
                                layer.msg(result.msg,{icon:1},function(){
                                    table.reload('list');
                                    layer.close(index); //关闭弹层
                                })
                            }else{
                                layer.alert(result.msg,{icon:2});
                            }

                        });

                        submit.trigger('click');
                    }
                });
            }else if(obj.event='showimg'){
                layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 1,
                    shadeClose: true,
                    area:['300px','300px'],
                    content: '<img width="100%" height="300px" src="'+data.original_img+'">'
                });
            }else if(obj.event='is_hot'){
                console.log('111');
            }
        });
        var active = {
            batchdel: function(){
                var checkStatus = table.checkStatus('list')
                    ,checkData = checkStatus.data; //得到选中的数据
                console.log(checkData);
                if(checkData.length === 0){
                    return layer.msg('请选择数据');
                }

                var idList=[];

                checkData.forEach(function(n,i){
                    idList.push(n.id);

                });



//             var a=JSON.stringify(idList);
                layer.confirm('确定删除吗？', function(index) {
                    $.ajax({
                        url: 'commodity_delAll',
                        type: 'post',
                        dataType:'json',
                        data:{"id":idList},
                        success: function (data) {
                            if(data.code==1){
                                table.reload('list');
                                layer.msg('删除成功');
                            }
                        }
                    });
                });

            },
            add: function(){
                layer.open({
                    type: 2
                    ,title: '添加优惠卷'
                    ,content: '<?php echo url("marketing/youhuijuan_add"); ?>'
                    ,area: ['85%', '85%']
                    ,btn: ['确定', '取消']
                    ,yes: function(index, layero){
                        var iframeWindow = window['layui-layer-iframe'+ index]
                            ,submit = layero.find('iframe').contents().find("#add");
                        // 监听提交
                        iframeWindow.layui.form.on('submit(add)', function(data){
                            var field = data.field; //获取提交的字段

                            //提交 Ajax 成功后，静态更新表格中的数据
                            var result=ajax_post($,'<?php echo url("marketing/youhuijuan_add"); ?>',field);
                            if(result.code==1){
                                layer.msg(result.msg,{icon:1},function(){
                                    table.reload('list');
                                    layer.close(index); //关闭弹层
                                })
                            }else{
                                layer.alert(result.msg,{icon:2});
                            }
                        });
                        submit.trigger('click');
                    }
                });
            }
        }






        //事件
        $('.layui-btn.layuiadmin-btn-admin').on('click', function () {
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
    });
</script>
</body>
</html>

