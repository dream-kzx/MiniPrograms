<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/4/29
 * Time: 15:01
 */

namespace app\api\validate;


class GoodsValidate extends BaseValidate
{
    protected $rule=[
        'id'    =>  'require|isGetInteger'
    ];
    protected $message=[
        'id'    =>  '参数必须为正整数'
    ];
}