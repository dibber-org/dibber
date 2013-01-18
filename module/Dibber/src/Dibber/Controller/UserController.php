<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Dibber\Controller;

use Zend\View\Model\ViewModel;
use Dibber\Service\ServiceAwareInterface;
use Dibber\Service\ServiceAwareTrait;

class UserController extends \ScnSocialAuth\Controller\UserController implements ServiceAwareInterface
{
    use ServiceAwareTrait;

    /**
     * Public user page
     */
    public function indexAction()
    {
        return new ViewModel( [
            'user' => $this->params('user')
        ] );
    }

    /**
     * Profile page
     */
    public function profileAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('dibber/login');
        }
        return new ViewModel();
    }

    public function listAction()
    {
        // @todo paginator with MongoDB?
//        $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\Array());
//        $paginator->setCurrentPageNumber($this->params('page'));

        $users = $this->getService()->getMapper()->findAll(['name']); // @todo sortBy not working

        return new ViewModel( [
            'users' => $users
        ] );
    }

    public function logoutAction()
    {
        # Seems to be needed to avoid PHP warnings as auth providers aren't set otherwise
        $this->getHybridAuth();
        return parent::logoutAction();
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
