<?php

return [

    'models' => [

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * Eloquent model should be used to retrieve your permissions. Of course, it
         * is often just the "Permission" model but you may use whatever you like.
         *
         * The model you want to use as a Permission model needs to implement the
         * `Spatie\Permission\Contracts\Permission` contract.
         */

        'permission' => Spatie\Permission\Models\Permission::class,

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * Eloquent model should be used to retrieve your roles. Of course, it
         * is often just the "Role" model but you may use whatever you like.
         *
         * The model you want to use as a Role model needs to implement the
         * `Spatie\Permission\Contracts\Role` contract.
         */

        'role' => Spatie\Permission\Models\Role::class,

    ],

    'table_names' => [

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your roles. We have chosen a basic
         * default value but you may easily change it to any table you like.
         */

        'roles' => 'roles',

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your permissions. We have chosen a basic
         * default value but you may easily change it to any table you like.
         */

        'permissions' => 'permissions',

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your models permissions. We have chosen a
         * basic default value but you may easily change it to any table you like.
         */

        'model_has_permissions' => 'user_has_permissions',

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your models roles. We have chosen a
         * basic default value but you may easily change it to any table you like.
         */

        'model_has_roles' => 'user_has_roles',

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your roles permissions. We have chosen a
         * basic default value but you may easily change it to any table you like.
         */

        'role_has_permissions' => 'role_has_permissions',
    ],

    /*
     * By default all permissions will be cached for 24 hours unless a permission or
     * role is updated. Then the cache will be flushed immediately.
     */

    'cache_expiration_time' => 60 * 24,

    /*
     * By default we'll make an entry in the application log when the permissions
     * could not be loaded. Normally this only occurs while installing the packages.
     *
     * If for some reason you want to disable that logging, set this value to false.
     */

    'log_registration_exception' => true,

    'permissions' => [
                        /* 最新消息 */
                        'news' =>   [
                                        'display_name' => '最新消息',
                                        'value' => [
                                                    /* 最新消息 - 基本設定 */
                                                    'news_index' => [
                                                                        'display_name' => '基本設定',
                                                                        'value' => [
                                                                                    /* 最新消息 - 基本設定 - 查看 */
                                                                                    'news_index_view'   => [
                                                                                                                'name' => 'news_index_view', 
                                                                                                                'display_name' => '查看'
                                                                                                            ],
                                                                                    /* 最新消息 - 基本設定 - 修改 */                        
                                                                                    'news_index_edit'   =>  [
                                                                                                                'name' => 'news_index_edit', 
                                                                                                                'display_name' => '修改'
                                                                                                            ],
                                                                                    ], 
                                                                    ],
                                                    /* 最新消息 - 分類 */
                                                    'news_category' => [
                                                                        'display_name' => '分類',
                                                                        'value' => [
                                                                                    /* 最新消息 - 分類 - 查看 */
                                                                                    'news_category_view'   => [
                                                                                                                'name' => 'news_category_view', 
                                                                                                                'display_name' => '查看'
                                                                                                            ],
                                                                                    /* 最新消息 - 分類 - 修改 */                        
                                                                                    'news_category_edit'   =>  [
                                                                                                                'name' => 'news_category_edit', 
                                                                                                                'display_name' => '修改'
                                                                                                            ],
                                                                                    ], 
                                                                    ], 
                                                    /* 最新消息 - 項目（列表） */
                                                    'news_item' => [
                                                                        'display_name' => '列表',
                                                                        'value' => [
                                                                                    /* 最新消息 - 項目（列表） - 查看 */
                                                                                    'news_item_view'   => [
                                                                                                                'name' => 'news_item_view', 
                                                                                                                'display_name' => '查看'
                                                                                                            ],
                                                                                    /* 最新消息 - 項目（列表） - 修改 */                        
                                                                                    'news_item_edit'   =>  [
                                                                                                                'name' => 'news_item_edit', 
                                                                                                                'display_name' => '修改'
                                                                                                            ],
                                                                                    ], 
                                                                    ],                                                                      
                                                    ]
                                    ],
                    ],
    'roles' => [
        'super_admin' => ['name' => 'super_admin', 'display_name' => '最高管理員'],
        'admin' => ['name' => 'admin', 'display_name' => '管理員'],
        'general_member' => ['name' => 'general_member', 'display_name' => '一般會員'],
    ],
];
