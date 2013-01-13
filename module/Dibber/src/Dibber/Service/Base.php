<?php

namespace Dibber\Service;

use Dibber\Mapper\MapperAwareInterface;
use Dibber\Mapper\MapperProviderTrait;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;

abstract class Base implements MapperAwareInterface, ServiceManagerAwareInterface
{
    use MapperProviderTrait;
    use ServiceManagerProviderTrait;

    /**
     * Overload with specific lazy-loading when request and empty.
     */
    abstract public function getMapper();

    /**
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }
}