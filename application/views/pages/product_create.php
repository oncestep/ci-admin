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
    <link href="<?php echo base_url('resource/lib/umeditor/themes/default/css/umeditor.min.css') ?>" rel="stylesheet">
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
        <span class="modular fl"><i class="add"></i><em>编辑/添加产品</em></span>
        <span class="modular fr"><a href="<?php echo site_url('product/manage') ?>" class="pt-link-btn">返回</a></span>
    </div>

    <form method="post" enctype="multipart/form-data" accept-charset="utf-8" target="_self" action="<?=site_url('product/create_on/')?>">
        <table class="list-style">
            <tr>
                <td style="text-align:right;width:15%;">产品名称：</td>
                <td><input name="product_name" type="text" class="textBox length-long" placeholder="请输入产品名称"/></td>
            </tr>
            <tr>
                <td style="text-align:right;">产品分类：</td>
                <td>
                    <div class="col-md-9 item6 select_left" id="box_first">
                        <select id="level_fir" name="level_fir" id="level_fir" class="form-control limit_select_create" onchange="show_sec()">
                            <?php foreach ($rows as $key => $value) { ?>
                                <option value="<?php echo $value['category_id'] ?>"<?php if ($value['category_id'] == $default['default_fir']): ?>selected<?php endif; ?>>
                                    <?php echo $value['category_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-9 item6 select_left" id="box_second">
                        <select id="level_sec" name="level_sec" class="form-control limit_select_create" onclick="show_thi()">
                        </select>
                    </div>
                    <div class="col-md-9 item6 select_left" id="box_third">
                        <select id="level_thi" name="level_thi" class="form-control limit_select_create">
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="text-align:right;">价格：</td>
                <td>
                    <input name="product_price" type="text" class="textBox length-short" placeholder="价格"/>
                    <span>元</span>
            </tr>
            <tr>
                <td style="text-align:right;">库存：</td>
                <td>
                    <input name="product_num" type="text" class="textBox length-short" placeholder="库存"/>
                    <span>件</span>
                </td>
            <tr>
                <td style="text-align:right;">产品图：</td>
                <td>
                    <input name="product_img" type="file" multiple="multiple" id="product_img"/>
<!--                    <label for="product_img" class="labelBtn2">本地上传(最多选择8张)</label>-->
                </td>
            </tr>
<!--            <tr>-->
<!--                <td style="text-align:right;"></td>-->
<!--                <td>-->
<!--                    <img src="#" width="80" height="80"/>-->
<!--                </td>-->
<!--            </tr>-->
            <tr>
                <td style="text-align:right;">产品详情：</td>
                <td>
                    <script class="editor_box" type="text/plain" id="container" name="container">请输入文章内容</script>
                </td>
            </tr>
            <tr>
                <td style="text-align:right;"></td>
                <td><input type="submit" value="确认发布(UPLOAD)" class="tdBtn" style="float:right;margin-right: 19%;"/></td>
            </tr>
        </table>
    </form>
</div>

<script type="text/javascript">

    function show_sec(flag){
        var id_fir  = $.trim($('#level_fir').val());
        $.ajax({
            type:"POST",
            url:"<?=site_url('product/get_second/')?>",
            data:"id_fir="+id_fir,
            success: function(output){
                $('#level_sec').html(output);
                if(flag == 1){
                    var default_second = '<?php echo $default!=null?$default['default_sec']:""?>';
                    $("#level_sec").val(default_second);
                    show_thi(1);
                } else {
                    show_thi();
                }

            }
        });
    }

    function show_thi(flag){
        var id_sec =$.trim($('#level_sec').val());
        $.ajax({
            type:"POST",
            url:"<?=site_url('product/get_third/')?>",
            data:"id_sec="+id_sec,
            success:function(output){
                $('#level_thi').html(output);
                if(flag == 1){
                    var default_third = '<?php echo $default!=null?$default['default_thi']:""?>';
                    $("#level_thi").val(default_third);
                }
            }
        });
    }
    show_sec(1);


</script>

<!--UEditor-->
<script src="<?php echo base_url('resource/js/jquery.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('resource/lib/umeditor/third-party/template.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('resource/lib/umeditor/umeditor.config.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('resource/lib/umeditor/umeditor.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('resource/lib/umeditor/lang/zh-cn/zh-cn.js') ?>"></script>
<script type="text/javascript">
    //实例化编辑器
    var um = UM.getEditor('container');
</script>
</body>
</html>