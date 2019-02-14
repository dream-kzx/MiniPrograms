<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/5/6
 * Time: 14:42
 */

namespace app\api\controller\v1;


use app\api\model\TaskLocation;
use app\api\service\AddTask;
use app\api\validate\AddTaskValidate;
use app\api\validate\GoodsValidate;
use app\api\validate\LocationValidate;
use app\api\validate\SearchValidate;
use app\api\validate\TaskLocationValidate;
use app\lib\exception\BaseException;
use think\Model;
use think\Request;
use app\api\model\Task as ModelTask;
use app\api\service\Token as SToken;
use traits\model\SoftDelete;

class Task
{

    /**根据用户的位置，获取任务列表
     * @url api/Task?location=
     * @param Request $request
     * @return \think\response\Json
     * @throws BaseException
     * @throws \think\Exception
     */
    public function getTask(Request $request){
        (new TaskLocationValidate())->gocheck();
        $location=$request->param('location');
        $page=$request->param('page');
        $result=TaskLocation::getIdByLocation($location,$page);

        if(!$result){
            throw new BaseException();
        }else{
            return json($result,200);
        }
    }

    /**根据任务id获取任务详情
     * @url api/TaskParticulars?id=
     * @param Request $request
     * @return \think\response\Json
     * @throws BaseException
     * @throws \think\Exception
     */
    public function getTaskParticulars(Request $request){
        (new GoodsValidate())->gocheck();
        $result=ModelTask::taskParticulars($request->param('id'));

        if(!$result){
            throw new BaseException();
        }else{
            return json($result,200);
        }
    }

    /** /api/AddTask发布任务
     * @param Request $request
     * @return \think\response\Json
     * @throws BaseException
     * @throws \think\Exception
     */
    public function addTask(Request $request){
        (new AddTaskValidate())->gocheck();
        $userId=SToken::getTokenUserId();
        if($userId){
            $result=AddTask::addTask($userId);
        }else{
            throw new BaseException();
        }
        return json($result,200);
    }

    public function addTask2(Request $request){
        (new AddTaskValidate())->gocheck();
        $userId=SToken::getTokenUserId();
        if($userId){
            $result=AddTask::addTask2($userId);
        }else{
            throw new BaseException();
        }
        return json($result,200);
    }


    /** /api/MyTask
     * @return \think\response\Json
     * @throws BaseException
     * @throws \think\Exception
     */
    public function queryTask(){
        $userId=SToken::getTokenUserId();
        $result=ModelTask::queryMyTask($userId);
        if($result){
            return json($result,200);
        }else{
            throw new BaseException();
        }
    }

    /** 查询我已发现且下架的商品
     * @return \think\response\Json
     * @throws BaseException
     * @throws \think\Exception
     */
    public function querySoldTask(){
        $userId=SToken::getTokenUserId();
        $result=ModelTask::querySoldTask($userId);
        if($result){
            return json($result,200);
        }else{
            throw new BaseException();
        }
    }

    /** soldTask 下架任务
     * @param Request $request
     * @return \think\response\Json
     * @throws BaseException
     * @throws \think\Exception
     */
    public function soldTask(Request $request){
        (new GoodsValidate())->gocheck();
        $id=$request->param('id');
        $userId=SToken::getTokenUserId();
        if($userId){
            $result=ModelTask::fackDeleteTask($id);
            return json($result,200);
        }else{
            throw new BaseException();
        }
    }

    public function searchTask(Request $request){
        (new SearchValidate())->gocheck();
        $keyWord=$request->param('keyWord');
        $page=$request->param('page');
        $location=$request->param("location");

        if($keyWord){
            $result=ModelTask::searchTask($keyWord,$location,$page);
        }else{
            throw new BaseException();
        }
        return json($result,200);
    }
}