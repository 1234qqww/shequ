<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"D:\xy\project\shequshop\public/../application/admin\view\subject\topic.html";i:1564131455;}*/ ?>
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
  <div class="layui-card">
    <div class="layui-card-body">
      <div class="layui-form toolbar">
        <div class="layui-form-item">
          <div class="layui-inline">
            <input id="edtSearch" class="layui-input" type="text" placeholder="请输入姓名"/>
          </div>
          <div class="layui-inline">
            <button id="btnSearch" class="layui-btn icon-btn layui-btn-sm"><i class="layui-icon">&#xe615;</i>搜索</button>
            <button id="btnAdd" class="layui-btn icon-btn layui-btn-sm">添加</button>
          </div>
        </div>
      </div>

      <table class="layui-table" id="userTable" lay-filter="userTable"></table>
    </div>
  </div>
</div>
<!-- 表格状态列 -->
<script type="text/html" id="tableState">
  <input type="checkbox" lay-filter="ckState" value="{{d.userId}}" lay-skin="switch"
         lay-text="正常|锁定" {{d.state==0?'checked':''}}/>
</script>
<script type="text/html" id="tableBar">
  <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit">修改</a>
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
<!-- 表单弹窗 -->
<script type="text/html" id="modelUser">
  <form id="modelUserForm" lay-filter="modelUserForm" class="layui-form model-form">
    <input type="hidden" name="id">
    <div class="layui-form-item">
      <label class="layui-form-label">律所名称</label>
      <div class="layui-input-block">
        <input name="name" placeholder="请案件名称" type="text" class="layui-input" maxlength="15"
               lay-verType="tips" lay-verify="required"  required/>
      </div>
    </div>
    <div class="layui-form-item text-right">
      <button class="layui-btn layui-btn-primary" type="button" ew-event="closePageDialog">取消</button>
      <button class="layui-btn" lay-filter="modelUserSubmit" lay-submit>保存</button>
    </div>
  </form>
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
    // 渲染表格
    var insTb = table.render({
      elem: '#userTable',
      url: "<?php echo url('subject/topiclist'); ?>",
      page: true,
      cellMinWidth: 100,
      cols: [[
        {field: 'id',align:"center",title:"id"},
        {field: 'head', title: '标题',align:"center"},
        {field: 'picture', title: '图片',align:"center",templet:function(e){
            if(e.picture) {
              return '<img src="' + e.picture + '" alt="" style="width:50px;height:50px">'
            }
        }},
        {field: 'image', title: '视屏',align:"center"},
        {field: 'author', title: '作者',align:"center"},
        {field: 'headimg', title: '头像',align:"center",templet:function(e){
            if(e.headimg) {
              return '<img src="' + e.headimg + '" alt="" style="width:50px;height:50px">'
            }
          }},
        {field: 'content', title: '内容',align:"center"},
        {field: 'browse', title: '浏览量',align:"center"},
        {field: 'goods_id', title: '商品名称',align:"center",templet:function(e){
            if(e.shop) {
              return e.shop.goods_name
            }
          }},
        {field: 'sid', title: '话题分类',align:"center",templet:function(e){
            if(e.subject) {
              return e.subject.title
            }
          }},
        {align: 'center', toolbar: '#tableBar', title: '操作', minWidth: 200}
      ]]
    });
    // 添加
    $('#btnAdd').click(function () {
      layer.open({
        type: 2 //此处以iframe举例
        ,title: '添加'
        ,area: ['100%', '100%']
        ,shade: 0.2
        ,maxmin: true
        ,content:"<?php echo url('subject/add_topic'); ?>"
        ,btn: ['保存关闭', '取消'] //只是为了演示
        ,yes: function(){
          var index = parent.layer.getFrameIndex()
          var form = layer.getChildFrame('form', index);
          form.find('#getContent').click();
          var head = form.find('#head').val()
          var picture = form.find('#picture').val()
          var image = form.find('#image').val()
          var author = form.find('#author').val()
          var content = form.find('#content').val()
          var browse = form.find('#browse').val()
          var goods_id = form.find('#goods_id').val()
          var sid = form.find('#sid').val()
          var headimg = form.find('#headimg').val()
          if(!head || !picture || !author || !content ||!browse || !goods_id || !goods_id || !sid || !headimg){
            layer.msg('缺少参数!',{icon: 2})
            return;
          }
          layer.load(2);
          $.post(
                  "<?php echo url('subject/topic_add'); ?>",
                  {head: head,picture:picture,image:image,author:author,content:content,browse:browse,goods_id:goods_id,sid:sid,headimg:headimg},
                  function(res){
                    console.log(1);
                    layer.closeAll('loading');
                    if (res.code == 0) {
                      layer.closeAll();
                      layer.msg(res.msg, {icon: 1});
                      insTb.reload();
                    } else {
                      layer.msg(res.msg, {icon: 2});
                    }
                  }
          )
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

    //监听行工具事件
    table.on('tool(userTable)', function(obj){
      var that = this;
      var data = obj.data;
      //console.log(obj)
      if(obj.event === 'edit'){
        var id = data.id;
        //多窗口模式，层叠置顶
        layer.open({
          type: 2 //此处以iframe举例
          ,title: '修改'
          ,area: ['100%', '100%']
          ,shade: 0.2
          ,maxmin: true
          ,content: "<?php echo url('subject/update_topic'); ?>?id="+id
          ,btn: ['保存关闭', '取消'] //只是为了演示
          ,yes: function(){
            var index = parent.layer.getFrameIndex()
            var form = layer.getChildFrame('form', index);
            form.find('#getContent').click();
            var head = form.find('#head').val()

            var picture = form.find('#picture').val()
            var image = form.find('#image').val()
            var author = form.find('#author').val()
            var content = form.find('#content').val()
            var browse = form.find('#browse').val()
            var goods_id = form.find('#goods_id').val()
            var sid = form.find('#sid').val()
            var headimg = form.find('#headimg').val()
            if(!head || !picture || !author || !content ||!browse || !goods_id || !goods_id || !sid || !headimg){
              alert('请填写完整')
              return;
            }
            layer.load(2);
            $.post(
                    "<?php echo url('subject/topic_edit'); ?>?id="+id,
                    {head: head,picture:picture,image:image,author:author,content:content,browse:browse,goods_id:goods_id,sid:sid,headimg:headimg},
                    function(res){
                      layer.closeAll('loading');
                      if (res.code == 0) {
                        layer.closeAll();
                        layer.msg(res.msg, {icon: 1});
                        insTb.reload();
                      } else {
                        layer.msg(res.msg, {icon: 2});
                      }
                    }
            )
          }
          ,btn2: function(){
            layer.closeAll();
          }
          ,zIndex: layer.zIndex //重点1
          ,success: function(layero){
            layer.setTop(layero); //重点2
          }
        });


      }else if(obj.event === 'del') {
        layer.confirm('真的删除吗?', function(index){
          var id = data.id;
          $.ajax({
            url: "<?php echo url('subject/topic_del'); ?>?id="+id,
            type: 'delete',
            data: {id:id},
            dataType: 'json',
            success: function(){
              obj.del();
              layer.msg('删除成功', {icon: 1});
              window.location.reload();
            }
          })
        });
      }
    });
  });
</script>
</body>
</html>

