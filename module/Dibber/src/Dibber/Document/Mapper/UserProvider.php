<?php
namespace Dibber\Document\Mapper;

use Doctrine\ODM\MongoDB\DocumentManager;
use ScnSocialAuthDoctrineMongoODM\Options\ModuleOptions;
use ZfcUser\Entity\UserInterface;

class UserProvider extends Base implements \ScnSocialAuth\Mapper\UserProviderInterface
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
        $userProvider = $this->findOneBy(['providerId' => (string) $providerId, 'provider' => $provider]);

        $this->getEventManager()->trigger('find', $this, array('document' => $userProvider));

        return $userProvider;
    }

    /**
     * @param  UserInterface               $user
     * @param  string                      $provider
     * @return UserProviderInterface|false
     */
    public function findProviderByUser(UserInterface $user, $provider)
    {
        $userProvider = $this->findOneBy( [
            'userId' => $user->getId(),
            'provider' => $provider,
        ] );

        $this->getEventManager()->trigger('find', $this, array('document' => $userProvider));

        return $userProvider;
    }

    /**
     * @param  UserInterface $user
     * @return array
     */
    public function findProvidersByUser(UserInterface $user)
    {
        $userProviders = $this->getRepository()->findByUserId($user->getId());

        $return = array();
        foreach ($userProviders as $userProvider) {
            $return[$userProvider->getProvider()] = $userProvider;
            $this->getEventManager()->trigger('find', $this, array('document' => $userProvider));
        }

        return $return;
    }

    /**
     * @param   UserInterface       $user
     * @param   Hybrid_User_Profile $hybridUserProfile
     * @param   string              $provider
     * @param   array               $accessToken
     */
    public function linkUserToProvider(UserInterface $user, Hybrid_User_Profile $hybridUserProfile, $provider, array $accessToken = null)
    {
        $userProvider = $this->findUserByProviderId($hybridUserProfile->identifier, $provider);

        if (false != $userProvider) {
            if ($user->getId() == $userProvider->getUserId()) {
                // already linked
                return;
            }
            throw new Exception\RuntimeException('This ' . ucfirst($provider) . ' profile is already linked to another user.');
        }

        $userProvider = $this->createDocument();
        $userProvider->setUserId($user->getId())
                     ->setProviderId($hybridUserProfile->identifier)
                     ->setProvider($provider);
        $this->save($userProvider);
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