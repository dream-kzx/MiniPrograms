<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/4/23
 * Time: 21:43
 */

namespace app\api\controller\v1;


use app\api\validate\TokenGet;
use app\api\service\UserToken;
use think\Cache;
use think\Request;
use app\api\service\Token as SToken;

class Token
{
    /**
     * 根据wxcode返回token
     * @method  POST
     * @url /api/Token/User?wxcode=
     * @param Request $request
     * @return \think\response\Json
     * @throws \app\lib\exception\BaseException
     * @throws \app\lib\exception\TokenException
     * @throws \app\lib\exception\WeChatException
     * @throws \think\Exception]
     */
    public function getToken(Request $request){
        (new TokenGet())->gocheck();
        $wxcode=$request->param('wxcode');
        $userToken=new UserToken($wxcode);
        $token=$userToken->get();
        return json($token,200);
    }

    /**检测token是否有效
     * @return \think\response\Json
     */
    public function verifyToken(){
        $request= Request::instance();
        $token=$request->header('token');
        $vars=Cache::get($token);
        if($vars){
            $vars=json_decode($vars,true);
            $userId=$vars['userId'];
            if($userId){
                return json(true,200);
            }else{
                return json(false,200);
            }
        }else{
            return json(false,200);
        }
    }
}