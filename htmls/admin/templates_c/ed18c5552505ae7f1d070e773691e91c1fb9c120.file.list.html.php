<?php /* Smarty version Smarty-3.1.16, created on 2016-01-04 00:41:52
         compiled from ".\htmls\admin\templates\Product\list.html" */ ?>
<?php /*%%SmartyHeaderCode:2581556894798462ec9-93749264%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ed18c5552505ae7f1d070e773691e91c1fb9c120' => 
    array (
      0 => '.\\htmls\\admin\\templates\\Product\\list.html',
      1 => 1451839311,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2581556894798462ec9-93749264',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_568947984fe269_64411801',
  'variables' => 
  array (
    'glist' => 0,
    'goods' => 0,
    '__PUBLIC__' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_568947984fe269_64411801')) {function content_568947984fe269_64411801($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">

<head>

<?php echo $_smarty_tpl->getSubTemplate ("../Public/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">wshop</a>
            </div>
            <!-- /.navbar-header -->

            <?php echo $_smarty_tpl->getSubTemplate ("../Public/icon.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

            <!-- /.navbar-top-links -->

            <?php echo $_smarty_tpl->getSubTemplate ("../Public/menu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">商品列表</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
				<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            DataTables Advanced Tables
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>标题</th>
                                            <th>描述</th>
                                            <th>添加时间</th>
                                            <th>修改时间</th>
											<th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<!--
                                        <tr class="odd gradeX">
                                            <td>Trident</td>
                                            <td>Internet Explorer 4.0</td>
                                            <td>Win 95+</td>
                                            <td class="center">4</td>
                                            <td class="center">X</td>
                                        </tr>
										-->
										<?php  $_smarty_tpl->tpl_vars['goods'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['goods']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['glist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['goods']->key => $_smarty_tpl->tpl_vars['goods']->value) {
$_smarty_tpl->tpl_vars['goods']->_loop = true;
?>
                                        <tr class="even gradeC">
                                            <td><?php echo $_smarty_tpl->tpl_vars['goods']->value['id'];?>
</td>
                                            <td><?php echo $_smarty_tpl->tpl_vars['goods']->value['title'];?>
</td>
                                            <td><?php echo $_smarty_tpl->tpl_vars['goods']->value['disc'];?>
</td>
                                            <td class="center"><?php echo $_smarty_tpl->tpl_vars['goods']->value['addtime'];?>
</td>
                                            <td class="center"><?php echo $_smarty_tpl->tpl_vars['goods']->value['edittime'];?>
</td>
											<td class="center"><a href="<?php echo U_admin(array('m'=>"product",'a'=>"del",'p'=>"gid=".((string)$_smarty_tpl->tpl_vars['goods']->value['id'])),$_smarty_tpl);?>
">删除</a></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
			</div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php echo $_smarty_tpl->getSubTemplate ("../Public/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- DataTables JavaScript -->
<script src="<?php echo $_smarty_tpl->tpl_vars['__PUBLIC__']->value;?>
/bootstrap3/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['__PUBLIC__']->value;?>
/bootstrap3/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
<!-- Page-Level Demo Scripts - Tables - Use for reference -->

<script>
/*
$(document).ready(function() {
	$('#dataTables-example').DataTable({
			responsive: true
	});
});
*/
</script>

</body>

</html>
<?php }} ?>
