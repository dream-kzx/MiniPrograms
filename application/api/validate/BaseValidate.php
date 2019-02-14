<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/4/22
 * Time: 0:09
 */

namespace app\api\validate;


use app\lib\exception\BaseException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function gocheck(){
        $request=Request::instance();
        $params=$request->param();
        $result=$this->batch()->check($params);

        if(!$result){
            $error=$this->error;
            throw new BaseException($error);
        }else{
            return true;
        }
    }

    /**
     * 读取需要的参数到数组
     * @param $arrays
     * @return array
     * @throws BaseException
     */
    public function getDataByRule($arrays){
        if(array_key_exists('user_id',$arrays)|array_key_exists('userId',$arrays)){
            throw new BaseException([
                'msg'   =>  '请求中包含非法参数'
            ]);
        }
        $newArrays=[];
        foreach ($this->rule as $key=>$value){
            $newArrays[$key]=$arrays[$key];
        }
        return $newArrays;
    }
    /**
     * @param $value
     * @param string $rule
     * @param string $data
     * @param string $field
     * @return array|bool
     * 验证id参数
     */
    protected function isGetInteger($value,$rule='',$data='',$field=''){
        if(is_numeric($value)&&is_int($value+0)&&($value+0)>0){
            return true;
        }else{
            return ['msg'=>'参数必须为正整数'];
        }
    }

    /**判断是不是正数
     * @param $value
     * @return array|bool
     */
    protected function isGetFloat($value){
        if(is_numeric($value)&&(is_int($value+0)||is_float($value+0))&&($value+0)>0){
            return true;
        }else{
            return ['msg'=>'参数必须为正数'];
        }
    }

    protected function isGetArray($value){
        $value=json_decode($value);
        if(is_array($value)){
            return true;
        }else{
            return ['msg'=>'参数必须是一个数组'];
        }
    }

    /**
     * @param $value
     * @return array|bool
     * 验证位置参数
     */
    protected function isGetLocation($value){
        $really=preg_match_all('/[\x{4e00}-\x{9fa5}a-zA-Z0-9]/u',$value,$matches);
        $length1=strlen($value);//传入参数location的长度

        $length2=0;//匹配到字符的长度
        for ($i=0;$i<sizeof($matches[0]);$i++){
            $length2+=strlen($matches[0][$i]);
        }

        if($length1==$length2){
            return true;
        }else{
            return ['msg'   =>  '参数不能有特殊字符'];
        }
    }

    protected function isPhone($value){
        $really=preg_match_all('/[0-9]/u',$value,$matches);
        $length1=strlen($value);//传入参数location的长度

        $length2=0;//匹配到字符的长度
        for ($i=0;$i<sizeof($matches[0]);$i++){
            $length2+=strlen($matches[0][$i]);
        }

        if($length1==$length2){
            return true;
        }else{
            return ['msg'   =>  '参数不能有特殊字符'];
        }
    }

}