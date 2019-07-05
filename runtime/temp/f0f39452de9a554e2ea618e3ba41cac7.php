<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:63:"D:\xy\wuliu\public/../application/admin\view\upload\upload.html";i:1560598622;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>选项卡组件</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/admin/style/admin.css" media="all">
</head>
<style>
    .files {
        width: 100%;
        overflow: hidden;
    }

    .files > .file_son {
        width: 23%;
        height: 9rem;
        margin-right: 5px;
        float: left;
        margin-bottom: 5px;
        border: 1px solid #c7e6e8ed;
        position: relative;
        overflow: hidden;
    }

    .file_son img {
        height: 7rem
    }

    .files .filecaoBox {
        width: 100%;
        height: 30px;
        background: rgba(30, 159, 255, 0.48);
        position: absolute;
        line-height: 30px;
    }

    .files .filecaoBox span {
        color: #fff;
        display: block;
        width: 100%;
        text-align: center;
    }

    .files .filecaoBox i {
        color: #FF5722;
        position: absolute;
        right: 0;
        font-size: 24px;
        top: 0;
        display: none;
    }

    .files > .file_son:hover .layui-icon-delete {
        display: block;
    }

    .ok {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: rgba(51, 51, 51, 0.8);
        display: none;
    }

    .ok > i {
        font-size: 28px;
        font-weight: bold;
        color: #1e9fff
    }
</style>
<body>
<div class="layui-fluid" id="component-tabs">

    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-body">
                <div class="layui-tab">
                    <ul class="layui-tab-title">
                        <li class="layui-this">上传图片</li>
                        <li>本地图片</li>
                        <li>网络图片</li>
                    </ul>
                    <div class="layui-tab-content">
                        <div class="layui-tab-item layui-show">
                            <input type="hidden" name="img">
                            <button type="button" onclick="uploadfile(this)" class="layui-btn" id="test-upload-normal">
                                上传图片
                            </button>
                            <input type="file" style="display:none" accept="image/*">
                            <div class="layui-upload-list upload1" style="position: relative;display:none">
                                <img onclick="choose_this(this)" class="layui-upload-img"
                                     style="width:200px;height:12rem" id="img">
                                <div class="ok" style="width:200px;height:12rem"><i
                                        class="layui-icon layui-icon-ok"></i></div>
                            </div>
                        </div>
                        <div class="layui-tab-item ">
                            <!--本地图片列表-->
                            <div class="files">
                            </div>
                            <div id="page"></div>
                        </div>
                        <div class="layui-tab-item">
                            <div class="layui-form" lay-filter="layuiadmin-form-img" id="layuiadmin-form-img">
                                <div class="layui-form-item">
                                    <div class="layui-inline" style="width:70%">
                                        <label class="layui-form-label">图片地址:</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="picurl" placeholder="请输入图片地址" autocomplete="off"
                                                   class="layui-input">
                                        </div>
                                    </div>
                                    <div class="layui-inline">
                                        <button class="layui-btn layuiadmin-btn-admin" lay-submit lay-filter="search">
                                            <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="layui-upload-list " id="internet_pic" align="center"
                                     style="position: relative;display:none">
                                    <img onclick="choose_this(this)" class="layui-upload-img"
                                         style="width:200px;height:10rem">
                                    <div class="ok" style="width:200px;height:10rem;margin:0px auto"><i
                                            class="layui-icon layui-icon-ok"></i></div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="layui-form" lay-filter="layuiadmin-form-role" id="layuiadmin-form-role" style="display:none">
            <div class="layui-form-item">
                <label class="layui-form-label">图片</label>
                <div class="layui-input-block">
                    <input type="text" name="img" lay-verify="upload_file" placeholder="请输入" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item layui-hide">
                <button class="layui-btn" lay-submit lay-filter="upload" id="upload">提交</button>
            </div>
        </div>
    </div>
</div>

<script src="/static/admin/layui/layui.js"></script>
<script src="/static/admin/js/app.js"></script>
<script>
    var $ = false;
    layui.config({
        base: '/static/admin//' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'laypage', 'form','element'], function () {
        var admin = layui.admin
                , element = layui.element
                , router = layui.router()
                , form = layui.form
                , laypage = layui.laypage;
        form.verify({
            upload_file: function (value, item) {
                if (value == '') {
                    return '请选择或者上传图片!';
                }
            }
        })
        $ = layui.$;
        //总页数大于页码总数
        laypage.render({
            elem: 'page'
            , count: <?php echo $count; ?> //数据总数
            , limit: 12
            , jump: function (obj) {
                load_files(obj.curr)
            }
        });
        element.render();

        element.on('tab(component-tabs-brief)', function (obj) {
            layer.msg(obj.index + '：' + this.innerHTML);
        });

        /* 触发事件 */
        var active = {
            tabAdd: function () {
                /* 新增一个Tab项 */
                element.tabAdd('demo', {
                    title: '新选项' + (Math.random() * 1000 | 0) /* 用于演示 */
                    , content: '内容' + (Math.random() * 1000 | 0)
                    , id: new Date().getTime() /* 实际使用一般是规定好的id，这里以时间戳模拟下 */
                })
            }
            , tabDelete: function (othis) {
                /* 删除指定Tab项 */
                element.tabDelete('demo', '22');
                othis.addClass('layui-btn-disabled');
            }
            , tabChange: function () {
                /* 切换到指定Tab项 */
                element.tabChange('demo', '33');
            }
        };

        $('#component-tabs .site-demo-active').on('click', function () {
            var othis = $(this), type = othis.data('type');
            active[type] ? active[type].call(this, othis) : '';
        });

        /* Hash地址的定位 */
        var layid = router.hash.replace(/^#layid=/, '');
        layid && element.tabChange('component-tabs-hash', layid);
        element.on('tab(component-tabs-hash)', function (elem) {
            location.hash = '/' + layui.router().path.join('/') + '#layid=' + $(this).attr('lay-id');
        });
        //监听搜索
        form.on('submit(search)', function (data) {
            var field = data.field;
            console.log(field);
            $("#internet_pic").show();
            form.render();
            $("#internet_pic").find('img').attr('src', field.picurl)
        });
    });
    var upload_lock = false;
    var last_page = 1;
    function uploadfile(obj) {
        $(obj).next('input').click();
        $(obj).next('input').change(function () {
            if ($(this).val() == '') {
                return;
            }
            if (upload_lock) {
                return;
            }
            upload_lock = true;
            var url = $(this).val();
            if (url == '') {
                return;
            }
            var arr = url.split('.');
            console.log(arr)
            var len = arr.length;
            var i = len - 1;
            if (arr[i] != 'jpg' && arr[i] != 'jpeg' && arr[i] != 'png' && arr[i] != 'gif') {
                layer.alert('上传的不是一个图片!', {icon: 2});
                return;
            }
            var imgFile = new FileReader();

            var file = this.files[0];
            ImgToBase64(file, 1080, function (base64) {
                $('.upload1').show();
                $("#img").attr('src', base64);
                upload_lock = false;
            })
        })
    }
    //图片压缩
    function ImgToBase64(file, maxLen, callBack) {
        var img = new Image();

        var reader = new FileReader();//读取客户端上的文件
        reader.onload = function () {
            var url = reader.result;//读取到的文件内容.这个属性只在读取操作完成之后才有效,并且数据的格式取决于读取操作是由哪个方法发起的.所以必须使用reader.onload，
            img.src = url;//reader读取的文件内容是base64,利用这个url就能实现上传前预览图片
        };
        img.onload = function () {
            //生成比例
            var width = img.width, height = img.height;
            //计算缩放比例
            var rate = 1;
            if (width >= height) {
                if (width > maxLen) {
                    rate = maxLen / width;
                }
            } else {
                if (height > maxLen) {
                    rate = maxLen / height;
                }
            }
            ;
            img.width = width * rate;
            img.height = height * rate;
            //生成canvas
            var canvas = document.createElement("canvas");
            var ctx = canvas.getContext("2d");
            canvas.width = img.width;
            canvas.height = img.height;
            ctx.drawImage(img, 0, 0, img.width, img.height);
            var base64 = canvas.toDataURL('image/jpeg', 0.9);
            callBack(base64);
        };
        reader.readAsDataURL(file);
    }
    function load_files(page) {
        //加载文件
        post_json = {p: page};
        last_page = page;
        var res = ajax_post($, '/admin/upload/upload', post_json);
        console.log(res);
        var html = '';
        for (i = 0; i < res.length; i++) {
            html += '<div class="file_son">';
            html += '<img onclick="choose_this(this)" src="' + res[i].url + '" width="100%" alt="">';
            html += '<div class="ok"><i class="layui-icon layui-icon-ok"></i></div>';
            html += '<div class="filecaoBox">';
            html += '<span title="' + res[i].name + '">' + res[i].name + '</span>';
            html += '<i class="layui-icon layui-icon-delete" onclick="del_pic(\'' + res[i].name + '\')"></i>';
            html += '</div>';
            html += '</div>';
        }
//            console.log(html);
        $(".files").html(html)
    }
    function del_pic(file_name) {
        layer.confirm('删除此图片？', function (index) {
//                console.log(data.admin_id)
            post_json = {file_name: file_name};
            var result = ajax_post($, '<?php echo url("upload/del_pic"); ?>', post_json);
            if (result.code == 1) {
                layer.msg(result.msg, {icon: 1}, function () {
                    load_files(last_page)
                    //table.reload('admin_list');
                    layer.close(index);
                })
            } else {
                layer.alert(result.msg, {icon: 2});
            }
        });
    }
    function choose_this(obj) {
        $(".ok").hide();
        $(obj).siblings('.ok').css('display', 'flex');
        $("input[name='img']").val($(obj).attr('src'))
    }
</script>
</body>
</html>
