<?php
namespace Dibber\Tests\Units\Document;

require_once(__DIR__ . '/Test.php');

use Dibber\Document;

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
        $this
            ->assert('Setting a Place as parent')
                ->if($place = new \mock\Dibber\Document\Place)
                ->and($this->field->setParent($place))
                ->then
                   ->object($this->field->getParent())
                       ->isInstanceOf('Dibber\Document\Place')
                       ->isIdenticalTo($place)


            ->assert('Setting a Zone as parent')
                ->if($zone = new \mock\Dibber\Document\Zone)
                ->and($this->field->setParent($zone))
                ->then
                   ->object($this->field->getParent())
                       ->isInstanceOf('Dibber\Document\Zone')
                       ->isIdenticalTo($zone)


            ->assert('Setting null parent')
                ->if($this->field->setParent())
                ->then
                   ->variable($this->field->getParent())
                       ->isNull()


            ->assert('Setting a not accepted parent raises an exception')
                ->exception(function() {
                    $this->field->setParent(new Document\Field);
                } )
                    ->isInstanceOf('\Exception')
                    ->hasMessage("Dibber\Document\Field does not accept Dibber\Document\Field as a child")
        ;
    }
}