<?php

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'production' => [
            'adapter' => 'mysql',
            'host' => 'database',
            'name' => 'tpa',
            'user' => 'root',
            'pass' => 'tpa_root_password',
            'port' => '3306',
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => 'mysql',
            'host' => 'tpa1_database',
            'name' => 'tpa',
            'user' => 'tpa_user',
            'pass' => 'tpa_user_password',
            'port' => '3306',
            'charset' => 'utf8',
        ],

        'testing' => [
            'adapter' => 'mysql',
            'host' => '127.0.0.1', // use localhost for ci testing
            'name' => 'tpa',
            'user' => 'tpa_user',
            'pass' => 'tpa_user_password',
            'port' => '3306',
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];
