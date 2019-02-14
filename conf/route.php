<?php
/**
 * Created by PhpStorm.
 * User: LookUpMan
 * Date: 2018/4/21
 * Time: 22:25
 */

use think\Route;

Route::post('test','push/Test/testMessage');

//根据location获取banner信息
Route::get('api/Banner','api/v1.Banner/getBanner');
//根据goods_id，获取goods详情
Route::get('api/Goods','api/v1.Goods/getGoodsParticulars');
//根据分类和位置获取商品列表
Route::get("api/TypeLocation",'api/v1.TypeLocation/getGoodsDescribe');
//获取最新的商品信息
Route::get("api/NewGoods",'api/v1.NewGoods/getNewGoods');
//用户登录
Route::post('api/Token/User','api/v1.Token/getToken');
//根据location获取位置列表
Route::get('api/Task','api/v1.Task/getTask');
//根据task_id获取任务详情
Route::get('api/TaskParticulars','api/v1.Task/getTaskParticulars');

Route::post('api/Address','api/v1.Address/createUpdateAddress');
Route::get("api/getAddress",'api/v1.Address/getAddress');
//发布商品
Route::post('api/AddGoods','api/v1.Goods/addGoods');
//上传图片列表
Route::post('api/uploadPicture','api/v1.Goods/uploadPicture');
//发布任务
Route::post('api/AddTask','api/v1.Task/addTask');
Route::post('api/AddTask2','api/v1.Task/addTask2');

//查询我发布的商品
Route::post('api/MyGoods','api/v1.Goods/queryGoods');
//查询我发布的已下架的商品
Route::post('api/querySoldGoods','api/v1.Goods/querySoldGoods');
//查询我发布的已下架的商品
Route::post('api/querySoldTask','api/v1.Task/querySoldTask');
//查询我发布的任务
Route::post('api/MyTask','api/v1.Task/queryTask');
//下架商品
Route::post('api/soldGoods','api/v1.Goods/soldGoods');
//下架任务
Route::post('api/soldTask','api/v1.Task/soldTask');
//收藏商品
Route::post('api/collectGoods','api/v1.CollectGoods/collectGoods');
//查询我收藏的商品
Route::post('api/myCollectGoods','api/v1.CollectGoods/myCollectGoods');
//删除我收藏的商品
Route::post('api/removeCollectGoods','api/v1.CollectGoods/removeCollectGoods');
//收藏任务
Route::post('api/collectTask','api/v1.CollectTask/collectTask');
//查询我收藏的任务
Route::post('api/myCollectTask','api/v1.CollectTask/myCollectTask');
//删除我收藏的任务
Route::post('api/removeCollectTask','api/v1.CollectTask/removeCollectTask');
//登录时增加用户信息
Route::post('api/addUser','api/v1.User/addUserMessage');
//加载聊天的列表
Route::post('api/getContacts','push/SendMessage/getContacts');
//加载聊天的详情
Route::post('api/getHistoryMessage','push/SendMessage/getHistoryMessage');

//验证token是否有效
Route::post('api/verifyToken','api/v1.Token/verifyToken');

//获取用户的信息
Route::post('api/getUserMessage','api/v1.User/getUserMessage');

//根据别人userId获取用户的信息
Route::post('api/getHisUserMessage','api/v1.User/getHisMessage');


Route::get('api/searchGoods','api/v1.Goods/searchGoods');

Route::get('api/searchTask','api/v1.Task/searchTask');

//获取用户的号码
Route::post('api/getUserPhone','api/v1.User/getUserPhone');

//设置用户的号码
Route::post('api/setUserPhone','api/v1.User/setUserPhone');








return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
    'news' =>   "api/index/index"
];