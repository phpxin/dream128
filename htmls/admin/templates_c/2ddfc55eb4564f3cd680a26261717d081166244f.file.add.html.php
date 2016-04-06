<?php /* Smarty version Smarty-3.1.16, created on 2016-04-06 16:45:12
         compiled from ".\htmls\admin\templates\Product\add.html" */ ?>
<?php /*%%SmartyHeaderCode:186055689479aa7c104-66330117%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2ddfc55eb4564f3cd680a26261717d081166244f' => 
    array (
      0 => '.\\htmls\\admin\\templates\\Product\\add.html',
      1 => 1459932311,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '186055689479aa7c104-66330117',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_5689479ab16df6_58706925',
  'variables' => 
  array (
    '__PUBLIC__' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5689479ab16df6_58706925')) {function content_5689479ab16df6_58706925($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">

<head>

<?php echo $_smarty_tpl->getSubTemplate ("../Public/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>



<script type="text/javascript" charset="utf-8" src="<?php echo $_smarty_tpl->tpl_vars['__PUBLIC__']->value;?>
/editor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo $_smarty_tpl->tpl_vars['__PUBLIC__']->value;?>
/editor/ueditor.all.min.js"> </script>
<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
<script type="text/javascript" charset="utf-8" src="<?php echo $_smarty_tpl->tpl_vars['__PUBLIC__']->value;?>
/editor/lang/zh-cn/zh-cn.js"></script>
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
                    <h1 class="page-header">新建文章</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            New Article
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <form role="form" name="content-form">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input class="form-control" name="atitle">
                                    <p class="help-block">Input article title here.</p>
                                </div>
                                <div class="form-group">
                                    <label>Inline Radio Buttons</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline1" value="option1" checked>1
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline2" value="option2">2
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline3" value="option3">3
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>Content</label>
                                    <script id="editor" type="text/plain" style="height:500px;"></script>
                                </div>
                                <div class="form-group">
                                    <button type="button" id="submit" class="btn btn-default">Submit Button</button>
                                    <button type="reset" id="reset" class="btn btn-default">Reset Button</button>
                                </div>
                            </form>

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

<script type="text/javascript">
    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    var h_editor = UE.getEditor('editor');

    $('#submit').click(function(){

        var params = {} ;
        params.title = $('[name=atitle]').val();
        params.content = UE.getEditor('editor').getContent() ;

        $.post('<?php echo U_admin(array('m'=>'product','a'=>'doAdd'),$_smarty_tpl);?>
', params, function(jdata){

        })


        //console.log(params.content)

        /*
        var form_obj = document.forms[0] ;
        var len = form_obj.elements.length ;


        for(var _i=0; _i<len; _i++){
            var info = form_obj.elements[_i] ;
            console.log(info.type);
            if(info.type == 'text'){
                console.log(info.value) ;
            }

        }
        console.log('len is ' + len)
        */


    })

    $('#reset').click(function(){
        h_editor.setContent('', false);
    })

</script>
</body>

</html>
<?php }} ?>
