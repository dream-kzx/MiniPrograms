<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/19
 * Time: 17:43
 */

namespace app\api\model;


use think\Exception;
use think\Model;
use traits\model\SoftDelete;

class CollectGoods extends Model
{
    use SoftDelete;

    protected $deleteTime='delete_time';

    protected $autoWriteTimestamp='datetime';

    protected $hidden=[
        'create_time','update_time','delete_time','id'
    ];

    public function goods(){
        return $this->belongsTo('Goods','goods_id','id');
    }

    public static function addCollect($id,$userId){
        $result=0;
        try{
            $really1=self::where([
                'goods_id'  =>  $id,
                'user_id'   =>  $userId
            ])->find();

            if(!empty($really1)){
                $result=1;
            }

            $goods=new Goods();
            $really2=$goods->where([
                'id'  =>  $id,
                'user_id'   =>  $userId
            ])->find();

            if(empty($really1)&&!$really2){
                $collectGoods=new CollectGoods();
                $collectGoods->data(['user_id'=>$userId,'goods_id'=>$id]);
                $result=$collectGoods->save();
            }
        }catch (Exception $e){
            throw new Exception($e);
        }
        return $result;
    }


    public static function queryCollect($userId){
        try{
            $result=self::with(['goods','goods.items','goods.items.getImages'])
                ->where('user_id','=',$userId)->order('create_time desc')->select();
        }catch (Exception $e){
            throw new Exception($e);
        }
        return $result;
    }

    public static function removeCollect($userId,$goods_id){
        try{
            $result=self::where(['user_id'=>$userId,'goods_id'=>$goods_id])->delete();
        }catch (Exception $e){
            throw new Exception($e);
        }
        return $result;
    }

}