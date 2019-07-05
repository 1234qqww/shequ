<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:70:"D:\xy\project\wuliu\public/../application/admin\view\home\welcome.html";i:1561341135;}*/ ?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>layuiAdmin 控制台主页一</title>
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
        <div class="layui-row layui-col-space15">
          <div class="layui-col-md12">
            <div class="layui-card">
              <div class="layui-card-header">快捷方式</div>
              <div class="layui-card-body">
                <div class="layui-carousel layadmin-carousel layadmin-shortcut">
                  <div carousel-item>
                    <ul class="layui-row layui-col-space10">
                      <li class="layui-col-xs6">
                        <a href="<?php echo url('merchant/merchant'); ?>">
                          <i class="layui-icon layui-icon-list"></i>
                          <cite>商户列表</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a href="<?php echo url('user/user'); ?>">
                          <i class="layui-icon layui-icon-user"></i>
                          <cite>用户列表</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a href="<?php echo url('banner/banner'); ?>">
                          <i class="layui-icon layui-icon-app"></i>
                          <cite>管理</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a href="<?php echo url('system/setting'); ?>">
                          <i class="layui-icon layui-icon-set-fill"></i>
                          <cite>设置</cite>
                        </a>
                      </li>
                      <!--<li class="layui-col-xs3">-->
                        <!--<a lay-href="component/progress/index.html">-->
                          <!--<i class="layui-icon layui-icon-find-fill"></i>-->
                          <!--<cite>进度条</cite>-->
                        <!--</a>-->
                      <!--</li>-->
                      <!--<li class="layui-col-xs3">-->
                        <!--<a lay-href="app/workorder/list.html">-->
                          <!--<i class="layui-icon layui-icon-survey"></i>-->
                          <!--<cite>工单</cite>-->
                        <!--</a>-->
                      <!--</li>-->
                      <!--<li class="layui-col-xs3">-->
                        <!--<a lay-href="user/user/list.html">-->
                          <!--<i class="layui-icon layui-icon-user"></i>-->
                          <!--<cite>用户</cite>-->
                        <!--</a>-->
                      <!--</li>-->
                      <!--<li class="layui-col-xs3">-->
                        <!--<a lay-href="set/system/website.html">-->
                          <!--<i class="layui-icon layui-icon-set"></i>-->
                          <!--<cite>设置</cite>-->
                        <!--</a>-->
                      <!--</li>-->
                    </ul>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script src="/static/admin/layui/layui.js?t=1"></script>
  <script>
  layui.config({
    base: '/static/admin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'console']);
  </script>
</body>
</html>

