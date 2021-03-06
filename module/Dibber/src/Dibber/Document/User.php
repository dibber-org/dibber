<?php
namespace Dibber\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Sds\DoctrineExtensions\Annotation\Annotations as Sds;
use Dibber\Document\Traits;

/** @ODM\Document(collection="users") */
class User extends Base implements \ZfcUser\Entity\UserInterface
{
    use Traits\ManyPlaces;

    const COLLECTION = 'users';

    /** @ODM\String */
    private $login;

    /** @ODM\String */
    private $password;

    /** @ODM\String */
    private $email;

    /** @ODM\String */
    private $name;

    /**
     *  @ODM\ReferenceMany(
     *      targetDocument="Place",
     *      sort={"name"},
     *      cascade={"persist"},
     *      simple=true
     *  )
     * @Sds\Serializer(@Sds\Eager)
     */
    private $places;

    /**
     * @var int
     */
    private $state;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->places = new \Doctrine\Common\Collections\ArrayCollection;
    }

    /**
     * Used to comply with ZfcUser UserInterface
     *
     * @param string $id
     * @throws Exception
     */
    public function setId($id) {
        throw new \Exception('It is not allowed to specifically set the ID of a document');
    }

    /**
     * @return string the $login
     */
    public function getLogin() {
        return $this->login;
    }

    /**
     * @param string $login
     * @return User
     */
    public function setLogin($login) {
        $this->login = (string) $login;
        return $this;
    }

    /**
     * Used to comply with ZfcUser UserInterface
     *
     * @return string the $login
     */
    public function getUsername() {
        return $this->getLogin();
    }

    /**
     * Used to comply with ZfcUser UserInterface
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username) {
        return $this->setLogin($username);
    }

    /**
     * @return string the $password
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param string $passsword
     * @return User
     */
    public function setPassword($passsword) {
        $this->password = (string) $passsword;
        return $this;
    }

    /**
     * @return string the $email
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail($email) {
        $this->email = (string) $email;
        return $this;
    }

    /**
     * @return string the $name
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     * @return User
     */
    public function setName($name) {
        $this->name = (string) $name;
        return $this;
    }

    /**
     * Used to comply with ZfcUser UserInterface
     *
     * @return string the $name
     */
    public function getDisplayName() {
        return $this->getName();
    }

    /**
     * Used to comply with ZfcUser UserInterface
     *
     * @param string $displayName
     * @return User
     */
    public function setDisplayName($displayName) {
        return $this->setName($displayName);
    }

    /**
     * Get state. Used to comply with ZfcUser UserInterface
     *
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set state. Used to comply with ZfcUser UserInterface
     *
     * @param int $state
     * @return User
     */
    public function setState($state)
    {
        $this->state = (int) $state;
        return $this;
    }

    /**
     * Called after a ManyPlaces::addPlace to inverse the relation
     *
     * @param Place $place
     */
    public function inverseAddPlace(Place $place)
    {
        $place->addUser($this, false);
    }

    /**
     * Called after a ManyPlaces::removePlace to inverse the removal of the
     * relation.
     *
     * @param Place $place
     */
    public function inverseRemovePlace(Place $place)
    {
        $place->removeUser($this, false);
    }
}