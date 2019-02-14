<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/4/22
 * Time: 0:12
 */

namespace app\api\validate;


class MustParamBanner extends BaseValidate
{
    protected $rule=[
        'id'    =>  'require|isGetInteger',
        'location'  =>  'require|isGetLocation'
    ];

    protected $message=[
        'id'    =>  '参数必须为正整数'
    ];



}