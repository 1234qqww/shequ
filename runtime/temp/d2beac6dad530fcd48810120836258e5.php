<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:87:"D:\xy\project\shequshop\public/../application/admin\view\marketing\youhuijuan_edit.html";i:1564131000;}*/ ?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>添加分类</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css" media="all">
</head>
<body>

<div class="layui-form" lay-filter="layuiadmin-form-role" id="layuiadmin-form-role" style="padding: 20px 30px 0 0;">
    <div class="layui-form-item">
        <label class="layui-form-label">优惠卷名称</label>
        <div class="layui-input-inline">
            <input type="text"  name="dis_name"  lay-verify="required" value="<?php echo $vo['dis_name']; ?>" autocomplete="off" class="layui-input" >
            <input type="hidden" name="id" value="<?php echo $vo['id']; ?>">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-inline">
            <input type="number" name="order" lay-verify="required" value="<?php echo $vo['order']; ?>" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux">数字越小排序越靠前</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">使用条件</label>
        <div class="layui-input-inline">
            <input type="text" name="satisfy" lay-verify="required" value="<?php echo $vo['satisfy']; ?>" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux">消费满多少可以使用,填写准确金额</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">优惠金额</label>
        <div class="layui-input-inline">
            <input type="text" name="reduction" lay-verify="required" value="<?php echo $vo['reduction']; ?>" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">发行总数</label>
        <div class="layui-input-inline">
            <input type="number" name="total" lay-verify="required" value="<?php echo $vo['total']; ?>" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux">发行数量，不填写不能领取或发放</div>
    </div>
    <div class="layui-form">
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">使用时间限制</label>
                <div class="layui-input-inline">
                    <input  class="layui-input" name="time" value="<?php echo substr($vo['start_time'],0,10); ?>-<?php echo substr($vo['end_time'],0,10); ?>"  id="test16" placeholder="-">
                </div>
            </div>
        </div>
    </div>
    <div class="layui-form-item layui-hide">
        <button class="layui-btn" lay-submit lay-filter="edit" id="edit">提交</button>
    </div>
</div>

<script src="/static/admin/layui/layui.js"></script>
<script src="/static/admin/js/app.js"></script>
<script>
    layui.config({
        base: '/static/admin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'form','hhtc','laydate'], function(){
        var $ = layui.$
            ,form = layui.form
            ,hhtc=layui.hhtc
            ,level=1
            ,laydate = layui.laydate;
        //日期范围
        laydate.render({
            elem: '#test16',
            range:true
        });
        form.on("select(menu_one)",function(data){
            var pid=data.value;
            var post_json = {parent_id: pid};
            $.post("<?php echo url('commodity/get_category'); ?>", post_json, function (res) {
                if (res.code == 1) {
                    var html='<option value="">请选择商品分类</option>';
                    for(i=0;i<res.data.length;i++){
                        html+='<option value="'+res.data[i].id+'">'+res.data[i].name+'</option>';
                    }
                    $("select[name='parent_id_2']").html(html)
                    form.render();
                }
            })
        });


        $('#image').click(function () {
            hhtc.upload_one(function(res){
                $("#beijing").val(res);
                $("#demo1").attr('src',res);
            })
        });
    })

</script>
</body>
</html>