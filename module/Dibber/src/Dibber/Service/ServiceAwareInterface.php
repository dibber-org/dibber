<?php

namespace Dibber\Service;

interface ServiceAwareInterface
{
    public function setService($service);

    public function getService();
}