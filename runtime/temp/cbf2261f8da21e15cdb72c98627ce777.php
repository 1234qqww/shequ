<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"D:\xy\project\shequshop\public/../application/admin\view\home\edit_pwd.html";i:1560496488;}*/ ?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>设置我的密码</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="/static/admin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="/static/admin/style/admin.css" media="all">
</head>
<body>

  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">修改密码</div>
          <div class="layui-card-body" pad15>
            <div class="layui-form" lay-filter="">
              <div class="layui-form-item">
                <label class="layui-form-label">当前密码</label>
                <div class="layui-input-inline">
                  <input type="password" name="oldPassword" lay-verify="required" lay-verType="tips" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">新密码</label>
                <div class="layui-input-inline">
                  <input type="password" name="password" lay-verify="pass" lay-verType="tips" autocomplete="off" id="LAY_password" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">6到12个字符</div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">确认新密码</label>
                <div class="layui-input-inline">
                  <input type="password" name="repassword" lay-verify="repass" lay-verType="tips" autocomplete="off" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item layui-hide">
                <button class="layui-btn" lay-submit lay-filter="edit" id="edit">提交</button>
              </div>
            </div>
          </div>
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
  }).use(['index', 'form'],function(){
      var $=layui.$
          ,form=layui.form;
      // form.verify({
      //     pass:function(value,dom){
      //         if(value.length<6 || value.length>12){
      //           layer.alert('密码长度为6-12位',{icon:2});
      //         }
      //     },
      //     repass:function(value){
      //         if(value!=$("input[name='password']").val()){
      //           layer.alert('两次密码输入不一致',{icon:2});
      //
      //         }
      //     }
      // });

      // form.on('submit(edit_pwd)',function(data){
      //     var res=ajax_post($,'',data.field);
      //     if(res.code==1){
      //         layer.msg(res.msg,{icon:1},function(){
      //             $(TABS_HEADER).eq(admin.tabsPage.index).find('.layui-tab-close').trigger('click');
      //         })
      //     }else{
      //         layer.alert(res.msg,{icon:2});
      //     }
      // })
  });

  </script>
</body>
</html>