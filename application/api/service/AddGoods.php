<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/14
 * Time: 21:35
 */

namespace app\api\service;

use app\api\model\Goods;
use app\api\model\GoodsImage;
use app\api\model\ImageByGoods;
use app\api\model\TypeLocation;
use app\api\service\Token as SToken;
use think\Db;
use think\Exception;
use think\Request;

class AddGoods
{
    public static function addGoods($userId){
        $request=Request::instance();
        //首先向goods表中插入数据,获得自动递增的goods_id (id,title,describe,location,price,user_id,type)
        //在向image_by_goods表中插入数据，获取自动递增的image_id    (id,image_url,goods_id,from)
        //向type_location表中插入数据，(id,type,goods_id,location)
        //向goods_image表中插入数据 (id,image_id,goods_id)
        $title=$request->param('title');
        $describe=$request->param('describe');
        $location=$request->param('location');
        $price=$request->param('price');
        $type=$request->param('type');
        $goods_id=null;
        $image_id=[];
        $imageUrls=$request->param('imageUrls');
        $imageUrls=json_decode($imageUrls);


        Db::startTrans();
        try{
            //首先向goods表中插入数据,获得自动递增的goods_id (id,title,describe,location,price,user_id,type)
            $goods=new Goods();
            $goods->data([
               'title'  =>  $title,
               'describe'   =>  $describe,
               'location'   =>  $location,
               'price'      =>  $price,
               'user_id'    =>  $userId,
               'type'       =>  $type
            ]);
            $result1=$goods->save();
            $goods_id=$goods->id;

            //在向image_by_goods表中插入数据，获取自动递增的image_id    (id,image_url,goods_id,from)
            $imageByGoods=new ImageByGoods();
            $list=[];
            foreach ($imageUrls as $imageUrl){
                array_push($list,['image_url'=>'/images/'.$imageUrl,'goods_id'=>$goods_id,'from'=>1]);
            }
            $result2=$imageByGoods->saveAll($list);
            foreach ($result2 as $value) {
                array_push($image_id,$value->getData()['id']);
            }

            //向type_location表中插入数据，(id,type,goods_id,location)
            $typeLocation=new TypeLocation();
            $typeLocation->data([
               'type'   =>  $type,
               'goods_id'   =>  $goods_id,
               'location'   =>  $location
            ]);
            $typeLocation->save();

            //向goods_image表中插入数据 (id,image_id,goods_id)
            $goodsImage=new GoodsImage();
            $list=[];
            foreach ($image_id as $value){
                array_push($list,['goods_id'=>$goods_id,'image_id'=>$value]);
            }
            $goodsImage->saveAll($list);
            Db::commit();
        }catch (Exception $e){
            Db::rollback();
            throw new Exception($e);
        }
        return true;
    }
}