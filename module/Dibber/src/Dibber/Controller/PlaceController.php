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
use Dibber\Service\ServiceProviderTrait;

class PlaceController extends AbstractActionController implements ServiceAwareInterface
{
    use ServiceProviderTrait;

    /**
     * Public place page
     */
    public function indexAction()
    {
        return new ViewModel( [
            'place' => $this->params('place')
        ] );
    }

    public function listAction()
    {
        // @todo paginator with MongoDB?
//        $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\Array());
//        $paginator->setCurrentPageNumber($this->params('page'));

        $places = $this->getService()->getMapper()->findAll(['name']); // @todo sortBy not working

        return new ViewModel( [
            'places' => $places
        ] );
    }

    /**
     * @return \Dibber\Service\Place
     */
    public function getService()
    {
        if (null === $this->service) {
            $this->service = $this->getServiceLocator()->get('dibber_place_service');
        }

        return $this->service;
    }
}
