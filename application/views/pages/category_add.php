<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>新增产品分类</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="<?php echo base_url('resource/css/adminStyle.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url('resource/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url('resource/css/renew.css') ?>" rel="stylesheet" type="text/css">

    <script src="<?php echo base_url('resource/js/jquery.js') ?>"></script>
</head>
<body>
<div class="wrap">
    <div class="page-title">
        <span class="modular fl"><i></i><em>添加分类</em></span>
        <span class="modular fr"><a href="<?php echo site_url('category/manage') ?>" class="pt-link-btn">返回</a></span>
    </div>

    <div>
        <select class="form-control" id="type" onchange="type_choose()">
            <option value="1">新建一级分类</option>
            <option value="2">新建二级分类</option>
            <option value="3" selected>新建三级分类</option>
        </select>
    </div>
    <br>

    <div id="type_form">
        <form method="post" accept-charset="utf-8" target="_self" action="<?php echo site_url('category/create_on_three') ?>">
            <table class="list-style">
                <tr>
                    <td style="text-align:right;width:15%;">一级分类名称：</td>
                    <td class="category_align">
<!--                        <input type="text" class="textBox category_input" placeholder="请输入一级分类名称" name="level_fir"/>-->
                        <select id="level_fir" name="level_fir" class="form-control" onchange="change_fir()">
                            <option value="-1">一级分类</option>
                            <?php foreach($select_fir as $row){?>
                                <option value="<?=$row['category_name']?>"><?=$row['category_name']?></option>
                            <?php }?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:right;width:15%;">二级分类名称：</td>
                    <td class="category_align">
<!--                        <input type="text" class="textBox category_input" placeholder="请输入二级分类名称" name="level_sec"/>-->
                        <select id="level_sec" name="level_sec" class="form-control">
                            <option value="-1">二级分类</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:right;width:15%;">三级分类名称：</td>
                    <td class="category_align">
                        <input type="text" class="form-control" placeholder="三级分类" name="level_thi"/>
                    </td>
                </tr>
            </table>

            <div class="category_btn">
                <button type="reset" class="btn btn-warning">重置 (RESET)</button>
                <button type="submit" class="btn btn-primary">确认发表 (UPLOAD)</button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    var select_default = $.trim($("#type_form").html());

    function type_choose() {
        var type = $("#type").val();
        switch (type) {
            case "1":
                $("#type_form").html('<form method="post" accept-charset="utf-8" target="_self" action="<?php echo site_url('category/create_on_one')?>">' +
                '<table class="list-style"> <tr> <td style="text-align:right;width:15%;">一级分类名称：</td> <td class="category_align"> ' +
                '<input type="text" class="form-control" placeholder="一级分类" name="level_fir"/> </td> </tr> </table> ' +
                '<div class="category_btn"> <button type="reset" class="btn btn-warning">重置 (RESET)</button> ' +
                '<button type="submit" class="btn btn-primary">确认发表 (UPLOAD)</button> </div> </form>');
                break;
            case "2":
                $("#type_form").html('<form method="post" accept-charset="utf-8" target="_self" action="<?php echo site_url('category/create_on_two')?>">' +
                    '<table class="list-style"> <tr> <td style="text-align:right;width:15%;">一级分类名称：</td> <td class="category_align"> ' +
                    '<select id="level_fir" name="level_fir" class="form-control"> <option value="-1">一级分类</option> '+
                    '<?php foreach($select_fir as $row){?><option value="<?=$row['category_name']?>"><?=$row['category_name']?></option><?php }?> </select> ' +
                    '</td> </tr> <tr> <td style="text-align:right;width:15%;">二级分类名称：</td> <td class="category_align"> ' +
                    '<input type="text" class="form-control" placeholder="二级分类" name="level_sec"/> </td> </tr> </table> ' +
                    '<div class="category_btn"> <button type="reset" class="btn btn-warning">重置 (RESET)</button> ' +
                    '<button type="submit" class="btn btn-primary">确认发表 (UPLOAD)</button> </div> </form>');
                break;
            default:
                $("#type_form").html(select_default);
                break;
        }
    }

    function change_fir(){
        var name_fir = $.trim($("#level_fir").val());

        $.ajax({
            type:"POST",
            url:"<?= site_url("category/change_fir_byname/")?>",
            dataType:"json",
            data:"name_fir="+name_fir,
            success:function(output){
                $("#level_sec").html(output.second_list);
            },
            error:function(tip){
                alert("Fail To Refresh");
            }
        });

    }

</script>
</body>
</html>