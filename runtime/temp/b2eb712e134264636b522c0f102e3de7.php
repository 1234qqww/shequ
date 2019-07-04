<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"D:\xy\project\wuliu\public/../application/admin\view\system\setting.html";i:1561340579;}*/ ?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>网站设置</title>
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
          <div class="layui-card-header">网站基本信息</div>
          <div class="layui-card-body" pad15>
            <div class="layui-form" wid100 lay-filter="">
              <div class="layui-form-item">
                <label class="layui-form-label">网站名称</label>
                <div class="layui-input-block">
                  <input type="hidden" name="configname" value="base_config">
                  <input type="text" name="site_name" value="<?php echo config('base_config.site_name'); ?>" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">网站头像</label>
                <div class="layui-input-block">
                  <button type="button" class="layui-btn" id="upload1s">上传</button>
                  <input type="hidden" id="img_urls" name="imgs" value="<?php echo config('base_config.imgs'); ?>"/>
                  <div class="layui-upload-list">
                    <img src="<?php echo config('base_config.imgs'); ?>" class="layui-upload-img"style="width: 200px;height:12rem" id="demo2" alt=""/>
                    <p id="demoTexts"></p>
                  </div>
                </div>
              </div>
              <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">META关键词</label>
                <div class="layui-input-block">
                  <textarea name="keywords" class="layui-textarea" placeholder=""><?php echo config('base_config.keywords'); ?></textarea>
                </div>
              </div>
              <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">META描述</label>
                <div class="layui-input-block">
                  <textarea name="description" class="layui-textarea"><?php echo config('base_config.description'); ?></textarea>
                </div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">客服电话</label>
                <div class="layui-input-block">
                  <input type="text" name="service_number" value="<?php echo config('base_config.service_number'); ?>" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">客服QQ</label>
                <div class="layui-input-block">
                  <input type="text" name="service_qq" value="<?php echo config('base_config.service_qq'); ?>" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">备案服务号</label>
                <div class="layui-input-block">
                  <input type="text" name="record" value="<?php echo config('base_config.record'); ?>" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">版权信息</label>
                <div class="layui-input-block">
                  <textarea name="copyright" class="layui-textarea"><?php echo config('base_config.copyright'); ?></textarea>
                </div>
              </div>
              <div class="layui-form-item">
                <div class="layui-input-block">
                  <button class="layui-btn" lay-submit lay-filter="set_website">确认保存</button>
                </div>
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
  }).use(['index','form','hhtc'],function(){
      var $=layui.$
          ,form = layui.form
              ,hhtc=layui.hhtc
      form.render();
      form.on('submit(set_website)',function(obj){
         var result=ajax_post($,'',obj.field);
         if(result.code==1){
             layer.msg(result.msg,{icon:1});
         }else{
             layer.alert(result.msg,{icon:2})
         }
      })
    $("#upload1s").click(function(){
      hhtc.upload_one(function(res){
        $("input[name='imgs']").val(res);
        $("#demo2").attr('src',res);
      })
    })

  });
  </script>
</body>
</html>