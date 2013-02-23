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
use Zend\ModuleManager\Feature;
use Zend\EventManager\EventInterface;

class Module implements
    Feature\AutoloaderProviderInterface,
    Feature\BootstrapListenerInterface,
    Feature\ConfigProviderInterface,
    Feature\ServiceProviderInterface
{
    public function onBootstrap(EventInterface $e)
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
                'dibber_user_service' => 'zfcuser_user_service',
                'doctrine.serializer.odm_default' => 'Sds\DoctrineExtensions\Serializer'
            ],

            'invokables' => [
                'zfcuser_user_service' => 'Dibber\Service\User',
                'dibber_event_manager' => 'Zend\EventManager\SharedEventManager'
            ],

            'factories' => [
                /**
                 * Services for documents mappers
                 */
                'dibber_field_mapper' => function ($sm) {
                    $fieldMapper = new \Dibber\Mapper\Field(
                        $sm->get('doctrine.documentmanager.odm_default')
                    );
                    $fieldMapper->setSerializer($sm->get('doctrine.serializer.odm_default'));
                    return $fieldMapper;
                },
                'dibber_place_mapper' => function ($sm) {
                    $placeMapper = new \Dibber\Mapper\Place(
                        $sm->get('doctrine.documentmanager.odm_default')
                    );
                    $placeMapper->setSerializer($sm->get('doctrine.serializer.odm_default'));
                    return $placeMapper;
                },
                'dibber_role_mapper' => function ($sm) {
                    $roleMapper = new \Dibber\Mapper\Role(
                        $sm->get('doctrine.documentmanager.odm_default')
                    );
                    $roleMapper->setSerializer($sm->get('doctrine.serializer.odm_default'));
                    return $roleMapper;
                },
                'dibber_user_mapper' => function ($sm) {
                    $userMapper = new \Dibber\Mapper\User(
                        $sm->get('doctrine.documentmanager.odm_default')
                    );
                    $userMapper->setSerializer($sm->get('doctrine.serializer.odm_default'));
                    return $userMapper;
                },
                'dibber_user_provider_mapper' => function ($sm) {
                    $userProviderMapper = new \Dibber\Mapper\UserProvider(
                        $sm->get('doctrine.documentmanager.odm_default')
                    );
                    $userProviderMapper->setSerializer($sm->get('doctrine.serializer.odm_default'));
                    return $userProviderMapper;
                },
                'dibber_zone_mapper' => function ($sm) {
                    $zoneMapper = new \Dibber\Mapper\Zone(
                        $sm->get('doctrine.documentmanager.odm_default')
                    );
                    $zoneMapper->setSerializer($sm->get('doctrine.serializer.odm_default'));
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
                'dibber_role_service' => function($sm) {
                    $roleService = new \Dibber\Service\Role();
                    $roleService->setServiceManager($sm);
                    return $roleService;
                },
                'dibber_zone_service' => function($sm) {
                    $zoneService = new \Dibber\Service\Zone();
                    $zoneService->setServiceManager($sm);
                    return $zoneService;
                },

                'dibber_logger' => 'Dibber\ServiceFactory\Logger'
            ],
        ];
    }
}
