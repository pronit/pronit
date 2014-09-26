<?php

namespace Pronit\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\CoreBundle\Entity\Personas\PersonaFisica;

/**
 * @author ldelia
 */
class LoadPersonaFisica extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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
            array( "apellido" => "Cáseres", "nombre" => "Germán"),
            array( "apellido" => "Arana", "nombre" => "Patricio"),
            array( "apellido" => "Delía", "nombre" => "Lisandro"),
        );
        
        foreach( $values as $value ){
            $obj = new PersonaFisica();
            $obj->setApellido($value['apellido']);
            $obj->setNombre($value['nombre']);
            
            $manager->persist($obj);
            
            $this->addReference('pronit-core-personafisica-' . $value['apellido'], $obj);        
        }
        
        $manager->flush();
    }
    
    function getOrder()
    {
        return 13; 
    }
}
