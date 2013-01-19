<?php
namespace Dibber\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Sds\DoctrineExtensions\Annotation\Annotations as Sds;
use Dibber\Document\Traits;

/** @ODM\Document(collection="places", repositoryClass="Gedmo\Tree\Document\MongoDB\Repository\MaterializedPathRepository") */
class Place extends Thing
{
    use Traits\Coordinates;
    use Traits\ManyUsers;
    use Traits\Surface;

    public $COLLECTION = 'places';
    public $ACCEPTS = ['zones', 'fields'];

    /**
     *  @ODM\ReferenceMany(
     *      targetDocument="User",
     *      sort={"name"},
     *      cascade={"persist"},
     *      simple=true
     *  )
     * @Sds\Serializer(@Sds\Eager)
     */
    public $users;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->users  = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setParent();
    }

    /**
     * For consistency with Document\User::getLogin()
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->getCode();
    }

    /**
     * Places can't have parents. They are the root of all "Thing"s :)
     *
     * @param Thing $parent
     * @return Place
     */
    public function setParent(Thing $parent = null)
    {
        if (! is_null($parent)) {
            // @todo throw right exception
            throw new \Exception(get_class($this) . " can't have a parent");
        }
        $this->parent = null;
        return $this;
    }
}