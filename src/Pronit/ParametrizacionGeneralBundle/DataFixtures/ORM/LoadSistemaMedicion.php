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
    
    protected function createEscala( $nombre, $abreviatura, $factor )
    {
        $escala = new Escala();
        $escala->setNombre($nombre);
        $escala->setAbreviatura($abreviatura);
        $escala->setFactor($factor);
        return $escala;
    }
    
    /**
     * {@inheritDoc}
     */       
    public function load(ObjectManager $manager)
    {
        $this->setManager($manager);        
                
        $escalaMetro = $this->createEscala('Metro', 'm', 1 );
        $this->addReference('pronit-parametrizaciongeneral-escala-metro', $escalaMetro);
        
        $sistemaMetrico = new SistemaMedicion();
        $sistemaMetrico->setNombre('Sistema Métrico');
        $sistemaMetrico->setAbreviatura('S-ME');
        $sistemaMetrico->addEscala( $escalaMetro );
        $sistemaMetrico->addEscala( $this->createEscala('Decímetro', 'dm', 0.1 ) );
        $sistemaMetrico->addEscala( $this->createEscala('Centímetro', 'cm', 0.01 ) );
        $sistemaMetrico->addEscala( $this->createEscala('Milímetro', 'mm', 0.001 ) );
        
        $manager->persist($sistemaMetrico);
        
        $sistemaMillas = new SistemaMedicion();                
        $sistemaMillas->setNombre('Sistema Millas');
        $sistemaMillas->setAbreviatura('S-MI');
        $sistemaMillas->addEscala( $this->createEscala('Milla', 'mi', 1 ) );
        $sistemaMillas->addEscala( $this->createEscala('Yarda', 'yd', 0.000568182 ) );
        $sistemaMillas->addEscala( $this->createEscala('Pie', 'ft', 0.000189394 ) );
        $sistemaMillas->addEscala( $this->createEscala('Pulgada', 'in', 0.000015783 ) );
        
        $manager->persist($sistemaMillas);
        
        $conversion = new ConversionSistemaMedicion();
        $conversion->setDesde($sistemaMetrico);
        $conversion->setHasta($sistemaMillas);
        $conversion->setFactor(1.6);
        
        $manager->persist($conversion);

        $sistemaLitros = new SistemaMedicion();                
        $sistemaLitros->setNombre('Sistema Volúmen Líquido Litros');
        $sistemaLitros->setAbreviatura('S-VL');
        $sistemaLitros->addEscala( $this->createEscala('Litro', 'l', 1 ) );
        $sistemaLitros->addEscala( $this->createEscala('Decilitro', 'dl', 0.1 ) );
        $sistemaLitros->addEscala( $this->createEscala('Centilitro', 'cl', 0.01 ) );
        $sistemaLitros->addEscala( $this->createEscala('Mililitro', 'ml', 0.001 ) );
        
        $this->addReference('pronit-parametrizaciongeneral-sistemamedicion-litro', $sistemaLitros);
        
        $manager->persist($sistemaLitros);
        
        $manager->flush();
    }
    
    function getOrder()
    {
        return 41; 
    }
}
