<?php
namespace Dibber\Document\Mapper;

use \Doctrine\ODM\MongoDB\DocumentManager;

class UserProvider extends Base implements \ScnSocialAuthDoctrineMongoODM\Mapper\UserProviderInterface
{
    /**
     * @param DocumentManager $dm
     * @param ModuleOptions $options
     */
    public function __construct(DocumentManager $dm = null, ModuleOptions $options = null)
    {
        parent::__construct('Dibber\Document\UserProvider', $dm);
    }

    /**
     * @param string $providerId
     * @param string $provider
     * @return UserProvider
     */
    public function findUserByProviderId($providerId, $provider)
    {
        return $this->findOneBy(array('providerId' => (string) $providerId, 'provider' => $provider));;
    }

    /**
     * Used to comply with ScnSocialAuth UserProviderInterface
     *
     * @param UserProvider $userProvider
     * @return UserProvider
     */
    public function insert($userProvider) {
        return $this->save($userProvider, true);
    }

    /**
     * Used to comply with ScnSocialAuth UserProviderInterface
     *
     * @param UserProvider $userProvider
     * @return UserProvider
     */
    public function update($userProvider) {
        return $this->save($userProvider, true);
    }
}