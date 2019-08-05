<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:77:"D:\xy\project\shequshop\public/../application/admin\view\retail\reseller.html";i:1564131455;}*/ ?>


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
    // 渲染表格
    var insTb = table.render({
      elem: '#userTable',
      url: "<?php echo url('retail/resellerlists'); ?>",
      page: true,
      cellMinWidth: 100,
      cols: [[
        {field: 'id',align:"center",title:"id"},
        { title: '申请人',align:"center",templet:function(e){
            if(e.user!=null){
              return e.user.userName;
            }else{
              return '';
            }
          }},
        { title: '推荐人',align:"center",templet:function(e){
            if(e.fuser!=null){
              return e.fuser.userName;
            }else{
              return '无';
            }
          }},
        {field: 'money', title: '账户余额',align:"center"},
        {field: 'created_at', title: '申请时间',align:"center"},
      ]]
    });
    // 添加
    $('#btnAdd').click(function () {
      layer.open({
        type: 2 //此处以iframe举例
        ,title: '添加'
        ,area: ['40%', '40%']
        ,shade: 0.2
        ,maxmin: true
        ,content:"<?php echo url('subject/add_subject'); ?>"
        ,btn: ['保存关闭', '取消'] //只是为了演示
        ,yes: function(){
          var index = parent.layer.getFrameIndex()
          var form = layer.getChildFrame('form', index);
          var title = form.find('#title').val()
          console.log(title)
          if(!title){
            alert('缺少参数!');
            return;
          }
          layer.load(2);
          $.post(
                  "<?php echo url('subject/add'); ?>",
                  {title: title},
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
        layer.confirm('确定通过审核?', function(index){
          var id = data.id;
          //console.log(id)
          $.ajax({
            url: "<?php echo url('retail/adopt'); ?>?id="+id,
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


      }else if(obj.event === 'del') {
        layer.confirm('真的删除吗?', function(index){
          var id = data.id;
          //console.log(id)
          $.ajax({
            url: "<?php echo url('subject/del'); ?>?id="+id,
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

