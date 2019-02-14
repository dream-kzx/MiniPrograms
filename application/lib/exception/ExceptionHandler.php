<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/4/21
 * Time: 23:54
 */

namespace app\lib\exception;


use think\exception\Handle;
use think\exception\HttpException;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;

    function render(\Exception $e)
    {
        if($e instanceof BaseException){
            $this->code=$e->code;
            $this->msg=$e->msg;
            $this->errorCode=$e->errorCode;
        }elseif ($e instanceof HttpException){
            $this->code=404;
            $this->msg='请求类型错误';
            $this->errorCode=999999;
        }else{
            if(config('app_debug')){
                return parent::render($e);
            }else{
                $this->code=500;
                $this->msg='服务器内部未知错误';
                $this->errorCode=9999;
                $this->errorLog($e);
            }
        }

        $request=Request::instance();
        $result=[
            'msg'   =>  $this->msg ,
            'error_code'    =>  $this->errorCode,
            'request_url'   =>  config('setting.image_prefix').$request->url()
        ];
        return json($result,$this->code);
    }

    private function errorLog(\Exception $e){
        Log::init([
            'type'  =>  'File',
            'path'  =>  LOG_PATH,
            'level' =>  ['error']
        ]);

        Log::record([
            $e->getMessage(),
            $e->getLine(),
            $e->getFile()
        ]);
    }
}