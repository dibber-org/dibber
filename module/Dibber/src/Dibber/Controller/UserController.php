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
use Zend\View\Model\ViewModel;
use Dibber\Service\ServiceAwareInterface;
use Dibber\Service\ServiceAwareTrait;

class UserController extends AbstractActionController implements ServiceAwareInterface
{
    use ServiceAwareTrait;

    /**
     * Public user page
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        return new ViewModel( [
            'user' => $this->params('user')
        ] );
    }

    /**
     * Profile page
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function profileAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('dibber/login');
        }
        return new ViewModel();
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function listAction()
    {
        // @todo paginator with MongoDB?
//        $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\Array());
//        $paginator->setCurrentPageNumber($this->params('page'));

        $users = $this->getService()->getMapper()->findAll('name');

        return new ViewModel( [
            'users' => $users
        ] );
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function registerAction()
    {
        // Attaching to register event in order to add the "user" role to the new user.
        /* @var $roleService \Dibber\Service\Role */
        $roleService = $this->getServiceLocator()->get('dibber_role_service');
        $this->getService()->getEventManager()->attach('register', [$roleService, 'onRegister']);

        return $this->forward()->dispatch('scn-social-auth-user', ['action' => 'register']);
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function providerLoginAction()
    {
        return $this->forward()->dispatch('scn-social-auth-user', ['action' => 'providerLogin', 'provider' => $this->params('provider'), 'redirect' => $this->params('redirect')]);
    }

    public function authenticateAction()
    {
        // Attaching to register event in order to add the "user" role to the new user.
        /* @var $hybridAuthAdapter \ScnSocialAuth\Authentication\Adapter\HybridAuth */
        $hybridAuthAdapter = $this->getServiceLocator()->get('ScnSocialAuth\Authentication\Adapter\HybridAuth');
        /* @var $roleService \Dibber\Service\Role */
        $roleService = $this->getServiceLocator()->get('dibber_role_service');
        $hybridAuthAdapter->getEventManager()->attach('registerViaProvider', [$roleService, 'onRegister']);

        return $this->forward()->dispatch('zfcuser', ['action' => 'authenticate', 'provider' => $this->params('provider'), 'redirect' => $this->params('redirect')]);
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function loginAction()
    {
        return $this->forward()->dispatch('scn-social-auth-user', ['action' => 'login']);
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function logoutAction()
    {
        return $this->forward()->dispatch('scn-social-auth-user', ['action' => 'logout']);
    }

    /**
     * @return \Dibber\Service\User
     */
    public function getService()
    {
        if (null === $this->service) {
            $this->service = $this->getServiceLocator()->get('dibber_user_service');
        }

        return $this->service;
    }
}
