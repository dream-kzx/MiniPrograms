<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/5
 * Time: 21:59
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $code=404;
    public $msg='Toekn已过期或无效Token';
    public $errorCode=100001;
}