<?php

namespace Dibber\Service;

class Place extends Base
{
    /**
     * @return \Dibber\Mapper\Place
     */
    public function getMapper()
    {
        if (null === $this->mapper) {
            $this->mapper = $this->getServiceManager()->get('dibber_place_mapper');
        }

        return $this->mapper;
    }
}
