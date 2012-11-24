<?php

namespace Dibber\Document\Mapper;

/**
 * A trait for objects that provide mapper
 */
trait MapperProviderTrait
{
    /**
     * @var
     */
    protected $mapper;

    /**
     * @param Base $mapper
     */
    public function setMapper(Base $mapper)
    {
        $this->mapper = $mapper;
    }
}