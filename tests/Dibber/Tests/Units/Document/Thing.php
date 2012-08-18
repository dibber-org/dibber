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
        $this->thing->setName('A Verrières');

        $this->string($this->thing->getName())
             ->isEqualTo('A Verrières');
    }

    public function testSetNote()
    {
        $this->thing->setNote('How wonderful !');

        $this->string($this->thing->getNote())
             ->isEqualTo('How wonderful !');
    }
}