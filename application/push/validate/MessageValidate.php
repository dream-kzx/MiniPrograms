<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/25
 * Time: 14:25
 */

namespace app\push\validate;


use app\api\validate\BaseValidate;

class MessageValidate extends BaseValidate
{
    protected $rule=[
        'hisUserId' =>  'require|isGetInteger',
        'page'      =>  'require|isGetInteger'
    ];

    protected $message=[
        'hisUserId' =>  '参数必须为正整数',
        'page'      =>  '参数必须为正整数'
    ];
}