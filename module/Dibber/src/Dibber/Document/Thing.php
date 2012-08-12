<?php
namespace Dibber\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM
 ,  Gedmo
 ,  Dibber\Document\Traits;

/**
 * @ODM\Document(repositoryClass="Gedmo\Tree\Document\MongoDB\Repository\MaterializedPathRepository")
 * @Gedmo\Mapping\Annotation\Tree(type="materializedPath", activateLocking=true)
 */
abstract class Thing extends Base
{
    use Traits\Behavior\Tree;

    /**
     * Has to be overriden
     */
    public $ACCEPTS = [];

    /**
     * Has to be overriden
     */
    public $COLLECTION = '';

    /**
     * @ODM\ReferenceOne(targetDocument="Thing")
     * @Gedmo\Mapping\Annotation\TreeParent
     */
    private $parent;

    /** @ODM\String */
    private $note;

    /**
     * @return string the $note
     */
    public function getNote() {
        return $this->note;
    }

    /**
     * @param Thing $parent
     * @return Thing
     */
    public function setParent(Thing $parent = null)
    {
        if (! in_array($this->COLLECTION, $parent->ACCEPTS)) {
            // @todo throw right exception
            throw new \Exception(get_class($parent) . ' does not accept ' . get_class($this) . ' children');
        } else {
            $this->parent = $parent;
        }
        return $this;
    }

    /**
     * @param string $note
     * @return Thing
     */
    public function setNote($note) {
        $this->note = $note;
        return $this;
    }
}