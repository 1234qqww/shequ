<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:85:"D:\xy\project\shequshop\public/../application/admin\view\commodity\add_commodity.html";i:1562740946;}*/ ?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>添加分类</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css" media="all">
    <script src="/static/js/jquery.js"></script>
    <style>
        .control-label {
            position: relative;
            height: 42px;
            line-height: 42px;
            border-bottom: 1px solid #f6f6f6;
            color: #333;
            border-radius: 2px 2px 0 0;
            font-size: 14px;
        }
        .controls input{
            height: 28px;
            line-height: 28px;
            padding: 0 10px;
            font-size: 12px;
            border-radius: 2px;
            cursor: pointer;
            white-space: nowrap;
            text-align: center;
            margin-right: 20px;
            border: 1px solid #e6e6e6;
        }
        .table-bordered {
            border: 1px solid #eceeef;
        }
        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
        }
        table {
            border-collapse: collapse;
            background-color: transparent;
        }
        .table-bordered thead td, .table-bordered thead th {
            border-bottom-width: 2px;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #eceeef;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #eceeef;
        }
        .table tr{
            line-height: 30px;
        }
        .table td, .table th {
            padding: .55rem;
            vertical-align: top;
            border-top: 1px solid #eceeef;
        }
        th {
            text-align: left;
        }
    </style>
</head>
<body>
<div class="layui-form" lay-filter="layuiadmin-form-role" id="layuiadmin-form-role" style="padding:35px 45px;">
<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
            <ul class="layui-tab-title">
                <li class="layui-this">基本设置</li>
                <li>库存/规格</li>
                <li>商品详情</li>
            </ul>

            <div class="layui-tab-content" style="height: 100px;">

            <div class="layui-tab-item layui-show">
                    <div class="layui-form-item">
                        <label class="layui-form-label">商品名称</label>
                        <div class="layui-input-block">
                            <input type="text"  name="goods_name"  lay-verify="required" placeholder=请输入商品名称 value="" autocomplete="off" class="layui-input" >
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">排序</label>
                        <div class="layui-input-inline">
                            <input type="number" name="sort" lay-verify="required" value="" placeholder=请输入排序号 autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux">数字越小排序越靠前</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">关键词</label>
                        <div class="layui-input-inline">
                            <input type="text"  name="goods_gjc"  value=""  placeholder=请输入关键词 autocomplete="off" class="layui-input" >
                        </div>
                        <div class="layui-form-mid layui-word-aux">商品关键词,能准确搜到商品的,比如 : 海尔电视|电视 之类的</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">赠送积分</label>
                        <div class="layui-input-inline">
                            <input type="number"  name="give_integral"    placeholder=请输入赠送积分 autocomplete="off" class="layui-input" >
                        </div>
                        <div class="layui-form-mid layui-word-aux">商品赠送积分，赠送的积分可以在积分商城进行购买商品</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">商品展示销量</label>
                        <div class="layui-input-inline">
                            <input type="number"  name="sales_sum"  value=""  placeholder=请输入商品展示销量 autocomplete="off" class="layui-input" >
                        </div>
                        <div class="layui-form-mid layui-word-aux">商品展示销量是用户看到的销量</div>
                    </div>
                    <div class="layui-form-item" id="menu_one" >
                        <label class="layui-form-label">商品类型</label>
                        <div class="layui-input-inline">
                            <select name="parent_id_1"  id="parent_id_1" model="select" lay-filter="menu_one" >
                                <option value="0">请选择商品分类</option>
                                <?php if(is_array($cat_list) || $cat_list instanceof \think\Collection || $cat_list instanceof \think\Paginator): $i = 0; $__LIST__ = $cat_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                <option value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                        <div class="layui-input-inline">
                            <select model="select"  name="parent_id_2" id="parent_id_2"  lay-filter="menu_two">
                                <option value="">请选择商品分类</option>
                            </select>
                        </div>
                        <div class="layui-input-inline">
                            <select model="select"  name="parent_id_3" id="parent_id_3"  lay-filter="menu_there">
                                <option value="">请选择商品分类</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">市场价</label>
                        <div class="layui-input-inline">
                            <input type="text"  name="market_price"  lay-verify="required" value="" placeholder=请输入市场价 autocomplete="off" class="layui-input" >
                        </div>
                        <label class="layui-form-label">本店价</label>
                        <div class="layui-input-inline">
                            <input type="text"  name="shop_price"  lay-verify="required" value="" autocomplete="off" placeholder=请输入本店价 class="layui-input" >
                        </div>
                        <label class="layui-form-label">成本价</label>
                        <div class="layui-input-inline">
                            <input type="text"  name="cost_price"  lay-verify="required" value="" autocomplete="off" placeholder=请输入成本价 class="layui-input" >
                        </div>
                        <div class="layui-form-mid layui-word-aux">尽量填写完整，有助于于商品销售的数据分析</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">商品图片</label>
                        <div class="layui-input-block">
                            <button type="button" class="layui-btn layui-btn-primary" id="upload1s"><i class="layui-icon"></i>上传</button>
                            <div class="layui-upload-list" id="demo2"></div>
                        </div>
                        <div class="layui-form-mid layui-word-aux" style="margin-left: 110px">您可以拖动图片改变其显示顺序,第一张为缩略图</div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">是否包邮</label>
                        <div class="layui-input-block">
                            <input type="checkbox" name="is_free_shipping" lay-skin="switch" lay-text="是|否"  lay-filter="switchTest" >
                        </div>
                    </div>
                    <div class="layui-form-item"  id="youfei">
                        <label class="layui-form-label">邮费</label>
                        <div class="layui-input-inline">
                            <input type="text"  name="shipping_money"  value="" placeholder=请输入邮费 autocomplete="off" class="layui-input" >
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">是否推荐</label>
                        <div class="layui-input-block">
                            <input type="checkbox" name="is_tuijian" lay-skin="switch" lay-text="是|否">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">是否显示</label>
                        <div class="layui-input-block">
                            <input type="checkbox" name="is_show"  lay-skin="switch" lay-text="是|否">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">是否热卖</label>
                        <div class="layui-input-block">
                            <input type="checkbox" name="is_hot"  lay-skin="switch" lay-text="是|否">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">是否新品</label>
                        <div class="layui-input-block">
                            <input type="checkbox" name="is_newshop"  lay-skin="switch" lay-text="是|否">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">是否上架</label>
                        <div class="layui-input-block">
                            <input type="checkbox" name="is_on_sale"  lay-skin="switch" lay-text="是|否" checked>
                        </div>
                    </div>




                </div>
            <div class="layui-tab-item">
<!--                <div class="layui-form" lay-filter="layuiadmin-form-role" id="layuiadmin-form" style="padding:35px 45px;">-->
                    <div class="layui-form-item">
                        <label class="layui-form-label">库存</label>
                        <div class="layui-input-inline">
                            <input type="text"  name="store_count"   placeholder=请输入库存 value="" autocomplete="off" class="layui-input" >
                        </div>
                        <input type="radio" name="is_reduce" value="2" title="付款减库存" checked="">
                        <input type="radio" name="is_reduce" value="1" title="拍下减库存" >
                        <input type="radio" name="is_reduce" value="3" title="永不减库存">
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">规格</label>
                        <div class="layui-input-inline">
                            <input type="checkbox" name="is_model" lay-skin="primary" title="启用产品规格" lay-filter="is_model" >
                        </div>
                        <div class="layui-form-mid layui-word-aux">启用商品规格后，商品的价格及库存以商品规格为准</div>
                    </div>
                    <div class="control-group"  id="guige" style="display: none">
                        <label class="control-label"> </label>
                        <div class="controls">
                            <button id="add_lv1"  type="button" class="layui-btn layui-btn-sm layui-btn-normal">添加规格项</button>
                            <button id="update_table"  type="button" class="layui-btn layui-btn-sm layui-btn-normal">生成规格项目表</button>
                        </div>
                    </div>
                    <div>
                        <button id="save_product" style="display: none;">保存商品</button>
                    </div>
                    <div id="lv_table_con" class="control-group" style="display: none;">
                        <label class="control-label">规格项目表</label>
                        <div class="controls">
                            <div id="lv_table">

                            </div>
                        </div>
                    </div>
            </div>
            <div class="layui-tab-item">

                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">商品详情：</label>
                        <div class="layui-input-block">
                            <!-- 加载编辑器的容器 -->
                            <!-- 加载编辑器的容器 -->
                            <form action="" method="post">
                                <script id="container" name="goods_content" type="text/plain"></script>
                            </form>
                            <!-- 配置文件 -->
                            <script type="text/javascript" src="/static/ueditor/ueditor.config.js"></script>
                            <!-- 编辑器源码文件 -->
                            <script type="text/javascript" src="/static/ueditor/ueditor.all.js"></script>
                            <!-- 实例化编辑器 -->
                        </div>
                    </div>

            </div>


    </div>
            <div class="layui-form-item layui-hide">
                <button class="layui-btn" lay-submit lay-filter="add1" id="add">提交</button>
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
    }).use(['index', 'form','hhtc','element'], function(){
        var $ = layui.$
            ,form = layui.form
            ,hhtc=layui.hhtc
            ,element = layui.element
            ,level=1
            var ue = UE.getEditor('container',{
                //这里可以选择自己需要的工具按钮名称,此处仅选择如下五个    
                //focus时自动清空初始化时的内容    

                //关闭elementPath    
                elementPathEnabled:false,
                //默认的编辑区域高度    
                initialFrameHeight:300
                //更多其他参数，请参考ueditor.config.js中的配置项    

            });


            form.on("select(menu_one)",function(data){
                var pid=data.value;
                var post_json = {parent_id: pid};
                $.post("<?php echo url('commodity/get_category'); ?>", post_json, function (res) {
                    if (res.code == 1) {
                        var html='<option value="">请选择商品分类</option>';
                        for(i=0;i<res.data.length;i++){
                            html+='<option value="'+res.data[i].id+'">'+res.data[i].name+'</option>';
                        }
                        $("select[name='parent_id_2']").html(html);
                        form.render();
                    }
                })
            });
            form.on("select(menu_two)",function(data){
                var pid=data.value;
                var post_json = {parent_id: pid};
                $.post("<?php echo url('commodity/get_category'); ?>", post_json, function (res) {
                    if (res.code == 1) {
                        var html='<option value="">请选择商品分类</option>';
                        for(i=0;i<res.data.length;i++){
                            html+='<option value="'+res.data[i].id+'">'+res.data[i].name+'</option>';
                        }
                        $("select[name='parent_id_3']").html(html);
                        form.render();
                    }
                })
            });


            form.on('switch(switchTest)', function(data){
                if(this.checked){
                    $('#youfei').hide()
                }else{

                    $('#youfei').show();
                }
            });
            form.on('checkbox(is_model)', function(data){
                if(data.elem.checked){
                   $("input[name='store_count']").attr("readOnly","true").css("background-color","#ddd").val('');
                    $('#guige').show();

                }else{
                    $("input[name='store_count']").attr("readOnly",false).css("background-color","");
                    $('#guige').hide();
                }
            });
                 var id=0 ;
                //认证图片
                $("#upload1s").click(function(){
                    id++;
                    hhtc.upload_one(function(res){
                        $('#demo2').append('<div class="file_son" style="display: inline-block" id="wrap'+id+'">' +
                            '<img src="'+ res +'" style="width: 200px;height:12rem" id="img'+id+'" draggable="true">' +
                            '<input type="hidden" name="autuimg[]" value="'+res+'"/>' +
                            ' <div onclick="dede(this)" class="filecaoBox" style="color: #CF1900;width: 30px;height: 30px;float: right">' +
                            '<i class="layui-icon layui-icon-delete" ></i></div></div>')
                    })
                });
                $('#image').click(function () {
                    hhtc.upload_one(function(res){
                        $("#beijing").val(res);
                        $("#demo1").attr('src',res);
                    })
                });
    })

</script>
<script>
    function dede(dede) {
        $(dede).parents('.file_son').remove();
        // console.log('121');
    }
    function yess() {

        console.log('21');
    }
</script>

<script>
    const dragCon = document.getElementById('demo2');
    dragCon.addEventListener('dragstart', startDrag, false);
    /**
     *  这里一定要阻止dragover的默认行为，不然触发不了drop
     */
    dragCon.addEventListener('dragover', function (e) {
        e.preventDefault();
    }, false);
    dragCon.addEventListener('drop', exchangeElement, false);
    function startDrag(e) {
        e.dataTransfer.setData('Text', e.target.id + ';' + e.target.parentElement.id);
    }
    function exchangeElement(e) {

        e.preventDefault();
        const el = e.target;
        let PE, //要插入位置的父元素
            CE; //需要交换的元素

        if (el.tagName.toLowerCase() !== 'div') {
            PE = el.parentElement;
            CE = el;
        } else {
            PE = el;
            CE = el.querySelector('img');
        }
        // console.log(PE);
        // console.log(CE);

        /**
         * 判断不在控制范围内
         */
        if (!PE.classList.contains('file_son')) {
            return;
        }

        const data = e.dataTransfer.getData('Text').split(';');
        // console.log(data);
        //交换元素
        document.getElementById(data[1]).appendChild(CE);
        PE.appendChild(document.getElementById(data[0]));
    }
</script>

<script>
    var lv1HTML = '<div class="control-group lv1 item-attr">' +
        '<label class="control-label">规格名称</label>' +
        '<div class="controls">' +
        '<input type="text" name="lv1" placeholder="规格名称" lay-verify="required">' +
        '<button class="layui-btn layui-btn-sm layui-btn-normal add_lv2" type="button">添加参数</button>' +
        '<button class="layui-btn layui-btn-sm layui-btn-danger remove_lv1" type="button">删除规格</button>' +
        '</div>' +
        '<div class="controls lv2s"></div>' +
        '</div>';

    var lv2HTML = '<div style="margin-top: 5px;">' +
        '<input type="text" name="lv2" placeholder="参数名称">' +
        '<button  class="layui-btn layui-btn-sm layui-btn-danger remove_lv2" type="button">删除参数</button>' +
        '</div>';

    $(document).ready(function() {
        $('#add_lv1').on('click', function() {
            var last = $('.control-group.lv1:last');
            if (!last || last.length == 0) {
                $(this).parents('.control-group').eq(0).after(lv1HTML);
            } else {
                last.after(lv1HTML);
            }
        });

        $(document).on('click', '.remove_lv1', function() {
            $(this).parents('.lv1').remove();
        });

        $(document).on('click', '.add_lv2', function() {
            $(this).parents('.lv1').find('.lv2s').append(lv2HTML);
        });

        $(document).on('click', '.remove_lv2', function() {
            $(this).parent().remove();
        });
        $(document).on('click', '#add', function () {
            var obj = {};
            var i = 0;
            var first = '';
            var tmp = {};
            $('#lv_table input').each(function (index, e) {
                var name = $(e).attr('name');
                var value = $(e).val();
                symbol = name.split('|')[0];
                key = name.split('|')[1];
                if (index == 0) {
                    first = symbol;
                    tmp = {symbol: symbol, item_id: 1};
                } else if (first != symbol) {
                    first = symbol;
                    i++;
                    tmp = {symbol: symbol, item_id: 1};
                }
                tmp[key] = value;
                obj[i] = tmp;
            });
            $.ajax({
                'url': "<?php echo url('commodity/save_sku'); ?>",
                'method': 'post',
                'data': obj,
                'success': function (e) {

                }
            });
        });


        $(document).on('click', '#save_attr', function() {
            save_attr();
        });
        $('#update_table').on('click', function() {
            save_attr();
//            update_table();
        });
        function update_table() {
            var lv1Arr = $('input[name="lv1"]');
            if (!lv1Arr || lv1Arr.length == 0) {
                $('#lv_table_con').hide();
                $('#lv_table').html('');
                return;
            }
            for (var i = 0; i < lv1Arr.length; i++) {
                var lv2Arr = $(lv1Arr[i]).parents('.lv1').find('input[name="lv2"]');
                if (!lv2Arr || lv2Arr.length == 0) {
                    alert('请先删除无参数的规格项！');
                    return;
                }
            }

            var tableHTML = '';
            tableHTML += '<table class="table table-bordered">';
            tableHTML += '    <thead>';
            tableHTML += '        <tr>';
            for (var i = 0; i < lv1Arr.length; i++) {
                tableHTML += '<th width="50">' + $(lv1Arr[i]).val() + '</th>';
            }
            tableHTML += '            <th width="20">市场价</th>';
            tableHTML += '            <th width="20">本店价</th>';
            tableHTML += '            <th width="20">成本价</th>';
            tableHTML += '            <th width="20">库存数量</th>';
            tableHTML += '        </tr>';
            tableHTML += '    </thead>';
            tableHTML += '    <tbody>';

            var numsArr = new Array();
            var idxArr = new Array();
            for (var i = 0; i < lv1Arr.length; i++) {
                numsArr.push($(lv1Arr[i]).parents('.lv1').find('input[name="lv2"]').length);
                idxArr[i] = 0;
            }
            var len = 1;
            var rowsArr = new Array();
            for (var i = 0; i < numsArr.length; i++) {
                len = len * numsArr[i];

                var tmpnum = 1;
                for (var j = numsArr.length - 1; j > i; j--) {
                    tmpnum = tmpnum * numsArr[j];
                }
                rowsArr.push(tmpnum);
            }
            key='test';

            for (var i = 0; i < len; i++) {
                tableHTML += '        <tr data-row="' + (i+1) + '">';

                var name = '';
                var value = '';
                for (var j = 0; j < lv1Arr.length; j++) {
                    var n = parseInt(i / rowsArr[j]);
                    if (j == 0) {
                    } else if (j == lv1Arr.length - 1) {
                        n = idxArr[j];
                        if (idxArr[j] + 1 >= numsArr[j]) {
                            idxArr[j] = 0;
                        } else {
                            idxArr[j]++;
                        }
                    } else {
                        var m = parseInt(i / rowsArr[j]);
                        n = m % numsArr[j];
                    }
                    var text = $(lv1Arr[j]).parents('.lv1').find('input[name="lv2"]').eq(n).val();
                    var id = $(lv1Arr[j]).parents('.lv1').find('input[name="lv2"]').eq(n).attr('data-id');
                    if (j != lv1Arr.length - 1) {
                        value += id + ',';
                        name += text + ',';
                    } else {
                        name += text;
                        value += id;

                    }

                    if (i % rowsArr[j] == 0) {
                        tableHTML += '<td width="50" rowspan="' + rowsArr[j] + '" data-rc="' + (i+1) + ',' + (j+1) + '">' + text + '</td>';
                    }
//                    key=$(lv1Arr[j]).val();
//                    key=$(lv1Arr[j]).attr('data-id');
                }
                tableHTML += '<td width="20"><input type="text" name="' + name + '|sku_market_price" value="' + '"/></td>';
                tableHTML += '<td width="20"><input type="text" name="' + name + '|sku_shop_price"  value="' + '" /></td>';
                tableHTML += '<td width="20"><input type="text" name="' + name + '|sku_cost_price"  value="' + '" /></td>';
                tableHTML += '<td width="20"><input type="text" name="' + name + '|sku_store_count"  value="' + '" /></td>';
                tableHTML += '</tr>';
            }
            tableHTML += '</tbody>';
            tableHTML += '</table>';

            $('#lv_table_con').show();
            $('#lv_table').html(tableHTML);

        }
        function save_attr() {
            //生成key
            var key=[];
            $('.item-attr input[name=lv1]').each(function (index,ele) {
                key.push($(ele).val());
            });
            //生成值
            var need=[];
            for ( j=0;j<key.length;j++){
                need[j]=[];
            }
            i=0;
            $('.item-attr input').each(function (index,ele) {
                if($(ele).attr('name')=='lv1' && index!=0){
                    i++;
                }else if(index!=0){
                    need[i].push($(ele).val());
                }
            });


            $.ajax({
                'url': "<?php echo url('commodity/save_attr'); ?>",
                'method': 'post',
                'data': {key: JSON.stringify(key), 'value': JSON.stringify(need)},
                'sync': 0,
                'success': function (e) {
                    key = e.data.key;
                    value = e.data.value;
                    create_attr_id(key, value);
                }
            });
        }
        function create_attr_id(key,value) {
            console.log(key,value);
            $('.item-attr input[name=lv1]').each(function (index,ele) {
                $(ele).attr('data-id',key[index]);
            });
            $('.item-attr input[name=lv2]').each(function (index,ele) {
                $(ele).attr('data-id',value[index]);
            });
            update_table();
            // $('#save_product').show();
        }
    });
</script>
</body>
</html>