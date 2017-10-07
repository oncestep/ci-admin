<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>新文章</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="<?php echo base_url('resource/css/adminStyle.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url('resource/css/renew.css')?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url('resource/css/bootstrap.min.css')?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url('resource/lib/umeditor/themes/default/css/umeditor.min.css') ?>" rel="stylesheet">

</head>
<body>
<div class="wrap">
    <div class="page-title">
        <span class="modular fl"><i class="settings"></i><em>新文章</em></span>
    </div>
    <form id="create_form" method="post" accept-charset="utf-8" target="_self" action="<?php echo site_url('passage/create_on')?>">
        <table class="noborder">
            <tr>
                <td style="text-align:right;"><b>文章标题：</b></td>
                <td><input name="title" class="passage_headline" type="text" placeholder="请输入文章标题"/></td>
            </tr>
            <tr>
                <td style="text-align:right;vertical-align: top;">
                    <b>文章内容：</b>
                </td>
                <td>
                    <script name="content" class="editor_box" type="text/plain" id="container" name="content">请输入文章内容</script>
                </td>
            </tr>
            <tr>
                <td style="text-align:right;"></td>
                <td class="btn_right">
                    <button type="reset" class="btn btn-warning" onclick="reset()">重置 (RESET)</button>
                    <button type="submit" class="btn btn-primary">确认发表 (UPLOAD)</button>
                </td>
            </tr>
        </table>
    </form>
</div>

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