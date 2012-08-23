<?php
namespace Dibber\Tests\Units\Document;

require_once(__DIR__ . '/Test.php');

use Dibber\Document;

class Place extends Test
{
    /** @var Document\Place */
    protected $place;

    public function beforeTestMethod($method)
    {
        $this->place = new Document\Place;
    }

    /**
     * Move to the according ManyUsers Trait test when made
     */
    public function testAddUser()
    {
        $this->assert('User is added and retreived')
             ->if($user = new \mock\Dibber\Document\User)
             ->and($this->place->addUser($user))
             ->then
                ->object($this->place->getUsers()[0])
                    ->isInstanceOf('Dibber\Document\User')
                    ->isIdenticalTo($user);
    }

    /**
     * @tags thingParent
     */
    public function testSetParent()
    {
        $this->assert('Setting null parent')
             ->if($this->place->setParent())
             ->then
                ->variable($this->place->getParent())
                    ->isNull()

             ->assert('Setting any kind of parent raises an exception')
                ->exception(function() {
                    $this->place->setParent(new Document\Place);
                } )
                    ->isInstanceOf('\Exception')
                    ->hasMessage("Dibber\Document\Place can't have a parent");
    }
}