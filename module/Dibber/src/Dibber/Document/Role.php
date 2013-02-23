<?php
namespace Dibber\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Sds\DoctrineExtensions\Annotation\Annotations as Sds;
use BjyAuthorize\Acl\HierarchicalRoleInterface;

/** @ODM\Document(collection="roles") */
class Role extends Base implements HierarchicalRoleInterface
{
    const COLLECTION = 'roles';

    /** @ODM\String */
    private $roleId;

    /** @ODM\ReferenceOne(
     *      targetDocument="Role",
     *      simple=true
     * )
     */
    private $parent;

    /**
     * @param string|null                       $roleId
     * @param \Dibber\Document\Role|string|null $parent
     */
    public function __construct($roleId = null, $parent = null)
    {
        if (null !== $roleId) {
            $this->setRoleId($roleId);
        }
        if (null !== $parent) {
            $this->setParent($parent);
        }

        $this->users = new \Doctrine\Common\Collections\ArrayCollection;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * @param string $roleId
     *
     * @return self
     */
    public function setRoleId($roleId)
    {
        $this->roleId = (string) $roleId;

        return $this;
    }

    /**
     * @return \Dibber\Document\Role|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param \Dibber\Document\Role|string|null $parent
     *
     * @throws \BjyAuthorize\Exception\InvalidArgumentException
     *
     * @return self
     */
    public function setParent($parent)
    {
        if (null === $parent) {
            $this->parent = null;

            return $this;
        }

        if (is_string($parent)) {
            $this->parent = new Role($parent);

            return $this;
        }

        if ($parent instanceof Role) {
            $this->parent = $parent;

            return $this;
        }

        throw new Exception\InvalidArgumentException(sprintf(
            'Expected string or Zend\Permissions\Acl\Role\RoleInterface instance; received "%s"',
            (is_object($parent) ? get_class($parent) : gettype($parent))
        ));
    }
}
