<?php
namespace Dibber\Tests\Units\Document\Traits\Behavior\Asset;

require_once(__DIR__ . '/../../Test.php');
require_once(__DIR__ . '/Asset/Tree.php');

use Dibber\Document;

class Tree extends \Dibber\Tests\Units\Document\Test
{
    /** @var Document\Traits\Behavior\Asset\Timestampable */
    protected $tree;

    public function beforeTestMethod($method)
    {
        $this->tree = new \mock\Dibber\Document\Traits\Behavior\Asset\Tree;
    }

    public function testSetName()
    {
        $this
            ->assert('name is set and retreived')
                ->if($name = 'toto')
                ->and($this->tree->setName($name))
                ->then
                    ->string($this->tree->getName())
                        ->isEqualTo($name)
        ;
    }

    public function testSetParent()
    {
        $this
            ->assert('parent is set and retreived')
                ->if($parent = 'parent')
                ->and($this->tree->setParent($parent))
                ->then
                    ->string($this->tree->getParent())
                        ->isEqualTo($parent)
        ;
    }

    public function testGetCode()
    {
        $this
            ->assert('code is retreived')
                ->string($this->tree->getCode())
                    ->isEqualTo('code')
        ;
    }

    public function testGetLevel()
    {
        $this
            ->assert('level is retreived')
                ->integer($this->tree->getLevel())
                    ->isEqualTo(42)
        ;
    }

    public function testGetPath()
    {
        $this
            ->assert('path is retreived')
                ->string($this->tree->getPath())
                    ->isEqualTo('path')
        ;
    }

    public function testGetLockTime()
    {
        $this
            ->assert('lockTime is retreived')
                ->object($this->tree->getLockTime())
                    ->isInstanceOf('DateTime')
        ;
    }
}