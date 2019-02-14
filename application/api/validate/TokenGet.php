<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/4/23
 * Time: 21:45
 */

namespace app\api\validate;


class TokenGet extends BaseValidate
{
    protected $rule=[
        'wxcode'  =>  'require|isNotEmpty'
    ];

    protected $message=[
        'wxcode'  =>  '无wxcode'
    ];


    public function isNotEmpty($value, $rule = '', $data = '', $field = ''){
        if(empty($value)){
            return false;
        }else{
            return true;
        }
    }
}