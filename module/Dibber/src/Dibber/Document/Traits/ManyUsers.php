<?php
namespace Dibber\Document\Traits;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM
 ,  Dibber\Document;

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
//    public $users;

    /**
     * @return array of Document\User
     */
    public function getUsers() {
        return $this->users;
    }

    /**
     * @param array $users of Document\User
     * @return mixed
     */
    public function setUsers($users)
    {
        $this->users = [];

        foreach ($users as $user) {
            if ($user instanceof Document\User) {
                $this->addUser($user);
            }
        }

        return $this;
    }

    /**
     * @param Document\User $user
     * @return mixed
     */
    public function addUser(Document\User $user)
    {
        $this->users[] = $user;
        $user->places[] = $this; // @todo gonna break one day when used by another class than User!
        return $this;
    }
}
