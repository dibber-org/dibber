<?php
namespace Dibber\Service;

use ZfcUser\Service\User as ZfcUserService;
use Dibber\Document\Mapper\MapperAwareInterface;
use Dibber\Document\Mapper\Base as BaseMapper;
use Dibber\Document\Mapper\User as UserMapper;

class User extends ZfcUserService implements MapperAwareInterface
{
    /**
     * @return UserMapper
     */
    public function getMapper()
    {
        return $this->getUserMapper();
    }

    /**
     * @param BaseMapper $mapper
     * @return User
     */
    public function setMapper(BaseMapper $mapper)
    {
        $this->setUserMapper($mapper);
        return $this;
    }
}