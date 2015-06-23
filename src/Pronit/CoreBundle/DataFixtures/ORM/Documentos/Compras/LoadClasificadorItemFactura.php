<?php

namespace Pronit\CoreBundle\DataFixtures\ORM\Documentos\Compras;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\ComprasBundle\Entity\Documentos\Facturas\ClasificadorItemFactura;

/**
 * @author ldelia
 */
class LoadClasificadorItemFactura extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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
            array( "codigo" => "102", "nombre" => "Recepción de factura compra")
        );
        
        foreach( $values as $value ){
            $obj = new ClasificadorItemFactura();
            $obj->setCodigo($value['codigo']);
            $obj->setNombre($value['nombre']);
            
            $manager->persist($obj);
            
            $this->addReference('pronit-documentos-clasificadoritemfactura-' . $value['codigo'], $obj);        
        }
        
        $manager->flush();
    }
    
    function getOrder()
    {
        return 15; 
    }
}
