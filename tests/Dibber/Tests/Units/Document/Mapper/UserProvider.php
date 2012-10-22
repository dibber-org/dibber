<?php
namespace Dibber\Tests\Units\Document\Mapper;

require_once(__DIR__ . '/Test.php');

use Dibber\Document
 ,  Dibber\Document\Mapper
 ,  mageekguy\atoum;

class UserProvider extends Test
{
    /** @var Document\Mapper\UserProvider */
    protected $userProviderMapper;

    public function beforeTestMethod($method)
    {
        $this->userProviderMapper = new \mock\Dibber\Document\Mapper\UserProvider($this->dm);
    }

    public function testFindUserByProviderId()
    {
        $this->assert('FindByOne is called on parent')
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
                    ->call('findOneBy')->withArguments(['providerId' => $providerId, 'provider' => $provider])->once();
    }
}