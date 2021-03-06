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
    // 关注以后用跳出来的东西
    $api->any('/wechat', 'WeChatCSubstituteBindingsontroller@serve');

    // 获取openid
    $api->post('/auth/ml_openid_store','AuthController@mlOpenidStore')->name('api.auth.mlOpenidStore');
    // 获取手机号
    $api->post('/auth/phone_store','AuthController@phoneStore')->name('api.auth.phone_store');

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
//    $api->get('/teams/{team}/users/{user}','UserController@storeFellow')->name('api.team.storeFellow');

    // 邀请老板加入
//    $api->get('/teams/users/{user}','UserController@storeBoss')->name('api.team.storeBoss');
    // 用户处于某种状态的时候才可以有以下的操作,必须有号码才可以操作
    $api->group(['middleware' => ['auth:api','user.status','user.authorization']], function ($api) {

        // 个人信息
        $api->get('/meShow','AuthController@meShow')->name('api.auth.meShow');
        /**
         * 团队
         **/
        // 我的团队
        $api->get('/teams','TeamController@index')->name('api.team.index');
        // 搜索团队成员，模糊搜索
        $api->get('/team_users/{username}','TeamController@search')->name('api.team.search');

        // 创建团队 要符合某个条件，成员可以创建团队
        $api->post('/teams','TeamController@store')->name('api.team.store');
        // 对于申请的用户进行 允许|拒绝 | 设置管理员|取消管理员|删除团队组员
        $api->patch('/teams/{team}','TeamController@update')->name('api.team.update');
        // 修改团队成员的权限
        $api->put('/teams/{team}/users/{user}','AuthController@update')->name('api.auth.update');

        /**
         * 首页
         **/
        // 任务列表(首页) 分配给我的
        $api->get('/sub_tasks','SubTaskController@index')->name('api.sub_tasks.index');

        // 查看我创建的任务
        $api->get('/tasks','TaskController@index')->name('api.tasks.index');

        // 创建任务
//        $api->post('/tasks','TaskController@store')->name('api.task.store');
//        $api->patch('/tasks/{id}','TaskController@update')->name('api.task.update');
        $api->post('/sub_tasks','SubTaskController@store')->name('api.sub_task.store');
        $api->put('/sub_tasks/{id}','TaskController@update')->name('api.sub_task.update');

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
            $api->post('/tasks','TaskController@store')->name('api.task.store');
            $api->post('/upload_images','UploadImageController@store')->name('api.task.store');
            // UploadImageController
            $api->post('/task_flows','TaskFlowController@store')->name('api.task_flow.store');
        });
//        $api->group(['middleware' => ['welfare']], function ($api) {
            $api->put('/tasks/{id}','TaskController@update')->name('api.task.update');
//        });

        $api->put('/task_flows/{status}','TaskFlowController@updateStatus')->name('api.task_flow.updateStatus');
        // 任务流程列表
        $api->get('/task_flow_collections','TaskFlowCollectionController@index')->name('api.task_flow_collections.index');
        // 查看
        $api->get('/task_flow_collections/{id}','TaskFlowCollectionController@show')->name('api.task_flow_collections.show');
        // 编辑
        $api->put('/task_flow_collections/{task_flow_collection_id}/task_flows/{task_flow_id}','TaskFlowController@update')->name('api.task_flow_collections.update');


        // 评论
        $api->get('/discusses','DiscussController@index')->name('api.discuss.index');
        $api->post('/discusses','DiscussController@store')->name('api.discuss.store');

        //  支付提交订单
        $api->post('/wechat_pay','WechatPayController@storeAdd')->name('api.wechat_pay.storeAdd');
        $api->post('/payByWechat/{id}','WechatPayController@payByWechat')->name('api.wechat_pay.payByWechat');


    });
    $api->any('/handle_paid_notifies','WechatPayController@handlePaidNotify')->name('api.wechat_pay.handle_paid_notifies');
    // 帮助中心
    $api->get('/help_centers','HelpCenterController@index')->name('api.help_centers.index');
    $api->get('/help_centers/{id}','HelpCenterController@show')->name('api.help_centers.show');
    // 联系客服
    $api->get('/contact_customer_service','ContactCustomerServiceController@index')->name('api.contact_customer_service.index');
    $api->get('/contact_customer_service/{id}','ContactCustomerServiceController@show')->name('api.contact_customer_service.show');
    /**
     * 模板
     **/
    $api->get('/templates','TemplateController@index')->name('api.templates.index');

    // 我的团队
//    $api->get('/discuss','DiscussController@index')->name('api.discuss.index');

    // 回复评论
//    $api->post('/discuss','DiscussController@store')->name('api.discuss.store');
});