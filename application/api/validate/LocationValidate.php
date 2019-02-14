<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/4
 * Time: 21:24
 */

namespace app\api\validate;


class LocationValidate extends BaseValidate
{
    protected $rule=[
        'location'  =>  'require|isGetLocation',
    ];
}