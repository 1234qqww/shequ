<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:84:"D:\xy\project\shequshop\public/../application/admin\view\commodity\category_add.html";i:1561969670;}*/ ?>


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
        <label class="layui-form-label">分类名称</label>
        <div class="layui-input-inline">
            <input type="text"  name="name"  lay-verify="required" value="" autocomplete="off" class="layui-input" >
        </div>
    </div>
    <div class="layui-form-item" id="menu_one" >
        <label class="layui-form-label">一级菜单</label>
        <div class="layui-input-inline">
            <select name="parent_id_1"  id="parent_id_1" model="select" lay-filter="menu_one" >
                <option value="0">顶级菜单</option>
                <?php if(is_array($cat_list) || $cat_list instanceof \think\Collection || $cat_list instanceof \think\Paginator): $i = 0; $__LIST__ = $cat_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <option value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
        <div class="layui-input-inline">
            <select model="select"  name="parent_id_2" id="parent_id_2"  lay-filter="menu_two">
                <option value="">请选择商品分类</option>
            </select>
        </div>
        <div class="layui-form-mid layui-word-aux">最多成为第三级,如果设置为第二级, 只选择第一级即可</div>
    </div>


    <div class="layui-form-item">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-inline">
            <input type="number" name="sort_order" lay-verify="required" value="" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux">数字越小排序越靠前</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">是否推荐</label>
        <div class="layui-input-block">
            <input type="checkbox" name="is_tuijian" lay-skin="switch" lay-text="是|否">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">是否显示</label>
        <div class="layui-input-block">
            <input type="checkbox" name="is_show"  lay-skin="switch" lay-text="是|否">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">分类展示图片</label>
        <div class="layui-input-block">
            <button type="button" class="layui-btn" id="image"><i class="layui-icon"></i>点我</button>
            <input type="hidden" id="beijing" name="image" value=""/>
            <div class="layui-upload-list">
                <img src=""  class="layui-upload-img" style="width: 200px;height:12rem"   id="demo1" alt=""/>
            </div>
        </div>
    </div>


    <div class="layui-form-item layui-hide">
        <button class="layui-btn" lay-submit lay-filter="add" id="add">提交</button>
    </div>
</div>

<script src="/static/admin/layui/layui.js"></script>
<script src="/static/admin/js/app.js"></script>
<script>
    layui.config({
        base: '/static/admin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'form','hhtc'], function(){
        var $ = layui.$
            ,form = layui.form
            ,hhtc=layui.hhtc
            ,level=1
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