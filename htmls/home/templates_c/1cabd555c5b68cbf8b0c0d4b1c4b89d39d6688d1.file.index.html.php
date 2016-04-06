<?php /* Smarty version Smarty-3.1.16, created on 2016-04-06 18:36:46
         compiled from ".\htmls\home\templates\Index\index.html" */ ?>
<?php /*%%SmartyHeaderCode:2114156ea19dde5f779-38516439%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1cabd555c5b68cbf8b0c0d4b1c4b89d39d6688d1' => 
    array (
      0 => '.\\htmls\\home\\templates\\Index\\index.html',
      1 => 1459935381,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2114156ea19dde5f779-38516439',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_56ea19dde96283_72698580',
  'variables' => 
  array (
    'list' => 0,
    'article' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56ea19dde96283_72698580')) {function content_56ea19dde96283_72698580($_smarty_tpl) {?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<?php echo $_smarty_tpl->getSubTemplate ("../Public/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</head>
<body>
<header >
</header>
<?php echo $_smarty_tpl->getSubTemplate ("../Public/nav.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="container" style="margin-top : 100px">

	<div class="row">
		<div class="col-md-9">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title">Panel title</h3>
			  </div>
			  <div class="panel-body">
                  <?php  $_smarty_tpl->tpl_vars['article'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['article']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['article']->key => $_smarty_tpl->tpl_vars['article']->value) {
$_smarty_tpl->tpl_vars['article']->_loop = true;
?>
                  <p><a href="<?php echo U_home(array('m'=>'article','a'=>'detail','p'=>"id=".((string)$_smarty_tpl->tpl_vars['article']->value['id'])),$_smarty_tpl);?>
" title="<?php echo $_smarty_tpl->tpl_vars['article']->value['title'];?>
"><?php echo $_smarty_tpl->tpl_vars['article']->value['title'];?>
</a></p>
                  <?php } ?>
			  </div>
			</div>
		</div>
		<div class="col-md-3">
			<ul class="list-group">
			  <li class="list-group-item">Cras justo odio</li>
			  <li class="list-group-item">Dapibus ac facilisis in</li>
			  <li class="list-group-item">Morbi leo risus</li>
			  <li class="list-group-item">Porta ac consectetur ac</li>
			  <li class="list-group-item">Vestibulum at eros</li>
			  <li class="list-group-item">Vestibulum at eros</li>
			  <li class="list-group-item">Vestibulum at eros</li>
			  <li class="list-group-item">Vestibulum at eros</li>
			  <li class="list-group-item">Vestibulum at eros</li>
			  <li class="list-group-item">Vestibulum at eros</li>
			  <li class="list-group-item">Vestibulum at eros</li>
			</ul>
		</div>

	</div>

</div>

<div>

</div>
<?php echo $_smarty_tpl->getSubTemplate ("../Public/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</body>
</html>
<?php }} ?>
