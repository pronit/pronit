<?php

namespace Pronit\CustomizingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\CustomizingBundle\Entity\Operaciones\AsociacionOperacionClasificadorItem;

/**
 * @author gcaseres
 */
class LoadAsociacionOperacionClasificadorItemEntradaMercancias extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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
            array( "codigo" => "101", "operacion" => "BSX"),         
            array( "codigo" => "101", "operacion" => "WRX"),
            array( "codigo" => "101", "operacion" => "PRD+"),
            array( "codigo" => "101", "operacion" => "PRD-"),
            array( "codigo" => "101", "operacion" => "BSD+"),
            array( "codigo" => "101", "operacion" => "BSD-"),
        );
        
        foreach( $values as $value ){
            
            $clasificador = $this->getReference('pronit-documentos-clasificadoritementradamercancias-' . $value['codigo']);
            $operacion = $this->getReference('pronit-core-operacion-' . $value['operacion'] );
            
            $obj = new AsociacionOperacionClasificadorItem();
            $obj->setClasificador($clasificador);
            $obj->setOperacion($operacion);

            $this->setReference('pronit-customizing-asociacionoperacionclasificadoritem-' . $value['codigo'] . $value['operacion'], $obj);
        
            $manager->persist($obj);            
        }
        
        $manager->flush();
    }
    
    function getOrder()
    {
        return 61; 
    }
}
