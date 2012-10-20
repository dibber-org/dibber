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

class UserController extends \ScnSocialAuth\Controller\UserController
{
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
            return $this->redirect()->toRoute('zfcuser/login');
        }
        return new ViewModel();
    }

    public function listAction()
    {
        // @todo paginator with MongoDB?
//        $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\Array());
//        $paginator->setCurrentPageNumber($this->params('page'));

        /* @var $userMapper \Dibber\Document\Mapper\User */
        $userMapper = $this->getServiceLocator()->get('dibber_user_mapper');
        $users = $userMapper->findAll(['name']); // @todo sortBy not working

        return new ViewModel( [
            'users' => $users
        ] );
    }
}
