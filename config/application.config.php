<?php
return [
    'modules' => [
        'DoctrineModule',
        'DoctrineMongoODMModule',
        'ZfcBase',
//        'ZfcUser',
//        'ZfcUserDoctrineMongoODM',
        'Dibber'
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
