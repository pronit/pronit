<?php

namespace Pronit\ComprasBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\ComprasBundle\Entity\Pedido;
use Pronit\ComprasBundle\Entity\ItemPedido;

/**
 * @author ldelia
 */
class LoadPedidos extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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
        $escala = $this->getReference('pronit-parametrizaciongeneral-escala-metro');
        $material = $this->getReference('pronit-gestionmateriales-materialmm001');
        
        $pedido = new Pedido($sociedad, "3445/5", new \DateTime(), $moneda);
        $pedido->addItemPedido( new ItemPedido( $material, 4, $escala, 9.9  ) );
                
        $manager->persist($pedido);
        
        $manager->flush();
    }
    
    function getOrder()
    {
        return 50; 
    }
}
