<?php
namespace Dibber\Tests\Units\Document;

require_once(__DIR__ . '/../Test.php');

use Dibber\Tests\Units\Test
 ,  Dibber\Document;

class Field extends Test
{
    /** @var Document\Field */
    protected $field;

    public function beforeTestMethod($method)
    {
        $this->field = new Document\Field;
    }

    /**
     * @tags thingParent
     */
    public function testSetParent()
    {
        $place = new \mock\Dibber\Document\Place;
        $this->field->setParent($place);
        $this->object($this->field->getParent())
             ->isInstanceOf('Dibber\Document\Place')
             ->isIdenticalTo($place);

        $this->field->setParent();
        $this->variable($this->field->getParent())
             ->isNull();

        $zone = new \mock\Dibber\Document\Zone;
        $this->field->setParent($zone);
        $this->object($this->field->getParent())
             ->isInstanceOf('Dibber\Document\Zone')
             ->isIdenticalTo($zone);

        $this->exception(function() {
                $this->field->setParent(new Document\Field);
            } )
            ->isInstanceOf('\Exception')
            ->hasMessage("Dibber\Document\Field does not accept Dibber\Document\Field as a child");
    }
}