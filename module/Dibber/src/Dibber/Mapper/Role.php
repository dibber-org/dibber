<?php
namespace Dibber\Mapper;

use Doctrine\ODM\MongoDB\DocumentManager;

class Role extends Base
{
    /**
     * @param \Doctrine\ODM\MongoDB\DocumentManager $dm
     */
    public function __construct(DocumentManager $dm = null)
    {
        parent::__construct('Dibber\Document\Role', $dm);
    }

    /**
     * @param string $id
     * @return \Dibber\Document\Role
     */
    public function findByRoleId($id)
    {
        return $this->findOneBy(['roleId' => (string) $id]);
    }
}