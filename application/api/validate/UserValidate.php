<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/28
 * Time: 10:29
 */

namespace app\api\validate;


class UserValidate extends BaseValidate
{
    protected $rule=[
        'name'  =>  'require|nameLength',
        'sex'   =>  'require|isGetInteger',
        'avatar'=>  'require'
    ];


    protected function nameLength($value){
        $length=strlen($value);
        if($length>30){
            return ["name"  =>  '长度过长'];
        }else{
            return true;
        }
    }
}