<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>产品列表</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="<?php echo base_url('resource/css/adminStyle.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url('resource/css/font-awesome.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('resource/css/simple-line-icons.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('resource/css/style.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('resource/css/renew.css') ?>" rel="stylesheet" type="text/css">
    <script src="<?php echo base_url('resource/js/jquery.js') ?>"></script>
    <script src="<?php echo base_url('resource/js/public.js') ?>"></script>
    <script src="<?php echo base_url('resource/js/tether.min.js') ?>"></script>
    <script src="<?php echo base_url('resource/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo base_url('resource/js/pace.min.js') ?>"></script>
    <script src="<?php echo base_url('resource/js/Chart.min.js') ?>"></script>

</head>
<body>
<div class="wrap">
    <div class="page-title">
        <span class="modular fl"><i></i><em>产品列表</em></span>
        <span class="modular fr"><a href="<?php echo site_url('product/create') ?>"
                                    class="pt-link-btn">+添加新商品</a></span>
    </div>
    <form method="post" accept-charset="utf-8" action="<?= site_url('product/search') ?>" target="_self">
        <div>
            <div class="input-group">
                <input type="text" id="input2-group2" name="search_box" class="form-control" placeholder="搜索产品标题">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </span>
            </div>
        </div>
    </form>
    <br>
    <form>
        <div class="col-md-9 limit_select">
            <select id="select_fir" name="select_fir" class="form-control" onchange="change_fir()">
                <option value="-1">一级分类</option>
                <?php foreach ($lists as $row) { ?>
                    <option value="<?= $row['category_id'] ?>"><?= $row['category_name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-9 limit_select">
            <select id="select_sec" name="select_sec" class="form-control" onchange="change_sec()">
                <option value="0">二级分类</option>

            </select>
        </div>
        <div class="col-md-9 limit_select">
            <select id="select_thi" name="select_thi" class="form-control" onchange="change_thi()">
                <option value="0">三级分类</option>

            </select>
        </div>
    </form>
    </br>
    <table class="list-style Interlaced list_table" id="output_box">
        <tr>
            <th style="text-align: center">产品名称</th>
            <th style="text-align: center">价格</th>
            <th style="text-align: center">所属分类</th>
            <th style="text-align: center">库存量</th>
            <th style="text-align: center">修改者</th>
            <th style="text-align: center">修改时间</th>
            <th style="text-align: center">操作</th>
        </tr>
        <?php foreach ($rows as $row) { ?>
            <tr>
                <td class="center">
                <span>
                    <?= $row['product_name'] ?>
                </span>
                </td>
                <td class="center">
                <span>
                    <?= $row['product_price'] ?>
                </span>
                </td>
                <td class="center">
                <span>
                    <?= $row['category_name'] ?>
                </span>
                </td>
                <td class="center">
                <span>
                    <?= $row['product_quantity'] ?>
                </span>
                </td>
                <td class="center">
                <span>
                    <?= $row['username'] ?>
                </span>
                </td>
                <td class="center">
                <span>
                    <?= $row['update_time'] ?>
                </span>
                </td>
                <td class="center">
                    <a title="编辑" href="<?= site_url('product/alter/' . $row['product_id']) ?>">
                        <img src="<?php echo base_url('resource/img/base/icon_edit.gif') ?>"/>
                    </a>
                    <a title="删除" href="<?= site_url('product/delete/' . $row['product_id']) ?>"
                       onclick="return confirm('确认删除?');">
                        <img src="<?php echo base_url('resource/img/base/icon_drop.gif') ?>"/>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <!-- BatchOperation -->
    <!-- turn page -->
    <div id="pag">
        <?php echo $this->pagination->create_links(); ?>
    </div>
</div>


<script>
    var table_fir = $.trim($('#output_box').html());
    var table_sec = $.trim($('#output_box').html());
    var table_thi = $.trim($('#output_box').html());

    function del_confirm() {
        return confirm("确认删除?");
    }

    function change_fir() {
        var id_fir = $.trim($("#select_fir").val());

        if (id_fir != -1) {
            $.ajax({
                type: "POST",
//                contentType: "application/json",
                url: "<?=site_url('product/list_fir')?>",
                dataType: "json",
                data: "id_fir=" + id_fir,
                success: function (output) {

                    var data_list = output.data_list;
                    var data_table = output.data_table;
                    $("#select_sec").html('<option value="-1">二级分类</option>');
                    $.each(data_list, function (index, obj) {
                        $("#select_sec").append('<option value="' + obj.category_id + '">' + obj.category_name + '</option>');
                    });

                    $("#output_box").html('<tr> <th style="text-align: center">产品名称</th> <th style="text-align: center">价格</th> ' +
                        '<th style="text-align: center">所属分类</th> <th style="text-align: center">库存量</th> ' +
                        '<th style="text-align: center">修改者</th> <th style="text-align: center">修改时间</th> ' +
                        '<th style="text-align: center">操作</th> </tr>');
                    $.each(data_table, function (index, obj) {
                        $("#output_box").append('<tr> <td class="center"> <span>' + obj.product_name + '</span> </td> ' +
                            '<td class="center"> <span>' + obj.product_price + '</span> </td> ' +
                            '<td class="center"> <span>' + obj.category_name + '</span> </td> ' +
                            '<td class="center"> <span>' + obj.product_quantity + '</span> </td> ' +
                            '<td class="center"> <span>' + obj.username + '</span> </td> ' +
                            '<td class="center"> <span>' + obj.update_time + '</span> </td> ' +
                            '<td class="center"> ' +
                            '<a title="编辑" href="http://pro_product.loc/index.php/product/alter/' + obj.product_id + '"> ' +
                            '<img src="http://pro_product.loc/resource/img/base/icon_edit.gif"/> ' +
                            '</a> ' +
                            '<a title="删除" href="http://pro_product.loc/index.php/product/delete/' + obj.product_id + '" onclick="del_confirm()"> ' +
                            '<img src="http://pro_product.loc/resource/img/base/icon_drop.gif"/> ' +
                            '</a> ' +
                            '</td> ' +
                            '</tr>');
                    });

                    $.getScript("<?= base_url('resource/js/public.js');?>");

                    $('#pag').html("");
                    table_sec = $.trim($("#output_box").html());
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(XMLHttpRequest.status);
                    alert(XMLHttpRequest.readyState);
                    alert(textStatus);
                },
            });
        } else {
            $("#output_box").html(table_fir);
            $("#select_sec").html('<option value="-1" selected>二级分类</option>');
            $("#select_thi").html('<option value="-1" selected>三级分类</option>');
            $("#pag").html('<?= $this->pagination->create_links();?>');
            $.getScript("<?= base_url('resource/js/public.js');?>");
        }
    }

    function change_sec() {
        var id_sec = $.trim($("#select_sec").val());
        if (id_sec != -1) {
            $.ajax({
                type: "POST",
                url: "<?=site_url('product/list_sec')?>",
                dataType: "json",
                data: {"id_sec": id_sec},
                success: function (output) {
                    var data_list = output.data_list;
                    var data_table = output.data_table;

                    $("#select_thi").html('<option value="-1">三级分类</option>');
                    $.each(data_list, function (index, obj) {
                        $("#select_thi").append('<option value="' + obj.category_id + '">' + obj.category_name + '</option>');
                    });

                    $("#output_box").html('<tr> <th style="text-align: center">产品名称</th> <th style="text-align: center">价格</th> ' +
                        '<th style="text-align: center">所属分类</th> <th style="text-align: center">库存量</th> ' +
                        '<th style="text-align: center">修改者</th> <th style="text-align: center">修改时间</th> ' +
                        '<th style="text-align: center">操作</th> </tr>');
                    $.each(data_table, function (index, obj) {
                        $("#output_box").append('<tr> <td class="center"> <span>' + obj.product_name + '</span> </td> ' +
                            '<td class="center"> <span>' + obj.product_price + '</span> </td> ' +
                            '<td class="center"> <span>' + obj.category_name + '</span> </td> ' +
                            '<td class="center"> <span>' + obj.product_quantity + '</span> </td> ' +
                            '<td class="center"> <span>' + obj.username + '</span> </td> ' +
                            '<td class="center"> <span>' + obj.update_time + '</span> </td> ' +
                            '<td class="center"> ' +
                            '<a title="编辑" href="http://pro_product.loc/index.php/product/alter/' + obj.product_id + '"> ' +
                            '<img src="http://pro_product.loc/resource/img/base/icon_edit.gif"/> ' +
                            '</a> ' +
                            '<a title="删除" href="http://pro_product.loc/index.php/product/delete/' + obj.product_id + '" onclick="del_confirm()"> ' +
                            '<img src="http://pro_product.loc/resource/img/base/icon_drop.gif"/> ' +
                            '</a> ' +
                            '</td> ' +
                            '</tr>');
                    });

                    $.getScript("<?=base_url("resource/js/public.js");?>");
                    $("#pag").html("");
                    table_thi = $.trim($("#output_box").html());
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(XMLHttpRequest.status);
                    alert(textStatus.readyState);
                    alert(textStatus);
                },
            });
        } else {
            $("#output_box").html(table_sec);
            $("#select_thi").html('<option value="-1" selected>三级分类</option>');
            $("#pag").html('');
            $.getScript("<?= base_url('resource/js/public.js');?>");
        }
    }

    function change_thi() {
        var id_thi = $.trim($("#select_thi").val());
        if (id_thi != -1) {
            $.ajax({
                type: "POST",
                url: "<?=site_url('product/list_thi')?>",
                dataType: "json",
                data: {"id_thi": id_thi},
                success: function (output) {
                    $("#output_box").html('<tr> <th style="text-align: center">产品名称</th> <th style="text-align: center">价格</th> ' +
                        '<th style="text-align: center">所属分类</th> <th style="text-align: center">库存量</th> ' +
                        '<th style="text-align: center">修改者</th> <th style="text-align: center">修改时间</th> ' +
                        '<th style="text-align: center">操作</th> </tr>');
                    $.each(output, function (index, obj) {
                        $("#output_box").append('<tr> <td class="center"> <span>' + obj.product_name + '</span> </td> ' +
                            '<td class="center"> <span>' + obj.product_price + '</span> </td> ' +
                            '<td class="center"> <span>' + obj.category_name + '</span> </td> ' +
                            '<td class="center"> <span>' + obj.product_quantity + '</span> </td> ' +
                            '<td class="center"> <span>' + obj.username + '</span> </td> ' +
                            '<td class="center"> <span>' + obj.update_time + '</span> </td> ' +
                            '<td class="center"> ' +
                            '<a title="编辑" href="http://pro_product.loc/index.php/product/alter/' + obj.product_id + '"> ' +
                            '<img src="http://pro_product.loc/resource/img/base/icon_edit.gif"/> ' +
                            '</a> ' +
                            '<a title="删除" href="http://pro_product.loc/index.php/product/delete/' + obj.product_id + '" onclick="del_confirm()"> ' +
                            '<img src="http://pro_product.loc/resource/img/base/icon_drop.gif"/> ' +
                            '</a> ' +
                            '</td> ' +
                            '</tr>');
                    });
                    $.getScript("<?=base_url("resource/js/public.js");?>");
                    $("#pag").html("");
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(XMLHttpRequest.status);
                    alert(textStatus.readyState);
                    alert(textStatus);
                },
            });
        } else {
            $("#output_box").html(table_thi);
            $("#pag").html('');
            $.getScript("<?= base_url('resource/js/public.js');?>");
        }
    }
</script>
</body>
</html>