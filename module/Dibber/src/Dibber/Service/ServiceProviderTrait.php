<?php

namespace Dibber\Service;

/**
 * A trait for objects that provide service
 */
trait ServiceProviderTrait
{
    /**
     * @var
     */
    protected $service;

    /**
     * @todo ? User service extends ZfcUserService thus prevent us from having
     * a common base of service here in dibber.
     *
     * @param mixed $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }
}