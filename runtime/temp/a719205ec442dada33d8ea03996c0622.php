<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"D:\xy\project\shequshop\public/../application/admin\view\commodity\commodity.html";i:1562549574;}*/ ?>


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
         .shuxin{
            margin: 0 20px;
            color: #c0a16b;
        }
        .shuxin1{
            margin: 0 20px;
            color: #C00E08;
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
                        <label class="layui-form-label">商品名</label>
                        <div class="layui-input-block">
                            <input type="text" name="goods_name" placeholder="请输入商品名" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="search">
                            <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div style="padding-bottom: 10px;">
                <button class="layui-btn layuiadmin-btn-role" data-type="batchdel">删除</button>
                <button class="layui-btn layuiadmin-btn-role" data-type="add">添加</button>
            </div>
            <table id="list" lay-filter="list"></table>
            <script type="text/html" id="nameImg">
                <img src="{{d.original_img}}"  lay-event="showimg" alt="图片丢失">
                {{d.goods_name}}
            </script>
            <script type="text/html" id="state">
                <button type="button" class="layui-btn layui-btn-sm {{#  if(d.is_is_on_sale == 0){ }}layui-btn-danger{{#  } else { }}layui-btn-normal{{#  } }}">上架</button>
            </script>
            <script type="text/html" id="shuxin">
                <a class="{{#  if(d.is_hot == 0){ }}shuxin{{#  } else { }}shuxin1{{#  } }}" >热卖</a>
                <a class="{{#  if(d.is_free_shipping == 0){ }}shuxin{{#  } else { }}shuxin1{{#  } }}">包邮</a>
                <a class="{{#  if(d.is_tuijian == 0){ }}shuxin{{#  } else { }}shuxin1{{#  } }}">推荐</a>
                <a class="{{#  if(d.is_show == 0){ }}shuxin{{#  } else { }}shuxin1{{#  } }}">显示</a>
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
    }).use(['index', 'table'], function(){
        var $ = layui.$
            ,form = layui.form
            ,table = layui.table;
        var cols=[[
            {type: 'checkbox', fixed: 'left'}
            ,{field: 'id', width: 50, title: 'ID', sort: true}
            ,{title: '商品名称',toolbar: '#nameImg'}
            ,{field: 'shop_price', title: '商品价格',width: 80,align: 'center',}
            ,{field: 'store_count', title: '库存数量', width: 80,sort: true,align: 'center',}
            ,{field: 'inventory_count', title: '销量',width: 80, sort: true,align: 'center',}
            ,{title: '状态',toolbar: '#state',width: 100}
            ,{title: '属性',toolbar: '#shuxin'}
            ,{title: '操作', width: 200, align: 'center', fixed: 'right', toolbar: '#action'}
        ]];

        base_table(table,'list','<?php echo url("commodity/commodity"); ?>',cols);
        table.on('tool(list)',function(obj){
            var data=obj.data;
            if(obj.event=='del'){
                if(obj.event=='del'){
                    layer.confirm('确定删除此角色？', function(index){
                        post_json={role_id:data.role_id};
                        var result=ajax_post($,'<?php echo url("admin/del_role"); ?>',post_json);
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
                    ,title: '编辑角色'
                    ,content: '/admin/admin/edit_role/role_id/'+data.role_id
                    ,area: ['800px', '800px']
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
                            var result=ajax_post($,'<?php echo url('admin/edit_role'); ?>',field);
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
            }
        })
        //事件
        var active = {
            batchdel: function(){
                var checkStatus = table.checkStatus('LAY-user-back-role')
                    ,checkData = checkStatus.data; //得到选中的数据
                if(checkData.length === 0){
                    return layer.msg('请选择数据');
                }
                layer.confirm('确定删除吗？', function(index) {
                    //执行 Ajax 后重载
                    /*
                    admin.req({
                      url: 'xxx'
                      //,……
                    });
                    */
                    table.reload('LAY-user-back-role');
                    layer.msg('已删除');
                });
            },
            add: function(){
                layer.open({
                    type: 2
                    ,title: '添加商品'
                    ,content: '<?php echo url("commodity/add_commodity"); ?>'
                    ,area: ['100%', '100%']
                    ,btn: ['确定', '取消']
                    ,yes: function(index, layero){
                    var iframeWindow = window['layui-layer-iframe'+ index]
                        ,submit = layero.find('iframe').contents().find("#add");
                    // 监听提交
                    iframeWindow.layui.form.on('submit(add1)', function(data){
                        console.log(data);
                        var field = data.field; //获取提交的字段
                        console.log(field)
                        //提交 Ajax 成功后，静态更新表格中的数据
                        var result=ajax_post($,'<?php echo url("commodity/add_commodity"); ?>',field);
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
        $('.layui-btn.layuiadmin-btn-role').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
    });
</script>
</body>
</html>

