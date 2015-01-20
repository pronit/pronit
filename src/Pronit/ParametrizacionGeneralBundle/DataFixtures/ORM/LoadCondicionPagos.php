<?php

namespace Pronit\ParametrizacionGeneralBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\ParametrizacionGeneralBundle\Entity\CondicionPagos;
use Pronit\ParametrizacionGeneralBundle\Entity\ItemCondicionPagos;

/**
 * @author ldelia
 */
class LoadCondicionPagos extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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
        
        $values =  array(
            array( 
                "codigo" => "2C30", 
                "nombre" => "2 cuotas a 30 días", 
                "items" => array(
                    array("cantidadDias" => 30, "porcentaje" => 50),
                    array("cantidadDias" => 30, "porcentaje" => 50),
                )
            ),
        );
                
        foreach( $values as $value ){
            
            $condicionPagos = new CondicionPagos();
            $condicionPagos->setCodigo($value['codigo']);
            $condicionPagos->setNombre($value['nombre']);
            
            foreach( $value['items'] as $item ){
                $itemCondicionPagos = new ItemCondicionPagos();
                $itemCondicionPagos->setCantidadDias( $item['cantidadDias'] );
                $itemCondicionPagos->setPorcentaje( $item['porcentaje'] );
                
                $condicionPagos->addItem($itemCondicionPagos);
            }            
            
            $manager->persist($condicionPagos);
        }
        $manager->flush();
    }
    
    function getOrder()
    {
        return 44; 
    }
}
