<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/18
 * Time: 22:16
 */

namespace app\api\validate;


class AddTaskValidate extends BaseValidate
{
    protected $rule=[
        'title'     =>  'require|isGetLocation',
        'describe'  =>  'require',
        'location'  =>  'require|isGetLocation',
        'price'     =>  'require|isGetFloat',
    ];
}