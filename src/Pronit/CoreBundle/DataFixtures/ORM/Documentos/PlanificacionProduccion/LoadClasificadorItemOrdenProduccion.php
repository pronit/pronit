<?php

namespace Pronit\CoreBundle\DataFixtures\ORM\Documentos\PlanificacionProduccion;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Pronit\CoreBundle\Entity\Documentos\PlanificacionProduccion\OrdenProduccion\ClasificadorItemOrdenProduccion;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * @author ldelia
 */
class LoadClasificadorItemOrdenProduccion extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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
            array( "codigo" => "601", "nombre" => "Item Material Directo de Orden de Producción")
        );
        
        foreach( $values as $value ){
            $obj = new ClasificadorItemOrdenProduccion();
            $obj->setCodigo($value['codigo']);
            $obj->setNombre($value['nombre']);
            
            $manager->persist($obj);
            
            $this->addReference('pronit-documentos-planificacionproduccion-ordenproduccion-clasificadoritemordenproduccion-' . $value['codigo'], $obj);
        }
        
        $manager->flush();
    }
    
    function getOrder()
    {
        return 14; 
    }
}
