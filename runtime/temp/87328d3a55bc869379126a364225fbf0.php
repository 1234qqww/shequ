<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:83:"D:\xy\project\shequshop\public/../application/admin\view\marketing\seckill_add.html";i:1565235374;}*/ ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layuiAdmin 角色管理 iframe 框</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css" media="all">
</head>
<body>
<div class="layui-form" lay-filter="layuiadmin-form-role" id="layuiadmin-form-role" style="padding: 20px 30px 0 0;">
    <div class="layui-form-item">
        <label class="layui-form-label">请选择商品</label>
        <div class="layui-input-inline">
            <input type="text"   id="goods_name" lay-verify="required" value="" autocomplete="off" class="layui-input" readonly="readonly">
            <input type="hidden" name="goods_id" value="" id="goods_id">
        </div>
        <button type="button"  id="searchs" class="layui-btn  layui-btn-normal layui-btn-sm"><i class="layui-icon layui-icon-search"></i>选择商品</button>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">抢购数量</label>
        <div class="layui-input-inline">
            <input type="text" name="quantity" lay-verify="required"   value=""  autocomplete="off" class="layui-input" >
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">抢购优惠</label>
        <div class="layui-input-inline">
            <input type="number" name="discount" lay-verify="required"   value=""  autocomplete="off" class="layui-input" >
        </div>
        <div class="layui-form-mid layui-word-aux">原价基础上减抢购优惠等于秒杀价,抢购优惠不能大于商品本身价格</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">限购数量</label>
        <div class="layui-input-inline">
            <input type="text" name="purchase" lay-verify="required" value="" autocomplete="off" class="layui-input" >

        </div>
        <div class="layui-form-mid layui-word-aux">每个用户限抢购数量</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">开始时间</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input"  name="start_time"  lay-verify="required" id="test" placeholder="yyyy-MM-dd HH:mm:ss">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">结束时间</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" name="end_time"  lay-verify="required" id="test5" placeholder="yyyy-MM-dd HH:mm:ss">
        </div>
    </div>
    <div class="layui-form-item layui-hide">
        <button class="layui-btn" lay-submit lay-filter="add" id="add">提交</button>
    </div>
</div>

<script src="/static/admin/layui/layui.js"></script>
<script>
    layui.config({
        base: '/static/admin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'form','hhtc','laydate'], function(){
        var $ = layui.$
            ,hhtc=layui.hhtc
            ,form = layui.form
            ,laydate = layui.laydate;

        //日期时间选择器
        laydate.render({
            elem: '#test5'
            ,type: 'datetime'
        });
        //日期时间选择器
        laydate.render({
            elem: '#test'
            ,type: 'datetime'
        });


        $('#searchs').click(function () {
            layer.open({
                type: 2 //此处以iframe举例
                ,title: '添加'
                ,area: ['70%', '70%']
                ,shade: 0.2
                ,maxmin: true
                ,content:"<?php echo url('subject/shopgood'); ?>"
                ,btn: ['保存关闭', '取消'] //只是为了演示
                ,yes: function(){
                    var index = parent.layer.getFrameIndex();
                    var form = layer.getChildFrame('form', index);
                    var sid = form.find('#gid').val();
                    var goods_name = form.find('#goods_name').val();
                    $('#goods_id').val(sid);
                    $('#goods_name').val(goods_name);
                    layer.closeAll();
                }
                ,btn2: function(){
                    layer.closeAll();
                }
                ,zIndex: layer.zIndex //重点1
                ,success: function(layero){
                    layer.setTop(layero); //重点2
                }
            });
        });
    })
</script>
</body>
</html>