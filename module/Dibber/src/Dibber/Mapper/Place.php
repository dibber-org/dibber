<?php
namespace Dibber\Mapper;

use Doctrine\ODM\MongoDB\DocumentManager;

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
     * Alias to findByCode for consistency with
     * Mapper\User::findByLogin()
     *
     * @param string $login
     * @return \Dibber\Document\Place
     */
    public function findByLogin($login)
    {
        return $this->findByCode($login);
    }

    /**
     * @param string $code
     * @return \Dibber\Document\Place
     */
    public function findByCode($code)
    {
        return $this->findOneBy(['code' => (string) $code]);
    }
}