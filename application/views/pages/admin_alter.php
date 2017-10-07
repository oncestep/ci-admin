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
            修改个人信息
        </div>
        <div class="panel-footer">

<!--            <div class="form_left">-->
<!--                <img style="width: auto;height: auto;" src="--><?php //echo base_url('resource/img/component/profile.jpg')?><!--">-->
<!--            </div>-->

            <form class="form-horizontal" method="post" accept-charset="utf-8" target="_parent" action="<?php echo site_url('admin/alter')?>">

                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">邮箱</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="email" value="<?php echo $_SESSION['email']?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="telephone" class="col-sm-2 control-label">电话</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="telephone" value="<?php echo $_SESSION['telephone']?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="department" class="col-sm-2 control-label">部门</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="department" value="<?php echo $_SESSION['department']?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password_pre" class="col-sm-2 control-label">旧密码</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password_pre" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">新密码</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirm" class="col-sm-2 control-label">密码确认</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="confirm" value="">
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn_extra">确认更改</button>
                </div>

            </form>



        </div>
    </div>
</div>

</body>
</html>