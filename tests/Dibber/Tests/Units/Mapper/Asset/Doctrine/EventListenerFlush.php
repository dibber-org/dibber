<?php
namespace Dibber\Tests\Units\Mapper\Asset\Doctrine;

/**
 *
 */
class EventListenerFlush extends EventListener
{
    public function preFlush()
    {
        throw new \Exception('preFlush event caught.');
    }
}
