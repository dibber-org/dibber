<?php
namespace Dibber\Tests\Units\Mapper;

require_once(__DIR__ . '/Test.php');

use Dibber\Document
 ,  Dibber\Mapper
 ,  mageekguy\atoum;

class User extends Test
{
    /** @var Mapper\User */
    protected $userMapper;

    public function beforeTestMethod($method)
    {
        parent::beforeTestMethod($method);

        $this->userMapper = new \mock\Dibber\Mapper\User($this->dm);
    }

    public function testFindById()
    {
        $this
            ->assert('Find is called on parent')
                ->if($user = new \mock\Dibber\Document\User)
                ->and($this->userMapper->getMockController()->find = function($id) use ($user) {
                    return $user;
                } )
                ->and($id = '42')
                ->then
                   ->object($this->userMapper->findById($id))
                       ->isInstanceOf('Dibber\Document\User')
                   ->mock($this->userMapper)
                       ->call('find')->withArguments($id)->once()
        ;
    }

    public function testFindByLogin()
    {
        $this
            ->assert('FindByOne is called on parent')
                ->if($user = new \mock\Dibber\Document\User)
                ->and($this->userMapper->getMockController()->findOneBy = function(array $criteria) use ($user) {
                    return $user;
                } )
                ->and($login = 'jhuet')
                ->then
                   ->object($this->userMapper->findByLogin($login))
                       ->isInstanceOf('Dibber\Document\User')
                   ->mock($this->userMapper)
                       ->call('findOneBy')->withArguments(['login' => $login])->once()
        ;
    }

    public function testFindByUsername()
    {
        $this
            ->assert('FindByusername is just an alias to findByLogin')
                ->if($user = new \mock\Dibber\Document\User)
                ->and($login = 'jhuet')
                ->then
                   ->object($this->userMapper->findByUsername($login))
                       ->isInstanceOf('Dibber\Document\User')
                   ->mock($this->userMapper)
                       ->call('findByLogin')->withArguments($login)->once()
        ;
    }

    public function testFindByEmail()
    {
        $this
            ->assert('FindByOne is called on parent')
                ->if($user = new \mock\Dibber\Document\User)
                ->and($this->userMapper->getMockController()->findOneBy = function(array $criteria) use ($user) {
                    return $user;
                } )
                ->and($email = 'jeremy.huet+dibber@gmail.com')
                ->then
                   ->object($this->userMapper->findByEmail($email))
                       ->isInstanceOf('Dibber\Document\User')
                   ->mock($this->userMapper)
                       ->call('findOneBy')->withArguments(['email' => $email])->once()
        ;
    }

    public function testInsert()
    {
        $this
            ->assert('Insert is just an alias to save with flush = true')
                ->if($user = new \mock\Dibber\Document\User)
                ->and($this->userMapper->getMockController()->save = function($user) {
                    return $user;
                } )
                ->then
                   ->object($this->userMapper->insert($user))
                       ->isInstanceOf('Dibber\Document\User')
                       ->isEqualTo($user)
                   ->mock($this->userMapper)
                       ->call('save')->withArguments($user, true)->once()
        ;
    }

    public function testUpdate()
    {
        $this
            ->assert('Update is just an alias to save with flush = true')
                ->if($user = new \mock\Dibber\Document\User)
                ->and($this->userMapper->getMockController()->save = function($user) {
                    return $user;
                } )
                ->then
                   ->object($this->userMapper->update($user))
                       ->isInstanceOf('Dibber\Document\User')
                       ->isEqualTo($user)
                   ->mock($this->userMapper)
                       ->call('save')->withArguments($user, true)->once()
        ;
    }
}