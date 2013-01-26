<?php
namespace Dibber\Tests\Units\Mapper;

require_once(__DIR__ . '/Test.php');

use Dibber\Document
 ,  Dibber\Mapper
 ,  mageekguy\atoum;

/**
 * @todo test triggered events
 */
class UserProvider extends Test
{
    /** @var Mapper\UserProvider */
    protected $userProviderMapper;

    public function beforeTestMethod($method)
    {
        # Somehow autoload doesn't find it...
        require 'vendor/hybridauth/hybridauth/hybridauth/Hybrid/User_Profile.php';

        $this->userProviderMapper = new \mock\Dibber\Mapper\UserProvider($this->dm);
    }

    public function testFindUserByProviderId()
    {
        $this
            ->assert('FindByOne is called on parent')
                ->if($userProvider = new \mock\Dibber\Document\UserProvider)
                ->and($this->userProviderMapper->getMockController()->findOneBy = function(array $criteria) use ($userProvider) {
                    return $userProvider;
                } )
                ->and($providerId = '4242')
                ->and($provider = 'provider')
                ->then
                   ->object($this->userProviderMapper->findUserByProviderId($providerId, $provider))
                       ->isInstanceOf('Dibber\Document\UserProvider')
                   ->mock($this->userProviderMapper)
                       ->call('findOneBy')->withArguments(['providerId' => $providerId, 'provider' => $provider])->once()
        ;
    }
}