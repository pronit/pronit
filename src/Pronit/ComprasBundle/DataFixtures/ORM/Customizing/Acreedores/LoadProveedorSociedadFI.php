<?php

namespace Pronit\ComprasBundle\DataFixtures\ORM\Customizing\Acreedores;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\ComprasBundle\Entity\Customizing\Acreedores\ProveedorSociedadFI;

/**
 * @author ldelia
 */
class LoadProveedorSociedadFI extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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
        
        $proveedorSociedadFI = new ProveedorSociedadFI();
        $proveedorSociedadFI->setAcreedor($this->getReference('pronit-core-proveedor-Delía'));
        $proveedorSociedadFI->setCodigo('DEL');
        $proveedorSociedadFI->setMonedaPedido($this->getReference('pronit-parametrizaciongeneral-moneda-pesos'));
        $proveedorSociedadFI->setSociedadFI($this->getReference( 'pronit-estructuraempresa-sociedadfi' ));
                
        $manager->persist($proveedorSociedadFI);
        
        $manager->flush();
        
        $this->addReference('pronit-compras-customizing-acreedor-proveedorsociedadfi-delía', $proveedorSociedadFI);
    }
    
    function getOrder()
    {
        return 80; 
    }
}
