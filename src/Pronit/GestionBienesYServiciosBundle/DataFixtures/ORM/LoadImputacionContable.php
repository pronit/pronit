<?php

namespace Pronit\GestionBienesYServiciosBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\GestionBienesYServiciosBundle\Entity\Customizing\Contabilidad\ImputacionContable;

/**
 * @author ldelia
 */
class LoadImputacionContable extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
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
            array( "asociacionOperacionClasificadorItem" => "101BSX", "categoriaValoracion" => "3000", "cuenta" => "150106"),
            array( "asociacionOperacionClasificadorItem" => "101BSX", "categoriaValoracion" => "3001", "cuenta" => "150102"),
            array( "asociacionOperacionClasificadorItem" => "101BSX", "categoriaValoracion" => "3002", "cuenta" => "150103"),
            array( "asociacionOperacionClasificadorItem" => "101BSX", "categoriaValoracion" => "3003", "cuenta" => "150101"),
        );
        
        foreach( $values as $value ){
            $categoriaValoracion = $this->getReference('pronit-gestionbienesyservicios-categoriavaloracion-' . $value['categoriaValoracion']);
            $cuenta = $this->getReference('pronit-contabilidad-cuenta-' . $value['cuenta']);
            $asociacionOperacionClasificadorItem = $this->getReference('pronit-customizing-asociacionoperacionclasificadoritem-' . $value['asociacionOperacionClasificadorItem']);
            
            $obj = new ImputacionContable();
            $obj->setAsociacionOperacionClasificadorItem($asociacionOperacionClasificadorItem);
            $obj->setCategoriaValoracion($categoriaValoracion);
            $obj->setCuenta($cuenta);
            
            $manager->persist($obj);
        }                
        
        $manager->flush();
    }
    
    function getOrder()
    {
        return 72; 
    }
}
