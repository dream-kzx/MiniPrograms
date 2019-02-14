<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/19
 * Time: 17:43
 */

namespace app\api\model;


use think\Model;
use traits\model\SoftDelete;
use think\Exception;

class CollectTask extends Model
{
    use SoftDelete;

    protected $deleteTime='delete_time';

    protected $autoWriteTimestamp='datetime';

    protected $hidden=[
        'create_time','update_time','delete_time','id'
    ];

    public function task(){
        return $this->belongsTo('Task','task_id','id');
    }

    public static function addCollect($id,$userId){
        $result=0;
        try{
            $really1=self::where([
                'task_id'  =>  $id,
                'user_id'   =>  $userId
            ])->find();

            if(!empty($really1)){
                $result=1;
            }

            $task=new Task();
            $really2=$task->where([
                'id'  =>  $id,
                'user_id'   =>  $userId
            ])->find();
            if(empty($really1)&&!$really2){
                $collectTask=new CollectTask();
                $collectTask->data(['user_id'=>$userId,'task_id'=>$id]);
                $result=$collectTask->save();
            }
        }catch (Exception $e){
            throw new Exception($e);
        }
        return $result;
    }

    public static function queryCollect($userId){
        try{
            $result=self::with(['task'])
                ->where('user_id','=',$userId)->order('create_time desc')->select();
        }catch (Exception $e){
            throw new Exception($e);
        }
        return $result;
    }

    public static function removeCollect($userId,$task_id){
        try{
            $result=self::where(['user_id'=>$userId,'task_id'=>$task_id])->delete();
        }catch (Exception $e){
            throw new Exception($e);
        }
        return $result;
    }

}