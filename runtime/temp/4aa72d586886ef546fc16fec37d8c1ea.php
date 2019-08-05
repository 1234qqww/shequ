<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:79:"D:\xy\project\shequshop\public/../application/admin\view\marketing\seckill.html";i:1564652544;}*/ ?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layuiAdmin 角色管理</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/admin/style/admin.css" media="all">
</head>
<body>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
            <div style="padding-bottom: 10px;">
                <button class="layui-btn layuiadmin-btn-admin" data-type="add">添加</button>
            </div>
            <table id="list" lay-filter="list"></table>
            <script type="text/html" id="goodss">
                <img src="{{d.original_img}}"  lay-event="showimg" alt="图片丢失">
                {{d.goods_name}}
            </script>


            <script type="text/html" id="action">
                <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-search"></i>查看</a>
            </script>
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
        ,hhtc: 'hhtc'
    }).use(['index', 'table','laydate','hhtc'], function(){
        var $ = layui.$
            ,form = layui.form
            ,table = layui.table
            ,laydate= layui.laydate
            ,hhtc=layui.hhtc;
        laydate.render({
            elem: '#times'
            ,range: true
        });
        var cols=[[
            {field: 'id', width: 80, title: 'ID', sort: true}
            ,{align: 'center',title: '商品名',toolbar: '#goodss'}
            ,{field: 'discount',align: 'center', title: '抢购优惠'}
            ,{field: 'quantity',align: 'center', title: '抢购数量'}
            ,{field: 'quantitys',align: 'center', title: '已购数量'}
            ,{field: 'start_time',align: 'center', title: '开始时间'}
            ,{field: 'end_time',align: 'center', title: '结束时间'}
            ,{title: '操作', width: 150, align: 'center', fixed: 'right', toolbar: '#action'}
        ]];
        //加载数据
        base_table(table,'list','/admin/marketing/seckill',cols);
        form.on('submit(search)', function(data){
            var field = data.field;
            //执行重载
            table.reload('list', {
                where: field
            });
        });
        table.on('tool(list)',function(obj){
            var data=obj.data;
            if(obj.event=='del'){
                layer.confirm('确定删除此轮播图？', function(index){
                    var post_json={id:data.id};
                    hhtc.ajax('<?php echo url("banner/del_banner"); ?>',post_json,function(res){
                        if(res.code==1){
                            layer.msg(res.msg,{icon:1},function(){
                                table.reload('list');
                                layer.close(index);
                            })
                        }else{
                            layer.alert(res.msg,{icon:2});
                        }
                    })
                });
            }else if(obj.event=='edit'){
                layer.open({
                    type: 2
                    ,content: '/admin/order/edit_order/id/'+data.id
                    ,area: ['100%', '100%']
                });
            }else if(obj.event='showimg'){
                layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 1,
                    shadeClose: true,
                    area:['768px','304px'],
                    content: '<img width="100%" src="'+data.imgs+'">'
                });
            }
        });
        //事件/
        var active = {
            add: function(){
                layer.open({
                    type: 2
                    ,title: '添加秒杀商品'
                    ,content: "<?php echo url('marketing/seckill_add'); ?>"
                    ,area: ['100%', '100%']
                    ,btn: ['确定', '取消']
                    ,yes: function(index, layero){
                        var iframeWindow = window['layui-layer-iframe'+ index]
                            ,submit = layero.find('iframe').contents().find("#add");
                        //监听提交
                        iframeWindow.layui.form.on('submit(add)', function(data){
                            var field = data.field; //获取提交的字段
                            hhtc.ajax("<?php echo url('marketing/seckill_add'); ?>",data.field,function(res){
                                if(res.code==1){
                                    layer.msg(res.msg,{icon:1},function(){
                                        table.reload('list');
                                        layer.close(index); //关闭弹层
                                    })
                                }else{
                                    layer.alert(res.msg,{icon:2});
                                }
                            })
                        });
                        submit.trigger('click');
                    }
                });
            },
            upload:function(){
                hhtc.upload_one(function(img){
                    layer.msg('图片路径为:'+img)
                });
            },
            uploads:function(){
                hhtc.upload_more(function(img){
                    var str='选择了'+img.length+'张图片;路径分别为:<br>';
                    for(i=0;i<img.length;i++){
                        str+=img[i]+'<br>';
                    }
                    layer.alert(str)
                });
            }
        }
        $('.layui-btn.layuiadmin-btn-admin').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
    });

</script>
</body>
</html>

