<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>文章列表</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <link rel="stylesheet" href="<?php echo base_url('resource/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('resource/css/adminStyle.css') ?>" type="text/css"/>
    <link rel="stylesheet" href="<?php echo base_url('resource/css/renew.css') ?>" type="text/css"/>

    <script src="<?php echo base_url('resource/js/jquery.js') ?>"></script>
    <script src="<?php echo base_url('resource/js/json2.js') ?>"></script>
    <script src="<?php echo base_url('resource/js/public.js') ?>"></script>
    <script src="<?php echo base_url('resource/js/component.js') ?>"></script>
</head>
<body>
<div class="wrap">
    <div class="page-title">
        <span class="modular fl"><i></i><em>文章列表</em></span>
        <span class="modular fr"><a href="<?php echo site_url('passage/create')?>" class="pt-link-btn">+添加新文章</a></span>
    </div>

    <form method="post" accept-charset="utf-8" target="_self" onsubmit="return checkSearch()" action="<?php echo site_url('passage/search');?>"
    <div style="margin-top: 15px;">
        <div class="input-group input-group-sm">
            <input type="text" class="form-control" placeholder="搜索文章标题" name="search" id="search_box">
            <span class="input-group-btn">
            <button type="submit" class="btn btn-info btn-flat">Go!</button>
        </span>
        </div>
    </div>
    </form>
    <br>

    <form class="wrap limit_form" method="post" accept-charset="utf-8" target="_self" onsubmit="return checkForm()" action="<?php echo site_url('passage/delete_batch') ?>"
          id="choose_form">
        <table class="list-style Interlaced" id="choose_table">
            <tr>
                <th class="center">
                    <input type="checkbox" name="item_all" id="check_all"/>
                </th>
                <th class="center">文章标题</th>
                <th class="center">文章内容</th>
                <th class="center">更新管理员</th>
                <th class="center">更新时间</th>
                <th class="center">管理操作</th>
            </tr>

            <?php foreach ($passages as $key => $value): ?>
                <tr>
                    <td class="center">
                        <input type="checkbox" class="choose" name="item[]" value="<?php echo $value['passage_id']?>" <?php echo set_checkbox('item[]',$key);?>/>
                    </td>
                    <td><?php echo $value['passage_title'] ?></td>
                    <td class="content_limit"><?php echo $value['passage_content'] ?></td>
                    <td><?php echo $value['username'] ?></td>
                    <td><?php echo $value['update_time'] ?></td>
                    <td class="center">
                        <a href="<?php echo site_url('passage/alter/'.$value['passage_id']) ?>" title="编辑" id="prompt_del">
                            <img src="<?php echo base_url('resource/img/base/icon_edit.gif') ?>"/>
                        </a>
                        <a href="<?php echo site_url('passage/delete/'.$value['passage_id'].'/'.$value['admin_id']); ?>" onclick="return confirm('确认删除?');" title="删除">
                            <img src="<?php echo base_url('resource/img/base/icon_drop.gif') ?>"/>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>


        <!-- BatchOperation -->
        <div style="overflow:hidden;">
            <!-- Operation -->
            <div class="BatchOperation fl">
                <!--            <label for="del" class="btnStyle middle">全选</label>-->
                <input type="button" value="全选" class="btnStyle label_adjust" id="check_btn"/>
                <input type="submit" value="批量删除" class="btnStyle label_adjust" id="batch_btn"/>
            </div>
            <!-- turn page -->
            <div class="turnPage center fr page_converse">
                <div id="pag">
                    <?php echo $this->pagination->create_links();?>
                </div>
            </div>
        </div>

    </form>
</div>
</body>
</html>