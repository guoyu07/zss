
<?php
return [
    'adminEmail' => 'admin@example.com',
    'rbac' => [
        'user_auth_on'              =>  true,
        'user_auth_type'			=>  2,	// 默认认证类型 1 登录认证 2 实时认证
        'admin_auth_key'			=>  'admin',
        'not_auth_controller'       =>  [''],	// 默认无需认证模块
        'rbac_role_table'           =>  'zss_auth_role',
        'rbac_user_table'           =>  'zss_auth_admin_role',
        'rbac_access_table'         =>  'zss_auth_role_node',
        'rbac_node_table'           =>  'zss_auth_node',
		'rbac_temp_table'           =>  'zss_auth_node_temp',
    ],
];
