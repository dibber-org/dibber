<?php
namespace Dibber\Document\Traits\Asset;
require_once 'module/Dibber/src/Dibber/Document/Traits/ManyUsers.php';

use Dibber\Document;

class ManyUsers
{
    use Document\Traits\ManyUsers;

    public $users;

    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Called after a ManyUsers::addUser to inverse the relation
     *
     * @param Document\User $user
     */
    public function inverseAddUser(Document\User $user)
    {
        throw new \Exception('Added user is inversed.');
    }

    /**
     * Called after a ManyUsers::removeUser to inverse the removal of the
     * relation.
     *
     * @param Document\User $user
     */
    public function inverseRemoveUser(Document\User $user)
    {
        throw new \Exception('Removed user is inversed.');
    }
}
