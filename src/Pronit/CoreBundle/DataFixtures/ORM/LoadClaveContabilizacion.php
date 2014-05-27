<?php

namespace Pronit\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\CoreBundle\Entity\Contabilidad\ClaveContabilizacion;

/**
 * @author ldelia
 */
class LoadClaveContabilizacion extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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
            array( "key" => 1, "nombre" => "Factura Deudor", "signo" => 1 ),
            array( "key" => 2, "nombre" => "Anular abono", "signo" => 1 ),
            array( "key" => 3, "nombre" => "Gastos", "signo" => 1 ),
            array( "key" => 40, "nombre" => "Contab.Debe", "signo" => 1 ),
            array( "key" => 50, "nombre" => "Contab.Haber", "signo" => -1 ),
            array( "key" => 83, "nombre" => "Diferencia de precio -", "signo" => 1 ),
            array( "key" => 86, "nombre" => "EM/RF Debe", "signo" => 1 ),
            array( "key" => 89, "nombre" => "Alta de inventario", "signo" => 1 ),
            array( "key" => 93, "nombre" => "Diferencia de precio +", "signo" => -1 ),
            array( "key" => 96, "nombre" => "EM/RF Haber", "signo" => -1 ),
            
        );
                
        foreach( $values as $value ){
            
            $obj = new ClaveContabilizacion();
            $obj->setNombre($value['nombre']);
            $obj->setSigno($value['signo']);
        
            $manager->persist($obj);
            
            $this->addReference('pronit-core-clavecontabilizacion-' . $value["key"], $obj);        
        }
        
        $manager->flush();
    }
    
    function getOrder()
    {
        return 40; 
    }
}
