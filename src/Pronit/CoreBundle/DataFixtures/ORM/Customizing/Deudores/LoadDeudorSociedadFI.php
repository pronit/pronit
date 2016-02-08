<?php

namespace Pronit\CoreBundle\DataFixtures\ORM\Customizing\Deudores;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\CoreBundle\Entity\Customizing\Deudores\DeudorSociedadFI;

/**
 * @author ldelia
 */
class LoadDeudorSociedadFI extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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
        
        $deudorSociedadFI = new DeudorSociedadFI();
        $deudorSociedadFI->setDeudor($this->getReference('pronit-core-deudor-Arana'));
        $deudorSociedadFI->setCodigo('26250958');
        $deudorSociedadFI->setSociedadFI($this->getReference( 'pronit-estructuraempresa-sociedadfi-modelosa' ));
                
        $manager->persist($deudorSociedadFI);
        
        $manager->flush();
        
        $this->addReference('pronit-compras-customizing-deudores-deudorsociedadfi-Arana', $deudorSociedadFI);
    }
    
    function getOrder()
    {
        return 80; 
    }
}
