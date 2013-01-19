<?php
namespace Dibber\Mapper;

use Doctrine\ODM\MongoDB\DocumentManager;

class User extends Base implements \ZfcUser\Mapper\UserInterface
{
    /**
     * @param \Doctrine\ODM\MongoDB\DocumentManager $dm
     */
    public function __construct(DocumentManager $dm = null)
    {
        parent::__construct('Dibber\Document\User', $dm);
    }

    /**
     * Used to comply with ZfcUser UserInterface
     *
     * @param string $id
     * @return \Dibber\Document\User
     */
    public function findById($id) {
        return $this->find($id);
    }

    /**
     * @param string $login
     * @return \Dibber\Document\User
     */
    public function findByLogin($login)
    {
        return $this->findOneBy(['login' => $login]);
    }

    /**
     * Used to comply with ZfcUser UserInterface
     *
     * @param string $username
     * @return \Dibber\Document\User
     */
    public function findByUsername($username) {
        return $this->findByLogin($username);
    }

    /**
     * @param string $email
     * @return \Dibber\Document\User
     */
    public function findByEmail($email)
    {
        return $this->findOneBy(['email' => $email]);
    }

    /**
     * Used to comply with ZfcUser UserInterface
     *
     * @param \Dibber\Document\User $user
     * @return \Dibber\Document\User
     */
    public function insert($user) {
        return $this->save($user, true);
    }

    /**
     * Used to comply with ZfcUser UserInterface
     *
     * @param \Dibber\Document\User $user
     * @return \Dibber\Document\User
     */
    public function update($user) {
        return $this->save($user, true);
    }
}