<?php

namespace Pronit\ComprasBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\ComprasBundle\Entity\EntradasMercancias\EntradaMercancias;
use Pronit\ComprasBundle\Entity\EntradasMercancias\ItemEntradaMercancias;

/**
 * @author ldelia
 */
class LoadEntradaMercancias extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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
        
        $sociedad = $this->getReference('pronit-estructuraempresa-sociedadfi');
        $moneda = $this->getReference('pronit-parametrizaciongeneral-moneda-pesos');
        
        $clasificador = $this->getReference('pronit-documentos-clasificadoritem-101');
        $material = $this->getReference('pronit-gestionmateriales-material-610615008');
        
        $item = new ItemEntradaMercancias();
        $item->setClasificador($clasificador);        
        $item->setCantidad(4);        
        $item->setMaterial($material);
        $item->setPrecioUnitario(5.5);
        
        $entradaMercancias = new EntradaMercancias($sociedad, "0001/1", new \DateTime(), $moneda);
        $entradaMercancias->addItemEntradaMercancias($item);
        
        $manager->persist($entradaMercancias);
        
        $manager->flush();
    }
    
    function getOrder()
    {
        return 81; 
    }
}