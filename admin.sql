INSERT INTO `admin_users` VALUES (1, 'admin', '$2y$10$1tXB8SJpYTf0Y.u8RWanGOP7Ig7wc6XSVigEUZeO/MH9QWiM1oeBe', 'Administrator', NULL, 'kvHw9EmJ4FGfuSoMdSifklZesggcBTp6Q1SLGe4RfciFn2hGcaOXNQV1T6ul', '2020-04-22 15:46:55', '2020-04-22 15:46:55');

INSERT INTO `admin_roles` VALUES (1, 'Administrator', 'administrator', '2020-04-22 15:46:55', '2020-04-22 15:46:55');

INSERT INTO `admin_role_users` VALUES (1, 1, NULL, NULL);

INSERT INTO `admin_role_menu` VALUES (1, 2, NULL, NULL);

INSERT INTO `admin_role_permissions` VALUES (1, 1, NULL, NULL);

INSERT INTO `admin_menu` VALUES (1, 0, 1, '控制台', 'fa-bar-chart', '/', NULL, NULL, '2020-04-22 15:51:01');
INSERT INTO `admin_menu` VALUES (2, 0, 2, '后台管理', 'fa-tasks', NULL, NULL, NULL, '2020-04-22 15:51:10');
INSERT INTO `admin_menu` VALUES (3, 2, 3, '用户管理', 'fa-users', 'auth/users', NULL, NULL, '2020-04-22 15:51:19');
INSERT INTO `admin_menu` VALUES (4, 2, 4, '角色管理', 'fa-user', 'auth/roles', NULL, NULL, '2020-04-22 15:51:26');
INSERT INTO `admin_menu` VALUES (5, 2, 5, '权限管理', 'fa-ban', 'auth/permissions', NULL, NULL, '2020-04-22 15:51:33');
INSERT INTO `admin_menu` VALUES (6, 2, 6, '菜单管理', 'fa-bars', 'auth/menu', NULL, NULL, '2020-04-22 15:51:40');
INSERT INTO `admin_menu` VALUES (7, 2, 7, '日志管理', 'fa-history', 'auth/logs', NULL, NULL, '2020-04-22 15:51:46');