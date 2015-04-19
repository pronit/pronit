<?php

namespace Pronit\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\CoreBundle\Entity\Personas\Deudor;

/**
 * @author ldelia
 */
class LoadDeudor extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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
            array( "apellido" => "Arana", "cuenta" => "210101" ),
        );
        
        foreach( $values as $value ){
            
            $obj = new Deudor();
            $obj->setPersona( $this->getReference('pronit-core-personafisica-'. $value['apellido']) );
            $obj->setCuenta( $this->getReference('pronit-contabilidad-cuenta-' . $value["cuenta"]) );
            
            $manager->persist($obj);
            
            $this->addReference('pronit-core-deudor-' . $value['apellido'], $obj);        
        }
        
        $manager->flush();
    }
    
    function getOrder()
    {
        return 15; 
    }
}
