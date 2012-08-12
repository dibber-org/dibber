<?php
namespace Dibber\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM
 ,  Dibber\Document\Traits;

/** @ODM\Document(collection="users") */
class User extends Base
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
     */
    public $places;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->places = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param Place $place
     * @return mixed
     */
    public function addPlace(Place $place)
    {
        $this->places[] = $place;
        $place->users[] = $this;
        return $this;
    }
}