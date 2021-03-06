<?php

namespace Dibber\Service;

class Zone extends Base
{
    /**
     * @return \Dibber\Mapper\Zone
     */
    public function getMapper()
    {
        if (null === $this->mapper) {
            $this->mapper = $this->getServiceManager()->get('dibber_zone_mapper');
        }

        return parent::getMapper();
    }
}
