<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/4/22
 * Time: 12:44
 */

namespace app\api\model;


use think\Exception;
use think\Model;

class BannerItem extends Model
{
    protected $hidden=['id','banner_id','image_id'];

    public function image(){
        return $this->belongsTo('ImageByBanner','image_id','id');
    }
}