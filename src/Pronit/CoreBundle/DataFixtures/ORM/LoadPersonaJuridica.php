<?php

namespace Pronit\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\CoreBundle\Entity\Personas\Personajuridica;

/**
 * @author ldelia
 */
class LoadPersonaJuridica extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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

        $values =  array();
        
        for($i=1; $i<50; $i++){
            $values[ ] = array('nombre' => 'PJ'.$i, 'razonSocial' => 'Persona Jurídica ' . $i);
        }        
        
        foreach( $values as $value ){
            $obj = new PersonaJuridica();
            $obj->setRazonSocial($value['razonSocial']);
            $obj->setNombre($value['nombre']);
            
            $manager->persist($obj);
            
            $this->addReference('pronit-core-personajuridica-' . $value['nombre'], $obj);        
        }
        
        $manager->flush();
    }
    
    function getOrder()
    {
        return 14; 
    }
}
