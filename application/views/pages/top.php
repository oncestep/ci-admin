<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>header</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo base_url('resource/css/adminStyle.css')?>" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="header">
 <div class="logo">
  <img src="<?php echo base_url('resource/img/base/admin_logo.png')?>" title="LOGO"/>
 </div>
 <div class="fr top-link">
  <a href="<?php echo site_url('admin/page_info/'.$_SESSION['admin_id'])?>" target="mainCont" title="DeathGhost">
      <i class="adminIcon"></i>
      <span>管理员：<?php echo $_SESSION['username']?></span>
  </a>
  <a href="<?php echo site_url('admin/page_alter')?>" target="mainCont" title="修改个人信息">
      <i class="revisepwdIcon"></i>
      <span>修改个人信息</span>
  </a>
  <a href="<?php echo site_url('admin/logout')?>" target="_parent" title="安全退出" style="background:rgb(60,60,60);">
      <i class="quitIcon"></i>
      <span>安全退出</span>
  </a>
 </div>
</div>
</body>
</html>