<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/2
 * Time: 19:28
 */

namespace app\api\controller\v1;


use app\api\validate\TypeValidate;
use app\lib\exception\TypeException;
use think\Request;
use app\api\model\TypeLocation as MType;
class TypeLocation
{
    /**
     * 根据商品分类获取商品列表
     * @url /api/TypeLocation?type= &location=
     * @param Request $request
     * @return \think\response\Json
     * @throws TypeException
     * @throws \app\lib\exception\BaseException
     * @throws \think\Exception
     */
    public function getGoodsDescribe(Request $request){
        (new TypeValidate())->gocheck();
        $type=$request->param('type');
        $location=$request->param("location");
        $page=$request->param('page');

        $result=MType::getGoodsByType($type,$location,$page);
        if(!$result){
            throw new TypeException();
        }

        return json($result,200);
    }
}