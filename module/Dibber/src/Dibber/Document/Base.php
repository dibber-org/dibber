<?php
namespace Dibber\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Dibber\Document\Traits\Behavior;

/** @ODM\MappedSuperclass */
abstract class Base
{
    use Behavior\Timestampable;

    /** @ODM\Id */
    private $id;

    /** */
    public function __construct() {}

    /**
     * @return string the $id
     */
    public function getId() {
        return $this->id;
    }
}