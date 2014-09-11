<?php

namespace Pronit\GestionBienesYServiciosBundle\DataFixtures\ORM\Automatizacion\EsquemasCalculo;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ClaseCondicion;


/**
 * @author ldelia
 */
class LoadClaseCondicion extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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

        $values = array(
            array( 'codigo' => 'PR00', 'nombre' => 'Precio' ),
        );
        
        foreach ($values as $value)
        {
            $claseCondicion = new ClaseCondicion();
            $claseCondicion->setCodigo($value['codigo']);
            $claseCondicion->setNombre($value['nombre']);
            
            $manager->persist($claseCondicion);           
            $this->addReference('pronit-core-clasecondicion-' . $claseCondicion->getCodigo(), $claseCondicion);                    
        }
        
        $manager->flush();
    }
    
    function getOrder()
    {
        return 74; 
    }
}
