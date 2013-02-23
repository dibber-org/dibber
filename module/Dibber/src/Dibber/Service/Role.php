<?php

namespace Dibber\Service;

class Role extends Base
{
    /**
     * @return \Dibber\Mapper\RoleField
     */
    public function getMapper()
    {
        if (null === $this->mapper) {
            $this->mapper = $this->getServiceManager()->get('dibber_role_mapper');
        }

        return parent::getMapper();
    }

    /**
     * @param \Zend\EventManager\EventInterface $event
     */
    public function onRegister(\Zend\EventManager\EventInterface $event)
    {
        $userRole = $this->getMapper()->findByRoleId(\Dibber\Document\Role::ROLE_USER);
        $user = $event->getParam('user');
        $user->addRole($userRole);
    }
}
