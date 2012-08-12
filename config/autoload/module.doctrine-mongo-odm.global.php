<?php
return [
    'doctrine' => [
        'odm_autoload_annotations' => true,

        'connection' => [
            'odm_default' => [
//                'server'    => 'localhost',
//                'port'      => '27017',
//                'user'      => null,
//                'password'  => null,
//                'dbname'    => 'dibber',
//                'options'   => []
            ],
        ],

        'configuration' => [
            'odm_default' => [
                'metadata_cache'     => 'array',

//                'driver'             => 'odm_default',

                'generate_proxies'   => true,
                'proxy_dir'          => 'module/Dibber/src/Dibber/Document/Proxy',
                'proxy_namespace'    => 'Dibber\Model\Proxy',

                'generate_hydrators' => true,
                'hydrator_dir'       => 'module/Dibber/src/Dibber/Document/Hydrator',
                'hydrator_namespace' => 'Dibber\Document\Hydrator',

                'default_db'         => 'dibber',

//                'filters'            => []  // ['filterName' => 'BSON\Filter\Class']
            ]
        ],

        'driver' => [
            'odm_default' => [
                'class'     => 'Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver',
                'drivers'   => []
            ]
        ],

//        'documentmanager' => [
//            'odm_default' => [
//                'connection'    => 'odm_default',
//                'configuration' => 'odm_default',
//                'eventmanager'  => 'odm_default'
//            ]
//        ],

        'eventmanager' => [
            'odm_default' => [
                'subscribers' => [
                    'Gedmo\Sluggable\SluggableListener',
                    'Gedmo\Timestampable\TimestampableListener',
                    'Gedmo\Tree\TreeListener',
                ]
            ]
        ],
    ],
];