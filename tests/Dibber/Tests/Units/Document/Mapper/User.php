<?php
namespace Dibber\Tests\Units\Document\Mapper;

require_once(__DIR__ . '/Test.php');

use Dibber\Document
 ,  Dibber\Document\Mapper
 ,  mageekguy\atoum;

class User extends Test
{
    /** @var Document\Mapper\User */
    protected $userMapper;

    public function beforeTestMethod($method)
    {
        $this->userMapper = new \mock\Dibber\Document\Mapper\User($this->dm);
    }

    public function testFindByLogin()
    {
        $this->assert('FindByOne is called on parent')
             ->if($user = new \mock\Dibber\Document\User)
             ->and($this->userMapper->getMockController()->findOneBy = function(array $criteria) use ($user) {
                 return $user;
             } )
             ->and($login = 'jhuet')
             ->then
                ->object($this->userMapper->findByLogin($login))
                    ->isInstanceOf('Dibber\Document\User')
                ->mock($this->userMapper)
                    ->call('findOneBy')->withArguments(['login' => $login])->once();
    }

    public function testFindByEmail()
    {
        $this->assert('FindByOne is called on parent')
             ->if($user = new \mock\Dibber\Document\User)
             ->and($this->userMapper->getMockController()->findOneBy = function(array $criteria) use ($user) {
                 return $user;
             } )
             ->and($email = 'jeremy.huet+dibber@gmail.com')
             ->then
                ->object($this->userMapper->findByEmail($email))
                    ->isInstanceOf('Dibber\Document\User')
                ->mock($this->userMapper)
                    ->call('findOneBy')->withArguments(['email' => $email])->once();
    }
}