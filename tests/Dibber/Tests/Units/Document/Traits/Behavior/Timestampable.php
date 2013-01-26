<?php
namespace Dibber\Tests\Units\Document\Traits\Behavior\Asset;

require_once(__DIR__ . '/../../Test.php');
require_once(__DIR__ . '/Asset/Timestampable.php');

use Dibber\Document;

class Timestampable extends \Dibber\Tests\Units\Document\Test
{
    /** @var Document\Traits\Behavior\Asset\Timestampable */
    protected $timestampable;

    public function beforeTestMethod($method)
    {
        $this->timestampable = new \mock\Dibber\Document\Traits\Behavior\Asset\Timestampable;
    }

    public function testSetCreatedAt()
    {
        $this
            ->assert('createdAt is set and retreived')
                ->if($createdAt = new \DateTime(date('Y-m-d')))
                ->and($this->timestampable->setCreatedAt($createdAt))
                ->then
                    ->object($this->timestampable->getCreatedAt())
                        ->isIdenticalTo($createdAt)
        ;
    }

    public function testSetUpdatedAt()
    {
        $this
            ->assert('updatedAt is set and retreived')
                ->if($updatedAt = new \DateTime(date('Y-m-d')))
                ->and($this->timestampable->setUpdatedAt($updatedAt))
                ->then
                    ->object($this->timestampable->getUpdatedAt())
                        ->isEqualTo($updatedAt)
        ;
    }
}