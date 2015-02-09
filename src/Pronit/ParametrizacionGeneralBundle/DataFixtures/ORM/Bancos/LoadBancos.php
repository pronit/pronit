<?php

namespace Pronit\ParametrizacionGeneralBundle\DataFixtures\ORM\Bancos;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\ParametrizacionGeneralBundle\Entity\Bancos\Banco;

/**
 * @author ldelia
 */
class LoadBancos extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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
            array( "nombre" => "Banco Francés" ),
        );
                
        foreach( $values as $value ){
            
            $obj = new Banco();
            $obj->setNombre($value['nombre']);

            $this->addReference('pronit-parametrizaciongeneral-banco-banco-frances', $obj);
            
            $manager->persist($obj);
        }
        $manager->flush();
    }
    
    function getOrder()
    {
        return 45; 
    }
}
