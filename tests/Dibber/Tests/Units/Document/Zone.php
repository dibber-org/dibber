<?php
namespace Dibber\Tests\Units\Document;

require_once(__DIR__ . '/Test.php');

use Dibber\Document;

class Zone extends Test
{
    /** @var Document\Zone */
    protected $zone;

    public function beforeTestMethod($method)
    {
        $this->zone = new Document\Zone;
    }

    /**
     * @tags thingParent
     */
    public function testSetParent()
    {
        $this->assert('Setting a Place as parent')
             ->if($place = new \mock\Dibber\Document\Place)
             ->and($this->zone->setParent($place))
             ->then
                ->object($this->zone->getParent())
                    ->isInstanceOf('Dibber\Document\Place')
                    ->isIdenticalTo($place)

             ->assert('Setting a not accepted parent raises an exception')
                ->exception(function() {
                    $this->zone->setParent(new Document\Field);
                } )
                    ->isInstanceOf('\Exception')
                    ->hasMessage("Dibber\Document\Field does not accept Dibber\Document\Zone as a child");
    }
}