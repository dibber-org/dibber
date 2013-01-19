<?php
namespace Dibber\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Dibber\Document\Traits;

/** @ODM\Document(collection="users_providers") */
class UserProvider extends Base implements \ScnSocialAuth\Entity\UserProviderInterface
{
    const COLLECTION = 'users_providers';

    /** @ODM\String */
    protected $userId;

    /** @ODM\String */
    protected $providerId;

    /** @ODM\String */
    protected $provider;

//    /**
//     *  @ODM\ReferenceOne(
//     *      targetDocument="User",
//     *      sort={"name"},
//     *      cascade={"persist"},
//     *      simple=true
//     *  )
//     */
//    public $user;

    /**
     * @param string $userId
     * @return UserProvider
     */
    public function setUserId($userId) {
        $this->userId = (string) $userId;
        return $this;
    }

    /**
     * @return string the $userId
     */
    public function getUserId() {
        return $this->userId;
    }

    /**
     * @param string $providerId
     * @return UserProvider
     */
    public function setProviderId($providerId) {
        $this->providerId = (string) $providerId;
        return $this;
    }

    /**
     * @param string $providerId
     * @return UserProvider
     */
    public function getProviderId() {
        return $this->providerId;
    }

    /**
     * @param string $provider
     * @return UserProvider
     */
    public function setProvider($provider) {
        $this->provider = (string) $provider;
        return $this;
    }

    /**
     * @return string the $provider
     */
    public function getProvider()
    {
        return $this->provider;
    }
}