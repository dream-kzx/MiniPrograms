<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/4/22
 * Time: 0:06
 */

namespace app\api\model;


use think\Model;
use think\Request;

class Banner extends Model
{
    protected $hidden=['id'];

    public function items(){
        $request=Request::instance();
        $location=$request->param('location');
        return $this->hasMany('BannerItem','banner_id','id');
//            ->where('location','=',$location);
    }

    public static function getBannerById($id){
        $result=null;
        try{
            $result=self::with(['items','items.image'])->find($id);
        }catch (Exception $e){
            throw new Exception($e);
            return null;
        }
        $result=json_decode(json_encode($result),true);
        if($result){
            if($result["items"]==null){
                return null;
            }else {
                return $result;
            }
        }else{
            return null;
        }
    }
}