<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/6/9
 * Time: 22:50
 */

namespace app\api\validate;


class PhoneValidate extends BaseValidate
{
    protected $rule=[
        'phone' =>  'isPhone'
    ];
}