<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/24
 * Time: 20:22
 */

namespace app\push\controller;


use app\push\model\SendMessage;
use think\Request;

class Test
{
    public function testMessage(Request $request){
        $userId=$request->param('userId');
        $toUserId=$request->param('toUserId');
        $message=$request->param("message");
        $result=SendMessage::saveMessage($userId,$toUserId,$message);
        return json($result,200);
    }
}