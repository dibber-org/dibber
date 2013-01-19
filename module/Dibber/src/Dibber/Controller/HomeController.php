<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Dibber\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Dibber\Document;

class HomeController extends AbstractActionController
{
    /**
     * Guess if a user or a place has been queried and forward to the according
     * controller and action if found. Otherwise, generate a 404 HTTP error.
     */
    public function indexAction()
    {
        $login = $this->params('login');

        # Check if it is a User
        /* @var $userMapper \Dibber\Mapper\User */
        $userMapper = $this->getServiceLocator()->get('dibber_user_mapper');
        $user = $userMapper->findByLogin($login);
        if ($user instanceof Document\User) {
            return $this->forward()->dispatch('Dibber\Controller\User', ['action' => 'index', 'user' => $user]);
        }

        # Check if it is a Place
        /* @var $placeMapper \Dibber\Mapper\Place */
        $placeMapper = $this->getServiceLocator()->get('dibber_place_mapper');
        $place = $placeMapper->findByLogin($login);
        if ($place instanceof Document\Place) {
            return $this->forward()->dispatch('Dibber\Controller\Place', ['action' => 'index', 'place' => $place]);
        }

        # None found, generate 404 HTTP error
        $this->getResponse()->setStatusCode(404);
    }
}
