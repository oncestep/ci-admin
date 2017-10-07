<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>后台管理中心起始页面</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <link href="<?php echo base_url('resource/css/adminStyle.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url('resource/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url('resource/css/renew.css') ?>" rel="stylesheet" type="text/css"/>
    <style>html, body {
            width: 100%;
            height: 100%;
        }</style>
    <script src="<?php echo base_url('resource/js/jquery.js') ?>"></script>
    <script src="<?php echo base_url('resource/js/public.js') ?>"></script>
    <script href="<?php echo base_url('resource/js/bootstrap.min.js') ?>"></script>

</head>
<body>
<!--<div class="wrap">-->
<!-- <div class="page-title">-->
<!--  <span class="modular fl"><i class="user"></i><em>管理员列表</em></span>-->
<!--  <span class="modular fr"><a href="-->
<?php //echo site_url('section/revise_password')?><!--" class="pt-link-btn">+添加管理员</a></span>-->
<!-- </div>-->
<!-- <table class="list-style Interlaced">-->
<!--  <tr>-->
<!--   <th>管理员账号</th>-->
<!--   <th>电子邮箱地址</th>-->
<!--   <th>加入时间</th>-->
<!--   <th>最后登陆时间</th>-->
<!--   <th>操作</th>-->
<!--  </tr>-->
<!--  <tr>-->
<!--   <td>DeathGhost</td>-->
<!--   <td>DeathGhost@sina.cn</td>-->
<!--   <td class="center">2015-04-18 17:38</td>-->
<!--   <td class="center">2015-04-19 15:38</td>-->
<!--   <td class="center">-->
<!--    <a href="--><?php //echo site_url('section/revise_password')?><!--"><img src="-->
<?php //echo base_url('resource/img/base/icon_edit.gif')?><!--"/></a>-->
<!--    <a><img src="--><?php //echo base_url('resource/img/base/icon_drop.gif')?><!--"/></a>-->
<!--   </td>-->
<!--  </tr>-->
<!-- </table>-->
<!--</div>-->

<div class="login_suit">
    <div class="panel panel-success">
        <div class="panel-body">
            管理员信息
        </div>
        <div class="panel-footer">

<!--            <div class="form_left">-->
<!--                <img style="width: auto;height: auto;" src="--><?php //echo base_url('resource/img/component/profile.jpg')?><!--">-->
<!--            </div>-->

            <form class="form-horizontal">
                <div class="form-group">
                    <label for="username" class="col-sm-2 control-label">登录名</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="username" value="<?php echo $username?>" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">邮箱</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="email" value="<?php echo $email?>" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label for="telephone" class="col-sm-2 control-label">电话</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="telephone" value="<?php echo $telephone?>" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label for="department" class="col-sm-2 control-label">部门</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="department" value="<?php echo $department?>" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label for="passage_num" class="col-sm-2 control-label">发表资讯</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="passage_num" value="<?php echo $passage_num?>" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label for="product_num" class="col-sm-2 control-label">发布产品</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="passage_num" value="<?php echo $product_num?>" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label for="login_time" class="col-sm-2 control-label">最近登录</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="login_time" value="<?php echo $login_time?>" disabled>
                    </div>
                </div>
            </form>


        </div>
    </div>
</div>

</body>
</html>