<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/6/7
 * Time: 3:49
 */

namespace app\api\validate;


class TaskLocationValidate extends BaseValidate
{
    protected $rule=[
        'location'  =>  'require|isGetLocation',
        'page'  =>  'require|isGetInteger'
    ];
}