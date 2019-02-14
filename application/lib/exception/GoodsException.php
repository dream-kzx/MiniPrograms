<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/2
 * Time: 19:52
 */

namespace app\lib\exception;


class GoodsException extends BaseException
{
    //https状态码
    public $code=400;

    //错误信息
    public $msg='该商品不存在';

    //自定义状态码
    public $errorCode=10001;
}