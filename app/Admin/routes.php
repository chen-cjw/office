<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index')->name('admin.home'); //  控制台
    $router->resource('users', 'UserController'); // 用户
    $router->resource('contact_customer_services', 'ContactCustomerServiceController'); // 联系客服
    $router->resource('help_centers', 'HelpCenterController'); // 帮助我们
    $router->resource('discusses', 'DiscussController'); // 评论
    $router->resource('notices', 'NoticeController'); // 通知中心
    $router->resource('send_invite_sets', 'SendInviteSetController'); // 设置(邀请同事/老板)
    $router->resource('sub_tasks', 'SubtaskController'); // 子任务
    $router->resource('tasks', 'TaskController'); // 任务
    $router->resource('task_flow_collections', 'TaskFlowCollectionController'); // 任务流程集合
    $router->resource('task_flows', 'TaskFlowController'); // 任务流程
    $router->resource('task_logs', 'TaskLogController'); // 操作任务的日志
    $router->resource('teams', 'TeamController'); // 团队
    $router->resource('team_members', 'TeamMemberController'); // 团队成员
});
