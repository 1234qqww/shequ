<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"D:\xy\project\shequshop\public/../application/admin\view\ceshi\ceshi.html";i:1562291026;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
</head>
<body>
<form about="<?php echo url('ceshi/ceshi'); ?>" method="post" id="form1">
<div class="control-group">
    <label class="control-label"> </label>
    <div class="controls">
        <button id="add_lv1" class="btn btn-primary" type="button">添加规格项</button>
        <button id="update_table" class="btn btn-success" type="button">刷新规格项目表</button>
    </div>
</div>
<div id="lv_table_con" class="control-group" style="display: none;">
    <label class="control-label">规格项目表</label>
    <div class="controls">
        <div id="lv_table">

        </div>
    </div>
</div>
    <button type="button" id="form">确定</button>
</form>




<script src="http://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script>
    var lv1HTML = '<div class="control-group lv1">' +
        '<label class="control-label">规格名称</label>' +
        '<div class="controls">' +
        '<input type="text" name="lv1[]" placeholder="规格名称">' +
        '<button class="btn btn-primary add_lv2" type="button">添加参数</button>' +
        '<button class="btn btn-danger remove_lv1" type="button">删除规格</button>' +
        '</div>' +
        '<div class="controls lv2s"></div>' +
        '</div>';

    var lv2HTML = '<div style="margin-top: 5px;">' +
        '<input type="text" name="lv2[]" placeholder="参数名称">' +
        '<button class="btn btn-danger remove_lv2" type="button">删除参数</button>' +
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

        $('#update_table').on('click', function() {
            var lv1Arr = $('input[name="lv1[]"]');
            if (!lv1Arr || lv1Arr.length == 0) {
                $('#lv_table_con').hide();
                $('#lv_table').html('');
                return;
            }
            for (var i = 0; i < lv1Arr.length; i++) {
                var lv2Arr = $(lv1Arr[i]).parents('.lv1').find('input[name="lv2[]"]');
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
            tableHTML += '            <th width="20">现价</th>';
            tableHTML += '            <th width="20">原价</th>';
            tableHTML += '        </tr>';
            tableHTML += '    </thead>';
            tableHTML += '    <tbody>';

            var numsArr = new Array();
            var idxArr = new Array();
            //numsArr记录每个规格又多少个参数，并用idxarr记录规格数组下标 方便后边标记name
            for (var i = 0; i < lv1Arr.length; i++) {
                numsArr.push($(lv1Arr[i]).parents('.lv1').find('input[name="lv2[]"]').length);
                idxArr[i] = 0;
            }

            var len = 1;
            var rowsArr = new Array();
            for (var i = 0; i < numsArr.length; i++) {
                //len  记录参数总行数
                len = len * numsArr[i];

                var tmpnum = 1;
                for (var j = numsArr.length - 1; j > i; j--) {
                    tmpnum = tmpnum * numsArr[j];
                }
                //当前规格每个参数所占行数
                rowsArr.push(tmpnum);
            }

            for (var i = 0; i < len; i++) {
                tableHTML += '        <tr data-row="' + (i+1) + '">';

                var name = '';
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

                    var text = $(lv1Arr[j]).parents('.lv1').find('input[name="lv2[]"]').eq(n).val();
                    if (j != lv1Arr.length - 1) {
                        name += text + '_';
                    } else {
                        name += text;
                    }

                    if (i % rowsArr[j] == 0) {
                        tableHTML += '<td width="50" rowspan="' + rowsArr[j] + '" data-rc="' + (i+1) + '_' + (j+1) + '">' + text + '</td>';
                    }
                }

                tableHTML += '<td width="20"><input type="text" name="' + name + '[price]" /></td>';
                tableHTML += '<td width="20"><input type="text" name="' + name + '[original_price]" /></td>';
                tableHTML += '</tr>';
            }
            tableHTML += '</tbody>';
            tableHTML += '</table>';

            $('#lv_table_con').show();
            $('#lv_table').html(tableHTML);
        });
    });
</script>
<script>
    $('#form').click(function () {
        $.ajax({
            'url': 'ceshi/save_sku',
            'method': 'post',
            'data':$('#form1').serialize(),
            'success': function (e) {

            }
        });


    })




</script>