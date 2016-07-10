<?php /* Smarty version Smarty-3.1.16, created on 2016-07-11 00:44:31
         compiled from ".\htmls\myadmin\templates\Index\login.html" */ ?>
<?php /*%%SmartyHeaderCode:11057827b594a2329-49854886%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fbd280d45274baef7dfa21f66dd65ddf83c77d7d' => 
    array (
      0 => '.\\htmls\\myadmin\\templates\\Index\\login.html',
      1 => 1468169065,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11057827b594a2329-49854886',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_57827b59694267_63112516',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57827b59694267_63112516')) {function content_57827b59694267_63112516($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">

<head>

<?php echo $_smarty_tpl->getSubTemplate ("../Public/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="username" type="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <a href="javascript:void(0);" id="doLogin" class="btn btn-lg btn-success btn-block">Login</a>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php echo $_smarty_tpl->getSubTemplate ("../Public/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<script type="text/javascript">
	$('#doLogin').click(function(){
		var fvars = {};
		fvars.username = $('[name=username]').val();
		fvars.passworld = $('[nmae=passworld]').val();
		
		$.post('<?php echo U_myadmin(array('m'=>'index','a'=>'doLogin'),$_smarty_tpl);?>
', fvars, function(json_data){
			console.log(json_data) ;
            json_data = $.parseJSON(json_data) ;
            if(json_data.code == 200){
                console.log('succ') ;
                window.location.href = '<?php echo U_myadmin(array('m'=>'index','a'=>'index'),$_smarty_tpl);?>
' ;
            }else{
                alert(json_data.data.msg);
            }
		})
	})
</script>

</body>

</html>
<?php }} ?>
