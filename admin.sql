
INSERT INTO `admin_menu` VALUES (1, 0, 1, '控制台', 'fa-bar-chart', '/', NULL, NULL, '2020-02-17 11:52:14');
INSERT INTO `admin_menu` VALUES (2, 0, 2, '系统管理', 'fa-tasks', NULL, NULL, NULL, '2020-02-17 11:52:34');
INSERT INTO `admin_menu` VALUES (3, 2, 3, '用户管理', 'fa-users', 'auth/users', NULL, NULL, '2020-02-17 11:52:44');
INSERT INTO `admin_menu` VALUES (4, 2, 4, '角色管理', 'fa-user', 'auth/roles', NULL, NULL, '2020-02-17 11:52:52');
INSERT INTO `admin_menu` VALUES (5, 2, 5, '权限管理', 'fa-ban', 'auth/permissions', NULL, NULL, '2020-02-17 11:53:07');
INSERT INTO `admin_menu` VALUES (6, 2, 6, '菜单管理', 'fa-bars', 'auth/menu', NULL, NULL, '2020-02-17 11:53:29');
INSERT INTO `admin_menu` VALUES (7, 2, 7, '操作日志', 'fa-history', 'auth/logs', NULL, NULL, '2020-02-17 11:53:40');

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
