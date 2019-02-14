<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/4/23
 * Time: 21:52
 */

namespace app\api\service;


use app\api\model\User as ModelUser;
use app\lib\enum\ScopeEnum;
use app\lib\exception\TokenException;
use app\lib\exception\WeChatException;
use think\Exception;


class UserToken extends Token
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    /**
     * UserToken constructor.
     * @param $code
     * 初始化信息
     */
    function __construct($code){
        $this->code=$code;
        $this->wxAppID=config('wx.app_id');
        $this->wxAppSecret=config('wx.app_secret');
        $this->wxLoginUrl=sprintf(config('wx.login_url'),
            $this->wxAppID,$this->wxAppSecret,$this->code);
    }

    /**请求微信服务器得到open_id，并配置得到token
     * @return string
     * @throws Exception
     * @throws TokenException
     * @throws WeChatException
     */
    public function get(){
        $result=getUrl($this->wxLoginUrl);
        $wxResult=json_decode($result,true);//true返回一个数组
        if(empty($wxResult)){
            throw new Exception('获取session_key,openid异常，微信内部错误');
        }else{
            $loginFail=array_key_exists('errcode',$wxResult);//接口调用错误，微信会返回一个errorcode码
            if($loginFail){
                throw new WeChatException([
                    'msg'   =>  $wxResult['errmsg'],
                    'errorCode' =>  $wxResult['errcode']]
                );
            }else{
                $token=$this->grantToken($wxResult);
            }
        }
        return $token;
    }

    /**
     * 设置token
     * @param $wxResult
     * @return string
     * @throws TokenException
     */
    private function grantToken($wxResult){
        //得到openid
        //看openid是否已经存在数据库
        //生成令牌，写入缓存
        //返回令牌key
        //value:wxResult,userId,scope
        $openid=$wxResult['openid'];
        $user=ModelUser::queryOpenid($openid);
        if($user){
            $userId=$user->id;
        }else{
            $userId=$this->newUser($openid);
        }
        $cacheValue=$this->perpareCacheValue($wxResult,$userId);
        $token=$this->writeCacheValue($cacheValue);
        return [
            "token" =>  $token
        ];
    }


    /**写入缓存
     * @param $cacheValue
     * @return string
     * @throws TokenException
     */
    private function writeCacheValue($cacheValue){
        $key=self::generateToekn();
        $value=json_encode($cacheValue);
        $cache_time=config('setting.token_cache_time');
        $result=cache($key,$value,$cache_time);
        if(!$result){
            throw new TokenException([
                'msg'   =>  '服务器缓存错误',
                'errorCode' =>  10005
            ]);
        }
        return $key;
    }

    /**
     * @param $wxResult
     * @param $userId
     * @return mixed
     * 用来准备缓存
     */
    private function perpareCacheValue($wxResult,$userId){
        $cacheValue=$wxResult;
        $cacheValue['userId']=$userId;
        $cacheValue['scope']=ScopeEnum::User;
        return $cacheValue;
    }

    /**
     * 像数据库user表中插入新用户
     * @param $openid
     * @return mixed
     */
    private function newUser($openid){
        $user=new ModelUser();
        $user->data([
            "openid"    => $openid
        ]);
        $user->save();
        return $user->id;
    }

}