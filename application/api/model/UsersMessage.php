<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/27
 * Time: 20:05
 */

namespace app\api\model;


use think\Exception;
use think\Model;
use traits\model\SoftDelete;

class UsersMessage extends Model
{
    use SoftDelete;
    protected $hidden=['id','create_time','update_time','delete_time'];
    protected $autoWriteTimestamp='datetime';


    protected $deleteTime='delete_time';


    /**
     * @param $userId
     * @param $name
     * @param $sex
     * @param $avatar
     * @return bool
     * @throws Exception
     */
    public static function addUserMessage($userId,$name,$sex,$avatar){
        try{
            $result=self::where('user_id','=',$userId)->find();
            if($result){
                self::where(['user_id'=>$userId])->update([
                    "name"  =>$name,
                    'sex'   =>$sex,
                    'avatar_url'    =>  $avatar
                ]);
            }else{
                $userMessage=new UsersMessage();
                $userMessage->data=[
                    'user_id'   =>$userId,
                    'name'  =>  $name,
                    'sex'   =>  $sex,
                    'avatar_url'    => $avatar
                ];
                $userMessage->save();
            }
        }catch (Exception $e){
            throw new Exception($e);
        }
        return true;
    }

    public static function getUserMessage($userId){
        try{
            $result=self::where('user_id','=',$userId)->find();
        }catch (Exception $e){
            throw new Exception($e);
        }

        return $result;
    }
}