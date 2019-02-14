<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/21
 * Time: 20:30
 */

namespace app\index\controller;

use GatewayWorker\BusinessWorker;
use GatewayWorker\Gateway;
use GatewayWorker\Register;
use Workerman\Worker;


class Run
{

    public function __construct(){

        //初始化各个GatewayWorker
        //初始化register
        new Register("text://127.0.0.1:1314");

        //初始化 bussinessWorker 进程
        $worker=new BusinessWorker();
        $worker->name="WebBusinessWorker";
        $worker->count=2;
        $worker->registerAddress='127.0.0.1:1314';

        //设置处理业务的类,此处制定Events的命名空间
        $worker->eventHandler='\app\push\controller\Events';

        // 初始化 gateway 进程
        $gateway=new Gateway("websocket://0.0.0.0:1234");
        $gateway->name="WebGateway";
        $gateway->count=2;
        $gateway->lanIp="127.0.0.1";
        $gateway->startPort=2900;
//        $gateway->pingInterval=10;
//        $gateway->pingData='{"type","ping"}';
        $gateway->registerAddress="127.0.0.1:1314";

        Worker::runAll();
    }
}