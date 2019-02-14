<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/18
 * Time: 11:18
 */

namespace app\api\service;


use app\api\model\Task;
use app\api\model\TaskLocation;
use think\Db;
use think\Exception;
use think\Request;

class AddTask
{
    public static function  addTask($userId){
        $request=Request::instance();
        //首先向task表中插入数据获取task_id,(title,price,describe,image_url,from,user_id)
        //再向task_location插入数据（location,task_id）
        $title=$request->param('title');
        $price=$request->param('price');
        $describe=$request->param('describe');
        $location=$request->param('location');
        $imageUrl=null;

        Db::startTrans();
        try{
            $file=$request->file('image');
            if($file) {
                $info = $file->validate(['size' => 5242880, 'ext' => 'jpg,png,gif'])
                    ->rule("date")
                    ->move(ROOT_PATH . 'public' . DS . 'images');
                if($info){
                    $imageUrl='/images/'.$info->getSaveName();
                }else{
                    $imageUrl='/images/1.jpg';
                }
            }

            //首先向task表中插入数据获取task_id,(title,price,describe,image_url,from,user_id)
            $task=new Task();
            $task->data([
                'title'  =>  $title,
                'price'  =>  $price,
                'describe'   =>  $describe,
                'image_url'  =>  $imageUrl,
                'from'   =>  1,
                'user_id'   =>  $userId,
                'location'  =>  $location
            ]);
            $task->save();
            $taskId=$task->id;

            //再向task_location插入数据（location,task_id）
            $taskLocation=new TaskLocation();
            $taskLocation->data([
                'location'  =>  $location,
                'task_id'   =>  $taskId
            ]);
            $taskLocation->save();

            Db::commit();
        }catch (Exception $e){
            Db::rollback();
            throw new Exception($e);
        }
        return true;
    }

    public static function addTask2($userId){
        $request=Request::instance();
        //首先向task表中插入数据获取task_id,(title,price,describe,image_url,from,user_id)
        //再向task_location插入数据（location,task_id）
        $title=$request->param('title');
        $price=$request->param('price');
        $describe=$request->param('describe');
        $location=$request->param('location');

        Db::startTrans();
        try{
            //首先向task表中插入数据获取task_id,(title,price,describe,image_url,from,user_id)
            $task=new Task();
            $task->data([
                'title'  =>  $title,
                'price'  =>  $price,
                'describe'   =>  $describe,
                'image_url'  =>  '/images/ui/noUpLoad.png',
                'from'   =>  1,
                'user_id'   =>  $userId,
                'location'  =>  $location
            ]);
            $task->save();
            $taskId=$task->id;

            //再向task_location插入数据（location,task_id）
            $taskLocation=new TaskLocation();
            $taskLocation->data([
                'location'  =>  $location,
                'task_id'   =>  $taskId
            ]);
            $taskLocation->save();

            Db::commit();
        }catch (Exception $e){
            Db::rollback();
            throw new Exception($e);
        }
        return true;
    }
}