<?php
/**
 * menu
 */
class config_menu
{
    public static $filterRoute = array(
        'allow' => array(
            'admin.login',
            'admin.main',
            'admin.forgetPassword',
        ),
        'deny' => array(
            
        )
    );

    public static $aMenu = [
        'index'=>[
            'name'   => '首页',
            'href'   => '?act=index.main',
            'route'  => 'index.*',
            'icon'   => 'icon icon-home',
        ],
        'user'=>[
            'name'     => '师生管理',
            'href'     => '#',
            'route'    => 'user.*',
            'icon'     => 'icon icon-cog',
            'children' => [
                'user.teacher_add'=>[
                    'name'    => '导入/修改老师',
                    'href'    => '?act=user.teacher_add',
                    'display' => 1
                ],
                'user.teacher_list'=>[
                    'name'    => '老师列表',
                    'href'    => '?act=user.teacher_list',
                    'display' => 1
                ],
            ],
        ],
        'school'=>[
            'name'     => '学校管理',
            'href'     => '#',
            'route'    => 'school.*',
            'icon'     => 'icon icon-sitemap',
            'children' => [
                'school.school_add'=>[
                    'name'    => '添加/修改学校',
                    'href'    => '?act=school.school_add',
                    'display' => 1
                ],
                'school.school_list'=>[
                    'name'    => '学校列表',
                    'href'    => '?act=school.school_list',
                    'display' => 1
                ],
            ],
        ],
        'admin'=>[
            'name'     => '管理员管理',
            'href'     => '#',
            'route'    => 'admin.*',
            'icon'     => 'icon icon-user',
            'children' => [
                'admin.addAccount'=>[
                    'name'    => '添加管理员',
                    'href'    => '?act=admin.addAccount',
                    'display' => 1
                ],
                'admin.admin_list'=>[
                    'name'    => '管理员列表',
                    'href'    => '?act=admin.admin_list',
                    'display' => 1
                ],
                'admin.role_add'=>[
                    'name'    => '添加/修改角色',
                    'href'    => '?act=admin.role_add',
                    'display' => 1
                ],
                'admin.role_list'=>[
                    'name'    => '角色列表',
                    'href'    => '?act=admin.role_list',
                    'display' => 1
                ],
            ],
        ],
    ];
}