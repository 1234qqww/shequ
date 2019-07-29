<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:68:"D:\xy\project\shequshop\public/../application/admin\view\\login.html";i:1564365591;}*/ ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo config('base_config.site_name'); ?></title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="keywords" content="<?php echo config('base_config.keywords'); ?>">
  <meta name="description" content="<?php echo config('base_config.description'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="/static/admin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="/static/admin/style/admin.css" media="all">
  <link rel="stylesheet" href="/static/admin/style/login.css" media="all">
  <link href="/static/css/app.css?v=1.1.33" rel="stylesheet">
  <link rel="stylesheet" href="/static/css/font_855362_tk5yxx1d41.css">
  <script src="/static/js/jquery-3.4.1.min.js"></script>
</head>
<body>

<div class="user-login-login app-body">
  <div class="login-body">
    <div class="es-content">
      <div class="login-box clearfix">
        <div class="plugin pull-left">
          <div class="plugin-info">
            <img src="/static/image/login_bg.png" alt="">
          </div>
        </div>
        <div class="login-form">
          <p class="title font-22 es-primary-text line-height-22 bold">登录</p>
          <form autocomplete="off" class="ivu-form ivu-form-label-right">
            <div class="ivu-form-item ivu-form-item-required">
              <div class="ivu-form-item-content" style="margin-left: 0px;">
                <div class="input ivu-input-wrapper ivu-input-wrapper-default ivu-input-type">
                  <i class="ivu-icon ivu-icon-ios-loading ivu-load-loop ivu-input-icon ivu-input-icon-validate"></i>
                  <input name="username" type="text" placeholder="请输入登陆账号" class="ivu-input ivu-input-default ivu-input-with-prefix">
                  <span class="ivu-input-prefix">
											<i class="ivu-icon icon-shoujihao iconfont"></i>
										</span>
                </div>
                <div class="ivu-form-item-error-tip" id="phonets"></div>
              </div>
            </div>
            <div class="ivu-form-item ivu-form-item-required">
              <div class="ivu-form-item-content" style="margin-left: 0px;">
                <div class="input ivu-input-wrapper ivu-input-wrapper-default ivu-input-type">
                  <i class="ivu-icon ivu-icon-ios-loading ivu-load-loop ivu-input-icon ivu-input-icon-validate"></i>
                  <input name="password" type="password" placeholder="请输入密码" class="ivu-input ivu-input-default ivu-input-with-prefix">
                  <span class="ivu-input-prefix">
											<i class="ivu-icon icon-mima iconfont"></i>
										</span>
                </div>
                <div class="ivu-form-item-error-tip" id="passwordts"></div>
              </div>
            </div>
            <button type="button" class="login-btn ivu-btn ivu-btn-default">
              <span>确定</span>
            </button>
          </form>

          <!-- <p class="handle font-12 es-666-text line-height-12"> -->
          <!-- <a href="#" class="">注册账号</a>  -->
          <!-- <a href="#" class="pull-right">忘记密码？</a> -->
          <!-- </p> -->
        </div>
      </div>
    </div>
  </div>
  <div class="user-footer">
    <div class="footer">
      <div class="es-content">
        <p class="footer-info font-12">技术支持由四川线上客信息技术开发有限公司提供</p>

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
  }).use(['index', 'form'], function(){
    var $ = layui.$
            ,setter = layui.setter
            ,admin = layui.admin
            ,form = layui.form
            ,router = layui.router()
            ,search = router.search;
    form.render();
    $("button").click(function(){
      var username = $("input[name='username']").val();
      var password = $("input[name='password']").val();

      if(!password){
        $('#passwordts').text('请输入密码')

      }else{
        $('#passwordts').text('')
      }
      var result=ajax_post($,"",{username:username,password:password});
      if(result.code==1){
        layer.msg(result.msg,{icon:1},function(){
          location="";
        })
      }else{
        var index=layer.alert(result.msg,{icon:2},function(){
          layer.close(index);
          $("#LAY-user-get-vercode").attr('src','/admin/login/getcaptcha/id/admin_login?t='+ new Date().getTime())
        });
      }
    })
    // form.on('submit(LAY-user-login-submit)', function(obj){
    //   console.log(obj);
    //   return;
    //   var result=ajax_post($,"",obj.field);
    //   if(result.code==1){
    //     layer.msg(result.msg,{icon:1},function(){
    //       location="";
    //     })
    //   }else{
    //     var index=layer.alert(result.msg,{icon:2},function(){
    //       layer.close(index);
    //       $("#LAY-user-get-vercode").attr('src','/admin/login/getcaptcha/id/admin_login?t='+ new Date().getTime())
    //     });
    //   }
    // });
  });
</script>
</html>