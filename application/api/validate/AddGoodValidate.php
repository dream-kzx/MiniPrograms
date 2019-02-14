<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/17
 * Time: 21:55
 */

namespace app\api\validate;


class AddGoodValidate extends BaseValidate
{
    protected $rule=[
        'title'     =>  'require|isGetLocation',
        'describe'  =>  'require',
        'location'  =>  'require|isGetLocation',
        'price'     =>  'require|isGetFloat',
        'type'      =>  'require|isGetInteger',
        'imageUrls' =>  'require|isGetArray'
    ];
}