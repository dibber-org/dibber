<?php
namespace Dibber\Tests\Units\Document;

require_once(__DIR__ . '/Test.php');

use Dibber\Document;

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
        $this->assert('Login is set and retreived')
             ->if($login = 'jhuet')
             ->and($this->user->setLogin($login))
             ->then
                ->string($this->user->getLogin())
                    ->isEqualTo($login);
    }

    public function testSetPassword()
    {
        $this->assert('Password is set and retreived')
             ->if($password = 'toto42')
             ->and($this->user->setPassword($password))
             ->then
                ->string($this->user->getPassword())
                    ->isEqualTo($password);
    }

    public function testSetEmail()
    {
        $this->assert('Email is set and retreived')
             ->if($email = 'contact@dibber.org')
             ->and($this->user->setEmail($email))
             ->then
                ->string($this->user->getEmail())
                    ->isEqualTo($email);
    }

    public function testSetName()
    {
        $this->assert('Name is set and retreived')
             ->if($name = 'Jérémy Huet')
             ->and($this->user->setName($name))
             ->then
                ->string($this->user->getName())
                    ->isEqualTo($name);
    }

    /**
     * @todo Move to the according ManyPlaces Trait test when made
     */
    public function testAddPlace()
    {
        $this->assert('Place is added and retreived')
             ->if($place = new Document\Place)
             ->and($this->user->addPlace($place))
             ->then
                ->object($this->user->getPlaces()[0])
                    ->isInstanceOf('Dibber\Document\Place')
                    ->isIdenticalTo($place);

                // @todo figure out how to test PHP errors.
//             ->assert('Adding something else than a Place creates an error')
//                ->when(function() {
//                    $this->user->addPlace(new \stdClass);
//                } )
//                    ->error(E_RECOVERABLE_ERROR)->exists();
    }

    /**
     * @todo Move to the according ManyPlaces Trait test when made
     */
    public function testSetPlaces()
    {
        $this->assert('Places are set and retreived')
             ->if($place1 = new \mock\Dibber\Document\Place)
             ->and($place2 = new \mock\Dibber\Document\Place)
             ->and($this->user->setPlaces([$place1, $place2]))
             ->then
                ->object($this->user->getPlaces()[0])
                    ->isInstanceOf('Dibber\Document\Place')
                    ->isIdenticalTo($place1)
                ->object($this->user->getPlaces()[1])
                    ->isInstanceOf('Dibber\Document\Place')
                    ->isIdenticalTo($place2);
    }
}