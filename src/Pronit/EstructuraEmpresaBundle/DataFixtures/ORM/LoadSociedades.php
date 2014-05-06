<?php

namespace Pronit\EstructuraEmpresaBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\EstructuraEmpresaBundle\Entity\SociedadFI;

/**
 * @author ldelia
 */
class LoadSociedades extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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
        
        $sociedadFI = new SociedadFI();
        $sociedadFI->setNombre( "Sociedad FI" );
        $sociedadFI->setAbreviatura("SFI");
        $sociedadFI->setNombreFantasia("SFI Fantasía");
        $sociedadFI->setFechaFundacion(new \DateTime());
        $sociedadFI->setActiva(true);        
        
        $manager->persist($sociedadFI);
        
        $manager->flush();
        
        $this->addReference('pronit-estructuraempresa-sociedadfi', $sociedadFI);                
    }
    
    function getOrder()
    {
        return 20; 
    }
}
