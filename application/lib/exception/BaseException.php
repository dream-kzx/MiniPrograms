<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/4/21
 * Time: 23:42
 */

namespace app\lib\exception;


use think\Exception;

class BaseException extends Exception
{
    //https状态码
    public $code=404;

    //错误信息
    public $msg='参数错误';

    //自定义状态码
    public $errorCode=10000;

    public function __construct($params=[]){
        if(!is_array($params)){
            return;
        }

        if(array_key_exists('code',$params)){
            $this->code=$params['code'];
        }
//        if(array_key_exists('msg',$params)){
//            $this->msg=$params['msg'];
//        }
        if(!empty($params)){
            $this->msg=$params;
        }


        if(array_key_exists('errorCode',$params)){
            $this->errorCode=$params['errorCode'];
        }
    }
}