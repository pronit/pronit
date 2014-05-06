<?php

namespace Pronit\ParametrizacionGeneralBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\ParametrizacionGeneralBundle\Entity\SistemaMedicion;
use Pronit\ParametrizacionGeneralBundle\Entity\Escala;
use Pronit\ParametrizacionGeneralBundle\Entity\ConversionSistemaMedicion;
/**
 * @author ldelia
 */
class LoadSistemaMedicion extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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
                
        $escalaMetro = new Escala('Metro', 'm', 1 );
        $this->addReference('pronit-parametrizaciongeneral-escala-metro', $escalaMetro);
        
        $sistemaMedicionME = new SistemaMedicion( 'Sistema Métrico', 'S-ME' );
        $sistemaMedicionME->addEscala( $escalaMetro );
        $sistemaMedicionME->addEscala( new Escala('Decímetro', 'dm', 0.1 ) );
        $sistemaMedicionME->addEscala( new Escala('Centímetro', 'cm', 0.01 ) );
        $sistemaMedicionME->addEscala( new Escala('Milímetro', 'mm', 0.001 ) );
        
        $manager->persist($sistemaMedicionME);
        
        $sistemaMedicionMI = new SistemaMedicion( 'Sistema Millas', 'S-MI' );                
        $sistemaMedicionMI->addEscala( new Escala('Milla', 'mi', 1 ) );
        $sistemaMedicionMI->addEscala( new Escala('Yarda', 'yd', 0.000568182 ) );
        $sistemaMedicionMI->addEscala( new Escala('Pie', 'ft', 0.000189394 ) );
        $sistemaMedicionMI->addEscala( new Escala('Pulgada', 'in', 0.000015783 ) );
        
        $manager->persist($sistemaMedicionMI);
        
        $conversion = new ConversionSistemaMedicion($sistemaMedicionME, $sistemaMedicionMI, 1.6);
        $manager->persist($conversion);
        
        $manager->flush();
    }
    
    function getOrder()
    {
        return 11; 
    }
}
