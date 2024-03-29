<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"D:\xy\project\shequshop\public/../application/admin\view\retail\broker.html";i:1564131455;}*/ ?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>layuiAdmin 角色管理</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="/easyweb/assets/libs/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="/static/admin/style/admin.css" media="all">
  <script src="/static/js/jquery.js"></script>
  <style>
    .layui-table-cell{
      height:60px;
      line-height:60px;
    }
    .layui-table img{
      height: 60px;
      width: 60px;
    }
    .shuxin{
      margin: 0 20px;
      color: #0e0e0e;
    }
    .shuxin1{
      margin: 0 20px;
      color: #fb0b03;
    }
  </style>
</head>
<body>

<div class="layui-fluid">
  <div class="layui-card"  style="padding:40px 0">
    <form class="layui-form" style="max-width: 700px"  action="" onsubmit="return false;" id="deploy">
      <div class="layui-form-item" style="margin-top:30px">
      <label class="layui-form-label">佣金比例</label>
      <div class="layui-input-block">
        <input type="text" name="broker" id="broker" placeholder="发送消息" class="layui-input"
               lay-verify="required" value="<?php echo !empty($info)?$info->broker:''; ?>" style="width:80%" required/>

        <input type="hidden" value="<?php echo !empty($info)?$info->id:''; ?>" id="broder_id">
      </div>
    </div>
      <div class="layui-form-item" style="margin-top:30px">
        <label class="layui-form-label">抽成</label>
        <div class="layui-input-block">
          <input type="text" name="percent" id="percent" placeholder="抽成比例" class="layui-input"
                 lay-verify="required" value="<?php echo !empty($info)?$info->percent:''; ?>" style="width:80%" required/>
        </div>
      </div>
      <div class="layui-form-item">
        <div class="layui-input-block">
          <button class="layui-btn" lay-submit="" lay-filter="demo1" id="demo1">保存</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script type="text/html" id="tableBar">
  <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit">通过</a>
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">驳回</a>
</script>
<!-- js部分 -->
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/easyweb/assets//js/common.js?v=304"></script>
<script type="text/javascript" src="/easyweb/assets/libs/jquery/jquery-3.2.1.min.js"></script>
<script>
  layui.use(['layer', 'form', 'table', 'util', 'admin', 'formSelects'], function () {
    var $ = layui.jquery;
    var layer = layui.layer;
    var form = layui.form;
    var table = layui.table;
    var util = layui.util;
    var admin = layui.admin;
    var formSelects = layui.formSelects;

    //监听行工具事件
    form.on('submit(demo1)', function (data) {
      var broker=$('#broker').val();
      var broker_id=$('#broder_id').val();
      var percent=$('#percent').val();
      if(!broker || !percent){
        layer.msg('请填写佣金比例');
        return;
      }
      $.post("<?php echo url('retail/retadd'); ?>",
              {broker:broker,id:broker_id,percent:percent}
              ,function (data) {
                location.reload();
              })
    });
  });
</script>
</body>
</html>

