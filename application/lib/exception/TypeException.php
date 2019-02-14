<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/2
 * Time: 19:59
 */

namespace app\lib\exception;


class TypeException extends BaseException
{
    //https状态码
    public $code=400;

    //错误信息
    public $msg='该分类没有商品';

    //自定义状态码
    public $errorCode=10001;
}