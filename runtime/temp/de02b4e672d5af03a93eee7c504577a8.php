<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:69:"/www/wwwroot/sq.zxrhyc.cn/public/../application/admin/view/index.html";i:1562837548;}*/ ?>
<<<<<<< HEAD
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
      <img src="<?php echo config('base_config.imgs'); ?>" />
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
      <div class="left-bar-list" >
        <a href="<?php echo url('order/order'); ?>" target="rightframe">
          <div  class="left-bar-list-item usedcar usedcar_banner"  >
            <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/shanghu.png"/>
            </div>
            <div class="left-bar-list-item-font"><span>订单</span></div>
          </div>
        </a>
        <a href="<?php echo url('marketing/marketing'); ?>" target="rightframe">
          <div  class="left-bar-list-item usedcar usedcar_banner"  >
            <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/shanghu.png"/>
            </div>
            <div class="left-bar-list-item-font"><span>营销</span></div>
          </div>
        </a>
        <a href="<?php echo url('finance/finance'); ?>" target="rightframe">
          <div  class="left-bar-list-item business"  >
            <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/yonghu.png" />
            </div>
            <div class="left-bar-list-item-font"><span>财务</span></div>
          </div>
        </a>
        <a href="<?php echo url('subject/index'); ?>"  target="rightframe">
        <a href="<?php echo url('banner/slide'); ?>" target="rightframe">
        <a href="<?php echo url('subject/index'); ?>" target="rightframe">
          <div  class="left-bar-list-item business"  >
            <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/yonghu.png" />
            </div>
            <div class="left-bar-list-item-font"><span>话题</span></div>
          </div>
        </a>
        <a href="<?php echo url('banner/banner'); ?>" target="rightframe">
          <div  class="left-bar-list-item user"  >
            <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/guanli.png" />
            </div>
            <div class="left-bar-list-item-font"><span>管理</span></div>
          </div>
        </a>
        <a href="<?php echo url('report/index'); ?>" target="rightframe">
        <a href="<?php echo url('report/index'); ?>" target="rightframe">
        <a href="<?php echo url('qudao/qudao'); ?>" target="rightframe">
          <div  class="left-bar-list-item user"  >
            <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/wxapp.png" />
            </div>
            <div class="left-bar-list-item-font"><span>渠道</span></div>
          </div>
        </a>
        <a href="<?php echo url('yingyong/yingyong'); ?>" target="rightframe">
          <div  class="left-bar-list-item user"  >
            <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/application.png" />
            </div>
            <div class="left-bar-list-item-font"><span>应用</span></div>
          </div>
        </a>
        <a href="<?php echo url('report/report'); ?>" target="rightframe">
          <div  class="left-bar-list-item user"  >
            <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/guanli.png" />
            </div>
            <div class="left-bar-list-item-font"><span>及时通讯</span></div>
          </div>
        </a>
        <a href="<?php echo url('system/setting'); ?>" target="rightframe" >
          <div  class="left-bar-list-item administrators"  >
            <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/shezhi.png" />
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
          <a href="<?php echo url('system/wemen'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" id="wemen">
              <span>关于我们</span>
            </div>
          </a>
          <div class="line"></div>
        </div>
      </div>
      <div class="left-bar-secendlist " id="2" style="display:none">
        <div   class="left-bar-secendlist-items" >
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
        <div  class="left-bar-secendlist-items" >
          <a href="<?php echo url('good/good'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" id="business">
              <span>商户列表</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('good/good_tixian'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" id="good_tixian">
              <span>提现申请</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('good/good_listadd'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" id="good_add">
              <span>入驻申请</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <div class="line"></div>
        </div>
      </div>
      <div class="left-bar-secendlist" id="4" style="display:none">
        <div   class="left-bar-secendlist-items" >
          <a href="<?php echo url('user/user'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" id="advanceSale">
              <span>用户列表</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <div class="line"></div>
        </div>
      </div>
      <div class="left-bar-secendlist" id="5" style="display:none">
        <div   class="left-bar-secendlist-items" >
          <a href="<?php echo url('commodity/commodity'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" id="commodity">
              <span>销售中</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('commodity/commodity_out'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" id="commodity_out">
              <span>已售罄</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('commodity/commodity_del'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" id="commodity_del">
              <span>回收站</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('commodity/commodity_category'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" id="commodity_category">
              <span>商品分类</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('commodity/commodity_biaoqian'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" id="commodity_biaoqian">
              <span>商品标签</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <div class="line"></div>
        </div>
      </div>
      <div class="left-bar-secendlist" id="6" style="display:none">
        <div   class="left-bar-secendlist-items" >
          <a href="<?php echo url('order/order_wait'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" >
              <span>待收货</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('order/order_wait_payment'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" >
              <span>待付款</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('order/order_order_end'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" >
              <span>已完成</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('order/order_order_close'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" >
              <span>已关闭</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('order/order_list'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" >
              <span>全部订单</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <div class="line"></div>
        </div>
      </div>
      <div class="left-bar-secendlist" id="7" style="display:none">
        <div   class="left-bar-secendlist-items" >
          <a href="<?php echo url('marketing/marketing'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" >
              <span>满额立减</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('marketing/marketing'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" >
              <span>满额包邮</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('marketing/marketing'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" >
              <span>优惠卷</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <div class="line"></div>
        </div>
      </div>
      <div class="left-bar-secendlist" id="8" style="display:none">
        <div   class="left-bar-secendlist-items" >
          <a href="<?php echo url('finance/finance'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" >
              <span>充值记录</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('finance/finance'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" >
              <span>提现明细</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('finance/finance'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" >
              <span>积分明细</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <div class="line"></div>
        </div>
      </div>
      <div class="left-bar-secendlist" id="9" style="display:none">
        <div   class="left-bar-secendlist-items" >
          <a href="<?php echo url('subject/index'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" >
              <span>话题分类</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('subject/topic'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" >
              <span>话题</span>
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

</body>
<script>
</script>
<script>
  $(function () {
    $('a').click(function () {
        var domain=$(this).attr('href');
        var i = domain.lastIndexOf('/');
        var href = domain.substr(i+1);

        if(href == 'setting.html' || href=='wemen.html'){
           $('#1').show();
        }else {
          $('#1').hide();
        }
        if(href == 'slide.html' ){
          $('#2').show();
        }else {
          $('#2').hide();
        }
        if(href=='good.html' || href == 'good_listadd.html' || href == 'good_tixian.html'){
          $('#3').show();
        }else {
          $('#3').hide();
        }
        if(href=='user.html'){
          $('#4').show();
        }else {
          $('#4').hide();
        }
        if(href=='commodity.html' || href=='commodity_out.html' || href=='commodity_del.html' || href=='commodity_category.html' ||href=='commodity_biaoqian.html'){
          $('#5').show();
        }else{
          $('#5').hide();
        }
        if(href=='order.html' || href=='order_list.html' || href=='order_order_close.html' || href=='order_order_end.html' ||href=='order_wait_payment.html' ||href=='order_wait.html' ){
          $('#6').show();
        }else{
          $('#6').hide();
        }
        if(href=='marketing.html'){
          $('#7').show();
        }else {
          $('#7').hide();
        }
        if(href=='finance.html'){
          $('#8').show();
        }else {
          $('#8').hide();
        }
      if(href=='index.html' || href=='topic.html'){
        $('#9').show();
      }else{
        $('#9').hide();
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


=======
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
      <img src="<?php echo config('base_config.imgs'); ?>" />
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
      <div class="left-bar-list" >
        <a href="<?php echo url('order/order'); ?>" target="rightframe">
          <div  class="left-bar-list-item usedcar usedcar_banner"  >
            <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/shanghu.png"/>
            </div>
            <div class="left-bar-list-item-font"><span>订单</span></div>
          </div>
        </a>
        <a href="<?php echo url('marketing/marketing'); ?>" target="rightframe">
          <div  class="left-bar-list-item usedcar usedcar_banner"  >
            <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/shanghu.png"/>
            </div>
            <div class="left-bar-list-item-font"><span>营销</span></div>
          </div>
        </a>
        <a href="<?php echo url('finance/finance'); ?>" target="rightframe">
          <div  class="left-bar-list-item business"  >
            <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/yonghu.png" />
            </div>
            <div class="left-bar-list-item-font"><span>财务</span></div>
          </div>
        </a>
        <a href="<?php echo url('subject/index'); ?>"  target="rightframe">
        <a href="<?php echo url('banner/slide'); ?>" target="rightframe">
        <a href="<?php echo url('subject/index'); ?>" target="rightframe">
          <div  class="left-bar-list-item business"  >
            <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/yonghu.png" />
            </div>
            <div class="left-bar-list-item-font"><span>话题</span></div>
          </div>
        </a>
        <a href="<?php echo url('banner/banner'); ?>" target="rightframe">
          <div  class="left-bar-list-item user"  >
            <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/guanli.png" />
            </div>
            <div class="left-bar-list-item-font"><span>管理</span></div>
          </div>
        </a>
        <a href="<?php echo url('report/index'); ?>" target="rightframe">
        <a href="<?php echo url('report/index'); ?>" target="rightframe">
        <a href="<?php echo url('qudao/qudao'); ?>" target="rightframe">
          <div  class="left-bar-list-item user"  >
            <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/wxapp.png" />
            </div>
            <div class="left-bar-list-item-font"><span>渠道</span></div>
          </div>
        </a>
        <a href="<?php echo url('yingyong/yingyong'); ?>" target="rightframe">
          <div  class="left-bar-list-item user"  >
            <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/application.png" />
            </div>
            <div class="left-bar-list-item-font"><span>应用</span></div>
          </div>
        </a>
        <a href="<?php echo url('report/report'); ?>" target="rightframe">
          <div  class="left-bar-list-item user"  >
            <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/guanli.png" />
            </div>
            <div class="left-bar-list-item-font"><span>及时通讯</span></div>
          </div>
        </a>
        <a href="<?php echo url('system/setting'); ?>" target="rightframe" >
          <div  class="left-bar-list-item administrators"  >
            <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/shezhi.png" />
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
          <a href="<?php echo url('system/wemen'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" id="wemen">
              <span>关于我们</span>
            </div>
          </a>
          <div class="line"></div>
        </div>
      </div>
      <div class="left-bar-secendlist " id="2" style="display:none">
        <div   class="left-bar-secendlist-items" >
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
        <div  class="left-bar-secendlist-items" >
          <a href="<?php echo url('good/good'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" id="business">
              <span>商户列表</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('good/good_tixian'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" id="good_tixian">
              <span>提现申请</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('good/good_listadd'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" id="good_add">
              <span>入驻申请</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <div class="line"></div>
        </div>
      </div>
      <div class="left-bar-secendlist" id="4" style="display:none">
        <div   class="left-bar-secendlist-items" >
          <a href="<?php echo url('user/user'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" id="advanceSale">
              <span>用户列表</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <div class="line"></div>
        </div>
      </div>
      <div class="left-bar-secendlist" id="5" style="display:none">
        <div   class="left-bar-secendlist-items" >
          <a href="<?php echo url('commodity/commodity'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" id="commodity">
              <span>销售中</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('commodity/commodity_out'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" id="commodity_out">
              <span>已售罄</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('commodity/commodity_del'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" id="commodity_del">
              <span>回收站</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('commodity/commodity_category'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" id="commodity_category">
              <span>商品分类</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('commodity/commodity_biaoqian'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" id="commodity_biaoqian">
              <span>商品标签</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <div class="line"></div>
        </div>
      </div>
      <div class="left-bar-secendlist" id="6" style="display:none">
        <div   class="left-bar-secendlist-items" >
          <a href="<?php echo url('order/order_wait'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" >
              <span>待收货</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('order/order_wait_payment'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" >
              <span>待付款</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('order/order_order_end'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" >
              <span>已完成</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('order/order_order_close'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" >
              <span>已关闭</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('order/order_list'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" >
              <span>全部订单</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <div class="line"></div>
        </div>
      </div>
      <div class="left-bar-secendlist" id="7" style="display:none">
        <div   class="left-bar-secendlist-items" >
          <a href="<?php echo url('marketing/marketing'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" >
              <span>满额立减</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('marketing/marketing'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" >
              <span>满额包邮</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('marketing/marketing'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" >
              <span>优惠卷</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <div class="line"></div>
        </div>
      </div>
      <div class="left-bar-secendlist" id="8" style="display:none">
        <div   class="left-bar-secendlist-items" >
          <a href="<?php echo url('finance/finance'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" >
              <span>充值记录</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('finance/finance'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" >
              <span>提现明细</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('finance/finance'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" >
              <span>积分明细</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <div class="line"></div>
        </div>
      </div>
      <div class="left-bar-secendlist" id="9" style="display:none">
        <div   class="left-bar-secendlist-items" >
          <a href="<?php echo url('subject/index'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" >
              <span>话题分类</span>
              <img src="/easyweb/layout/static/right_lit.png" />
            </div>
          </a>
          <a href="<?php echo url('subject/topic'); ?>" target="rightframe">
            <div  class="left-bar-secendlist-item" >
              <span>话题</span>
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

</body>
<script>
</script>
<script>
  $(function () {
    $('a').click(function () {
        var domain=$(this).attr('href');
        var i = domain.lastIndexOf('/');
        var href = domain.substr(i+1);

        if(href == 'setting.html' || href=='wemen.html'){
           $('#1').show();
        }else {
          $('#1').hide();
        }
        if(href == 'slide.html' ){
          $('#2').show();
        }else {
          $('#2').hide();
        }
        if(href=='good.html' || href == 'good_listadd.html' || href == 'good_tixian.html'){
          $('#3').show();
        }else {
          $('#3').hide();
        }
        if(href=='user.html'){
          $('#4').show();
        }else {
          $('#4').hide();
        }
        if(href=='commodity.html' || href=='commodity_out.html' || href=='commodity_del.html' || href=='commodity_category.html' ||href=='commodity_biaoqian.html'){
          $('#5').show();
        }else{
          $('#5').hide();
        }
        if(href=='order.html' || href=='order_list.html' || href=='order_order_close.html' || href=='order_order_end.html' ||href=='order_wait_payment.html' ||href=='order_wait.html' ){
          $('#6').show();
        }else{
          $('#6').hide();
        }
        if(href=='marketing.html'){
          $('#7').show();
        }else {
          $('#7').hide();
        }
        if(href=='finance.html'){
          $('#8').show();
        }else {
          $('#8').hide();
        }
      if(href=='index.html' || href=='topic.html'){
        $('#9').show();
      }else{
        $('#9').hide();
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


>>>>>>> 427a65f0749c027742482575e5e53a77ae5d7885
