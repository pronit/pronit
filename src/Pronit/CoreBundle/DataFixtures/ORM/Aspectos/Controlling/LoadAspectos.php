<?php

namespace Pronit\CoreBundle\DataFixtures\ORM\Aspectos\Controlling;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author ldelia
 */
class LoadAspectos extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {

    /**
     * @var ContainerInterface
     */
    private $container;
    private $manager;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function getManager() {
        return $this->manager;
    }

    public function setManager(ObjectManager $manager) {
        $this->manager = $manager;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        $this->setManager($manager);
        $objetoCostoAspectoManager = $this->container->get('pronit.controlling.aspectos.manager.imputa_objetoscosto');

        $operacionBSX = $this->getReference('pronit-core-operacion-BSX');
        $objetoCostoAspectoManager->set($operacionBSX);
        
        $operacionCOE = $this->getReference('pronit-core-operacion-COE');
        $objetoCostoAspectoManager->set($operacionCOE);

        $operacionCOR = $this->getReference('pronit-core-operacion-COR');
        $objetoCostoAspectoManager->set($operacionCOR);
        
        $manager->flush();
    }

    function getOrder() {
        return 12;
    }

}
