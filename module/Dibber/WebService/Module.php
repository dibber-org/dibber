<?php

namespace Dibber\WebService;

use Zend\Mvc\MvcEvent;
use Dibber\WebService\Controller;
use Zend\ModuleManager\Feature;
use Zend\EventManager\EventInterface;

/**
 *
 */
class Module implements
    Feature\AutoloaderProviderInterface,
    Feature\BootstrapListenerInterface,
    Feature\ConfigProviderInterface,
    Feature\ControllerProviderInterface
{
    /**
     * @param MvcEvent $e
     */
    public function onBootstrap(EventInterface $e)
    {
        /** @var \Zend\ModuleManager\ModuleManager $moduleManager */
        $moduleManager = $e->getApplication()->getServiceManager()->get('modulemanager');
        /** @var \Zend\EventManager\SharedEventManager $sharedEvents */
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();

        $sharedEvents->attach('Zend\Mvc\Controller\AbstractRestfulController', MvcEvent::EVENT_DISPATCH, [$this, 'postProcess'], -100);
        //@todo only attach if the route used matches this module's
        //@see https://github.com/scaraveos/ZF2-Restful-Module-Skeleton/issues/8
        $sharedEvents->attach('Zend\Mvc\Application', MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'errorProcess'], -999);
    }

    /**
     * return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\ClassMapAutoloader' => [
                __DIR__ . '/autoload_classmap.php',
            ],
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/WebService',
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                'Dibber\WebService\Controller\Field' => function ($sm) {
                    $controller = new Controller\FieldController();
                    $controller->setMapper($sm->getServiceLocator()->get('dibber_field_mapper'));
                    return $controller;
                },
                'Dibber\WebService\Controller\User' => function ($sm) {
                    $controller = new Controller\UserController();
                    $controller->setMapper($sm->getServiceLocator()->get('dibber_user_mapper'));
                    return $controller;
                },
                'Dibber\WebService\Controller\Place' => function ($sm) {
                    $controller = new Controller\PlaceController();
                    $controller->setMapper($sm->getServiceLocator()->get('dibber_place_mapper'));
                    return $controller;
                },
                'Dibber\WebService\Controller\Zone' => function ($sm) {
                    $controller = new Controller\ZoneController();
                    $controller->setMapper($sm->getServiceLocator()->get('dibber_zone_mapper'));
                    return $controller;
                }
            ]
        ];
    }

    /**
     * @param MvcEvent $e
     * @return null|\Zend\Http\PhpEnvironment\Response
     */
    public function postProcess(MvcEvent $e)
    {
        $routeMatch = $e->getRouteMatch();
        $formatter = $routeMatch->getParam('formatter', false);

        $sm = $e->getApplication()->getServiceManager();

        if ($formatter !== false) {
            if ($e->getResult() instanceof \Zend\View\Model\ViewModel) {
                if (is_array($e->getResult()->getVariables())) {
                    $vars = $e->getResult()->getVariables();
                } else {
                    $vars = null;
                }
            } else {
                $vars = $e->getResult();
            }

            /** @var \Dibber\WebService\PostProcessor\AbstractPostProcessor $postProcessor */
            $postProcessor = $sm->get($formatter . '-pp');
            $postProcessor->setResponse($e->getResponse())
                          ->setVars($vars)
                          ->process();

            return $postProcessor->getResponse();
        }

        return null;
    }

    /**
     * @param MvcEvent $e
     * @return null|\Zend\Http\PhpEnvironment\Response
     */
    public function errorProcess(MvcEvent $e)
    {
        $sm = $e->getApplication()->getServiceManager();

        $eventParams = $e->getParams();

        /** @var array $configuration */
        $configuration = $e->getApplication()->getConfig();

        $vars = [];
        if (isset($eventParams['exception'])) {
            /** @var \Exception $exception */
            $exception = $eventParams['exception'];

            if ($configuration['errors']['show_exceptions']['message']) {
                $vars['error-message'] = $exception->getMessage();
            }
            if ($configuration['errors']['show_exceptions']['trace']) {
                $vars['error-trace'] = $exception->getTrace();
            }
        }

        if (empty($vars)) {
            $vars['error'] = 'Something went wrong';
        }

        /** @var \Dibber\WebService\PostProcessor\AbstractPostProcessor $postProcessor */
        $postProcessor = $sm->get($configuration['errors']['post_processor']);
        $postProcessor->setResponse($e->getResponse())
                      ->setVars($vars)
                      ->process();

        if (
            $eventParams['error'] === \Zend\Mvc\Application::ERROR_CONTROLLER_NOT_FOUND ||
            $eventParams['error'] === \Zend\Mvc\Application::ERROR_ROUTER_NO_MATCH
        ) {
            $e->getResponse()->setStatusCode(\Zend\Http\PhpEnvironment\Response::STATUS_CODE_501);
        }
        else {
            $e->getResponse()->setStatusCode(\Zend\Http\PhpEnvironment\Response::STATUS_CODE_500);
        }

        $e->stopPropagation();

        return $postProcessor->getResponse();
    }
}