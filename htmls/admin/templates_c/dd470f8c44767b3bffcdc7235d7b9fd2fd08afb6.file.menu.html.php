<?php /* Smarty version Smarty-3.1.16, created on 2016-01-04 00:08:56
         compiled from "D:\www\dream128\1\kphp\htmls\admin\templates\Public\menu.html" */ ?>
<?php /*%%SmartyHeaderCode:858656894366582941-46387263%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dd470f8c44767b3bffcdc7235d7b9fd2fd08afb6' => 
    array (
      0 => 'D:\\www\\dream128\\1\\kphp\\htmls\\admin\\templates\\Public\\menu.html',
      1 => 1451837323,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '858656894366582941-46387263',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_56894366585d12_62623983',
  'variables' => 
  array (
    'uid' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56894366585d12_62623983')) {function content_56894366585d12_62623983($_smarty_tpl) {?><div class="navbar-default sidebar" role="navigation">
	<div class="sidebar-nav navbar-collapse">
		<ul class="nav" id="side-menu">
			<li class="sidebar-search">
				<div class="input-group custom-search-form">
					<input type="text" class="form-control" placeholder="Search...">
					<span class="input-group-btn">
					<button class="btn btn-default" type="button">
						<i class="fa fa-search"></i>
					</button>
				</span>
				</div>
				<!-- /input-group -->
			</li>
			<li>
				<a href="<?php echo U_admin(array('m'=>"index",'a'=>"index",'p'=>"uid=".((string)$_smarty_tpl->tpl_vars['uid']->value)),$_smarty_tpl);?>
"><i class="fa fa-dashboard fa-fw"></i> 主页</a>
			</li>
			<li>
				<a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> 商品管理<span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li>
						<a href="<?php echo U_admin(array('m'=>"product",'a'=>"glist"),$_smarty_tpl);?>
"> 列表</a>
					</li>
					<li>
						<a href="<?php echo U_admin(array('m'=>"product",'a'=>"add"),$_smarty_tpl);?>
"> 新建</a>
					</li>
				</ul>
				<!-- /.nav-second-level -->
			</li>
		</ul>
	</div>

	<!-- /.sidebar-collapse -->
</div><?php }} ?>
