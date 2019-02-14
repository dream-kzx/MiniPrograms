<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/2
 * Time: 19:29
 */

namespace app\api\model;


use think\Exception;
use think\Model;
use traits\model\SoftDelete;

class TypeLocation extends Model
{
    use SoftDelete;

    protected $deleteTime='delete_time';

    protected $autoWriteTimestamp='datetime';

    protected $hidden=[
        'id',
        'type',
        'create_time',
        'delete_time',
        'update_time'
    ];

    /**
     * 根据goods_id向Goods表中查询数据
     * @return $this
     */
    public function getGoods(){
        return $this->belongsTo('Goods','goods_id','id')
            ->field(['id','title','price']);
    }

    /**
     * 根据goods_id向Goods表中查询数据，并根据时间排序
     * @return $this
     */
    public function newGoods(){
        return $this->belongsTo('Goods','goods_id','id')->order('create_time')
            ->field(['id','title','price']);
    }

    /**
     * @param $type
     * @param $location
     * @return false|null|\PDOStatement|string|\think\Collection
     * @throws Exception
     * 根据位置和商品类型查询商品
     */
    public static function getGoodsByType($type,$location,$page){
        try{
            $result=self::with(['getGoods',
                'getGoods.items',
                'getGoods.items.getImages'
            ])->where(['type'=>$type,
                "location"  =>  $location])
                ->limit(0,$page*7)
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

    public static function getNewGoods($location){
        try{
            $result=self::with(['newGoods',
                'newGoods.items',
                'newGoods.items.getImages'
            ])->where('location','=',$location)
                ->order('create_time desc')
                ->limit(0,10)
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