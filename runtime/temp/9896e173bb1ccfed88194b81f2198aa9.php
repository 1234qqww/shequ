<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"/www/wwwroot/sq.zxrhyc.cn/public/../application/admin/view/good/good.html";i:1562835429;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>应用</title>
    <link href="/static/js/bootstrap.min.css?v=201903080001" rel="stylesheet">
    <link rel="stylesheet" href="/static/js/common.css?v=201903080001"/>
    <script src="/static/js/jquery.js"></script>
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/admin/style/admin.css" media="all">
</head>
<body>
<div class="main" style="margin:10px 0px">
    <div class="container">
        <div class="panel panel-content main-panel-content">
            <div class="panel-body clearfix main-panel-body " >
                <div class="right-content">
                    <div class="we7-page-title">店铺管理</div>
                    <!-- start用户管理菜单和消息管理菜单特殊,走自己的we7-page-tab,故加此if判断;平台/应用/我的账户无we7-page-table -->
                    <ul class="we7-page-tab">
                        <li class="actives"><a href="">店铺列表</a></li>
                    </ul>
                    <!-- end用户管理菜单和消息管理菜单特殊,走自己的we7-page-tab;平台/应用/我的账户无we7-page-table -->
                    <style>
                        .we7-table.vertical-middle > tbody > tr > td, .vertical-middle.wechat-communication > tbody > tr > td {
                            vertical-align: middle;
                            float: left;
                            width: 100%;
                        }
                        .we7-table > tbody > tr > td:first-child, .wechat-communication > tbody > tr > td:first-child {
                            padding-left: 0px;
                        }

                        .modal-type .modal-dialog .modal-body .type-list .item {
                            width: 218px;
                        }
                    </style>
                    <div class="clearfix ">
                        <div class="search-box we7-margin-bottom">
                            <form action="" class="search-form " method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="inp" name="name" placeholder="搜索店铺名">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" onclick="button(this)">Go!</button>
                                    </span>
                                </div>
                            </form>
                            <a href="javascript:;"  class="btn btn-primary we7-padding-horizontal"  id="add_dianbu" >添加店铺</a>
                            <!-- Button trigger modal -->
                        </div>
                    </div>
                    <!-- 列表数据 start -->
                    <table class="table we7-table table-hover vertical-middle table-manage ng-scope" id="js-system-account-display" ng-controller="SystemAccountDisplay">
                        <colgroup>
                            <col width="100px">
                            <col width="400px">
                            <col width="">
                            <col width="">
                            <col width="260px">
                        </colgroup>
                        <tbody>
                        <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <tr class="color-gray ng-scope" ng-repeat="list in lists" ng-show="list.current_user_role != 'clerk'">

                            <td class="td-link">
                                <a href="javascript:;"><img src="<?php echo $vo['pic']; ?>" class="img-responsive account-img icon"></a>
                            </td>
                            <td>
                                <p class="color-dark ng-binding" ng-bind="list.name"><?php echo $vo['name']; ?></p>
                            </td>
                            <td>
                                <p>入驻时间：<text ng-bind="list.end" class="ng-binding"><?php echo $vo['date']; ?></text>
                                </p>
                            </td>

                            <td class="vertical-middle table-manage-td">
                                <div class="link-group">
                                    <!-- ngIf: !list.support_version --><a href="<?php echo url('index/goodindexs',['id'=>$vo['id']]); ?>" target="_blank">进入店铺</a>
                                    <!-- end ngIf: !list.support_version -->


                                    <!-- ngIf: list.support_version -->

                                    <!-- ngIf: list.manage_premission --><a onclick="edits('<?php echo $vo['id']; ?>')"  >管理设置</a>
                                    <!-- end ngIf: list.manage_premission -->
                                </div>

                                <div class="text-right">
                                </div>
                            </td>
                        </tr>

                        <?php endforeach; endif; else: echo "" ;endif; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
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
        $('#add_dianbu').click(function () {
            layer.open({
                type: 2
                , title: ''
                , content: '/admin/good/good_adds'
                , area: ['100%', '100%']
                , btn: ['确定', '取消']
                , yes: function (index, layero) {
                    var iframeWindow = window['layui-layer-iframe' + index]
                        , submit = layero.find('iframe').contents().find("#add");
                    //监听提交
                    iframeWindow.layui.form.on('submit(add)', function (data) {

                        hhtc.ajax("<?php echo url('good/good_adds'); ?>", data.field, function (res) {
                            if (res.code == 1) {
                                layer.msg(res.msg, {icon: 1}, function () {
                                    document.location.reload();
                                    layer.close(index); //关闭弹层
                                })
                            } else {
                                layer.alert(res.msg, {icon: 2});
                            }
                        })
                    });
                    submit.trigger('click');
                }
            });
        });



    });
</script>
<script>
    function button(btn) {
        var G=document.getElementById('inp').value;
            if(G==''){
                alert('请输入')
                return
            }
           $.post( "good",{name:G}, function( html ) {
               $("body").html(html);


           })
    }
    function edits(edit) {
        layer.open({
            type: 2
            , title: ''
            , content: '/admin/good/good_edit?id='+edit
            , area: ['100%', '100%']
            , btn: ['确定', '取消']
            , yes: function (index, layero) {
                var iframeWindow = window['layui-layer-iframe' + index]
                    , submit = layero.find('iframe').contents().find("#edit");
                //监听提交
                iframeWindow.layui.form.on('submit(edit)', function (data) {

                    $.post("<?php echo url('good/good_edit'); ?>", data.field, function (res) {
                        if (res.code == 1) {
                            layer.msg(res.msg, {icon: 1}, function () {
                                document.location.reload();
                                layer.close(index); //关闭弹层
                            })
                        } else {
                            layer.alert(res.msg, {icon: 2});
                        }
                    })
                });
                submit.trigger('click');
            }
        });





    }





</script>
</html>