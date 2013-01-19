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
use Dibber\Mapper;

class MongoController extends AbstractActionController
{
    public function indexAction()
    {
        /* @var $dm \Doctrine\ODM\MongoDB\DocumentManager */
        $dm = $this->getServiceLocator()->get('doctrine.documentmanager.odm_default');

        $userMapper = new Mapper\User($dm);
        $jhuet = $userMapper->save( [
            'name' => 'Jérémy Huet',
            'login' => 'jhuet',
            'password' => 'toto42',
            'email' => 'jeremy.huet+dibber@gmail.com',
        ] );

        $qsnr = new Document\User;
        $qsnr->setName('Shawna Green')
             ->setLogin('qsnr2004')
             ->setPassword('42toto')
             ->setEmail('qsnr2004+dibber@gmail.com');
        $userMapper->save($qsnr);

        $potaje = new Document\Place;
        $dm->getHydratorFactory()->hydrate($potaje, [
            'name' => 'Pot\' à Jé',
            'coordinates' => [
                'latitude' => 48.992341,
                'longitude' => 2.108106
            ],
            'surfaceSize' => 1,
            'surfaceUnit' => 'ha'
        ] );
        $potaje->addUser($jhuet)
               ->addUser($qsnr);
        $dm->persist($potaje);

        $zone1 = new Document\Zone;
        $zone1->setName('Zone 1')
              ->setSurfaceSize(1000)
              ->setSurfaceUnit('m²')
              ->setParent($potaje);
        $dm->persist($zone1);

        $field11 = new Document\Field;
        $dm->getHydratorFactory()->hydrate($field11, [
            'name' => 'Field 1.1',
            'surfaceSize' => 0.2,
            'surfaceUnit' => 'ha'
        ] );
        $field11->setParent($zone1);
        $dm->persist($field11);

        $field12 = new Document\Field;
        $dm->getHydratorFactory()->hydrate($field12, [
            'name' => 'Field 1.2',
            'surfaceSize' => 0.3,
            'surfaceUnit' => 'ha'
        ] );
        $field12->setParent($zone1);
        $dm->persist($field12);

        $dm->flush();

//        $dm = $this->getServiceLocator()->get('doctrine.documentmanager.odm_default');
//        $repo = $dm->getRepository('Dibber\Document\Zone');
//        $repo->getChildren($zone1);

        die('<pre>'.var_export($zone1->getPath(), true).'</pre>'."\n");

        die;


        /* @var $place Document\Place */
        $place = $dm->getRepository('Dibber\Document\Place')->findOneBy(['login' => 'a-verrieres']);
        $place->setName('A Verrieres');
        $dm->persist($place);
        $dm->flush();
//        die($place->getUpdatedAt()->format('d/m/Y H:i:s'));

        $newPlace = new Document\Place;
        $dm->getHydratorFactory()->hydrate($newPlace, [
            'name' => 'A Conflans',
            'users' => [
                'id' => '501e902f6803fa4e2c000000'
            ]
        ] );
        $newPlace->setUsers($newPlace->getUsers());
        $dm->persist($newPlace);
        $dm->persist($newPlace->getUsers()[0]);
        $dm->flush();

        /* @var $place Document\Place */
        $place = $dm->getRepository('Dibber\Document\Place')->findOneBy(['login' => 'a-verrieres']);

        /* @var $user Document\User */
        $user = $dm->getRepository('Dibber\Document\User')->findOneBy(['login' => 'jhuet']);
        if ($place && $user) {
            $place->setCoordinates(new Document\Coordinates(0.01, 0.02));
            $user->setPassword('toto42');
//            $place->addUser($user);

            $dm->persist($place);
            $dm->flush();
        }

        $place = new Document\Place;
        $place->setName('Da supah place');

        $field = new Document\Field;
        $field->setName('Field 1')
              ->setSurfaceSize(42)
              ->setSurfaceUnit('m²');

        $zone = new Document\Zone;
        $zone->setName('Zone 1')
              ->setSurfaceSize(420)
              ->setSurfaceUnit('m²');

//        $zone->addThing($field);
//        $place->addThing($zone);

        $dm->persist($place);
        $dm->flush();

        /* @var $place Document\Place */
        $place = $dm->getRepository('Dibber\Document\Place')->findOneBy(['login' => 'a-verrieres']);
//        foreach ($place->getThings() as $thing) {
//            echo $thing -> getName() . '<br />';
//        }

        return new ViewModel();
    }
}
