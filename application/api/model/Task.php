<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/6
 * Time: 14:44
 */

namespace app\api\model;


use think\Exception;
use think\Model;
use traits\model\SoftDelete;

class Task extends Model
{
    use SoftDelete;
    protected $deleteTime='delete_time';
    protected $autoWriteTimestamp='datetime';

    protected $hidden=[
        'create_time','delete_time','update_time','from'
    ];

    public function getImageUrlAttr($value,$data){
        if($data['from']==1){//图片类型为1，拼接url
            return config('setting.image_prefix').$value;
        }else{//否则直接返回图片的url
            return $value;
        }
    }

    /**根据task_id获取task的详细信息
     * @param $id
     * @return array|false|null|\PDOStatement|string|Model
     * @throws Exception
     */
    public static function taskParticulars($id){
        try{
            $result=self::find($id);
        }catch (Exception $e){
            throw new Exception($e);
        }

        if($result){
            return $result;
        }else{
            return null;
        }
    }

    /**查询我发布的Task
     * @param $userId
     * @return false|\PDOStatement|string|\think\Collection
     * @throws Exception
     */
    public static function queryMyTask($userId){
        try{
            $result=self::where('user_id','=',$userId)
                ->select();
        }catch (Exception $e){
            throw new Exception($e);
        }
        return $result;
    }

    public static function querySoldTask($userId){
        try{
            $result=self::onlyTrashed()
                ->where('user_id','=',$userId)->select();
        }catch (Exception $e){
            throw new Exception($e);
        }
        return $result;
    }

    /**下架商品
     * @param $id
     * @return bool
     * @throws Exception
     */
    public static function fackDeleteTask($id){
        try{
            $result1=self::destroy(['id'=>$id]);
            $result2=TaskLocation::destroy(['task_id'=>$id]);
        }catch (Exception $e){
            throw new Exception($e);
        }

        return $result1&&$result2;
    }

    public static function searchTask($keyWord,$location,$page){
        try{
            $result=self::where('location','=',$location)
                ->where("title|describe",'like',"%".$keyWord."%")
                ->order('create_time desc')
                ->limit(0,$page*7)
                ->select();
        }catch (Exception $e){
            throw new Exception($e);
        }
        return $result;
    }
}