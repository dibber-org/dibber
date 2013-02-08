<?php

namespace Dibber\ServiceFactory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class Logger implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Zend\Log\Logger
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration');

        if (array_key_exists('dibber', $config) && array_key_exists('logger', $config['dibber'])) {
            $logger = new \Zend\Log\Logger($config['dibber']['logger']);
        } else {
            throw new \InvalidArgumentException('Missing configuration to create logger that should be in dibber.logger');
        }

        return $logger;
    }
}
