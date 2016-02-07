<?php

namespace Pronit\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\CoreBundle\Entity\Controlling\CentroCosto;
use Pronit\CoreBundle\Entity\Controlling\CentroBeneficio;
use Pronit\CoreBundle\Entity\Controlling\Orden;

/**
 * @author ldelia
 */
class LoadObjetoCosto extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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

        $valuesCentroCosto =  array(
            array( "nombre" => "Gastos de Administración"),
            array( "nombre" => "Pintura y acabado"),
            array( "nombre" => "Gastos financieros"),
        );
        
        foreach( $valuesCentroCosto as $value ){
            
            $obj = new CentroCosto();
            $obj->setNombre( $value['nombre'] );
            
            $manager->persist($obj);
            
            $this->addReference('pronit-core-controlling-centrocosto-' . $value['nombre'], $obj);        
        }       
        
        $valuesCentroBeneficio =  array(
            array( "nombre" => "Servicio de Atención al Cliente"),
            array( "nombre" => "Alquiler de instrumentos"),
            array( "nombre" => "Alquiler de inmueble"),
        );
        
        foreach( $valuesCentroBeneficio as $value ){
            
            $obj = new CentroBeneficio();
            $obj->setNombre( $value['nombre'] );
            
            $manager->persist($obj);
            
            $this->addReference('pronit-core-controlling-centrobeneficio-' . $value['nombre'], $obj);        
        }       

        $valuesOrden =  array(
            array( "nombre" => "Anvil para guitarra"),
            array( "nombre" => "Anvil para teclado"),
            array( "nombre" => "Anvil para pedalera"),
        );        
        
        foreach( $valuesOrden as $value ){
            
            $obj = new Orden();
            $obj->setNombre( $value['nombre'] );
            
            $manager->persist($obj);
            
            $this->addReference('pronit-core-controlling-orden-' . $value['nombre'], $obj);        
        }               
                
        $manager->flush();
    }
    
    function getOrder()
    {
        return 15; 
    }
}
