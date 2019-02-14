<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/4/23
 * Time: 19:14
 */

namespace app\lib\exception;


class BannerException extends BaseException
{
    //https状态码
    public $code=400;

    //错误信息
    public $msg='请求的轮播未找到';

    //自定义状态码
    public $errorCode=10001;
}