<?php
namespace Dibber\Tests\Units\Document\Traits\Asset;

require_once(__DIR__ . '/../Test.php');
require_once(__DIR__ . '/Asset/ManyUsers.php');

use Dibber\Document;

class ManyUsers extends \Dibber\Tests\Units\Document\Test
{
    /** @var Document\Traits\Asset\ManyUsers */
    protected $manyUsers;

    public function beforeTestMethod($method)
    {
        $this->manyUsers = new \Dibber\Document\Traits\Asset\ManyUsers;
        $this->users = [
            $this->createUser(['login' => 'user1']),
            $this->createUser(['login' => 'user2']),
            $this->createUser(['login' => 'user3']),
            $this->createUser(['login' => 'user4'])
        ];
    }

    /**
     * @param array $data
     * @return Document\User
     */
    protected function createUser($data)
    {
        $user = new Document\User;
        foreach ($data as $field => $value) {
            $setter = 'set' . ucfirst($field);
            $user->$setter($value);
        }
        return $user;
    }

    public function testSetUsers()
    {
        $this
            ->assert('users are set and retreived')
                ->if($manyUsers = [
                    $this->createUser(['login' => 'user1']),
                    $this->createUser(['login' => 'user2']),
                ] )
                ->and($this->manyUsers->setUsers($manyUsers, false))
                ->then
                    ->array($this->manyUsers->getUsers()->toArray())
                        ->hasSize(2)
                        ->strictlyContainsValues($manyUsers)


            ->assert('users are set without values that arent Document\User')
                ->if($manyUsers = [
                    $this->createUser(['login' => 'user1']),
                    'notAUser',
                ] )
                ->and($this->manyUsers->setUsers($manyUsers, false))
                ->then
                    ->array($this->manyUsers->getUsers()->toArray())
                        ->hasSize(1)
                        ->strictlyContains($manyUsers[0])
                        ->strictlyNotContains($manyUsers[1])
        ;
    }

    public function testAddUser()
    {
        $this
            ->assert('a user is added and not inversed')
                ->if($user = $this->createUser(['login' => 'user1']))
                ->and($this->manyUsers->addUser($user, false))
                ->then
                    ->object($return = $this->manyUsers->getUsers()[0])
                        ->isIdenticalTo($user)
                    ->string($return->getLogin())
                        ->isEqualTo('user1')

            ->assert('a user is added and inversed')
                ->if($user = $this->createUser(['login' => 'user1']))
                ->then
                    ->exception(function() use($user) {
                        $this->manyUsers->addUser($user);
                    } )
                    ->hasMessage('Added user is inversed.')
        ;
    }

    public function testRemoveUser()
    {
        $this
            ->assert('a user is removed and not inversed')
                ->if($user = $this->createUser(['login' => 'user1']))
                ->and($this->manyUsers->addUser($user, false))
                ->and($this->manyUsers->removeUser($user, false))
                ->then
                    ->array($return = $this->manyUsers->getUsers()->toArray())
                        ->hasSize(0)

            ->assert('a user is removed and inversed')
                ->if($user = $this->createUser(['login' => 'user1']))
                ->and($this->manyUsers->addUser($user, false))
                ->then
                    ->exception(function() use($user) {
                        $this->manyUsers->removeUser($user);
                    } )
                    ->hasMessage('Removed user is inversed.')
        ;
    }

    public function testHasUser()
    {
        $this
            ->assert('returns true if has an already added user')
                ->if($user = $this->createUser(['login' => 'user1']))
                ->and($this->manyUsers->addUser($user, false))
                ->then
                    ->boolean($this->manyUsers->hasUser($user))
                        ->isTrue()

            ->assert('returns false if has an already added user')
                ->if($user = $this->createUser(['login' => 'user1']))
                ->and($this->manyUsers->removeUsers(false))
                ->then
                    ->boolean($this->manyUsers->hasUser($user))
                        ->isFalse()
        ;
    }
}