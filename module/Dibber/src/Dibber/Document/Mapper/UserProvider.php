<?php
namespace Dibber\Document\Mapper;

use \Doctrine\ODM\MongoDB\DocumentManager;

class UserProvider extends Base implements \ScnSocialAuthDoctrineMongoODM\Mapper\UserProviderInterface
{
    /**
     * @var \ScnSocialAuthDoctrineMongoODM\Options\ModuleOptions
     */
    protected $options;

    /**
     * @param \Doctrine\ODM\MongoDB\DocumentManager $dm
     */
    public function __construct(DocumentManager $dm = null, ModuleOptions $options)
    {
        parent::__construct('Dibber\Document\UserProvider', $dm);

        $this->options = $options;
    }

    public function findUserByProviderId($providerId, $provider)
    {
        $dr = $this->dm->getRepository($this->options->getUserProviderEntityClass());
        $document = $dr->findOneBy(array('providerId' => (string) $providerId, 'provider' => $provider));
        return $document;
    }

    /**
     * Used to comply with ScnSocialAuth UserProviderInterface
     *
     * @param \Dibber\Document\UserProvider $userProvider
     * @return \Dibber\Document\UserProvider
     */
    public function insert($userProvider) {
        return $this->save($userProvider, true);
    }

    /**
     * Used to comply with ScnSocialAuth UserProviderInterface
     *
     * @param \Dibber\Document\UserProvider $userProvider
     * @return \Dibber\Document\UserProvider
     */
    public function update($userProvider) {
        return $this->save($userProvider, true);
    }
}