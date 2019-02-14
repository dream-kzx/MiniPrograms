<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/2
 * Time: 19:29
 */

namespace app\api\validate;


class TypeValidate extends BaseValidate
{
    protected $rule=[
        "type"  =>  'require|isGetInteger',
        "location"  =>  "require|isGetLocation",
        "page"  =>  'require|isGetInteger'
    ];
    protected $message=[
        "type"  =>  '参数必须为正整数',
        "location"  => "参数中不能有非法字符"
    ];
}