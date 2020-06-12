<?php

use Illuminate\Database\Seeder;

class AdminTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // base tables
        Encore\Admin\Auth\Database\Menu::truncate();
        Encore\Admin\Auth\Database\Menu::insert(
            [
                [
                    "parent_id" => 0,
                    "order" => 1,
                    "title" => "控制台",
                    "icon" => "fa-bar-chart",
                    "uri" => "/",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 0,
                    "order" => 2,
                    "title" => "系统管理",
                    "icon" => "fa-tasks",
                    "uri" => NULL,
                    "permission" => NULL
                ],
                [
                    "parent_id" => 2,
                    "order" => 3,
                    "title" => "用户管理",
                    "icon" => "fa-users",
                    "uri" => "auth/users",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 2,
                    "order" => 4,
                    "title" => "角色管理",
                    "icon" => "fa-user",
                    "uri" => "auth/roles",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 2,
                    "order" => 5,
                    "title" => "权限管理",
                    "icon" => "fa-ban",
                    "uri" => "auth/permissions",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 2,
                    "order" => 6,
                    "title" => "菜单管理",
                    "icon" => "fa-bars",
                    "uri" => "auth/menu",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 2,
                    "order" => 7,
                    "title" => "操作日志",
                    "icon" => "fa-history",
                    "uri" => "auth/logs",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 0,
                    "order" => 15,
                    "title" => "用户成员",
                    "icon" => "fa-tasks",
                    "uri" => "/users",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 0,
                    "order" => 19,
                    "title" => "联系客服",
                    "icon" => "fa-qq",
                    "uri" => "/contact_customer_services",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 0,
                    "order" => 20,
                    "title" => "帮助我们",
                    "icon" => "fa-american-sign-language-interpreting",
                    "uri" => "/help_centers",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 0,
                    "order" => 21,
                    "title" => "评论管理",
                    "icon" => "fa-bars",
                    "uri" => "/discusses",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 0,
                    "order" => 22,
                    "title" => "通知中心",
                    "icon" => "fa-bars",
                    "uri" => "notices",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 2,
                    "order" => 8,
                    "title" => "设置(邀请同事/老板)",
                    "icon" => "fa-bars",
                    "uri" => "send_invite_sets",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 22,
                    "order" => 11,
                    "title" => "子任务",
                    "icon" => "fa-bars",
                    "uri" => "sub_tasks",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 22,
                    "order" => 10,
                    "title" => "任务管理",
                    "icon" => "fa-bars",
                    "uri" => "tasks",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 22,
                    "order" => 12,
                    "title" => "任务流程集合",
                    "icon" => "fa-bars",
                    "uri" => "task_flow_collections",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 22,
                    "order" => 13,
                    "title" => "任务流程",
                    "icon" => "fa-bars",
                    "uri" => "task_flows",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 22,
                    "order" => 14,
                    "title" => "任务日志",
                    "icon" => "fa-bars",
                    "uri" => "task_logs",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 8,
                    "order" => 17,
                    "title" => "团队管理",
                    "icon" => "fa-bars",
                    "uri" => "teams",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 8,
                    "order" => 18,
                    "title" => "团队成员",
                    "icon" => "fa-bars",
                    "uri" => "team_members",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 8,
                    "order" => 16,
                    "title" => "用户管理",
                    "icon" => "fa-bars",
                    "uri" => NULL,
                    "permission" => NULL
                ],
                [
                    "parent_id" => 0,
                    "order" => 9,
                    "title" => "任务管理",
                    "icon" => "fa-tasks",
                    "uri" => NULL,
                    "permission" => NULL
                ]
            ]
        );

        Encore\Admin\Auth\Database\Permission::truncate();
        Encore\Admin\Auth\Database\Permission::insert(
            [
                [
                    "name" => "All permission",
                    "slug" => "*",
                    "http_method" => "",
                    "http_path" => "*"
                ],
                [
                    "name" => "Dashboard",
                    "slug" => "dashboard",
                    "http_method" => "GET",
                    "http_path" => "/"
                ],
                [
                    "name" => "Login",
                    "slug" => "auth.login",
                    "http_method" => "",
                    "http_path" => "/auth/login\r\n/auth/logout"
                ],
                [
                    "name" => "User setting",
                    "slug" => "auth.setting",
                    "http_method" => "GET,PUT",
                    "http_path" => "/auth/setting"
                ],
                [
                    "name" => "Auth management",
                    "slug" => "auth.management",
                    "http_method" => "",
                    "http_path" => "/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs"
                ]
            ]
        );

        Encore\Admin\Auth\Database\Role::truncate();
        Encore\Admin\Auth\Database\Role::insert(
            [
                [
                    "name" => "Administrator",
                    "slug" => "administrator"
                ]
            ]
        );

        // pivot tables
        DB::table('admin_role_menu')->truncate();
        DB::table('admin_role_menu')->insert(
            [
                [
                    "role_id" => 1,
                    "menu_id" => 2
                ]
            ]
        );

        DB::table('admin_role_permissions')->truncate();
        DB::table('admin_role_permissions')->insert(
            [
                [
                    "role_id" => 1,
                    "permission_id" => 1
                ]
            ]
        );

        // finish
    }
}
