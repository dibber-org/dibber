<?php
namespace Dibber\Document\Traits\Behavior;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM
 ,  Gedmo;

trait Tree
{
    /** @ODM\String */
    private $name;

    /**
     * @ODM\String
     * @Gedmo\Mapping\Annotation\Slug(fields={"name"})
     * @Gedmo\Mapping\Annotation\TreePathSource
     */
    private $code;

    /**
     * @ODM\String
     * @Gedmo\Mapping\Annotation\TreePath(separator="|")
     */
    private $path;

    /**
     * Comment to pass strict standards
     *
     * @ODM\ReferenceOne
     * @Gedmo\Mapping\Annotation\TreeParent
     */
//    private $parent;

    /**
     * @ODM\Int
     * @Gedmo\Mapping\Annotation\TreeLevel
     */
    private $level;

    /**
     * @ODM\Date
     * @Gedmo\Mapping\Annotation\TreeLockTime
     */
    private $lockTime;

    /**
     * @return string the $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function setName($name)
    {
        $this->name = (string) $name;
        return $this;
    }

    /**
     * @return string the $code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     * @return mixed
     */
    public function setParent($parent = null)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return DateTime
     */
    public function getLockTime()
    {
        return $this->lockTime;
    }
}
