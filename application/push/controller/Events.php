<?php
namespace app\push\controller;
use app\push\model\SendMessage;
use app\push\model\SocketToken;
use GatewayWorker\Lib\Gateway;

class Events{
    /**
     * 当客户端连接时触发
     * @param $client_id
     * @param $data:http头数据
     */
    public static function onWebSocketConnect($client_id,$data){
        //获取请求头中的token
        $token=$data['server']['HTTP_TOKEN'];
        //通过token读取缓存中的userId

        $userId=SocketToken::getUserIdByToken($token);
        dump("登录成功".$userId);
        //如果userId不存在者关闭连接，否则绑定client_id
        if($userId==null){
            Gateway::closeClient($client_id);
            dump("关闭连接".$userId);
        }else{
            Gateway::bindUid($client_id,$userId);
            //加载未接收的消息
//            $data=SendMessage::noOnMessage($userId);
//            if($data){
//                Gateway::sendToUid($userId,json_encode($data));
//            }
        }

    }

    /**
     * 当客户端发来消息时触发
     * @param int $client_id 连接id
     * @param mixed $message 具体消息
     */
    public static function onMessage($client_id, $data) {

        $userId=Gateway::getUidByClientId($client_id);
        $data=json_decode($data,true);
        $sendToUserId=$data['userId'];
        $message=$data['message'];
        dump($data);
        if(Gateway::isUidOnline($sendToUserId)){
            SendMessage::saveMessage($userId,$sendToUserId,$message,1);
            Gateway::sendToUid($sendToUserId,json_encode([
                'message'   =>  $message,
                'fromUserId'    =>  $userId,
                "create_time"   =>date("Y-m-d H:i:s")
            ]));
        }else{
            SendMessage::saveMessage($userId,$sendToUserId,$message,0);
            dump($sendToUserId."已经下线");
        }

    }

    /**
     * 当用户断开连接时触发
     * @param int $client_id 连接id
     */
    public static function onClose($client_id) {
        // 向所有人发送
//        GateWay::sendToAll("$client_id logout");
    }
}

