<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/27
 * Time: 20:09
 */

namespace app\api\controller\v1;


use app\api\model\UserPhone;
use app\api\model\UsersMessage;
use app\api\service\UserToken;
use app\api\validate\HisUserIdValidate;
use app\api\validate\PhoneValidate;
use app\api\validate\UserValidate;
use app\lib\exception\BaseException;
use think\Loader;
use think\Request;

class User
{
    /**增加用户信息
     * @param Request $request
     * @return \think\response\Json
     * @throws BaseException
     * @throws \think\Exception
     */
    public function addUserMessage(Request $request){
        (new UserValidate())->gocheck();
        $userId=UserToken::getTokenUserId();
        if($userId){
            $name=$request->param('name');
            $sex=$request->param("sex");
            $avatar=$request->param('avatar');
            $result=UsersMessage::addUserMessage($userId,$name,$sex,$avatar);
        }else{
            throw new BaseException();
        }
        return json(['user_id'=>$userId],200);
    }

    /**获取用户信息
     * @return \think\response\Json
     * @throws BaseException
     * @throws \think\Exception
     */
    public function getUserMessage(){
        $userId=UserToken::getTokenUserId();
        if($userId){
            $result=UsersMessage::getUserMessage($userId);
        }else{
            throw new BaseException();
        }
        return json($result,200);
    }

    /**获取对方用户的信息
     * @param Request $request
     * @return \think\response\Json
     * @throws BaseException
     * @throws \think\Exception
     */
    public function getHisMessage(Request $request){
        (new HisUserIdValidate())->gocheck();
        $userId=UserToken::getTokenUserId();
        if($userId){
            $hisUserId=$request->param("hisUserId");
            $result=UsersMessage::getUserMessage($hisUserId);
        }else{
            throw new BaseException();
        }
        return json($result,200);
    }

    /**获取用户的手机号码
     * @return \think\response\Json
     * @throws BaseException
     * @throws \think\Exception
     */
    public function getUserPhone(){
        $userId=UserToken::getTokenUserId();
        if($userId){
            $result=UserPhone::getUserPhone($userId);
        }else{
            throw new BaseException();
        }
        return json($result,200);
    }

    /**设置用户的手机号码
     * @param Request $request
     * @return \think\response\Json
     * @throws BaseException
     * @throws \think\Exception
     */
    public function setUserPhone(Request $request){
        (new PhoneValidate())->gocheck();
        $userId=UserToken::getTokenUserId();
        $phone=$request->param('phone');
        if($userId){
            $result=UserPhone::setUserPhone($userId,$phone);
        }else{
            throw new BaseException();
        }
        return json($result,200);
    }
}