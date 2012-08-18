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
        $place = new \mock\Dibber\Document\Place;
        $this->zone->setParent($place);
        $this->object($this->zone->getParent())
             ->isInstanceOf('Dibber\Document\Place')
             ->isIdenticalTo($place);

        $this->exception(function() {
                $this->zone->setParent(new Document\Zone);
            } )
            ->isInstanceOf('\Exception')
            ->hasMessage("Dibber\Document\Zone does not accept Dibber\Document\Zone as a child");
    }
}