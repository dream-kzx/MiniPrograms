<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/6
 * Time: 14:53
 */

namespace app\api\model;


use think\Exception;
use think\Model;
use traits\model\SoftDelete;

class TaskLocation extends Model
{
    use SoftDelete;
    protected $deleteTime='delete_time';
    protected $autoWriteTimestamp='datetime';
    protected $hidden=[
        'create_time','delete_time','id','update_time'
    ];
    public function taskParticulars(){
        return $this->belongsTo('Task','task_id','id');
    }

    public static function getIdByLocation($location,$page){
        try{
            $result=self::with(['taskParticulars'])
                ->where('location','=',$location)
                ->order("create_time desc")
                ->limit(0,$page*5)
                ->select();
        }catch (Exception $e){
            throw new Exception($e);
        }
        if($result){
            return $result;
        }else{
            return null;
        }
    }
}