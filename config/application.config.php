<?php
return [
    'modules' => [
        'ZendDeveloperTools',
        'DoctrineModule',
        'DoctrineMongoODMModule',
        'ZfcBase',
        'ZfcUser',
        'ZfcUserDoctrineMongoODM',
        'ScnSocialAuth',
        'ScnSocialAuthDoctrineMongoODM',
        'Sds\DoctrineExtensionsModule',
        'Jhu\ZdtLoggerModule',
        'Dibber\WebService',
        'Dibber',
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
