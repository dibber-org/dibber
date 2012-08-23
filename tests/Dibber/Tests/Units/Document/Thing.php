<?php
namespace Dibber\Tests\Units\Document;

require_once(__DIR__ . '/Test.php');

use Dibber\Document;

class Thing extends Test
{
    /** @var Document\Thing */
    protected $thing;

    public function beforeTestMethod($method)
    {
        $this->thing = new \mock\Dibber\Document\Thing;
    }

    public function testSetName()
    {
        $this->assert('Name is set and retreived')
             ->if($name = 'A Verrières')
             ->and($this->thing->setName($name))
             ->then
                ->string($this->thing->getName())
                    ->isEqualTo($name);
    }

    public function testSetNote()
    {
        $this->assert('Note is set and retreived')
             ->if($note = 'How wonderful !')
             ->and($this->thing->setNote($note))
             ->then
                ->string($this->thing->getNote())
                    ->isEqualTo($note);
    }
}