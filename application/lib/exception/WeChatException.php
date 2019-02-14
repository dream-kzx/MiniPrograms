<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/5
 * Time: 16:02
 */

namespace app\lib\exception;


class WeChatException extends BaseException
{
    public $code=400;

    public $msg="微信接口调用失败";

    public $errorCode=999;
}