<?php

namespace Dibber\Service;

use Zend\ServiceManager\ServiceManager;

/**
 * A trait for objects that provide the service manager
 */
trait ServiceManagerProviderTrait
{
    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * @param mixed $serviceManager
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }
}