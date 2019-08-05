<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"D:\xy\project\shequshop\public/../application/admin\view\order\edit_order.html";i:1564631407;}*/ ?>

<!doctype html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- Apple devices fullscreen -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <!-- Apple devices fullscreen -->
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/admin/main.css" media="all">
    <script src="/static/js/jquery.js"></script>
    <style>
    .ncm-goods-gift {
        text-align: left;
    }
    .ncm-goods-gift ul {
        display: inline-block;
        font-size: 0;
        vertical-align: middle;
    }
    .ncm-goods-gift li {
        display: inline-block;
        letter-spacing: normal;
        margin-right: 4px;
        vertical-align: top;
        word-spacing: normal;
    }
    .ncm-goods-gift li a {
        background-color: #fff;
        display: table-cell;
        height: 30px;
        line-height: 0;
        overflow: hidden;
        text-align: center;
        vertical-align: middle;
        width: 30px;
    }
    .ncm-goods-gift li a img {
        max-height: 30px;
        max-width: 30px;
    }

    a.green{

        background: #fff none repeat scroll 0 0;
        border: 1px solid #f5f5f5;
        border-radius: 4px;
        color: #999;
        cursor: pointer !important;
        display: inline-block;
        font-size: 12px;
        font-weight: normal;
        height: 20px;
        letter-spacing: normal;
        line-height: 20px;
        margin: 0 5px 0 0;
        padding: 1px 6px;
        vertical-align: top;
    }

    a.green:hover { color: #FFF; background-color: #1BBC9D; border-color: #16A086; }

    .ncap-order-style .ncap-order-details{
        margin:20px auto;
    }
    .contact-info h3,.contact-info .form_class{
        display: inline-block;
        vertical-align: middle;
    }
    .form_class i.fa{
        vertical-align: text-bottom;
    }
</style>
</head>
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3>商品订单</h3>
                <h5>商城实物商品交易订单查询及管理</h5>
            </div>
        </div>
    </div>
    <div class="ncap-order-style">
        <div class="titile">
            <h3></h3>
        </div>
        <div class="ncap-order-details">
            <form id="order-action">
                <div class="tabs-panels">
                    <div class="misc-info">
                        <h3>基本信息</h3>
                        <dl>
                            <dt>订单 ID：</dt>
                            <dd><?php echo $order['id']; ?></dd>
                            <dt>订单号：</dt>
                            <dd><?php echo $order['order_sn']; ?></dd>
                            <dt>会员：</dt>
                            <dd><?php echo $order['userName']; ?></dd>
                        </dl>
                        <dl>
                            <dt>电话：</dt>
                            <dd></dd>
                            <dt>应付金额：</dt>
                            <dd><?php echo $order['order_amount']; ?></dd>
                        </dl>
                        <dl>
                            <dt>订单状态：</dt>
                            <dd>
                                <?php switch($order['order_status']): case "0": ?>未付款<?php break; case "1": ?>待发货<?php break; case "2": ?>已退款<?php break; case "3": ?>退款申请中<?php break; case "4": ?>已退款<?php break; default: ?>错误
                                <?php endswitch; ?>
                            </dd>
                            <dt>下单时间：</dt>
                            <dd>
                                <?php echo $order['add_time']; ?>
                            </dd>
                            <dt>支付时间：</dt>
                            <dd>
                                <?php if($order['pay_time'] == ''): ?>
                                未支付
                                <?php else: ?>
                                <?php echo $order['pay_time']; endif; ?>
                            </dd>
                        </dl>
                        <dl>
                            <dt>支付方式：</dt>
                            <dd>
                                <?php echo $order['pay_name']; ?>
                            </dd>
                        </dl>

                    </div>

                    <div class="addr-note">

                        <h4>收货信息</h4>
                        <dl>
                            <dt>收货人：</dt>
                            <dd>
                            <?php echo $order['consignee']; ?>
                            </dd>
                            <dt>联系方式：</dt>
                            <dd>
                                <?php echo $order['mobile']; ?>
                            </dd>
                        </dl>
                        <?php if(isset($wuliu)): ?>
                        <dl>
                            <dt>配送方式：</dt>
                            <dd>
                                <?php echo $wuliu['wuliu_name']; ?>
                            </dd>
                        <dt>物流单号：</dt>
                                <dd>
                                    <?php echo $wuliu['wuliu_order']; ?>
                                </dd>
                            <a class="btn green"  onclick="ajax_wuliu_from('<?php echo $wuliu['id']; ?>')"><i class="fa fa-pencil-square-o"></i>修改</a>
                        </dl>

                        <?php endif; ?>
                        <dl>
                            <dt>收货地址：</dt>
                            <dd>
                                <?php echo $order['province']; ?>
                                <?php echo $order['city']; ?>
                                <?php echo $order['area']; ?>
                                <?php echo $order['address']; ?>
                            </dd>
                        </dl>

                    </div>
                    <div class="goods-info">
                        <h4>商品信息</h4>
                        <table>
                            <thead>
                            <tr>
                                <th>商品id</th>
                                <th colspan="2" style="text-align: left;">商品</th>
                                <th>规格属性</th>
                                <th>数量</th>
                                <th>单品价格</th>
                                <th>单品小计</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(is_array($goods) || $goods instanceof \think\Collection || $goods instanceof \think\Paginator): $i = 0; $__LIST__ = $goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                <tr>
                                    <td class="w30"><?php echo $vo['id']; ?></td>
                                    <td class="w30" ><img alt="" src="<?php echo $vo['original_img']; ?>"  style="width: 30px;height: 30px"/></td>
                                    <td style="text-align: left;"><?php echo $vo['goods_name']; ?><br/></td>
                                    <td class="w120"><?php echo $vo['sku']; ?></td>
                                    <td class="w60"><?php echo $vo['goods_num']; ?></td>
                                    <td class="w100"><?php echo $vo['price']; ?></td>
                                    <td class="w100"><?php echo $vo['price']*$vo['goods_num']; ?></td>
                                </tr>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </table>
                    </div>
                    <div class="total-amount contact-info">
                        <h3>订单总额：￥<?php echo $order['goods_price']; ?></h3>
                    </div>
                    <div class="contact-info">
                        <h3>费用信息 </h3>
                        <dl>
                            <dt>小计：</dt>
                            <dd><?php echo $order['goods_price']; ?></dd>
                            <dt>运费：</dt>
                            <dd>
                            <?php echo $order['shipping_price']; ?>
                            </dd>

                        </dl>
                        <dl>
                            <dt>优惠券抵扣：</dt>
                            <dd>
                                <?php echo $order['coupon_price']; ?>
                            </dd>
                            <dt>商铺优惠：</dt>
                            <dd>减：<?php echo $order['marketing_price']; ?></dd>
                        </dl>
                        <dl>
                            <dt>应付：</dt>
                            <dd><strong class="red_common"><?php echo $order['order_amount']; ?></strong></dd>
                        </dl>
                    </div>
                    <div class="contact-info">
                        <h3>操作信息</h3>

                        <dl class="row">
                            <dt class="tit">
                                <label >可执行操作</label>
                            </dt>
                            <dd class="opt" style="margin-left:10px">
                                <?php if(is_array($btn) || $btn instanceof \think\Collection || $btn instanceof \think\Paginator): if( count($btn)==0 ) : echo "" ;else: foreach($btn as $k=>$bt): ?>
                                    <a class="ncap-btn-big ncap-btn-green"  onclick="ajax_submit_form('<?php echo $order['id']; ?>','<?php echo $k; ?>')">
                                        <?php echo $bt; ?></a>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </dd>



                        </dl>
                    </div>


                </div>
            </form>
        </div>
    </div>
</div>
<script src="/static/admin/layui/layui.js"></script>
<script src="/static/admin/js/app.js"></script>
<script type="text/javascript">

    layui.config({
        base: '/static/admin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
        ,hhtc: 'hhtc'
    }).use(['index', 'table','laydate','hhtc'], function(){
        var $ = layui.$
            ,form = layui.form
            ,table = layui.table
            ,laydate= layui.laydate
            ,hhtc=layui.hhtc;


    });

    function ajax_submit_form(id,key) {
        if(key=='delivery'){
            layer.open({
                type: 2,
                title:'物流单号选择'
                ,content: '/admin/order/order_wuliu/id/'+id
                ,area: ['30%', '30%']
                ,btn: ['确定', '取消']
                ,yes: function(index, layero){
                    var iframeWindow = window['layui-layer-iframe'+ index]
                        ,submit = layero.find('iframe').contents().find("#add");
                    //监听提交
                    iframeWindow.layui.form.on('submit(add)', function(data){
                        var field = data.field; //获取提交的字段
                        $.post("<?php echo url('order/order_wuliu'); ?>",data.field,function(res){
                            if(res.code==1){
                                layer.msg(res.msg,{icon:1},function(){
                                    layer.close(index); //关闭弹层
                                    $.post("<?php echo url('order/order_action'); ?>",{'order_id':id,'key':key},function(res){
                                            if(res.code==1){
                                                location.reload();
                                            }
                                    },'json');
                                })
                            }else{
                                layer.alert(res.msg,{icon:2});
                            }
                        })
                    });
                    submit.trigger('click');
                }
            });
        }else{
            $.post("<?php echo url('order/order_action'); ?>",{'order_id':id,'key':key},function(res){

            },'json');
        }
    }
    function ajax_wuliu_from(id) {
        layer.open({
            type: 2,
            title:'物流单号选择'
            ,content: '/admin/order/order_wuliu_edit/id/'+id
            ,area: ['30%', '30%']
            ,btn: ['确定', '取消']
            ,yes: function(index, layero){
                var iframeWindow = window['layui-layer-iframe'+ index]
                    ,submit = layero.find('iframe').contents().find("#add");
                //监听提交
                iframeWindow.layui.form.on('submit(add)', function(data){
                    var field = data.field; //获取提交的字段
                    $.post("<?php echo url('order/order_wuliu_edit'); ?>",data.field,function(res){
                        if(res.code==1){
                            layer.msg(res.msg,{icon:1},function(){
                                layer.close(index); //关闭弹层
                                location.reload();
                            })
                        }else{
                            layer.alert(res.msg,{icon:2});
                        }
                    })
                });
                submit.trigger('click');
            }
        });

    }
    function delfun() {
        // 删除按钮
        layer.confirm('确认删除？', {
            btn: ['确定'] //按钮
        }, function () {
            console.log("确定");
        }, function () {
            console.log("取消");
        });
    }

</script>
</body>
</html>