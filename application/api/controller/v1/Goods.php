<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/4/29
 * Time: 14:50
 */

namespace app\api\controller\v1;


use app\api\validate\AddGoodValidate;
use app\api\validate\GoodsValidate;
use app\api\validate\SearchValidate;
use app\lib\enum\ScopeEnum;
use app\lib\exception\BaseException;
use app\lib\exception\GoodsException;
use app\lib\exception\ScopeException;
use app\lib\exception\TokenException;
use think\Controller;
use think\Exception;
use think\Request;
use app\api\model\Goods as MGoods;
use app\api\service\Token as SToken;
use app\api\service\AddGoods as SAddGoods;


class Goods extends Controller
{
    protected $beforeActionList=[
        'first' =>  ['only' =>  'second,third']
    ];

    public function checkScope(){
        $scope=SToken::readTokenVar('scope');
        if($scope){
            if($scope>=ScopeEnum::User){
                return true;
            }else{
                throw new ScopeException();
            }
        }else{
            throw new TokenException();
        }

    }

    public function second(){

    }
    /**
     * 根据goods_id获取商品的详细信息
     * @url /api/Goods?id=
     * @param Request $request
     * @return \think\response\Json
     * @throws Exception
     * @throws GoodsException
     * @throws \app\lib\exception\BaseException
     */
    public function getGoodsParticulars(Request $request){
        (new GoodsValidate())->gocheck();

        $result=MGoods::getGoodsParticularsById($request->param('id'));
        if(!$result){
            throw new GoodsException();
        }

        return json($result,200);
    }

    /**上传图片后，将数据插入数据库
     * @param Request $request
     * @return \think\response\Json
     * @throws BaseException
     * @throws Exception
     */
    public function addGoods(Request $request){
        (new AddGoodValidate())->gocheck();
        $userId=SToken::getTokenUserId();
        $result=SAddGoods::addGoods($userId);
        return json($result,200);
    }

    /**上传图片数组，返回图片的url
     * @param Request $request
     * @return \think\response\Json
     * @throws BaseException
     */
    public function uploadPicture(Request $request){
        $userId=SToken::getTokenUserId();
        if($userId){
            $file=$request->file('image');
            if($file) {
                $info = $file->validate(['size' => 5242880, 'ext' => 'jpg,png,gif'])
                    ->rule("date")
                    ->move(ROOT_PATH . 'public' . DS . 'images');
                if ($info) {
                    $filePath = $info->getSaveName();
                    return json(['filePath' => $filePath], 200);
                } else {
                    throw new BaseException($info->getError());
                }
            }
        }else{
            throw new BaseException();
        }
        return json(1,200);
    }


    /** api/MyGoods
     * @return \think\response\Json
     * @throws BaseException
     * @throws Exception
     */
    public function queryGoods(){
        $userId=SToken::getTokenUserId();
        $result=MGoods::queryMyGoods($userId);
        if($result){
            return json($result,200);
        }else{
            throw new BaseException();
        }
    }

    /**查询我已发布且下架的商品
     * @return \think\response\Json
     * @throws BaseException
     * @throws Exception
     */
    public function querySoldGoods(){
        $userId=SToken::getTokenUserId();
        $result=MGoods::querySold($userId);
        if($result){
            return json($result,200);
        }else{
            throw new BaseException();
        }
    }

    /**下架商品
     * @param Request $request
     * @return \think\response\Json
     * @throws BaseException
     * @throws Exception
     */
    public function soldGoods(Request $request){
        (new GoodsValidate())->gocheck();
        $userId=SToken::getTokenUserId();
        $id=$request->param('id');
        if($userId){
            $result=MGoods::fackDeleteGoods($id);
            return json($result,200);
        }else{
            throw new BaseException();
        }
    }

    public function searchGoods(Request $request){
        (new SearchValidate())->gocheck();
        $keyWord=$request->param('keyWord');
        $page=$request->param('page');
        $location=$request->param("location");
        if($keyWord){
            $result=MGoods::searchGoods($keyWord,$location,$page);
        }else{
            throw new BaseException();
        }
        return json($result,200);
    }

}