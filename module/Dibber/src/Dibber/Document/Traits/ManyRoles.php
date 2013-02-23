<?php
namespace Dibber\Document\Traits;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Dibber\Document;

trait ManyRoles
{
    /**
     * Override this property in the using class with according @ODM
     * annotations.
     *
     * Commented to pass strict standards.
     *
     * Do not forget to initialize $roles property in the using class with :
     * $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
     *
     * @var array
     */
//    private $roles;

    /**
     * @return array of Document\Role
     */
    public function getRoles() {
        return $this->roles;
    }

    /**
     * @param array $roles of Document\Role
     * @param bool $inverse
     * @return mixed
     */
    public function setRoles($roles, $inverse = true)
    {
        $this->removeRoles($inverse);

        foreach ($roles as $role) {
            if ($role instanceof Document\Role) {
                $this->addRole($role, $inverse);
            }
        }

        return $this;
    }

    /**
     * @param bool $inverse
     * @return mixed
     */
    public function removeRoles($inverse = true)
    {
        foreach ($this->roles as $role) {
            $this->removeRole($role, $inverse);
        }
        return $this;
    }

    /**
     * @param Document\Role $role
     * @param bool $inverse
     * @return mixed
     */
    public function addRole(Document\Role $role, $inverse = true)
    {
        $this->roles[] = $role;
        if ($inverse == true && method_exists($this, 'inverseAddRole')) {
            $this->inverseAddRole($role);
        }
        return $this;
    }

    /**
     * @param Document\Role $role
     * @param bool $inverse
     * @return mixed
     */
    public function removeRole(Document\Role $role, $inverse = true)
    {
        foreach ($this->roles as $key => $currentRole) {
            if ($currentRole == $role) {
                unset($this->roles[$key]);
                if ($inverse == true && method_exists($this, 'inverseRemoveRole')) {
                    $this->inverseRemoveRole($role);
                }
            }
        }

        return $this;
    }

    /**
     * @param Document\Role $role
     * @return boolean
     */
    public function hasRole(Document\Role $role)
    {
        foreach ($this->roles as $currentRole) {
            if ($currentRole == $role) {
                return true;
            }
        }

        return false;
    }
}
