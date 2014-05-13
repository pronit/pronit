<?php

namespace Pronit\ParametrizacionGeneralBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\ParametrizacionGeneralBundle\Entity\Moneda;

/**
 * @author ldelia
 */
class LoadMonedas extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
{
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
        
        $moneda = new Moneda();
        $moneda->setNombre("Peso");
        $moneda->setCodigoISO("ARS");
        $moneda->setAbreviatura("Peso");
        $moneda->setSignoMonetario("$");
                
        $manager->persist($moneda);
        
        $this->addReference('pronit-parametrizaciongeneral-moneda-pesos', $moneda);
        
        $manager->flush();
    }
    
    function getOrder()
    {
        return 10; 
    }
}
