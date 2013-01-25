<?php

namespace Dibber\Service;

use Dibber\EventManager\EventManagerAwareTrait;
use Dibber\EventManager\TriggerEventTrait;
use Dibber\Mapper\MapperAwareInterface;
use Dibber\Mapper\MapperAwareTrait;
//use Zend\ServiceManager\ServiceManagerAwareInterface;
//use Zend\EventManager\EventManagerAwareInterface;

abstract class Base implements
    MapperAwareInterface/*,
    ServiceManagerAwareInterface,
    EventManagerAwareInterface  // commented as it makes unit tests seg fault :/ */
{
    use EventManagerAwareTrait;
    use TriggerEventTrait;
    use MapperAwareTrait;
    use ServiceManagerAwareTrait;
}
