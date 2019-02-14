<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/4/29
 * Time: 15:39
 */

namespace app\api\model;


use think\Model;

class GoodsImage extends Model
{
    protected $hidden=[
        'id','image_id','goods_id',
    ];
    public function getImages(){
        return $this->belongsTo('ImageByGoods','image_id','id');
    }
}