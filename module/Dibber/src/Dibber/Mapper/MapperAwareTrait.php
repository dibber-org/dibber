<?php

namespace Dibber\Mapper;

/**
 * A trait for objects that provide mapper
 */
trait MapperAwareTrait
{
    /**
     * @var Base
     */
    protected $mapper;

    /**
     * @param Base $mapper
     * @return mixed
     */
    public function setMapper(Base $mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }

    /**
     * @return Base
     */
    public function getMapper()
    {
        return $this->mapper;
    }
}