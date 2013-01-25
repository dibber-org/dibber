<?php

namespace Dibber\EventManager;

use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\ResponseCollection;

/**
 *
 */
trait TriggerEventTrait
{
    /**
     * Trigger an event more easily :
     * - $target is $this by default
     *
     * @param  string $event
     * @param  array|object $argv
     * @param  object|string $target
     * @param  null|callable $callback
     * @return ResponseCollection
     */
    public function triggerEvent($event, $argv = array(), $target = null, $callback = null)
    {
//        if (! $this instanceof EventManagerAwareInterface) {
//            throw new \Exception('Dibber\EventManager\TriggerEventTrait requires the class that uses it to implement Zend\EventManager\EventManagerAwareInterface');
//        }
        // replaces above if until \Dibber\Mapper\Base can implement EventManagerAwareInterface without making unit tests seg fault :/
        if (! method_exists($this, 'getEventManager')) {
            throw new \Exception('Dibber\EventManager\TriggerEventTrait requires the class that uses it to implement Zend\EventManager\EventManagerAwareInterface');
        }

        if (is_null($target)) {
            $target = $this;
        }

        return $this->getEventManager()->trigger($event, $target, $argv, $callback);
    }
}
