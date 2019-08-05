<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"D:\xy\project\shequshop\public/../application/admin\view\subject\shopgood.html";i:1564970207;}*/ ?>
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
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
            <div class="layui-form toolbar">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <input id="edtSearch" class="layui-input" type="text" placeholder="请输入商品名"/>
                    </div>
                    <div class="layui-inline">
                        <button id="btnSearch" class="layui-btn icon-btn layui-btn-sm"><i class="layui-icon">&#xe615;</i>搜索</button>
                    </div>
                </div >
            </div>.
            <form id="modelUserForm" lay-filter="modelUserForm" class="layui-form model-form">
                <input type="hidden"  id="gid" value="">
                <input type="hidden"  id="goods_name" value="">

            </form>
            <input type="hidden" value="<?php echo $goods_id; ?>" id="goods_id">


            <table class="layui-table" id="userTable" lay-filter="userTable"></table>
            <script type="text/html" id="toolbarDemo">
                <div class="layui-btn-container">
                    <button class="layui-btn layui-btn-sm" lay-event="getCheckData">选中</button>

                </div>
            </script>
        </div>
    </div>
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
<script>
    layui.use(['layer', 'form', 'table', 'util', 'admin', 'formSelects'], function () {
        var $ = layui.jquery;
        var layer = layui.layer;
        var form = layui.form;
        var table = layui.table;
        var util = layui.util;
        var admin = layui.admin;
        var formSelects = layui.formSelects;
        var goods_id=$('#goods_id').val();
        // 渲染表格
        var insTb = table.render({
            elem: '#userTable',
            url: "<?php echo url('subject/shopgoodlist'); ?>?goods_id="+goods_id,
            page: true,
            cellMinWidth: 100,
            cols: [[
                    {type:'radio'},
                    {field: 'id',align:"center",title:"id"},
                    {field: 'goods_name', title: '商品名称',align:"center"},
                    {field: 'market_price', title: '市场价',align:"center"},
                    {field: 'store_count', title: '库存',align:"center"},
                ]]
            ,done:function(res,page,count){
                // for ( var i = 0; i <res.data.length; i++){
                //     if(res.data[i]['id']==goods_id){
                //         res.data[i].LAY_CHECKED=true
                //         form.render("radio");
                //         console.log(res.data[i]['goods_name'])
                //     }
                // }
            }
        });
        table.on('radio(userTable)', function(obj){
            $('#gid').val(obj.data.id);
            $('#goods_name').val(obj.data.goods_name)
        });
        // 搜索
        $('#btnSearch').click(function () {
            var value = $('#edtSearch').val();
            insTb.reload({where: { key: value}});
        });
    });
</script>
</body>
</html>