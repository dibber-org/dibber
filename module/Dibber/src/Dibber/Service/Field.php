<?php

namespace Dibber\Service;

class Field extends Base
{
    /**
     * @return \Dibber\Document\Mapper\Field
     */
    public function getMapper()
    {
        if (null === $this->mapper) {
            $this->mapper = $this->getServiceManager()->get('dibber_field_mapper');
        }

        return $this->mapper;
    }
}
