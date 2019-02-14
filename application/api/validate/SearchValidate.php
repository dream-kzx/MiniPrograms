<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/6/8
 * Time: 14:41
 */

namespace app\api\validate;


class SearchValidate extends BaseValidate
{
    protected $rule=[
        "keyWord"=>'require|isGetLocation',
        'page'=>"require|isGetInteger",
        "location"  =>"require|isGetLocation"
    ];
}