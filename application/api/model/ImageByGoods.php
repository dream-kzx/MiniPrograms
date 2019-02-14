<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/4/29
 * Time: 15:53
 */

namespace app\api\model;


use think\Model;

class ImageByGoods extends Model
{
    protected $hidden=['from','id','goods_id'];

    /**
     * 判断是否返回拼接的url
     */
    public function getImageUrlAttr($value,$data){
        if($data['from']==1){//图片类型为1，拼接url
            return config('setting.image_prefix').$value;
        }else{//否则直接返回图片的url
            return $value;
        }
    }
}