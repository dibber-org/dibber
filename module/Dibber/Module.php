<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Dibber;

use Zend\Mvc\ModuleRouteListener;

class Module
{
    public function onBootstrap($e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return [
            'aliases' => [
                'dibber_user_service' => 'zfcuser_user_service'
            ],

            'invokables' => [
                'zfcuser_user_service' => 'Dibber\Service\User',
            ],

            'factories' => [
                /**
                 * Services for documents mappers
                 */
                'dibber_field_mapper' => function ($sm) {
                    $fieldMapper = new \Dibber\Document\Mapper\Field(
                        $sm->get('doctrine.documentmanager.odm_default')
                    );
                    $fieldMapper->setSerializer($sm->get('Sds\DoctrineExtensions\Serializer'));
                    return $fieldMapper;
                },
                'dibber_place_mapper' => function ($sm) {
                    $placeMapper = new \Dibber\Document\Mapper\Place(
                        $sm->get('doctrine.documentmanager.odm_default')
                    );
                    $placeMapper->setSerializer($sm->get('Sds\DoctrineExtensions\Serializer'));
                    return $placeMapper;
                },
                'dibber_user_mapper' => function ($sm) {
                    $userMapper = new \Dibber\Document\Mapper\User(
                        $sm->get('doctrine.documentmanager.odm_default')
                    );
                    $userMapper->setSerializer($sm->get('Sds\DoctrineExtensions\Serializer'));
                    return $userMapper;
                },
                'dibber_zone_mapper' => function ($sm) {
                    $zoneMapper = new \Dibber\Document\Mapper\Zone(
                        $sm->get('doctrine.documentmanager.odm_default')
                    );
                    $zoneMapper->setSerializer($sm->get('Sds\DoctrineExtensions\Serializer'));
                    return $zoneMapper;
                },


                /**
                 * Services for services :]
                 */
                'dibber_field_service' => function($sm) {
                    $fieldService = new \Dibber\Service\Field();
                    $fieldService->setServiceManager($sm);
                    return $fieldService;
                },
                'dibber_place_service' => function($sm) {
                    $placeService = new \Dibber\Service\Place();
                    $placeService->setServiceManager($sm);
                    return $placeService;
                },
                'dibber_zone_service' => function($sm) {
                    $zoneService = new \Dibber\Service\Zone();
                    $zoneService->setServiceManager($sm);
                    return $zoneService;
                },

                'doctrine.serializer.odm_default' => function ($sm) {
                    return new \Sds\DoctrineExtensions\Serializer\Serializer;
                }
            ],
        ];
    }
}
