<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/5
 * Time: 21:36
 */

namespace app\api\service;


use app\lib\exception\BaseException;
use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    /**生成token
     * @return string
     */
    public static function generateToekn(){
        //32个字符组成一个字符串
        $randString=getRandString(32);
        //用三组字符串，进行md5加密
        $timesString=$_SERVER['REQUEST_TIME'];

        $secure=config('secure.my_love');

        return md5($randString.$timesString.$secure);
    }

    /**
     * 从缓存中读取token的值
     * @param $key      $key的值可以为userId，openid，session_key,scope
     * @return mixed
     * @throws Exception
     * @throws TokenException
     */
    public static function readTokenVar($key){
        $request= Request::instance();
        $token=$request->header('token');
        $vars=Cache::get($token);
        if(!$vars){
            throw new TokenException();
        }else{
            if(!is_array($vars)){
                $vars=json_decode($vars,true);
            }
            if(array_key_exists($key,$vars)){
                return $vars[$key];
            }else{
                throw new Exception('尝试获取Token变量不存在');
            }
        }
    }

    public static function getTokenUserId(){
        $userId=self::readTokenVar('userId');
        return $userId;
    }
}