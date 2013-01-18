<?php

namespace Dibber\Service;

use Dibber\Mapper\MapperAwareInterface;
use Dibber\Mapper\MapperAwareTrait;
use Zend\ServiceManager\ServiceManagerAwareInterface;

abstract class Base implements
    MapperAwareInterface,
    ServiceManagerAwareInterface
{
    use MapperAwareTrait;
    use ServiceManagerAwareTrait;
}
