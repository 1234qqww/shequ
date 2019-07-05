<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:70:"D:\xy\project\wuliu\public/../application/admin\view\banner\ceshi.html";i:1560761600;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>基于 Layui form 组件的省市区联动选择的实现</title>

    <script src="/static/js/jquery.js"></script>
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css" media="all">
    <script src="/static/admin/layui/layui.js"></script>
    <script type="text/javascript" src="/static/admin/layui/data.js"></script>
    <script type="text/javascript" src="/static/admin/layui/province.js"></script>
    <script type="text/javascript">
        var defaults = {
            s1: 'provid',
            s2: 'cityid',
            s3: 'areaid',
            v1: null,
            v2: null,
            v3: null
        };

    </script>
</head>
<body>

    <form class="layui-form">
        <div class="layui-form-item">
            <label class="layui-form-label">选择地区</label>
            <div class="layui-input-inline">
                <select name="provid" id="provid" lay-filter="provid">
                    <option value="">请选择省</option>
                </select>
            </div>
            <div class="layui-input-inline">
                <select name="cityid" id="cityid" lay-filter="cityid">
                    <option value="">请选择市</option>
                </select>
            </div>
            <div class="layui-input-inline">
                <select name="areaid" id="areaid" lay-filter="areaid">
                    <option value="">请选择县/区</option>
                </select>
            </div>

        </div>
    </form>

</body>
</html>