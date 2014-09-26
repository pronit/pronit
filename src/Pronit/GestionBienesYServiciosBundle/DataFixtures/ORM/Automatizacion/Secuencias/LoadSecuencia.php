<?php

namespace Pronit\GestionBienesYServiciosBundle\DataFixtures\ORM\Automatizacion\Secuencias;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\CoreBundle\Entity\Automatizacion\Secuencias\Secuencia;
use Pronit\CoreBundle\Entity\Automatizacion\Secuencias\Acceso;

/**
 * @author ldelia
 */
class LoadSecuencia extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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
            array(
                'descripcion' => 'Precio',
                'codigo' => 'PR-01',
                'accesos' => array(
                    array( 
                        'orden' => 10, 'tablaCondicion' => 'T1'
                    ),
                    array( 
                        'orden' => 20, 'tablaCondicion' => 'T1'
                    ),                    
                    array( 
                        'orden' => 30, 'tablaCondicion' => 'T2'
                    ),                    
                )
            ),
        );
                
        foreach( $values as $value ){
            
            $obj = new Secuencia();
            $obj->setDescripcion($value['descripcion']);
            $obj->setCodigo($value['codigo']);
            
            foreach( $value['accesos'] as $accesoValue ){
                
                $acceso = new Acceso();
                $acceso->setOrden($accesoValue['orden']);
                $acceso->setTablaCondicion( $this->getReference('pronit-core-tablacondicion-' . $accesoValue['tablaCondicion']) );
                
                $obj->addAcceso($acceso);
            }
        
            $manager->persist($obj);
        }
        
        $manager->flush();               
    }
    
    function getOrder()
    {
        return 76; 
    }
}
