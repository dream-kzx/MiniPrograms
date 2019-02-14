<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/4
 * Time: 21:23
 */

namespace app\api\controller\v1;


use app\api\validate\LocationValidate;
use app\lib\exception\BaseException;
use think\Request;
use \app\api\model\TypeLocation;

class NewGoods
{
    /**
     * 根据所在位置获取最新商品的信息
     * @url /api/NewGoods?location=
     * @param Request $request
     * @return \think\response\Json
     * @throws BaseException
     * @throws \think\Exception
     */
    public function getNewGoods(Request $request){
        (new LocationValidate())->gocheck();
            $result=TypeLocation::getNewGoods($request->param('location'));
        if(!$result){
            throw new BaseException();
        }
        return json($result,200);
    }
}