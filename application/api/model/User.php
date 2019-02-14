<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/4/23
 * Time: 21:51
 */

namespace app\api\model;


use think\Model;

class User extends Model
{
    protected $autoWriteTimestamp='datetime';

    public static function queryOpenid($openid){
        $user=self::where('openid','=',$openid)->find();
        if(empty($user)){
            return false;
        }else{
            return $user;
        }
    }

}