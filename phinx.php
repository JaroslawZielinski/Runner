<?php

$dotenv = Dotenv\Dotenv::create('.');
$envArr = $dotenv->load();

return [
    'paths' => [
        'migrations' => __DIR__ . '/src/Migrations',
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'development',
        'development' => [
            'adapter' => 'mysql',
            'host' => getenv('DB_HOST'),
            'name' => getenv('DB_DATABASE'),
            'user' => 'root',
            'pass' => getenv('DB_ROOT_PASSWORD'),
            'port' => '3306',
            'charset' => 'utf8'
        ],
    ],
];

