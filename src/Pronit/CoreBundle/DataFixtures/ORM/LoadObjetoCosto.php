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
            array( "nombre" => "Gastos de Administración","validezDesde" => "2016-01-01", "validezHasta" => "2017-01-01", "cuentaContable" => "710195"),
            array( "nombre" => "Pintura","validezDesde" => "2016-01-01", "validezHasta" => "2017-01-01", "cuentaContable" => "150103"),
            array( "nombre" => "Gastos financieros","validezDesde" => "2016-01-01", "validezHasta" => "2017-01-01", "cuentaContable" => "710195"),
            array( "nombre" => "Investigación y Desarrollo","validezDesde" => "2016-01-01", "validezHasta" => "2017-01-01", "cuentaContable" => "810194"),
        );
        
        foreach( $valuesCentroCosto as $value ){
            
            $obj = new CentroCosto();
            $obj->setNombre( $value['nombre'] );
            $obj->setValidezDesde( new \DateTime( $value['validezDesde'] ) );
            $obj->setValidezHasta( new \DateTime( $value['validezHasta'] ) );
            $obj->setSociedadFI( $this->getReference('pronit-estructuraempresa-sociedadfi-modelosa') );
            $obj->setCuentaContable( $this->getReference('pronit-contabilidad-cuenta-' . $value["cuentaContable"]) );
            
            $manager->persist($obj);
            
            $this->addReference('pronit-core-controlling-centrocosto-' . $value['nombre'], $obj);        
        }       
        
        $valuesCentroBeneficio =  array(
            array( "nombre" => "Servicio Garantía","validezDesde" => "2016-01-01", "validezHasta" => "2017-01-01", "cuentaContable" => "610194"),
            array( "nombre" => "Alquileres","validezDesde" => "2016-01-01", "validezHasta" => "2017-01-01", "cuentaContable" => "710194"),
        );
        
        foreach( $valuesCentroBeneficio as $value ){
            
            $obj = new CentroBeneficio();
            $obj->setNombre( $value['nombre'] );
            $obj->setValidezDesde( new \DateTime( $value['validezDesde'] ) );
            $obj->setValidezHasta( new \DateTime( $value['validezHasta'] ) );
            $obj->setSociedadFI( $this->getReference('pronit-estructuraempresa-sociedadfi-modelosa') );
            $obj->setCuentaContable( $this->getReference('pronit-contabilidad-cuenta-' . $value["cuentaContable"]) );
            
            $manager->persist($obj);
            
            $this->addReference('pronit-core-controlling-centrobeneficio-' . $value['nombre'], $obj);        
        }       

        $valuesOrden =  array(
            array( "nombre" => "Renovación Planta Gonnet","validezDesde" => "2016-01-01", "validezHasta" => "2017-01-01", "cuentaContable" => "150107"),
            array( "nombre" => "Motos - HFX - Lote 120356","validezDesde" => "2016-01-01", "validezHasta" => "2017-01-01", "cuentaContable" => "150105"),
        );        
        
        foreach( $valuesOrden as $value ){
            
            $obj = new Orden();
            $obj->setNombre( $value['nombre'] );
            $obj->setValidezDesde( new \DateTime( $value['validezDesde'] ) );
            $obj->setValidezHasta( new \DateTime( $value['validezHasta'] ) );
            $obj->setSociedadFI( $this->getReference('pronit-estructuraempresa-sociedadfi-modelosa') );
            $obj->setCuentaContable( $this->getReference('pronit-contabilidad-cuenta-' . $value["cuentaContable"]) );
            
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
