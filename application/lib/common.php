<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/4/24
 * Time: 16:51
 */

function getUrl($url,&$httpCode=0){
    $curl=curl_init();
    //设置请求的URL
    curl_setopt($curl,CURLOPT_URL,$url);
    //获取的信息以文件流的形式返回，而不是直接输出
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
    //不进行SLL验证
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    //延时时间设置
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
    $data=curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);
    return $data;
}

/**
 * 随机生成$length长度的字符串
 * @param $length
 * @return null|string
 */
function getRandString($length){
    $str=null;
    $randChar='123456789zxvbnmasdfghjklqwertyuiopZXCVBNMASDFGHJKLQWERTYUIOP';
    $max=strlen($randChar)-1;
    for($i=0;$i<$length;$i++){
        $str.=$randChar[rand(0,$max)];
    }
    return $str;
}