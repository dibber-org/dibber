<?php
namespace Dibber\Tests\Units\Document;

require_once(__DIR__ . '/../Test.php');

use Dibber\Tests\Units\Test
 ,  Dibber\Document;

class User extends Test
{
    /** @var Document\User */
    protected $user;

    public function beforeTestMethod($method)
    {
        $this->user = new Document\User;
    }

    public function testSetLogin()
    {
        $this->user->setLogin('jhuet');
        $this->string($this->user->getLogin())
             ->isEqualTo('jhuet');
    }

    public function testSetPassword()
    {
        $this->user->setPassword('toto42');
        $this->string($this->user->getPassword())
             ->isEqualTo('toto42');
    }

    public function testSetEmail()
    {
        $this->user->setEmail('contact@dibber.org');
        $this->string($this->user->getEmail())
             ->isEqualTo('contact@dibber.org');
    }

    public function testSetName()
    {
        $this->user->setName('Jérémy Huet');
        $this->string($this->user->getName())
             ->isEqualTo('Jérémy Huet');
    }

    /**
     * Move to the according ManyPlaces Trait test when made
     */
    public function testAddPlace()
    {
        $place = new \mock\Dibber\Document\Place;
        $this->user->addPlace($place);
        $this->object($this->user->getPlaces()[0])
             ->isInstanceOf('Dibber\Document\Place')
             ->isIdenticalTo($place);
    }

    /**
     * Move to the according ManyPlaces Trait test when made
     */
    public function testSetPlaces()
    {
        $place1 = new \mock\Dibber\Document\Place;
        $place2 = new \mock\Dibber\Document\Place;

        $this->user->setPlaces([$place1, $place2]);

        $this->object($this->user->getPlaces()[0])
             ->isInstanceOf('Dibber\Document\Place')
             ->isIdenticalTo($place1);

        $this->object($this->user->getPlaces()[1])
             ->isInstanceOf('Dibber\Document\Place')
             ->isIdenticalTo($place2);
    }
}