<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:85:"D:\xy\project\shequshop\public/../application/admin\view\commodity\commodity_del.html";i:1562836233;}*/ ?>


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
    <script src="/static/js/jquery.js"></script>
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
            color: #0e0e0e;
        }
        .shuxin1{
            margin: 0 20px;
            color: #fb0b03;
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
            <table id="list" lay-filter="list"></table>
            <script type="text/html" id="nameImg">
                <img src="{{d.original_img}}"  lay-event="showimg" alt="图片丢失">
                {{d.goods_name}}
            </script>
            <script type="text/html" id="state">
                <button type="button" class="layui-btn layui-btn-sm {{#  if(d.is_on_sale == 0){ }}layui-btn-danger{{#  } else { }}layui-btn-normal{{#  } }}"  onclick="changeTableSale('goods','id','{{d.id}}','is_on_sale',this)">上架</button>
            </script>
            <script type="text/html" id="shuxin">
                <a class="{{#  if(d.is_hot == 0){ }}shuxin{{#  } else { }}shuxin1{{#  } }}"  onclick="changeTable('goods','id','{{d.id}}','is_hot',this)">热卖</a>
                <a class="{{#  if(d.is_free_shipping == 0){ }}shuxin{{#  } else { }}shuxin1{{#  } }}" onclick="changeTable('goods','id','{{d.id}}','is_free_shipping',this)">包邮</a>
                <a class="{{#  if(d.is_tuijian == 0){ }}shuxin{{#  } else { }}shuxin1{{#  } }}" onclick="changeTable('goods','id','{{d.id}}','is_tuijian',this)">推荐</a>
                <a class="{{#  if(d.is_show == 0){ }}shuxin{{#  } else { }}shuxin1{{#  } }}" onclick="changeTable('goods','id','{{d.id}}','is_show',this)">显示</a>
                <a class="{{#  if(d.is_newshop == 0){ }}shuxin{{#  } else { }}shuxin1{{#  } }}" onclick="changeTable('goods','id','{{d.id}}','is_newshop',this)">新品</a>
            </script>
            <script type="text/html" id="action">
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon layui-icon-util"></i>恢复</a>
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
            ,{field: 'id', width: 50, title: 'ID', sort: true}
            ,{title: '商品名称',toolbar: '#nameImg'}
            ,{field: 'shop_price', title: '商品价格',width: 80,align: 'center',}
            ,{field: 'store_count', title: '库存数量', width: 80,sort: true,align: 'center',}
            ,{field: 'inventory_count', title: '销量',width: 80, sort: true,align: 'center',}
            ,{title: '状态',toolbar: '#state',width: 100}
            ,{title: '属性',toolbar: '#shuxin'}
            ,{title: '操作', width: 200, align: 'center', fixed: 'right', toolbar: '#action'}
        ]];
        base_table(table,'list','<?php echo url("commodity/commodity_del"); ?>',cols);
        table.on('tool(list)',function(obj){
            var data=obj.data;
            console.log(data);
            if(obj.event=='del'){
                if(obj.event=='del'){
                    layer.confirm('确定恢复此商品？', function(index){
                        post_json={id:data.id};
                        var result=ajax_post($,'<?php echo url("commodity/commodity_huifu"); ?>',post_json);
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

        $('.layui-btn.layuiadmin-btn-role').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
    });
</script>
<script>
    function  changeTable(table,id_name,id_value,field,obj){
        var src = "";
        if($(obj).hasClass('shuxin')) // 图片点击是否操作
        {
            $(obj).removeClass('shuxin').addClass('shuxin1');
            var value = 1;
        }else if($(obj).hasClass('shuxin1')){ // 图片点击是否操作
            $(obj).removeClass('shuxin1').addClass('shuxin');
            var value = 0;
        }else{ // 其他输入框操作
            var value = $(obj).val();
        }
        $.ajax({
            url:"changeTableVal?table="+table+'&id='+id_name+'&id_value='+id_value+'&field='+field+'&value='+value,
        });

    }


    function changeTableSale(table,id_name,id_value,field,obj) {
        var src = "";
        if($(obj).hasClass('layui-btn-danger')) // 图片点击是否操作
        {
            $(obj).removeClass('layui-btn-danger').addClass('layui-btn-normal').html('上架');
            var value = 1;
        }else if($(obj).hasClass('layui-btn-normal')){ // 图片点击是否操作
            $(obj).removeClass('layui-btn-normal').addClass('layui-btn-danger').html('下架');
            var value = 0;
        }else{ // 其他输入框操作
            var value = $(obj).val();
        }
        $.ajax({
            url:"changeTableVal?table="+table+'&id='+id_name+'&id_value='+id_value+'&field='+field+'&value='+value,
        });


    }
</script>
</body>
</html>

