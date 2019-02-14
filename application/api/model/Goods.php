<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/4/29
 * Time: 14:50
 */

namespace app\api\model;


use think\Exception;
use think\Model;
use traits\model\SoftDelete;

class Goods extends Model
{
    use SoftDelete;

    protected $deleteTime='delete_time';


    protected $autoWriteTimestamp='datetime';

    protected $hidden=[
        'image_item','create_time','delete_time','update_time',"type"
    ];

    public function items(){
        return $this->hasMany('GoodsImage','goods_id','id');
    }

    /**
     * 根据goods_id获取商品的详情
     */
    public static function getGoodsParticularsById($id){
        try{
            $goodsParticulars=self::with(['items','items.getImages'])
                ->where('id','=',$id)
                ->find();
        }catch (Exception $e){
            throw new Exception($e);
            return null;
        }

        if($goodsParticulars){
            $goodsParticulars->hidden([
                'create_time','delete_time','update_time',"type"
            ]);
            return $goodsParticulars;
        }else{
            return null;
        }
    }

    /**查询我发布的goods
     * @param $userId
     * @return false|\PDOStatement|string|\think\Collection
     * @throws Exception
     */
    public static function queryMyGoods($userId){
        try{
            $result=self::with(['items','items.getImages'])->where('user_id','=',$userId)->select();
        }catch (Exception $e){
            throw new Exception($e);
        }
        return $result;
    }

    public static function querySold($userId){
        try{
            $result=self::onlyTrashed()->with(['items','items.getImages'])
                ->where('user_id','=',$userId)->select();
        }catch (Exception $e){
            throw new Exception($e);
        }
        return $result;
    }

    public static function fackDeleteGoods($id){
        try{
            $result1=self::destroy(['id'=>$id]);
            $result2=TypeLocation::destroy(['goods_id'=>$id]);
        }catch (Exception $e){
            throw new Exception($e);
        }
       return $result1&&$result2;
    }


    public static function searchGoods($keyWord,$location,$page){
        try{
            $result=self::with(['items','items.getImages'])
                ->where('location','=',$location)
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