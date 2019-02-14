<?php
namespace app\index\controller;

class Index
{
    public function index()
    {
        echo("你看到了什么？");
//        phpinfo();
//        config("default_return_type",'html');
//        return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="ad_bd568ce7058a1091"></think>';
    }

    public function test(){
        return "1111111";
    }

//    public function index(){
//        $socket=socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
//        $result=socket_connect($socket,'0.0.0.0',443);
//        socket_bind($socket,'0.0.0.0',443);
//        socket_listen($socket,20);
//        $message=socket_accept($socket);
//        $length=128;
//        socket_read($message,$length);
//        socket_write($socket)
//        $socket=socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
//        if(socket_bind($socket,'127.0.0.1',1234)==false){
//            dump("绑定IP地址和端口失败");
//        }
//        if(socket_listen($socket,4)==false){
//            dump("监听端口失败");
//        }
//
//        do{
//            $accept=socket_accept($socket);
//            $string=socket_read($accept);
//            dump($string);
//
//            if($string=false){
//                $return_client="1111111111111111111111111111";
//            }else{
//                dump("fail");
//            }
//            socket_close($accept);
//        }while(true);
//        socket_close($socket);
//    }
}
