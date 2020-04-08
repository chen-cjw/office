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
    'middleware' => ['serializer:array']
], function ($api) {
    // 授权登陆 | 前端提交code给我
    $api->get('/auth','AuthController@index')->name('api.auth.index');

    // 个人信息
    $api->get('/meShow','AuthController@meShow')->name('api.auth.meShow');

    // 退出
    $api->delete('/auth/current', 'AuthController@destroy')->name('api.auth.destroy');

    /**
     * 首页
     **/
    // 任务列表(首页)
    $api->get('/tasks','TaskController@index')->name('api.task.index');
    // 创建任务
    $api->post('/tasks','TaskController@store')->name('api.task.store');
    // 详情
    $api->get('/tasks/{id}','TaskController@show')->name('api.task.show');

    /**
     * 更多
     **/
    // 我的通知
    $api->get('/mores/notice','MoreController@notice')->name('api.mores.notice');
    // 邀请同事加入 给他一个二维码，别人可以扫描
    $api->get('/mores/inviting_colleague','MoreController@invitingColleague')->name('api.mores.inviting_colleague');
    // 邀请老板加入
    $api->get('/mores/inviting_boss','MoreController@invitingBoss')->name('api.mores.inviting_boss');
    // 任务流程
    $api->get('/mores/task_flow','MoreController@taskFlow')->name('api.mores.task_flow');
    // 帮助中心
    $api->get('/mores/help_center','MoreController@helpCenter')->name('api.mores.help_center');
    // 联系客服
    $api->get('/mores/contact_customer_service','MoreController@contactCustomerService')->name('api.mores.contact_customer_service');


    // TeamController
    /**
     * 团队
     **/
    // 我的团队
    $api->get('/teams','TeamController@index')->name('api.team.index');
    // 创建团队 要符合某个条件，成员可以创建团队
    $api->post('/teams','TeamController@store')->name('api.team.store');
    // 对于申请的用户进行 允许|拒绝 | 设置管理员|取消管理员|删除团队组员
    $api->patch('/teams/{id}','TeamController@update')->name('api.team.update');

    /**
     * 任务详情下的评论
     **/
    // 我的团队
    $api->get('/discuss','DiscussController@index')->name('api.discuss.index');

    // 回复评论
    $api->post('/discuss','DiscussController@store')->name('api.discuss.store');


    /**
     * 任务流程
     **/
    // 任务流程
    $api->get('/task_flow','TaskFlowController@index')->name('api.task_flow.index');
    // 任务 详情
    $api->get('/task_flow/{id}','TaskFlowController@show')->name('api.task_flow.show');
    // 创建子任务 有父任务(任务已经建好，只是做的分发)
    $api->post('/task_flow','TaskFlowController@store')->name('api.task_flow.store');

});