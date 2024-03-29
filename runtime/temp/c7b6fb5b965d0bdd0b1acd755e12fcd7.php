<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"D:\xy\project\shequshop\public/../application/admin\view\magic\magic.html";i:1564131455;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>添加话题</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/easyweb/assets/libs/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/admin/style/admin.css" media="all">
    <script type="text/javascript" src="/static/admin/layui/layui.js"></script>
    <script type="text/javascript" src="/easyweb/assets//js/common.js?v=304"></script>
    <script type="text/javascript" src="/easyweb/assets/libs/jquery/jquery-3.2.1.min.js"></script>
    <script src="/static/js/jquery.js"></script>
    <script type="text/javascript" src="/webuploader-0.1.5/webuploader.js"></script>
    <script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.config.js"> </script>
    <script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.all.min.js"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="/ueditor/lang/zh-cn/zh-cn.js"></script>
    <style>
        .control-label {
            position: relative;
            height: 42px;
            line-height: 42px;
            border-bottom: 1px solid #f6f6f6;
            color: #333;
            border-radius: 2px 2px 0 0;
            font-size: 14px;
        }
        .controls input{
            height: 28px;
            line-height: 28px;
            padding: 0 10px;
            font-size: 12px;
            border-radius: 2px;
            cursor: pointer;
            white-space: nowrap;
            text-align: center;
            margin-right: 20px;
            border: 1px solid #e6e6e6;
        }
        .table-bordered {
            border: 1px solid #eceeef;
        }
        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
        }
        table {
            border-collapse: collapse;
            background-color: transparent;
        }
        .table-bordered thead td, .table-bordered thead th {
            border-bottom-width: 2px;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #eceeef;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #eceeef;
        }
        .table tr{
            line-height: 30px;
        }
        .table td, .table th {
            padding: .55rem;
            vertical-align: top;
            border-top: 1px solid #eceeef;
        }
        th {
            text-align: left;
        }
        #picker div{
            opacity: 0;
        }
        #picker .webuploader-pick{
            opacity: 1;
        }
    </style>
</head>
<body>
<div class="layui-form" lay-filter="layuiadmin-form-role" id="layuiadmin-form-role" style="padding: 20px 30px 0 0;">
    <form id="modelUserForm" lay-filter="modelUserForm" class="layui-form model-form" onsubmit="return false;">
        <div class="layui-input-block">
            <div>            <button type="button" class="layui-btn" id="test2" style="margin-bottom:20px"><i class="layui-icon"></i>魔方图</button>
            </div>
            <br>
            <?php if($magic): ?>
            <blockquote class="layui-elem-quote layui-quote-nm" style="width:700px;float: left">
                预览图：
                <div class="layui-upload-list" id="demo2">
                    <?php if(is_array($magic['magic']) || $magic['magic'] instanceof \think\Collection || $magic['magic'] instanceof \think\Paginator): if( count($magic['magic'])==0 ) : echo "" ;else: foreach($magic['magic'] as $key=>$value): ?>
                    <img style="width: 120px; height: 120px" data-url="<?php echo $value; ?>" src="<?php echo $value; ?>" alt="" class="layui-upload-img images shop-image">
                    <img class="del-image" style="cursor:pointer;position: relative;left: -35px;top: -40px;width: 25px; height: 25px;" src="/static/image/del.png">
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </blockquote>
            <?php else: ?>
            <blockquote class="layui-elem-quote layui-quote-nm" style="width:700px" style="margin-top: 10px;">
                预览图：
                <div class="layui-upload-list" id="demo2">
                </div>
            </blockquote>

            <?php endif; if($magic['magic_img']): ?>
            <div class="layui-input-inline" style="float:left">
                <img class="layui-upload-img" src="/hero_gam.png" style="width:385px;">
            </div>
            <?php endif; ?>
            <input type="hidden" id="magic">
            <input type="text" id="info_id" hidden value="<?php echo $magic['id']; ?>">


        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1" id="submit">立即提交</button>
            </div>
        </div>
    </form>
</div>
<script>
    incon = "/static/image/del.png"
    layui.use('upload', function(){
        var $ = layui.jquery
            ,upload = layui.upload;
        //添加驾驶证配图
        //添加驾驶证配图
        var uploadInst = upload.render({
            elem: '#test2'
            ,url: '<?php echo url("subject/update"); ?>'
            , multiple: true
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    $('#demo2').attr('src', result); //图片链接（base64）
                });
            }
            ,done: function(res){

                $('#demo2').append('<img style="width: 120px; height: 120px" data-url="'+res.url+'" src="' + res.url + '" alt="" class="layui-upload-img images shop-image"><img class="del-image" style="cursor:pointer;position: relative;left: -35px;top: -40px;width: 25px; height: 25px;" src='+ incon +'>')
                var image = [];
                $('form').find('.shop-image').each(function(){
                    image.push($(this).attr('data-url'))
                });
                $('#magic').val(image);
            }
        });
    })
    $('body').on('click', '.del-image', function(){
        let par = $(this).prev()
        par.remove()
        $(this).remove();

    })
        $('#submit').click(function(){
        var image = [];
        $('form').find('.shop-image').each(function(){
            image.push($(this).attr('data-url'))
        });
        var info_id=$('#info_id').val();
        if(image.length>4) {
            return layer.msg('最多上传4张图片')
        }
        console.log(1);
        layer.msg("生成中",{
            icon:16,
            time:-2
        })


        $.post('<?php echo url("magic/images"); ?>',{magic:image},function(res){
            setTimeout(function(){
                index = layer.msg()
                layer.close(index);
                $.post('<?php echo url("magic/edit"); ?>',{magic:image,id:info_id},function(res){
                    layer.msg(res.msg,{icon: 1});
                    setTimeout(function(){
                        window.location.reload();
                    },500)
                });
            },2000)

        });
    })
</script>
</body>
</html>