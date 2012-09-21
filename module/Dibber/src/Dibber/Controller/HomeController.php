<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Dibber\Controller;

use Zend\Mvc\Controller\AbstractActionController
 ,  Dibber\Document;

class HomeController extends AbstractActionController
{
    /**
     * Guess if a user or a place has been queried and forward to the according
     * controller and action if found. Otherwise, generate a 404 HTTP error.
     */
    public function indexAction()
    {
        /* @var $dm \Doctrine\ODM\MongoDB\DocumentManager */
        $dm = $this->getServiceLocator()->get('doctrine.documentmanager.odm_default');

        $login = $this->params('login');

        # Check if it is a User
        $userMapper = new Document\Mapper\User($dm);
        $user = $userMapper->findByLogin($login);
        if ($user instanceof Document\User) {
            return $this->forward()->dispatch('Dibber\Controller\User', array('action' => 'index', 'user' => $user));
        }

        # Check if it is a Place
        $placeMapper = new Document\Mapper\Place($dm);
        $place = $placeMapper->findByLogin($login);
        if ($place instanceof Document\Place) {
            return $this->forward()->dispatch('Dibber\Controller\Place', array('action' => 'index', 'place' => $place));
        }

        # None found, generate 404 HTTP error
        $this->getResponse()->setStatusCode(404);
    }
}
