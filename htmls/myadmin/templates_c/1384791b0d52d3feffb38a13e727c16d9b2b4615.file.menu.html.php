<?php /* Smarty version Smarty-3.1.16, created on 2016-07-11 00:44:40
         compiled from "E:\www\git\dream128\htmls\myadmin\templates\Public\menu.html" */ ?>
<?php /*%%SmartyHeaderCode:1257357827b782e2326-83868706%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1384791b0d52d3feffb38a13e727c16d9b2b4615' => 
    array (
      0 => 'E:\\www\\git\\dream128\\htmls\\myadmin\\templates\\Public\\menu.html',
      1 => 1461394862,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1257357827b782e2326-83868706',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'uid' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_57827b782f4aa1_30416356',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57827b782f4aa1_30416356')) {function content_57827b782f4aa1_30416356($_smarty_tpl) {?><div class="navbar-default sidebar" role="navigation">
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
				<a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> 文章管理<span class="fa arrow"></span></a>
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
			<li>
				<a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> 类型管理<span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li>
						<a href="<?php echo U_admin(array('m'=>"type",'a'=>"index"),$_smarty_tpl);?>
"> 列表</a>
					</li>
					<li>
						<a href="<?php echo U_admin(array('m'=>"type",'a'=>"add"),$_smarty_tpl);?>
"> 新建</a>
					</li>
				</ul>
				<!-- /.nav-second-level -->
			</li>
		</ul>
	</div>

	<!-- /.sidebar-collapse -->
</div><?php }} ?>
