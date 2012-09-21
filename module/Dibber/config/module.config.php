<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c] 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return [
    'router' => [
        'routes' => [
            'dibber' => [
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        '__NAMESPACE__' => 'Dibber\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'default' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '[:controller[/:action]]',
                            'constraints' => [
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => [
                                '__NAMESPACE__' => 'Dibber\Controller',
                                'action' => 'index',
                            ],
                        ],
                    ],

                    'home' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => ':login',
                            'constraints' => [
                                'login'      => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => [
                                'controller' => 'home',
                                'action'     => 'index',
                            ],
                        ],
                    ],

                    /**
                     * Shortcut routes
                     */
                    'profile' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => 'profile',
                            'defaults' => [
                                'controller' => 'user',
                                'action'     => 'profile',
                            ],
                        ],
                    ],
                    'login' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => 'login',
                            'defaults' => [
                                'controller' => 'user',
                                'action'     => 'login',
                            ],
                        ],
                    ],
                    'logout' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => 'logout',
                            'defaults' => [
                                'controller' => 'user',
                                'action'     => 'logout',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ],
    ],
    'translator' => [
        'locale' => 'fr_FR',
        'translation_patterns' => [
            [
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ],
        ],
    ],
    'controllers' => [
        'invokables' => [
            'Dibber\Controller\Index' => 'Dibber\Controller\IndexController',
            'Dibber\Controller\Home'  => 'Dibber\Controller\HomeController',
            'Dibber\Controller\Place' => 'Dibber\Controller\PlaceController',
            'Dibber\Controller\User'  => 'Dibber\Controller\UserController',
            'Dibber\Controller\Mongo' => 'Dibber\Controller\MongoController'
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
