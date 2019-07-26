<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"D:\xy\project\shequshop\public/../application/admin\view\marketing\marketing.html";i:1562923952;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>网站设置</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/admin/style/admin.css" media="all">
    <script src="/static/js/jquery.js"></script>
</head>
<body>

<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                <legend>满额立减设置</legend>
            </fieldset>
            <div style="padding: 20px; background-color: #F2F2F2;">
                <div class="layui-row layui-col-space15">
                    <div class="layui-col-md12">
                        <div class="layui-card">
                            <div class="layui-card-header">操作提示</div>
                            <div class="layui-card-body">
                                <ul>
                                    <li>温馨提示：设置完成后，用户在本商铺购买商品达到设置金额后。结算会减去立减金额</li>
                                    <li style="color:#ff0000;"><strong>必须两样一起设置才有效</strong></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-form" wid100  lay-filter="">
        <div class="contents">

            <?php foreach($content as $key=>$vo): ?>
            <div class="layui-form-item lv1">
                <div class="layui-inline">
                    <label class="layui-form-label">单笔订单满</label>
                    <div class="layui-input-inline" style="width: 100px;">
                        <input type="text" name="price_max[]" placeholder="￥" value="<?php echo $key; ?>" autocomplete="off" class="layui-input" lay-verify="required">
                    </div>
                    <div class="layui-form-mid">立减</div>
                    <div class="layui-input-inline" style="width: 100px;">
                        <input type="text" name="price_del[]" placeholder="￥" value="<?php echo $vo; ?>" autocomplete="off" class="layui-input" lay-verify="required">
                    </div>
                    <button  type="button" class="layui-btn  layui-btn-normal add_lv1" style="margin-left: 60px"><li class="layui-icon layui-icon-add-1" ></li></button>
                    <button   type="button" class="layui-btn layui-btn-danger del_lv1"  onclick='deltr(this)' type="button"><li class="layui-icon layui-icon-close"></li></button>
                </div>


            </div>
            <?php endforeach; ?>

        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="set_website">保存设置</button>
            </div>
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
    }).use(['index', 'form', 'hhtc'], function () {
        var $ = layui.$
            , form = layui.form
            , hhtc = layui.hhtc;
        form.render();

        form.on('submit(set_website)', function (obj) {
            var result=ajax_post($,'',obj.field);
            if(result.code==1){
                layer.msg(result.msg,{icon:1});
            }else{
                layer.alert(result.msg,{icon:2})
            }
        });

    });
</script>
<script>
    var  html='<div class="layui-form-item lv1"  style=\'margin-top: 10px;position: relative;\'>' +
        '<label class="layui-form-label">单笔订单满</label>' +
        '<div class="layui-input-inline" style="width: 100px;">' +
        '<input type="text" name="price_max[]" placeholder="￥" autocomplete="off" class="layui-input" lay-verify="required">' +
        '</div>' +
        '<div class="layui-form-mid">立减</div>' +
        '<div class="layui-input-inline" style="width: 100px;">' +
        '<input type="text" name="price_del[]" placeholder="￥" autocomplete="off" class="layui-input" lay-verify="required">' +
        '</div>' +
        '<button  type="button" class="layui-btn  layui-btn-normal add_lv1" style="margin-left: 60px" onclick=\'add(this)\'><li class="layui-icon layui-icon-add-1" ></li></button>' +
        '<button   type="button" class="layui-btn layui-btn-danger del_lv1"  onclick=\'deltr(this)\' type="button"><li class="layui-icon layui-icon-close"></li></button>' +
        '</div></div>';
        $('.add_lv1').on('click',function () {
            $(this).parents('.contents').append(html);
        });
        function add(t) {
            $(t).parents('.contents').append(html);
        }
        function deltr(t) {
            $(t).parents('.lv1').remove();
        }

</script>
</body>
</html>