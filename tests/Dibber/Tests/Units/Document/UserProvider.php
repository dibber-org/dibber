<?php
namespace Dibber\Tests\Units\Document;

require_once(__DIR__ . '/Test.php');

use Dibber\Document;

class UserProvider extends Test
{
    /** @var Document\UserProvider */
    protected $userProvider;

    public function beforeTestMethod($method)
    {
        $this->userProvider = new Document\UserProvider;
    }

    public function testSetUserId()
    {
        $this
            ->assert('userId is set and retreived')
                ->if($userId = '4242')
                ->and($this->userProvider->setUserId($userId))
                ->then
                   ->string($this->userProvider->getUserId())
                       ->isEqualTo($userId)
        ;
    }

    public function testSetProviderId()
    {
        $this
            ->assert('providerId is set and retreived')
                ->if($providerId = '4242')
                ->and($this->userProvider->setProviderId($providerId))
                ->then
                   ->string($this->userProvider->getProviderId())
                       ->isEqualTo($providerId)
        ;
    }

    public function testSetProvider()
    {
        $this
            ->assert('provider is set and retreived')
                ->if($provider = 'provider')
                ->and($this->userProvider->setProvider($provider))
                ->then
                   ->string($this->userProvider->getProvider())
                       ->isEqualTo($provider)
        ;
    }
}