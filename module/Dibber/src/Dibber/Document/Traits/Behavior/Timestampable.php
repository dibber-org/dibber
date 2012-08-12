<?php
namespace Dibber\Document\Traits\Behavior;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM
 ,  Dibber\Document;

trait Timestampable
{
    /**
     * @Gedmo\Mapping\Annotation\Timestampable(on="create")
     * @ODM\Date
     */
    private $createdAt;

    /**
     * @Gedmo\Mapping\Annotation\Timestampable(on="update")
     * @ODM\Date
     */
    private $updatedAt;

    /**
     * Sets createdAt.
     *
     * @param Datetime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns createdAt.
     *
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Sets updatedAt.
     *
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Returns updatedAt.
     *
     * @return Datetime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}