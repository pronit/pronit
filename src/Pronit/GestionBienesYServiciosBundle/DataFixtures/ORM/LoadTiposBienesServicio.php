<?php

namespace Pronit\GestionBienesYServiciosBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\GestionBienesYServiciosBundle\Entity\TipoMaterial;
use Pronit\GestionBienesYServiciosBundle\Entity\TipoServicio;

/**
 * @author ldelia
 */
class LoadTiposBienesServicios extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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

        $this->loadTiposMaterial();
        $this->loadTiposServicio();
        
        $manager->flush();               
    }   
    
    public function loadTiposMaterial()
    {
        $tipoMateriales = array(
            array('nombre' => "Materia Prima", 'codigo'=> 'materiaprima'),
            array('nombre' => "Producto Elaborado", 'codigo'=> 'productoelaborado'),
        );
        
        foreach( $tipoMateriales as $v ){
            
            $tipo = new TipoMaterial();
            $tipo->setNombre( $v['nombre'] );
        
            $this->manager->persist($tipo);
            
            $this->addReference('pronit-gestionbienesyservicios-tipobienservicio-' . $v['codigo'], $tipo);        
        }        
    }
    
    public function loadTiposServicio()
    {
        $tipoServicios = array(
            array('nombre' => "Consultoría Software", 'codigo'=> 'consultoria'),
            array('nombre' => "Limpieza", 'codigo'=> 'limpieza'),
        );
        
        foreach( $tipoServicios as $v ){
            
            $tipo = new TipoServicio();
            $tipo->setNombre( $v['nombre'] );
        
            $this->manager->persist($tipo);
            
            $this->addReference('pronit-gestionbienesyservicios-tipobienservicio-' . $v['codigo'], $tipo);        
        }        
    }
            
    function getOrder()
    {
        return 71; 
    }
}
