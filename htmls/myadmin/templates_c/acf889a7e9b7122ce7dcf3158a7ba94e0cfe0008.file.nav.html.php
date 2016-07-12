<?php /* Smarty version Smarty-3.1.16, created on 2016-07-11 00:44:40
         compiled from "E:\www\git\dream128\htmls\myadmin\templates\Public\nav.html" */ ?>
<?php /*%%SmartyHeaderCode:711157827b782c9ea7-83868696%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'acf889a7e9b7122ce7dcf3158a7ba94e0cfe0008' => 
    array (
      0 => 'E:\\www\\git\\dream128\\htmls\\myadmin\\templates\\Public\\nav.html',
      1 => 1461394862,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '711157827b782c9ea7-83868696',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_57827b782d16c3_35975468',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57827b782d16c3_35975468')) {function content_57827b782d16c3_35975468($_smarty_tpl) {?>        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">article</a>
            </div>
            <!-- /.navbar-header -->

            <?php echo $_smarty_tpl->getSubTemplate ("./icon.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

            <!-- /.navbar-top-links -->

            <?php echo $_smarty_tpl->getSubTemplate ("./menu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

            <!-- /.navbar-static-side -->
        </nav><?php }} ?>
