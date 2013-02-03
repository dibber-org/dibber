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
        parent::beforeTestMethod($method);

        # Somehow autoload doesn't find it...
        require 'vendor/hybridauth/hybridauth/hybridauth/Hybrid/User_Profile.php';

        $this->userProviderMapper = new \mock\Dibber\Mapper\UserProvider($this->dm);
    }

    public function testFindUserByProviderId()
    {
        $this
            ->assert('FindOneBy is called on parent and UserProvider returned')
                ->if($userProvider = new \mock\Dibber\Document\UserProvider)
                ->and($this->userProviderMapper->getMockController()->findOneBy = function(array $criteria) use ($userProvider) {
                    return $userProvider;
                } )
                ->and($providerId = '4242')
                ->and($provider = 'provider')
                ->then
                   ->object($this->userProviderMapper->findUserByProviderId($providerId, $provider))
                       ->isInstanceOf('Dibber\Document\UserProvider')
                       ->isIdenticalTo($userProvider)
                   ->mock($this->userProviderMapper)
                       ->call('findOneBy')->withArguments(['providerId' => $providerId, 'provider' => $provider])->once()
        ;
    }

    public function testFindProviderByUser()
    {
        $this
            ->assert('FindOneBy is called on parent and UserProvider returned')
                ->if($userProvider = new \mock\Dibber\Document\UserProvider)
                ->and($this->userProviderMapper->getMockController()->findOneBy = function(array $criteria) use ($userProvider) {
                    return $userProvider;
                } )
                ->and($user = new Document\User)
                ->and($provider = 'provider')
                ->then
                   ->object($this->userProviderMapper->findProviderByUser($user, $provider))
                       ->isInstanceOf('Dibber\Document\UserProvider')
                       ->isIdenticalTo($userProvider)
                   ->mock($this->userProviderMapper)
                       ->call('findOneBy')->withArguments(['userId' => $user->getId(), 'provider' => $provider])->once()
        ;
    }

    /**
     * @todo find a way to test findBy* document repository methods. Error :
     * Error FATAL ERROR in /var/www/dibber/dibber/tests/Dibber/Tests/Units/Mapper/UserProvider.php on unknown line, generated by file /var/www/dibber/dibber/vendor/doctrine/mongodb-odm/lib/Doctrine/ODM/MongoDB/DocumentRepository.php on line 201:
     * Call to a member function hasField() on a non-object
     */
    public function testFindProvidersByUser()
    {
//        $this
//            ->assert('FindBy is called on repository and array of UserProvider returned')
//                ->if($userProvider = new \mock\Dibber\Document\UserProvider)
//                ->and($repository = $this->mockGetRepository($this->userProviderMapper))
//                ->and($repository->getMockController()->findBy = function(array $criteria) use ($userProvider) {
//                    return [$userProvider, $userProvider];
//                } )
//                ->and($user = new Asset\Document\User)
//                ->then
//                   ->array($this->userProviderMapper->findProvidersByUser($user))
//                       ->strictlyContainsValues([$userProvider, $userProvider])
//                   ->mock($repository)
//                       ->call('findBy')->withArguments(['userId' => $user->getId()])->once()
//        ;
    }

    public function testLinkUserToProvider()
    {

    }
}