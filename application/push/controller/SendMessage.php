<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/25
 * Time: 12:36
 */

namespace app\push\controller;
use app\api\service\Token;
use app\lib\exception\BaseException;
use app\push\model\SendMessage as MSendMessage;

use app\push\validate\MessageValidate;
use think\Request;

class SendMessage
{
    public function getHistoryMessage(Request $request){

        (new MessageValidate())->gocheck();
        $userId=Token::getTokenUserId();

        $hisUserId=$request->param('hisUserId');
        $page=$request->param('page');

        $data=MSendMessage::historyMessage($userId,$hisUserId,$page);
        return json($data,200);
    }

    public function getContacts(Request $request){
        $userId=Token::getTokenUserId();
        $result=MSendMessage::getContacts($userId);

        if($result){
            return json($result,200);
        }else{
            throw new BaseException();
        }
    }
}