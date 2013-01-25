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

    public function testGetMapper()
    {
        $this
            ->assert('Returns a Dibber\Mapper\User')
            ->if($userMapper = new \Dibber\Mapper\User($this->dm))
            ->and($this->userService->getMockController()->getUserMapper = function() use($userMapper) {
                return $userMapper;
            } )
            ->then
                ->object($this->userService->getMapper())
                    ->isInstanceOf('Dibber\Mapper\User')
                    ->isIdenticalTo($userMapper);
    }

    public function testSetMapper()
    {
        $this
            ->assert('Sets the mapper and returns Dibber\Service\User')
            ->if($userMapper = new \Dibber\Mapper\User($this->dm))
            ->then
                ->object($ret = $this->userService->setMapper($userMapper))
                    ->isInstanceOf('Dibber\Service\User')
                ->object($this->userService->getMapper())
                    ->isInstanceOf('Dibber\Mapper\User')
                    ->isIdenticalTo($userMapper);
    }
}
