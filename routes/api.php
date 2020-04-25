<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
/***
 * 目前写了版本，防止有改动，直接更新路由版本 V1/V2 即可
 **/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api\V1',
    'middleware' => ['serializer:array', 'bindings'] // bindings 注入获取对象
], function ($api) {

//    $api->group(['middleware' => ['wechat.oauth']], function ($api) {
//        $api->get('/wechat', function () {
//            $user = session('wechat.oauth_user.default'); // 拿到授权用户资料
//
//            dd($user);
//        });
//    });

    // 关注以后用跳出来的东西
    $api->any('/wechat', 'WeChatController@serve');

    $api->post('/auth','AuthController@store')->name('api.auth.store');
    // 授权登陆 | 前端提交code给我
    $api->get('/auth','AuthController@index')->name('api.auth.index');
    // 退出
    $api->delete('/auth/current', 'AuthController@destroy')->name('api.auth.destroy');
    /**
     * 更多
     **/
    // 我的通知
    $api->get('/mores/notice','MoreController@notice')->name('api.mores.notice');

    // 任务流程
    $api->get('/mores/task_flow','MoreController@taskFlow')->name('api.mores.task_flow');
    // 帮助中心
    $api->get('/mores/help_center','MoreController@helpCenter')->name('api.mores.help_center');
    // 联系客服
    $api->get('/mores/contact_customer_service','MoreController@contactCustomerService')->name('api.mores.contact_customer_service');

    // 邀请同事加入
    $api->get('/teams/{team}/users/{user}','UserController@storeFellow')->name('api.team.storeFellow');

    // 邀请老板加入
    $api->get('/teams/users/{user}','UserController@storeBoss')->name('api.team.storeBoss');

    $api->group(['middleware' => ['auth:api']], function ($api) {


            // 个人信息
        $api->get('/meShow','AuthController@meShow')->name('api.auth.meShow');
        /**
         * 团队
         **/
        // 我的团队
        $api->get('/teams','TeamController@index')->name('api.team.index');
        // 创建团队 要符合某个条件，成员可以创建团队
        $api->post('/teams','TeamController@store')->name('api.team.store');
        // 对于申请的用户进行 允许|拒绝 | 设置管理员|取消管理员|删除团队组员
//        $api->patch('/teams/{team}','TeamController@update')->name('api.team.update');
        // 修改团队成员的权限
        $api->patch('/teams/{team}/users/{user}','TeamController@update')->name('api.team.update');

        /**
         * 首页
         **/
        // 任务列表(首页) 分配给我的
        $api->get('/sub_tasks','SubTaskController@index')->name('api.sub_tasks.index');
        // 查看已完成的(分配给我的)
        $api->get('/sub_tasks/status','SubTaskController@status')->name('api.tasks.status');

        // 查看我创建的任务
        $api->get('/tasks','TaskController@index')->name('api.tasks.index');

        // 创建任务
        $api->post('/tasks','TaskController@store')->name('api.task.store');
        $api->patch('/tasks/{id}','TaskController@update')->name('api.task.update');
        $api->post('/sub_tasks','SubTaskController@store')->name('api.sub_task.store');
        $api->patch('/sub_tasks/{id}','SubTaskController@update')->name('api.sub_task.update');

        // 详情(我创建的任务)
        $api->get('/tasks/{task}','TaskController@show')->name('api.task.show');
        /**
         * 任务流程
         **/
        // 任务流程
        $api->get('/task_flows','TaskFlowController@index')->name('api.task_flow.index');
        // 任务 详情
        $api->get('/task_flows/{id}','TaskFlowController@show')->name('api.task_flow.show');
        // 创建流程 有父任务
        // 必须是有团队了才行
        $api->group(['middleware' => ['team.use']], function ($api) {
            $api->post('/task_flows','TaskFlowController@store')->name('api.task_flow.store');
        });
        $api->patch('/task_flows/{status}','TaskFlowController@updateStatus')->name('api.task_flow.updateStatus');
        // 任务流程列表
        $api->get('/task_flow_collections','TaskFlowCollectionController@index')->name('api.task_flow_collections.index');
        // 查看
        $api->get('/task_flow_collections/{id}','TaskFlowCollectionController@show')->name('api.task_flow_collections.show');
        // 编辑
        $api->patch('/task_flow_collections/{task_flow_collection_id}/task_flows/{task_flow_id}','TaskFlowController@update')->name('api.task_flow_collections.update');


        // 评论
        $api->get('/discusses','DiscussController@index')->name('api.discuss.index');
        $api->post('/discusses','DiscussController@store')->name('api.discuss.store');
    });
    /**
     * 任务详情下的评论
     **/
    // 我的团队
    $api->get('/discuss','DiscussController@index')->name('api.discuss.index');

    // 回复评论
    $api->post('/discuss','DiscussController@store')->name('api.discuss.store');
});