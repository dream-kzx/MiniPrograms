<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/18
 * Time: 22:33
 */

namespace app\api\controller\v1;


use app\api\model\CollectGoods as ModelCollectGoods;
use app\api\service\Token;
use app\api\validate\GoodsValidate;
use app\lib\exception\BaseException;
use think\Request;

class CollectGoods
{
    /** /api/collectGoods 根据id(goods_id)和用户user_id加入收藏
     * @param Request $request
     * @return \think\response\Json
     * @throws BaseException
     * @throws \think\Exception
     */
    public function collectGoods(Request $request){
        (new GoodsValidate())->gocheck();
        $userId=Token::getTokenUserId();
        if($userId){
            $id=$request->param('id');
            $result=ModelCollectGoods::addCollect($id,$userId);
            return json($result,200);
        }else{
            throw new BaseException();
        }
    }

    /** /api/myCollectGoods 根据用户user_id查询我的收藏商品
     * @return \think\response\Json
     * @throws BaseException
     * @throws \think\Exception
     */
    public function myCollectGoods(){
        $userId=Token::getTokenUserId();
        $result=ModelCollectGoods::queryCollect($userId);
        if($result){
            return json($result,200);
        }else{
            throw new BaseException();
        }
    }

    /** /api/removeCollectGoods 根据id(goods_id) 和user_id取消收藏
     * @param Request $request
     * @return \think\response\Json
     * @throws BaseException
     * @throws \think\Exception
     */
    public function removeCollectGoods(Request $request){
        $userId=Token::getTokenUserId();
        $goods_id=$request->param('id');
        $result=ModelCollectGoods::removeCollect($userId,$goods_id);
        if($result){
            return json($result,200);
        }else{
            throw new BaseException();
        }

    }
}