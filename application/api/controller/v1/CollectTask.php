<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/18
 * Time: 22:33
 */

namespace app\api\controller\v1;
use app\api\model\CollectTask as ModelCollectTask;
use think\Request;
use app\api\validate\GoodsValidate;
use app\api\service\Token;
use app\lib\exception\BaseException;

class CollectTask
{
    /** /api/collectTask 根据id(task_id)和用户user_id加入收藏
     * @param Request $request
     * @return \think\response\Json
     * @throws BaseException
     * @throws \think\Exception
     */
    public function collectTask(Request $request){
        (new GoodsValidate())->gocheck();
        $userId=Token::getTokenUserId();
        if($userId){
            $id=$request->param('id');
            $result=ModelCollectTask::addCollect($id,$userId);
            return json($result,200);
        }else{
            throw new BaseException();
        }
    }

    /** /api/myCollectTask 根据用户user_id查询我的收藏任务
     * @return \think\response\Json
     * @throws BaseException
     * @throws \think\Exception
     */
    public function myCollectTask(){
        $userId=Token::getTokenUserId();
        $result=ModelCollectTask::queryCollect($userId);
        if($result){
            return json($result,200);
        }else{
            throw new BaseException();
        }
    }

    /** /api/removeCollectGoods 根据id(task_is) 和user_id取消收藏
     * @param Request $request
     * @return \think\response\Json
     * @throws BaseException
     * @throws \think\Exception
     */
    public function removeCollectTask(Request $request){
        $userId=Token::getTokenUserId();
        $task_id=$request->param('id');
        $result=ModelCollectTask::removeCollect($userId,$task_id);
        if($result){
            return json($result,200);
        }else{
            throw new BaseException();
        }

    }
}