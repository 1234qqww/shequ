<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:79:"D:\xy\project\shequshop\public/../application/admin\view\subject\add_topic.html";i:1564131455;}*/ ?>
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
    <form id="modelUserForm" lay-filter="modelUserForm" class="layui-form model-form">
        <div class="layui-form-item">
            <label class="layui-form-label">标题</label>
            <div class="layui-input-block">
                <input name="head" id="head" placeholder="请输入标题" type="text" class="layui-input" maxlength="20"
                       lay-verType="tips" lay-verify="required" value="" required/>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">话题分类</label>
            <div class="layui-input-inline">
                <select name="sid"  id="sid" lay-search=""　>
                    <option value="">直接选择或搜索选择</option>
                    <?php if(is_array($subject) || $subject instanceof \think\Collection || $subject instanceof \think\Paginator): $i = 0; $__LIST__ = $subject;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <option value="<?php echo $vo->id; ?>"><?php echo $vo->title; ?></option>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图片</label>
            <div class="layui-input-block">
                <button type="button" class="layui-btn" id="test1">上传图片</button>
                <span style="font-size: 12px;color: #cccccc">建议图片大小为：760*300</span>
                <div class="layui-upload-list">
                    <img class="layui-upload-img" id="demo1"  style="width:100px;height:100px">
                    <p id="demoText1"></p>
                    <input type="hidden" id="picture" name="picture">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">视频</label>
            <div class="layui-input-block">
                <button type="button" class="layui-btn" id="picker"><i class="layui-icon"></i>选择文件</button>
                <button type="button" class="layui-btn" id="ctlBtn">开始上传</button>
                <input type="hidden" value="" id="image">
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">内容</label>
            <div class="layui-input-block">
                <script id="editor" type="text/plain" style="width:100%;height:500px;margin: 0 auto"></script>
            </div>
            <input type="hidden" id="content" name="content">
            <div id="getContent"  onclick="getContent()" hidden></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">浏览量</label>
            <div class="layui-input-block">
                <input name="browse" id="browse" placeholder="请输入浏览量" type="text" class="layui-input" maxlength="20"
                       lay-verType="tips" lay-verify="required" value="" required/>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">商品连接</label>
            <div class="layui-input-block">
                <button type="button" class="layui-btn" id="images"><i class="layui-icon"></i>添加商品连接</button>
            </div>
            <input type="hidden" id="goods_id">
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">作者</label>
            <div class="layui-input-block">
                <input name="author" id="author" placeholder="请输入作者名称" type="text" class="layui-input" maxlength="20"
                       lay-verType="tips" lay-verify="required" value="" required/>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">作者头像</label>
            <div class="layui-input-block">
                <button type="button" class="layui-btn" id="test2">上传头像</button>
                <span style="font-size: 12px;color: #cccccc">建议图片大小为：100*100</span>
                <div class="layui-upload-list">
                    <img class="layui-upload-img" id="demo2"  style="width:100px;height:100px">
                    <p id="demoText2"></p>
                    <input type="hidden" id="headimg" name="headimg">
                </div>
            </div>
        </div>



    </form>
</div>
<script>
    layui.use(['layer', 'form', 'table', 'util', 'admin', 'formSelects','upload'], function () {
        var $ = layui.jquery;
        var layer = layui.layer;
        var form = layui.form;
        var table = layui.table;
        var util = layui.util;
        var admin = layui.admin;
        var formSelects = layui.formSelects;
        var upload=layui.upload;
    });
</script>
<script type="text/javascript">
    var file_md5   = '';   // 用于MD5校验文件
    var block_info = [];   // 用于跳过已有上传分片

    // 创建上传
    var uploader = WebUploader.create({
        swf: '/webuploader-0.1.5/Uploader.swf',
        server: '/Bigfile.php',          // 服务端地址
        pick: '#picker',              // 指定选择文件的按钮容器
        resize: false,
        chunked: true,                //开启分片上传
        chunkSize: 1024 * 1024 * 0.5,   //每一片的大小
        chunkRetry: 100,              // 如果遇到网络错误,重新上传次数
        threads: 3,                   // [默认值：3] 上传并发数。允许同时最大上传进程数。
    });
    // 上传提交
    $("#ctlBtn").click(function () {
        log('准备上传...');
        uploader.upload();
    });

    // 当有文件被添加进队列的时候-md5序列化
    uploader.on('fileQueued', function (file) {

        log("正在计算MD5值...");
        uploader.md5File(file)

            .then(function (fileMd5) {
                file.wholeMd5 = fileMd5;
                file_md5 = fileMd5;
                log("MD5计算完成。");

                // 检查是否有已经上传成功的分片文件
                $.post('<?php echo url("subject/check"); ?>', {md5: file_md5}, function (data) {
                    data = JSON.parse(data);

                    // 如果有对应的分片，推入数组
                    if (data.block_info) {
                        for (var i in data.block_info) {
                            block_info.push(data.block_info[i]);
                        }
                        log("有断点...");
                    }
                })
            });
    });

    // 发送前检查分块,并附加MD5数据
    uploader.on('uploadBeforeSend', function( block, data ) {
        var file = block.file;
        var deferred = WebUploader.Deferred();

        data.md5value = file.wholeMd5;
        data.status = file.status;

        if ($.inArray(block.chunk.toString(), block_info) >= 0) {
            log("已有分片.正在跳过分片"+block.chunk.toString());
            deferred.reject();
            deferred.resolve();
            return deferred.promise();
        }
    });

    // 上传完成后触发
    uploader.on('uploadSuccess', function (file,response) {
        log("上传分片完成。");
        log("正在整理分片...");
        $.post('<?php echo url("subject/merge"); ?>', { md5: file.wholeMd5, fileName: file.name }, function (data) {
                if(data['code']==0){
                    $('#image').val(data.url)
                    alert(data.msg)
                }else{
                    alert('上传失败')
                }
        });
    });

    // 文件上传过程中创建进度条实时显示。
    uploader.on('uploadProgress', function (file, percentage) {
        $("#percentage_a").css("width",parseInt(percentage * 100)+"%");
        $("#percentage").html(parseInt(percentage * 100) +"%");
    });

    // 上传出错处理
    uploader.on('uploadError', function (file) {
        uploader.retry();
    });

    // 暂停处理
    $("#stop").click(function(e){
        log("暂停上传...");
        uploader.stop(true);
    })

    // 从暂停文件继续
    $("#start").click(function(e){
        log("恢复上传...");
        uploader.upload();
    })

    function log(html) {
        $("#log").append("<div>"+html+"</div>");
    }

</script>
<script>
    var ue = UE.getEditor('editor');
    function getContent() {
        $('#content').val( UE.getEditor('editor').getContent())
    }
</script>
<script>
    layui.use(['layer', 'form', 'table', 'util', 'admin', 'formSelects'], function () {
        var $ = layui.jquery;
        var layer = layui.layer;
        var form = layui.form;
        var table = layui.table;
        var util = layui.util;
        var admin = layui.admin;
        var formSelects = layui.formSelects;
        // 渲染表格
        // 添加
        $('#images').click(function () {
            layer.open({
                type: 2 //此处以iframe举例
                ,title: '添加'
                ,area: ['70%', '70%']
                ,shade: 0.2
                ,maxmin: true
                ,content:"<?php echo url('subject/shopgood'); ?>"
                ,btn: ['保存关闭', '取消'] //只是为了演示
                ,yes: function(){
                    var index = parent.layer.getFrameIndex()
                    var form = layer.getChildFrame('form', index);
                    var sid = form.find('#gid').val()
                    $('#goods_id').val(sid)
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

        // 搜索
        $('#btnSearch').click(function () {
            var value = $('#edtSearch').val();
            insTb.reload({where: { key: value}});
        });
    });
    layui.use('upload', function(){
        var $ = layui.jquery
            ,upload = layui.upload;
        //添加驾驶证配图
        //添加驾驶证配图
        var uploadInst = upload.render({
            elem: '#test1'
            ,url: '<?php echo url("subject/update"); ?>'
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    $('#demo1').attr('src', result); //图片链接（base64）
                });
            }
            ,done: function(res){
                $("input[name='picture']").val(res.url);
            }
        });
        var uploadInst = upload.render({
            elem: '#test2'
            ,url: '<?php echo url("subject/update"); ?>'
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    $('#demo2').attr('src', result); //图片链接（base64）
                });
            }
            ,done: function(res){
                $("input[name='headimg']").val(res.url);
            }
        })
    })
</script>
</body>
</html>