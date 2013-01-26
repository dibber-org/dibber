<?php
namespace Dibber\Document\Traits;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Dibber\Document;

trait ManyUsers
{
    /**
     * Override this property in the using class with according @ODM
     * annotations.
     *
     * Commented to pass strict standards.
     *
     * Do not forget to initialize $users property in the using class with :
     * $this->users = new \Doctrine\Common\Collections\ArrayCollection();
     *
     * @var array
     */
//    private $users;

    /**
     * @return array of Document\User
     */
    public function getUsers() {
        return $this->users;
    }

    /**
     * @param array $users of Document\User
     * @param bool $inverse
     * @return mixed
     */
    public function setUsers($users, $inverse = true)
    {
        $this->removeUsers($inverse);

        foreach ($users as $user) {
            if ($user instanceof Document\User) {
                $this->addUser($user, $inverse);
            }
        }

        return $this;
    }

    /**
     * @param bool $inverse
     * @return mixed
     */
    public function removeUsers($inverse = true)
    {
        foreach ($this->users as $user) {
            $this->removeUser($user, $inverse);
        }
        return $this;
    }

    /**
     * @param Document\User $user
     * @param bool $inverse
     * @return mixed
     */
    public function addUser(Document\User $user, $inverse = true)
    {
        $this->users[] = $user;
        if ($inverse == true && method_exists($this, 'inverseAddUser')) {
            $this->inverseAddUser($user);
        }
        return $this;
    }

    /**
     * @param Document\User $user
     * @param bool $inverse
     * @return mixed
     */
    public function removeUser(Document\User $user, $inverse = true)
    {
        foreach ($this->users as $key => $currentUser) {
            if ($currentUser == $user) {
                unset($this->users[$key]);
                if ($inverse == true && method_exists($this, 'inverseRemoveUser')) {
                    $this->inverseRemoveUser($user);
                }
            }
        }

        return $this;
    }

    /**
     * @param Document\User $user
     * @return boolean
     */
    public function hasUser(Document\User $user)
    {
        foreach ($this->users as $currentUser) {
            if ($currentUser == $user) {
                return true;
            }
        }

        return false;
    }
}
