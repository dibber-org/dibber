<?php
namespace Dibber\Tests\Units\Service;

require_once(__DIR__ . '/Test.php');

use Dibber\Service;

class User extends Test
{
    /** @var Service\User */
    protected $userService;

    public function beforeTestMethod($method)
    {
        $this->userService = new \mock\Dibber\Service\User;
        $this->userService->setServiceManager($this->sm);
    }

    public function testSetMapper()
    {
        $this->assert('setUserMapper is called on parent')
             ->if($userMapper = new \Dibber\Mapper\User($this->dm))
             ->and($this->userService->getMockController()->setUserMapper = function($userMapper) {
                 return $this->userService;
             } )
             ->then
                 ->object($ret = $this->userService->setMapper($userMapper))
                     ->isInstanceOf('Dibber\Service\User')
                 ->mock($ret)
                     ->call('setUserMapper')->withArguments($userMapper)->once();
    }

    public function testGetMapper()
    {
        $this->assert('getUserMapper is called on parent')
             ->if($userMapper = new \Dibber\Mapper\User($this->dm))
             ->and($this->userService->getMockController()->getUserMapper = function() use($userMapper) {
                 return $userMapper;
             } )
             ->then
                 ->object($this->userService->getMapper())
                    ->isInstanceOf('Dibber\Mapper\User')
                    ->isIdenticalTo($userMapper)
                 ->mock($this->userService)
                     ->call('getUserMapper')->once();
    }
}