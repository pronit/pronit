<?php

namespace Pronit\ContabilidadBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\ContabilidadBundle\Entity\Customizing\AsignacionOperacionCuenta;

/**
 * @author ldelia
 */
class LoadAsignacionOperacionCuenta extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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
            array( "cuenta" => "150102", "operacion" => "BSX" ),
            array( "cuenta" => "210102", "operacion" => "WRX" ),
            array( "cuenta" => "210102", "operacion" => "WRZ" ),
            array( "cuenta" => "140108", "operacion" => "J1A1" ),
            array( "cuenta" => "190101", "operacion" => "PRM" ),
            array( "cuenta" => "510192", "operacion" => "PRG" ),
            array( "cuenta" => "190102", "operacion" => "PRD-" ),
            array( "cuenta" => "510193", "operacion" => "PRD+" ),
            array( "cuenta" => "150102", "operacion" => "BSD-" ),
            array( "cuenta" => "150102", "operacion" => "BSD+" ),
        );
                
        /** @todo Crear plan de cuentas */
        
        foreach( $values as $value ){
            
            $cuenta = $this->getReference('pronit-contabilidad-cuenta-' . $value["cuenta"]);
            $operacion = $this->getReference('pronit-core-operacion-' . $value["operacion"]);
            
            $obj = new AsignacionOperacionCuenta();
            $obj->setCuenta($cuenta);
            $obj->setOperacion($operacion);
        
            $manager->persist($obj);            
        }
        
        $manager->flush();
    }
    
    function getOrder()
    {
        return 51; 
    }
}
