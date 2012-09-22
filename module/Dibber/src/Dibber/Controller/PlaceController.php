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
 ,  Zend\View\Model\ViewModel;

class PlaceController extends AbstractActionController
{
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

        /* @var $dm \Doctrine\ODM\MongoDB\DocumentManager */
        $dm = $this->getServiceLocator()->get('doctrine.documentmanager.odm_default');
        $placeMapper = new \Dibber\Document\Mapper\Place($dm);
        $places = $placeMapper->findAll(['name']); // @todo sortBy not working

        return new ViewModel( [
            'places' => $places
        ] );
    }
}
