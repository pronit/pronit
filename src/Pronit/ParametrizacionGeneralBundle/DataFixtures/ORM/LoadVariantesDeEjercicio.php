<?php

namespace Pronit\ParametrizacionGeneralBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\ParametrizacionGeneralBundle\Entity\VarianteEjercicio;
use Pronit\ParametrizacionGeneralBundle\Entity\PeriodoVarianteEjercicio;

/**
 * @author ldelia
 */
class LoadVariantesDeEjercicio extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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
            array( "abreviatura" => "K01", "nombre" => "Enero-Diciembre 12 períodos"),
            array( "abreviatura" => "K02", "nombre" => "Julio-Junio 12 períodos"),
            array( "abreviatura" => "K03", "nombre" => "Enero-Diciembre 12 períodos"),
            array( "abreviatura" => "EC1", "nombre" => "Julio-Diciembre 6 períodos"),
        );
                
        foreach( $values as $value ){
            $obj = new VarianteEjercicio();
            $obj->setNombre($value['nombre']);
            $obj->setAbreviatura($value['abreviatura']);
            
            /** @todo agregar al fixture PeriodoVarianteEjercicio */
            
            $manager->persist($obj);
        }
        $manager->flush();
    }
    
    function getOrder()
    {
        return 12; 
    }
}
