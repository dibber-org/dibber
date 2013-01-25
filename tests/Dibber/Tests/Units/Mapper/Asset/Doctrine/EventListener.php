<?php
namespace Dibber\Tests\Units\Mapper\Asset\Doctrine;

/**
 *
 */
class EventListener
{
    /** @var \Doctrine\Common\EventManager */
    protected $evm;

    public function __construct($evm, $events = null)
    {
        $this->evm = $evm;

        if ($events) {
            $this->addEventListener($events);
        }
    }

    public function addEventListener($events)
    {
        $this->evm->addEventListener($events, $this);
    }
}
