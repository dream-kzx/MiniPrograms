<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/4/21
 * Time: 22:07
 */
return [
    // 默认模块名
    'default_module'         => 'index',
    // 禁止访问模块
    'deny_module_list'       => ['common'],
    // 默认控制器名
    'default_controller'     => 'Index',
    // 默认操作名
    'default_action'         => 'index',


    // 应用调试模式
    'app_debug'              => false,
    // 入口自动绑定模块
    'auto_bind_module'       => false,
    // 默认输出类型
    'default_return_type'    => 'json',
    // 路由使用完整匹配
    'route_complete_match'   => true,
    // 是否开启路由
    'url_route_on'           => true,
    // 是否强制使用路由
    'url_route_must'         => false,
    // 扩展函数文件
    'extra_file_list'        => [THINK_PATH . 'helper' . EXT,APP_PATH.'lib/common.php'],
    // 异常处理handle类 留空使用 \think\exception\Handle
    'exception_handle'       => 'app\lib\exception\ExceptionHandler',

    'cache'                  => [
        // 驱动方式
        'type'   => 'File',
        // 缓存保存目录
        'path'   => CACHE_PATH,
        // 缓存前缀
        'prefix' => '',
        // 缓存有效期 0表示永久缓存
        'expire' => 0,
    ],

    'log'                    => [
        // 日志记录方式，内置 file socket 支持扩展
        'type'  => 'test',
        // 日志保存目录
        'path'  => LOG_PATH,
        // 日志记录级别
        'level' => [],
    ]
];