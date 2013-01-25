<?php

namespace Dibber\EventManager;

use Zend\EventManager;
use Zend\ServiceManager;

/**
 *
 */
trait EventManagerAwareTrait
{
    use EventManager\EventManagerAwareTrait;

    /**
     * Retrieve the event manager
     *
     * Lazy-loads an EventManager instance if none registered.
     *
     * If the class implements ServiceManager, it adds the global dibber shared
     * event manager to it.
     *
     * @return EventManager\EventManagerInterface
     */
    public function getEventManager()
    {
        if (!$this->events instanceof EventManager\EventManagerInterface) {
            $this->setEventManager(new EventManager\EventManager());
            if ($this instanceof ServiceManager\ServiceManagerAwareInterface) {
                $this->getEventManager()->setSharedManager($this->getServiceManager()->get('dibber_event_manager'));
            }
        }
        return $this->events;
    }
}
