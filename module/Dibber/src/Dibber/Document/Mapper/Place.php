<?php
namespace Dibber\Document\Mapper;

use \Doctrine\ODM\MongoDB\DocumentManager;

class Place extends Base
{
    /**
     * @param \Doctrine\ODM\MongoDB\DocumentManager $dm
     */
    public function __construct(DocumentManager $dm = null)
    {
        parent::__construct('Dibber\Document\Place', $dm);
    }

    /**
     * For consistency with Document\Mapper\User::findByLogin()
     *
     * @param string $login
     * @return \Dibber\Document\User
     */
    public function findByLogin($login)
    {
        return $this->findOneBy(['code' => $login]);
    }
}