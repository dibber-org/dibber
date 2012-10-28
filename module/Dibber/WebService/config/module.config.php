<?php
return [
    'errors' => [
        'post_processor' => 'json-pp',
        'show_exceptions' => [
            'message' => true,
            'trace'   => true
        ]
    ],
    'di' => [
        'instance' => [
            'alias' => [
                'json-pp'  => 'Dibber\WebService\PostProcessor\Json',
//                'image-pp' => 'Dibber\WebService\PostProcessor\Image',
            ]
        ]
    ],
    'controllers' => [
        'invokables' => [
        ]
    ],
    'router' => [
        'routes' => [
            'ws' => [
                'type'    => 'Segment',
                'options' => [
                    'route'       => '/ws/:controller[/:id]',
                    'constraints' => [
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'         => '[a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        '__NAMESPACE__' => 'Dibber\WebService\Controller',
                        'formatter'  => 'json'
                    ],
                ],
            ],
        ],
    ],
];