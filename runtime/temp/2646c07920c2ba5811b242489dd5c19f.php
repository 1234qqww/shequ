<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:69:"D:\xy\project\shequshop\public/../application/admin\view\\indexs.html";i:1565235374;}*/ ?>

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
            <img src="<?php echo $good['pic']; ?>" />
        </div>
        <div class="top-title">
            <h4 style="font-weight: bold;font-size:18px"><?php echo config('base_config.site_name'); ?></h4>
            <div class="top-title-user">
                <ul class="layui-nav layui-layout-right" style="background: #fff;height:50px;">
                    <li class="layui-nav-item" lay-unselect style="margin-right: 10px;">
                        <a>
                            <img src="/easyweb/assets/images/head.png" class="layui-nav-img">
                            <cite style="color: #000"><?php echo $admin['username']; ?></cite>
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
                <a href="<?php echo url('home/welcome'); ?>" target="rightframe">
                    <div  class="left-bar-list-item mind top_banner cont_banner"  >
                        <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/shouye.png" />
                        </div>
                        <div class="left-bar-list-item-font"><span>首页</span></div>
                    </div>
                </a>
                <a href="<?php echo url('goodshop/good_back'); ?>" target="rightframe">
                    <div  class="left-bar-list-item usedcar usedcar_banner"  >
                        <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/mendian.png"/>
                        </div>
                        <div class="left-bar-list-item-font"><span>商铺</span></div>
                    </div>
                </a>
                <a href="<?php echo url('commodity/commodity'); ?>?merchantid=<?php echo $good['id']; ?>" target="rightframe">
                    <div  class="left-bar-list-item usedcar usedcar_banner"  >
                        <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/shangpin.png"/>
                        </div>
                        <div class="left-bar-list-item-font"><span>商品</span></div>
                    </div>
                </a>
                <a href="<?php echo url('group/group'); ?>?merchantid=<?php echo $good['id']; ?>" target="rightframe">
                    <div  class="left-bar-list-item "  >
                        <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/dingdan.png"/>
                        </div>
                        <div class="left-bar-list-item-font"><span>拼团</span></div>
                    </div>
                </a>
                <a href="<?php echo url('ceshi/ceshi'); ?>" target="rightframe">
                    <div  class="left-bar-list-item usedcar usedcar_banner"  >
                        <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/dingdan.png"/>
                        </div>
                        <div class="left-bar-list-item-font"><span>订单</span></div>
                    </div>
                </a>
                <a href="<?php echo url('user/user'); ?>" target="rightframe">
                    <div  class="left-bar-list-item business"  >
                        <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/yonghu.png" />
                        </div>
                        <div class="left-bar-list-item-font"><span>用户</span></div>
                    </div>
                </a>
                <a href="<?php echo url('banner/banner'); ?>" target="rightframe">
                    <div  class="left-bar-list-item user"  >
                        <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/guanli.png" />
                        </div>
                        <div class="left-bar-list-item-font"><span>管理</span></div>
                    </div>
                </a>
                <a href="<?php echo url('trand/trand'); ?>" target="rightframe">
                    <div  class="left-bar-list-item user"  >
                        <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/guanli.png" />
                        </div>
                        <div class="left-bar-list-item-font"><span>动态</span></div>
                    </div>
                </a>
                <a href="<?php echo url('report/report'); ?>" target="rightframe">
                    <div  class="left-bar-list-item user"  >
                        <div class="left-bar-list-item-img"><img  src="/easyweb/layout/static/guanli.png" />
                        </div>
                        <div class="left-bar-list-item-font"><span>通讯</span></div>
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
                    <a  href="<?php echo url('banner/banner'); ?>" target="rightframe">
                        <div  class="left-bar-secendlist-item" id="usedcar">
                            <span>广告设置</span>
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
                <div  class="left-bar-secendlist-items" >
                    <a href="<?php echo url('goodshop/good_back'); ?>" target="rightframe">
                        <div  class="left-bar-secendlist-item" id="business">
                            <span>商铺设置</span>
                            <img src="/easyweb/layout/static/right_lit.png" />
                        </div>
                    </a>

                    <a href="<?php echo url('goodshop/good_coupon'); ?>" target="rightframe">
                        <div  class="left-bar-secendlist-item" id="good_tixian">
                            <span>优惠券管理</span>

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
                    <a href="<?php echo url('commodity/commodity'); ?>?merchantid=<?php echo $good['id']; ?>" target="rightframe">
                        <div  class="left-bar-secendlist-item" id="commodity">
                            <span>销售中</span>
                            <img src="/easyweb/layout/static/right_lit.png" />
                        </div>
                    </a>
                    <a href="<?php echo url('commodity/commodity_out'); ?>?merchantid=<?php echo $good['id']; ?>" target="rightframe">
                        <div  class="left-bar-secendlist-item" id="commodity_out">
                            <span>已售罄</span>
                            <img src="/easyweb/layout/static/right_lit.png" />
                        </div>
                    </a>
                    <a href="<?php echo url('commodity/commodity_del'); ?>?merchantid=<?php echo $good['id']; ?>" target="rightframe">
                        <div  class="left-bar-secendlist-item" id="commodity_del">
                            <span>回收站</span>
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
            var h=window.location.href;
            var s=h.substring(h.lastIndexOf('/')+1,h.indexOf('.html'));
            $.post("<?php echo url('gs'); ?>",{merchantid:s},function(e){
            });

            var domain=$(this).attr('href');

            var i = domain.lastIndexOf('/');
            var href = domain.substr(i+1);
            if(href.indexOf('?')!=-1){
                var href=href.substring(0,href.indexOf('?'))
            }
            if(href == 'setting.html' || href=='wemen.html'){
                $('#1').show();
            }else {
                $('#1').hide();
            }
            if(href == 'banner.html' || href == 'slide.html' ){
                $('#2').show();
            }else {
                $('#2').hide();
            }

            if(href=='good_back.html'){
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


