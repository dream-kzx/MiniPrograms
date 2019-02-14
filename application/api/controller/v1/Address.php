<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/6
 * Time: 19:22
 */

namespace app\api\controller\v1;

use app\api\model\User;
use app\api\service\Token as SToken;
use app\lib\exception\BaseException;
use think\Request;

class Address
{
    /**@url /api/address
     * @method=Post token=
     * @return null|static
     * @throws BaseException
     * @throws \think\exception\DbException
     */
    public function createUpdateAddress(){
        //根据token获取用户的userId
        //根据userId查找用户数据，判断用户是否存在，如果不存在则抛出异常
        //获取用户从客户端传递来的数据se
        $userId=SToken::getTokenUserId();
        $user=User::get($userId);
        if(!$user){
            throw new BaseException();
        }
        return json($user,200);
    }

    public function getAddress(Request $request){

        $lat=$request->param('latitude');
        $lng=$request->param('longitude');
        $schoolUrl="http://api.map.baidu.com/place/v2/search?query=大学&tag=学院,校区&location=".
            $lat.",".$lng."&output=json&ak=NAXC3UwXHuhmTLHt8Qis2TMk1bk3kgnp&page_size=5";
//        $addressUrl="http://api.map.baidu.com/geocoder/v2/?callback=renderReverse&location=".
//            $lat.",".$lng."&output=json&pois=1&radius=1000&ak=NAXC3UwXHuhmTLHt8Qis2TMk1bk3kgnp";
//        $daxueUrl="http://api.map.baidu.com/place/v2/search?query=广西财经学院&region=广西&output=json&ak=NAXC3UwXHuhmTLHt8Qis2TMk1bk3kgnp";
        if($lat&&$lng){
            $result=getUrl($schoolUrl);
            $result=json_decode($result);
        }else{
            $result=null;
        }

        return json($result,200);
    }

}