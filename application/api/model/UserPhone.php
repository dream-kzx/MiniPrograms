<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/6/9
 * Time: 22:30
 */

namespace app\api\model;


use think\Exception;
use think\Model;

class UserPhone extends Model
{
    public static function getUserPhone($userId){
        try{
            $result=self::where('user_id','=',$userId)->find();
        }catch (Exception $e){
            throw new Exception($e);
        }
        return $result;
    }

    public static function setUserPhone($userId,$phone){
        try{
            $result=self::where('user_id','=',$userId)->find();
            if($result){
                $result=self::where('user_id','=',$userId)
                    ->update([
                        'user_id'=>$userId,
                        'phone'=>$phone
                    ]);
            }else{
                $thisModel=new UserPhone();
                $thisModel->data([
                    'user_id'=>$userId,
                    'phone'=>$phone
                ]);
                $result=$thisModel->save();
            }
        }catch (Exception $e){
            throw new Exception($e);
        }

        return $result;
    }
}