<?php

namespace Pronit\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\CoreBundle\Entity\Documentos\ClasificadorItem;

/**
 * @author ldelia
 */
class LoadClasificadorItem extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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
            array( "codigo" => "100", "nombre" => "Pedido de compra"),
            array( "codigo" => "101", "nombre" => "Entrada de materiales por compra"),
            array( "codigo" => "122", "nombre" => "Devolución de mercancías al proveedor"),
            array( "codigo" => "109", "nombre" => "Compensación EM/RF"),
            array( "codigo" => "110", "nombre" => "Compensación EM/RF"),
            array( "codigo" => "102", "nombre" => "Recepción de factura compra"),
            array( "codigo" => "107", "nombre" => "Entrada de materiales por bonificaciones"),
            array( "codigo" => "104", "nombre" => "Entrada de materiales en consignación"),
            array( "codigo" => "108", "nombre" => "Entrada de materiales por recuento de inventario"),
            array( "codigo" => "301", "nombre" => "Traslado interno de materiales"),
            array( "codigo" => "400", "nombre" => "Consumo de materiales por producción"),
        );
        
        foreach( $values as $value ){
            $obj = new ClasificadorItem();
            $obj->setCodigo($value['codigo']);
            $obj->setNombre($value['nombre']);
            
            $manager->persist($obj);
            
            $this->addReference('pronit-documentos-clasificadoritem-' . $value['codigo'], $obj);        
        }
        
        $manager->flush();
    }
    
    function getOrder()
    {
        return 12; 
    }
}
