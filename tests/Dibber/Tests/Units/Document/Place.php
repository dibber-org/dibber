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
        $user = new \mock\Dibber\Document\User;
        $this->place->addUser($user);
        $this->object($this->place->getUsers()[0])
             ->isInstanceOf('Dibber\Document\User')
             ->isIdenticalTo($user);
    }

    /**
     * @tags thingParent
     */
    public function testSetParent()
    {
        $this->place->setParent();
        $this->variable($this->place->parent)
             ->isNull();

        $this->exception(function() {
                $this->place->setParent(new \mock\Dibber\Document\Place);
            } )
            ->isInstanceOf('\Exception')
            ->hasMessage("Dibber\Document\Place can't have a parent");
    }
}