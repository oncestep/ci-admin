<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>左侧导航</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="<?php echo base_url('resource/css/adminStyle.css') ?>" rel="stylesheet" type="text/css"/>
    <script src="<?php echo base_url('resource/js/jquery.js') ?>"></script>
    <script src="<?php echo base_url('resource/js/public.js') ?>"></script>
</head>
<body style="background:#313131">
<div class="menu-list">
<!--    <a href="--><?php //echo site_url('section/component)') ?><!--" target="mainCont" class="block menu-list-title center"-->
<!--       style="border:none;margin-bottom:8px;color:#fff;">起始页</a>-->
    <ul>
        <li class="menu-list-title">
            <span>管理员账户</span>
            <i>◢</i>
        </li>
        <li>
            <ul class="menu-children">
                <li><a href="<?php echo site_url('admin/page_info/'.$_SESSION['admin_id']) ?>" title="个人信息" target="mainCont">个人信息</a>
                <li><a href="<?php echo site_url('admin/page_alter') ?>" title="修改信息" target="mainCont">修改信息</a>
                </li>
            </ul>
        </li>

        <li class="menu-list-title">
            <span>文章管理</span>
            <i>◢</i>
        </li>
        <li>
            <ul class="menu-children">
                <li>
                    <a href="<?php echo site_url('passage/manage') ?>" title="文章列表" target="mainCont">文章列表</a>
                </li>
                <li>
                    <a href="<?php echo site_url('passage/create') ?>" title="文章创建" target="mainCont">文章创建</a>
                </li>
            </ul>
        </li>

        <li class="menu-list-title">
            <span>分类管理</span>
            <i>◢</i>
        </li>
        <li>
            <ul class="menu-children">
                <li>
                    <a href="<?php echo site_url('category/manage') ?>" title="分类列表" target="mainCont">分类列表</a>
                </li>
                <li>
                    <a href="<?php echo site_url('category/create') ?>" title="分类创建" target="mainCont">分类创建</a>
                </li>
            </ul>
        </li>

        <li class="menu-list-title">
            <span>商品管理</span>
            <i>◢</i>
        </li>
        <li>
            <ul class="menu-children">
                <li>
                    <a href="<?php echo site_url('product/manage') ?>" title="商品列表" target="mainCont">商品列表</a>
                </li>
                <li>
                    <a href="<?php echo site_url('product/create') ?>" title="商品分类" target="mainCont">商品上传</a>
                </li>
            </ul>
        </li>




    </ul>
</div>
</body>
</html>