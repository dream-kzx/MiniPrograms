<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/6
 * Time: 21:51
 */

namespace app\lib\exception;


class ScopeException extends BaseException
{
    public $errorCode=10001;
    public $code=403;
    public $msg='无访问权限';
}