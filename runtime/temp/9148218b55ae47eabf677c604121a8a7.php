<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:56:"D:\xy\wuliu\public/../application/admin\view\\index.html";i:1560740081;}*/ ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>后台管理</title>
  <link href="/easyweb/assets/images/favicon.ico" rel="icon">
  <link rel="stylesheet" href="/easyweb/assets/libs/layui/css/layui.css"/>
  <link rel="stylesheet" href="/easyweb/assets/module/admin.css?v=304"/>
  <script type="text/javascript" src="/easyweb/assets/libs/jquery/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="/easyweb/assets/libs/layui/layui.js"></script>
  <script type="text/javascript" src="/easyweb/assets/js/common.js?v=304"></script>
  <link rel="stylesheet" href="/easyweb/layout/index.css"/>
</head>
<style>
  .left-bar-secendlist-item{
    margin-bottom:20px;
  }
  .left-bar-secendlist-item>img{
    display:none;
  }
  .ball-loader span{
    display: inline-block;
    width:50px;
    height:50px;
    overflow: hidden;
    border-radius:25px;
  }
  .ball-loader span img{
    width:100%;
  }
  .layui-input, .layui-select, .layui-textarea{
    height:33px;!important;;
  }
</style>
<body>
<div class="main">
  <!--顶部标题-->
  <div class="main-right">
    <div class="left-bar-title">
      <img src="/easyweb/layout/static/test.jpg" />
    </div>
    <div class="top-title">
      <h4 style="font-weight: bold;font-size:18px"><?php echo config('base_config.site_name'); ?></h4>
      <div class="top-title-user">
        <ul class="layui-nav layui-layout-right" style="background: #fff;height:50px;">
          <li class="layui-nav-item" lay-unselect style="margin-right: 10px;">
            <a>
              <img src="/easyweb/assets/images/head.png" class="layui-nav-img">
              <cite style="color: #000">admin</cite>
            </a>
            <dl class="layui-nav-child">
              <dd lay-unselect>
                <a id="edit">修改密码</a>
              </dd>
              <dd lay-unselect>
                <a id="login_out" >退出登录</a>
              </dd>
            </dl>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!--左侧菜单-->
  <div class="main-bot">
    <div class="left-bar">
      <div class="left-bar-list">
        <a href="<?php echo url('home/welcome'); ?>" target="rightframe">
          <div  class="left-bar-list-item mind top_banner cont_banner"  >
            <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/rec.png" />
            </div>
            <div class="left-bar-list-item-font"><span>首页</span></div>
          </div>
        </a>
        <a href="<?php echo url('merchant/merchant'); ?>" target="rightframe">
          <div  class="left-bar-list-item usedcar usedcar_banner"  >
            <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/rec.png" />
            </div>
            <div class="left-bar-list-item-font"><span>商户</span></div>
          </div>
        </a>
        <a href="{<?php echo url("","",true,false);?>}">
          <div  class="left-bar-list-item business"  >
            <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/rec.png" />
            </div>
            <div class="left-bar-list-item-font"><span>用户</span></div>
          </div>
        </a>

        <a href="<?php echo url('banner/banner'); ?>" target="rightframe">
          <div  class="left-bar-list-item user"  >
            <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/rec.png" />
            </div>
            <div class="left-bar-list-item-font"><span>管理</span></div>
          </div>
        </a>
        <a href="<?php echo url('system/setting'); ?>" target="rightframe" >
          <div  class="left-bar-list-item administrators"  >
            <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/rec.png" />
            </div>
            <div class="left-bar-list-item-font"><span>设置</span></div>
          </div>
        </a>
      </div>
      <div class="left-bar-secendlist " id="1" style="display:none">
        <div   class="left-bar-secendlist-items" >
          <a href="<?php echo url('system/setting'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" id="mind">
              <span>网站设置</span>
            </div>
          </a>
          <div class="line"></div>
        </div>
      </div>
      <div class="left-bar-secendlist " id="2" style="display:none">


        <div   class="left-bar-secendlist-items" >
          <a  href="<?php echo url('banner/banner'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" id="usedcar">
              <span>首页背景</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>

          <a href="<?php echo url('banner/slide'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" id="usedcar_banner">
              <span>轮播图管理</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <div class="line"></div>
        </div>
      </div>


      <div class="left-bar-secendlist" id="3" style="display:none">
        <div   class="left-bar-secendlist-items" >
          <a href="<?php echo url('merchant/merchant'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" id="business">
              <span>商户列表</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <div class="line"></div>
        </div>
      </div>
      <div class="left-bar-secendlist" id="4" style="display:none">
        <div   class="left-bar-secendlist-items" >
          <a href="{<?php echo url("","",true,false);?>}">
            <div  class="left-bar-secendlist-item" id="advanceSale">
              <span>轮播图管理</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <div class="line"></div>
        </div>
      </div>
      <div class="left-bar-secendlist" id="5" style="display:none">
        <div   class="left-bar-secendlist-items" >
          <a href="{<?php echo url("","",true,false);?>}">
            <div  class="left-bar-secendlist-item" id="examine">
              <span>货物审核</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="{<?php echo url("","",true,false);?>}">
            <div  class="left-bar-secendlist-item" id="examine_2">
              <span>二手车审核</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="{<?php echo url("","",true,false);?>}">
            <div  class="left-bar-secendlist-item " id = "examine_3">
              <span>采购审核</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="{<?php echo url("","",true,false);?>}">
            <div  class="left-bar-secendlist-item " id = "examine_4">
              <span>采购审核</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <div class="line"></div>
        </div>
      </div>
      <div class="left-bar-secendlist" id="6" style="display:none">
        <div   class="left-bar-secendlist-items" >
          <a href="{<?php echo url("","",true,false);?>}">
            <div  class="left-bar-secendlist-item" id="member">
              <span>开通会员配置</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="{<?php echo url("","",true,false);?>}">
            <div  class="left-bar-secendlist-item" id="integral">
              <span>积分会员管理</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="{<?php echo url("","",true,false);?>}">
            <div  class="left-bar-secendlist-item " id = "rule">
              <span>会员权益</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="{<?php echo url("","",true,false);?>}">
            <div  class="left-bar-secendlist-item " id = "sign">
              <span>签到配置</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="{<?php echo url("","",true,false);?>}">
            <div  class="left-bar-secendlist-item " id = "getintegral">
              <span>获取积分</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="{<?php echo url("","",true,false);?>}">
            <div  class="left-bar-secendlist-item " id = "roof">
              <span>置顶和广告位</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <div class="line"></div>
        </div>
      </div>
    </div>
    <div class="right_bar_body" style="overflow: hidden;width: 100%;min-height:95%;display: flex;">
         <iframe id="mainContent" width="100%" height="100%" style="border: none" src="<?php echo url('home/welcome'); ?>" name="rightframe" title="rightframe"></iframe>
    </div>
  </div>
</div>
<!-- 加载动画，移除位置在common.js中 -->
<!--<div class="page-loading">-->
<!--  <div class="ball-loader">-->
<!--        <span>-->
<!--            <img src="/layout/static/test.jpg" alt="">-->
<!--        </span>-->
<!--    <span>-->
<!--            <img src="/layout/static/test.jpg" alt="">-->
<!--        </span>-->
<!--    <span>-->
<!--            <img src="/layout/static/test.jpg" alt="">-->
<!--        </span>-->
<!--    <span>-->
<!--            <img src="/layout/static/test.jpg" alt="">-->
<!--        </span>-->
<!--  </div>-->
<!--</div>-->
</body>
<script>
  // var domain = document.location.href;
  // var i = domain.lastIndexOf('/');
  // if(href == 'usedcar' || href =='usedcar_banner'){
  //   $('#2').show();
  // }
</script>
<script>
  $(function () {
    $('a').click(function () {
        var domain=$(this).attr('href');
        var i = domain.lastIndexOf('/');
        var href = domain.substr(i+1);

        if(href == 'setting.html'){
           $('#1').show();
        }else {
          $('#1').hide();
        }
        if(href == 'banner.html' || href == 'slide.html' ){
          $('#2').show();
        }else {
          $('#2').hide();
        }
        if(href=='merchant.html'){
          $('#3').show();
        }else {
          $('#3').hide();
        }




      //
      // $('.'+href).css({'background':'#24303C','border-radius':'3px'});
      // $('#'+href).find('img').show();
      // $('#'+href).css({'background':'#e9eaf0'});

    });
  });
</script>
<script src="/static/admin/js/app.js"></script>
<script>
  $('#edit').click(function(){
    layer.open({
      type: 2
      ,title: '更改页面'
      ,content: '/admin/home/edit_pwd'
      ,area: ['40%', '40%']
      ,btn: ['确定', '取消']
      ,yes: function(index, layero){
        var iframeWindow = window['layui-layer-iframe'+ index]
                ,submit = layero.find('iframe').contents().find("#edit");
        //监听提交
        iframeWindow.layui.form.on('submit(edit)', function(data){
          var field = data.field; //获取提交的字段
          console.log(field);
          //提交 Ajax 成功后，静态更新表格中的数据
          if (field.password.length<6 ||field.password.length>12){
            layer.alert('密码长度为6-12位',{icon:2});
            return;
          }

          if(field.password!=field.repassword){
            layer.alert('两次密码输入不一致',{icon:2});
            return;
          }
       var result=ajax_post($,'<?php echo url("home/edit_pwd"); ?>',field);
        if(result.code==1){
          layer.msg(result.msg,{icon:1},function(){
            location.reload();
          })
        }else{
          layer.alert(result.msg,{icon:2});
        }
        });
        submit.trigger('click');
      }
    });
  });
  $('#login_out').click(function(){
    $.post('<?php echo url("home/login_out"); ?>',function(res){
      if(res.code == 1){
        window.location.href ='<?php echo url("login/login"); ?>';
      }
    })

  })
</script>
</html>


