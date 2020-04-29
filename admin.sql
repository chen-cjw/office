
INSERT INTO `admin_menu` VALUES (1, 0, 1, '控制台', 'fa-bar-chart', '/', NULL, NULL, '2020-04-28 13:36:10');
INSERT INTO `admin_menu` VALUES (2, 0, 2, '系统管理', 'fa-tasks', NULL, NULL, NULL, '2020-04-28 13:36:10');
INSERT INTO `admin_menu` VALUES (3, 2, 3, '用户管理', 'fa-users', 'auth/users', NULL, NULL, '2020-04-28 13:36:10');
INSERT INTO `admin_menu` VALUES (4, 2, 4, '角色管理', 'fa-user', 'auth/roles', NULL, NULL, '2020-04-28 13:36:10');
INSERT INTO `admin_menu` VALUES (5, 2, 5, '权限管理', 'fa-ban', 'auth/permissions', NULL, NULL, '2020-04-28 13:36:10');
INSERT INTO `admin_menu` VALUES (6, 2, 6, '菜单管理', 'fa-bars', 'auth/menu', NULL, NULL, '2020-04-28 13:36:10');
INSERT INTO `admin_menu` VALUES (7, 2, 7, '操作日志', 'fa-history', 'auth/logs', NULL, NULL, '2020-04-28 13:36:10');
INSERT INTO `admin_menu` VALUES (8, 0, 15, '用户成员', 'fa-tasks', '/users', NULL, '2020-04-28 12:37:33', '2020-04-28 15:50:45');
INSERT INTO `admin_menu` VALUES (9, 0, 19, '联系客服', 'fa-qq', '/contact_customer_services', NULL, '2020-04-28 12:37:44', '2020-04-28 15:51:39');
INSERT INTO `admin_menu` VALUES (10, 0, 20, '帮助我们', 'fa-american-sign-language-interpreting', '/help_centers', NULL, '2020-04-28 12:37:56', '2020-04-28 15:52:05');
INSERT INTO `admin_menu` VALUES (11, 0, 21, '评论管理', 'fa-bars', '/discusses', NULL, '2020-04-28 12:38:13', '2020-04-28 13:36:10');
INSERT INTO `admin_menu` VALUES (12, 0, 22, '通知中心', 'fa-bars', 'notices', NULL, '2020-04-28 12:38:21', '2020-04-28 13:36:10');
INSERT INTO `admin_menu` VALUES (13, 2, 8, '设置(邀请同事/老板)', 'fa-bars', 'send_invite_sets', NULL, '2020-04-28 12:38:53', '2020-04-28 13:36:10');
INSERT INTO `admin_menu` VALUES (14, 22, 11, '子任务', 'fa-bars', 'sub_tasks', NULL, '2020-04-28 12:39:09', '2020-04-28 13:36:10');
INSERT INTO `admin_menu` VALUES (15, 22, 10, '任务管理', 'fa-bars', 'tasks', NULL, '2020-04-28 12:39:25', '2020-04-28 13:36:10');
INSERT INTO `admin_menu` VALUES (16, 22, 12, '任务流程集合', 'fa-bars', 'task_flow_collections', NULL, '2020-04-28 12:39:34', '2020-04-28 13:36:10');
INSERT INTO `admin_menu` VALUES (17, 22, 13, '任务流程', 'fa-bars', 'task_flows', NULL, '2020-04-28 12:39:42', '2020-04-28 13:36:10');
INSERT INTO `admin_menu` VALUES (18, 22, 14, '任务日志', 'fa-bars', 'task_logs', NULL, '2020-04-28 12:40:06', '2020-04-28 13:36:10');
INSERT INTO `admin_menu` VALUES (19, 8, 17, '团队管理', 'fa-bars', 'teams', NULL, '2020-04-28 12:40:55', '2020-04-28 13:36:10');
INSERT INTO `admin_menu` VALUES (20, 8, 18, '团队成员', 'fa-bars', 'team_members', NULL, '2020-04-28 12:41:03', '2020-04-28 13:36:10');
INSERT INTO `admin_menu` VALUES (21, 8, 16, '用户管理', 'fa-bars', NULL, NULL, '2020-04-28 13:32:28', '2020-04-28 13:36:10');
INSERT INTO `admin_menu` VALUES (22, 0, 9, '任务管理', 'fa-tasks', NULL, NULL, '2020-04-28 13:34:03', '2020-04-28 15:50:37');


INSERT INTO `admin_role_permissions` VALUES (1, 1, NULL, NULL);

INSERT INTO `admin_role_users` VALUES (1, 1, NULL, NULL);

INSERT INTO `admin_roles` VALUES (1, 'Administrator', 'administrator', '2020-02-17 08:09:45', '2020-02-17 08:09:45');

INSERT INTO `admin_role_menu` VALUES (1, 2, NULL, NULL);

INSERT INTO `admin_permissions` VALUES (1, 'All permission', '*', '', '*', NULL, NULL);
INSERT INTO `admin_permissions` VALUES (2, 'Dashboard', 'dashboard', 'GET', '/', NULL, NULL);
INSERT INTO `admin_permissions` VALUES (3, 'Login', 'auth.login', '', '/auth/login\r\n/auth/logout', NULL, NULL);
INSERT INTO `admin_permissions` VALUES (4, 'User setting', 'auth.setting', 'GET,PUT', '/auth/setting', NULL, NULL);
INSERT INTO `admin_permissions` VALUES (5, 'Auth management', 'auth.management', '', '/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs', NULL, NULL);


INSERT INTO `admin_users` VALUES (1, 'admin', '$2y$10$LvgJIMvMe7.PDXZxffC8CeBY7kEs6JhZ4QDm.efXbzk2SUxjRTCoS', 'Administrator', NULL, 'Y71Rj5UBbSSpvTeTGPGwnlqafBr8WxUgaoiXYpNFGKtrIf0Nc8FVK78NYBK7', '2020-02-17 08:09:45', '2020-02-17 08:09:45');
