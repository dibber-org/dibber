<?php

namespace Dibber\Document\Mapper;

interface MapperAwareInterface
{
    /**
     * @todo ? User service extends ZfcUserService thus prevent us from having
     * a common base of service here in dibber.
     */
    public function setMapper(Base $mapper);

    public function getMapper();
}