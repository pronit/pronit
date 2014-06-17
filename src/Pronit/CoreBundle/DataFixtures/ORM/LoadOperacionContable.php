<?php

namespace Pronit\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\CoreBundle\Entity\Contabilidad\OperacionContable;

/**
 * @author ldelia
 */
class LoadOperacionContable extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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
            array( "codigo" => "BSX", "nombre" => "Contabilización de inventario", "claveContabilizacion" => 89, "nombreFuncion" => "OP_BSX" ),
            array( "codigo" => "WRX", "nombre" => "EM/RF abierta", "claveContabilizacion" => 96, "nombreFuncion" => "OP_WRX" ),
            array( "codigo" => "WRZ", "nombre" => "EM/RF concluida", "claveContabilizacion" => 86, "nombreFuncion" => "OP_BSX" ),
            array( "codigo" => "J1A1", "nombre" => "IVA soportado", "claveContabilizacion" => 40, "nombreFuncion" => "OP_BSX" ),
            array( "codigo" => "PRM", "nombre" => "Dif. de cambio R-", "claveContabilizacion" => 40, "nombreFuncion" => "OP_BSX" ),
            array( "codigo" => "PRG", "nombre" => "Dif. de cambio R+", "claveContabilizacion" => 50, "nombreFuncion" => "OP_BSX" ),
            array( "codigo" => "PRD-", "nombre" => "Dif. de precio negat", "claveContabilizacion" => 83, "nombreFuncion" => "OP_BSX" ),
            array( "codigo" => "PRD+", "nombre" => "Dif. de precio posit", "claveContabilizacion" => 93, "nombreFuncion" => "OP_BSX" ),
        );
        
        foreach( $values as $value ){
            
            $obj = new OperacionContable();
            $obj->setCodigo($value['codigo']);
            $obj->setNombre($value['nombre']);
            $obj->setClaveContabilizacion( $this->getReference( 'pronit-core-clavecontabilizacion-' . $value["claveContabilizacion"] ) );
            $obj->setFuncion( $this->getReference( 'pronit-automatizacion-funcion-' . $value["nombreFuncion"] ) );
            $obj->setContextosAceptados( array( 'Compras.ItemDocumentoEntradaMercancias' ) );
        
            $manager->persist($obj);
            
            $this->addReference('pronit-core-operacion-' . $value['codigo'], $obj);        
        }
        
        $manager->flush();
    }
    
    function getOrder()
    {
        return 11; 
    }
}