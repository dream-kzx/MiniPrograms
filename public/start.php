<?php
/**
 * run with command 
 * php start.php start
 */


ini_set('display_errors', 'on');

if(strpos(strtolower(PHP_OS), 'win') === 0)
{
    exit("start.php not support windows, please use start_for_win.bat\n");
}

// 检查扩展
if(!extension_loaded('pcntl'))
{
    exit("Please install pcntl extension. See http://doc3.workerman.net/appendices/install-extension.html\n");
}

if(!extension_loaded('posix'))
{
    exit("Please install posix extension. See http://doc3.workerman.net/appendices/install-extension.html\n");
}

define('APP_PATH', __DIR__ . '/../application/');
define("BIND_MODULE",'index/Run');

//定义自定义配置目录
define('CONF_PATH',__DIR__.'/../conf/');
//定义日志目录
define('LOG_PATH',__DIR__.'/../log/');

require __DIR__ . '/../thinkphp/start.php';

\think\Log::init([
    'type'  =>  'File',
    'path'  =>  LOG_PATH,
    'level' =>  ['sql']
]);
