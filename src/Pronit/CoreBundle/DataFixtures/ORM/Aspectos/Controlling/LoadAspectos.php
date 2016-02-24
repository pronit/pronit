<?php

namespace Pronit\CoreBundle\DataFixtures\ORM\Aspectos\Controlling;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pronit\CoreBundle\Entity\Operaciones\OperacionContable;
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
    public function setContainer(ContainerInterface $container = null) 
    {
        $this->container = $container;
    }

    public function getManager() 
    {
        return $this->manager;
    }

    public function setManager(ObjectManager $manager) 
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) 
    {
        $this->setManager($manager);
        
        $operacionBSX = $this->getReference('pronit-core-operacion-BSX');

        $this->container->get('pronit_core.imputa_objeto_costos_manager')->set( $operacionBSX );
        
        $manager->flush();
    }

    function getOrder() {
        return 12;
    }

}
