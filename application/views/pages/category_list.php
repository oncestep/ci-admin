<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>分类列表</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="<?php echo base_url('resource/css/adminStyle.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url('resource/css/font-awesome.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('resource/css/simple-line-icons.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('resource/css/style.css') ?>" rel="stylesheet">
    <!--    <link href="-->
    <?php //echo base_url('resource/css/bootstrap.min.css')?><!--" rel="stylesheet" type="text/css"/>-->
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
        <span class="modular fl"><i></i><em>分类列表</em></span>
        <span class="modular fr"><a href="<?php echo site_url('category/create') ?>" class="pt-link-btn">+添加新分类</a></span>
    </div>
    <br>
    <div class="operate">
            <div class="col-md-9 item limit_select">
                <select id="select_fir" name="select_fir" class="form-control" onchange="change_fir()">
                    <option value="-1" selected>一级分类</option>
                    <?php foreach($list as $row){ ?>
                        <option value="<?=$row['category_id']?>"><?=$row['category_name']?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-9 item limit_select">
                <select id="select_sec" name="select_sec" class="form-control" onchange="change_sec()">
                    <option value="-1" selected>二级分类</option>

                </select>
            </div>
            <div class="col-md-9 item limit_select">
                <select id="select_thi" name="select_thi" class="form-control" onchange="change_thi()">
                    <option value="-1" selected>三级分类</option>

                </select>
            </div>
    </div>
    </br>

    <table class="list-style Interlaced list_table" id="output_box">
        <tr>
            <th style="text-align: center">一级分类</th>
            <th style="text-align: center">二级分类</th>
            <th style="text-align: center">三级分类</th>
            <th style="text-align: center">创建时间</th>
            <th style="text-align: center">创建者</th>
            <th style="text-align: center">操作</th>
        </tr>
            <?php
                foreach ($rows as $key => $value):
                    echo $value;
                endforeach;
            ?>
    </table>
    <div id="pag">
        <?php echo $this->pagination->create_links();?>
    </div>
</div>
</div>

<script type="text/javascript">
    var table_fir = $.trim($("#output_box").html());
    var table_sec = $.trim($("#output_box").html());
    var table_third = $.trim($("#output_box").html());

    function change_fir(){
        var id_fir = $.trim($("#select_fir").val());
        if(id_fir!=-1){
            $.ajax({
                type:"POST",
                url:"<?=site_url("category/change_fir/")?>",
                dataType:"json",
                data:"id_fir="+id_fir,
                success:function(output){
                    $("#select_sec").html(output.second_list);
                    $("#output_box").html('<tr><th style="text-align: center">一级分类</th>' +
                        '<th style="text-align: center">二级分类</th><th style="text-align: center">三级分类</th>' +
                        '<th style="text-align: center">创建时间</th><th style="text-align: center">创建者</th>' +
                        '<th style="text-align: center">操作</th></tr>'+output.first_part);
                    $('#pag').html("");
                    table_sec = $.trim($("#output_box").html());
                },
                error:function(tip){
                    alert("Fail To Refresh");
                }
            });
        } else {
            $("#output_box").html(table_fir);
            $("#select_sec").html('<option value="-1" selected>二级分类</option>');
            $("#select_thi").html('<option value="-1" selected>三级分类</option>');
            $("#pag").html('<?php echo $this->pagination->create_links();?>');
        }
    }

    function change_sec(){
        var id_sec = $.trim($("#select_sec").val());
        if(id_sec!=-1){
            $.ajax({
                type:"POST",
                url:"<?=site_url("category/change_sec/")?>",
                dataType:"json",
                data:"id_sec="+id_sec,
                success:function(output){
                    $("#select_thi").html(output.third_list);
                    $("#output_box").html('<tr><th style="text-align: center">一级分类</th>' +
                        '<th style="text-align: center">二级分类</th><th style="text-align: center">三级分类</th>' +
                        '<th style="text-align: center">创建时间</th><th style="text-align: center">创建者</th>' +
                        '<th style="text-align: center">操作</th></tr>'+output.second_part);
                    $("#pag").html("");
                    table_thi = $.trim($("#output_box").html());
                },
                error:function(tip){
                    alert("Fail To Refresh");
                }
            });
        } else {
            $("#output_box").html(table_sec);
            $('#select_thi').html('<option value="-1" selected>三级分类</option>');
        }
    }

    function change_thi(){
        var id_thi = $.trim($("#select_thi").val());
        if(id_thi!=-1){
            $.ajax({
                type:"POST",
                url:"<?=site_url("category/change_thi/")?>",
                dataType:"json",
                data:"id_thi="+id_thi,
                success:function(output){
                    $("#output_box").html('<tr><th style="text-align: center">一级分类</th>' +
                        '<th style="text-align: center">二级分类</th><th style="text-align: center">三级分类</th>' +
                        '<th style="text-align: center">创建时间</th><th style="text-align: center">创建者</th>' +
                        '<th style="text-align: center">操作</th></tr>'+output.third_part);
                    $("#pag").html("");
                },
                error:function(tip){
                    alert("Fail To Refresh");
                }
            });
        } else {
            $("#output_box").html(table_thi);
        }
    }
</script>
</body>
</html>