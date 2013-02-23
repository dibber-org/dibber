<?php

return array(
    'bjyauthorize' => array(
        'default_role'          => 'guest',
        'identity_provider'     => 'BjyAuthorize\Provider\Identity\AuthenticationDoctrine',
        'unauthorized_strategy' => 'BjyAuthorize\View\UnauthorizedStrategy',
        'role_providers'        => array(
            'BjyAuthorize\Provider\Role\Doctrine' => array(
                'role_entity_class' => 'Dibber\Document\Role',
                'object_manager' => 'doctrine.documentmanager.odm_default'
            )
        ),
//        'resource_providers'    => array(
//            'BjyAuthorize\Provider\Resource\Config' => array(
//                'users'     => array(),
//            ),
//        ),
//        'rule_providers'        => array(
//            'BjyAuthorize\Provider\Rule\Config' => array(
//                'allow' => array(
//                    // allow guests and users (and admins, through inheritance)
//                    // the "read" privilege on the resource "users"
////                    array(array('guest', 'user'), 'users', 'read'),
//                ),
//
//                // Don't mix allow/deny rules if you are using role inheritance.
//                // There are some weird bugs.
//                'deny' => array(
//                    // ...
//                ),
//            )
//        ),
        'guards'                => array(
            'BjyAuthorize\Guard\Route' => array(
                // Below is the default index action used by the [ZendSkeletonApplication](https://github.com/zendframework/ZendSkeletonApplication)
                array('route' => 'dibber/login',    'roles' => array('guest')),
                array('route' => 'dibber/login/provider', 'roles' => array('guest')),
                array('route' => 'scn-social-auth-hauth', 'roles' => array('guest')),
                array('route' => 'scn-social-auth-user/authenticate/query', 'roles' => array('guest')),

                array('route' => 'dibber',          'roles' => array('guest', 'user')),
                array('route' => 'dibber/home',     'roles' => array('guest', 'user')),
                array('route' => 'dibber/users',    'roles' => array('guest', 'user')),
                array('route' => 'dibber/places',   'roles' => array('guest', 'user')),

                array('route' => 'dibber/profile',  'roles' => array('user')),
                array('route' => 'dibber/logout',   'roles' => array('user')),
            ),
        ),
        'template'              => 'error/403',
    )
);