<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/6/7
 * Time: 8:18
 */

namespace app\api\validate;


class HisUserIdValidate extends BaseValidate
{
    protected $rule=[
        'hisUserId'      =>  'require|isGetInteger',
    ];
}