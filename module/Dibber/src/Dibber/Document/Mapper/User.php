<?php
namespace Dibber\Document\Mapper;

use \Doctrine\ODM\MongoDB\DocumentManager;

class User extends Base
{
    /**
     * @param \Doctrine\ODM\MongoDB\DocumentManager $dm
     */
    public function __construct(DocumentManager $dm = null)
    {
        parent::__construct('Dibber\Document\User', $dm);
    }

    /**
     * @param string $login
     * @return Dibber\Document\User
     */
    public function findByLogin($login)
    {
        return $this->findOneBy(['login' => $login]);
    }

    /**
     * @param string $email
     * @return Dibber\Document\User
     */
    public function findByEmail($email)
    {
        return $this->findOneBy(['email' => $email]);
    }
}