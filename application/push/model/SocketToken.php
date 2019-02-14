<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/23
 * Time: 20:52
 */

namespace app\push\model;


use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;

class SocketToken
{
    public static function getUserIdByToken($token){
        $vars=Cache::get($token);
        if(!$vars){
            return null;
        }else{
            if(!is_array($vars)){
                $vars=json_decode($vars,true);
            }
            if(array_key_exists('userId',$vars)){
                return $vars['userId'];
            }else{
                return null;
            }
        }
    }
}