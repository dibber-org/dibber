<?php
return [
    'modules' => [
        'Dibber',
        'DoctrineModule',
        'DoctrineMongoODMModule'
    ],
    'module_listener_options' => [
        'config_glob_paths'    => [
            'config/autoload/{,*.}{global,local}.php',
        ],
        'module_paths' => [
            './module',
            './vendor',
        ],
    ],
];
