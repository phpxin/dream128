<?php
/**
 * 配置文件范例  ----   请将此文件 修改为 config.php 然后根据实际情况配置， config.php 不会被提交到服务器
 * @info 系统配置
 * @date 2014-05-28
 */

error_reporting(E_ALL-E_NOTICE) ;
date_default_timezone_set('Asia/ChongQing') ;
header('content-type:text/html; charset=utf-8');
session_start();

//其他配置
define('DS', DIRECTORY_SEPARATOR);//系统分隔符
define('APP_CHARSET', 'utf-8') ;
define('ADMIN_PWD', '');

//缓存配置（如果不使用缓存不需要配置）
define('CACHE_HOST','');
define('CACHE_PORT', 0);
define('CACHE_STATUS', false);

//数据库配置
define('DB_HOST', '127.0.0.1') ;
define('DB_PORT', '3306') ;
define('DB_USER', 'root') ;
define('DB_PWD', '') ;
define('DB_NAME', 'dream128') ;
define('DB_CACHE_FOLDER','./db_cache') ;


define('DB_CHARSET','utf8') ;
define('DB_PREFIX','') ;


//环境变量 (最后不要加分隔符)
define('__ROOT__','');
define('__THEME__',__ROOT__.'/theme');

//错误日志
define('LOG_ERROR',FALSE);
define('LOG_ERROR_PATH','./log');

//异常日志
define('LOG_EXCEPTION', FALSE);
define('LOG_EXCEPTION_PATH','./log');

//smarty
define('SMARTY_DIR','Lib/Smarty/libs'.DS);
define('DEBUG_MODE', true) ;
?>
