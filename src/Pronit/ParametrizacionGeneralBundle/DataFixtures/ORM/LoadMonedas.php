<?php

namespace Pronit\ParametrizacionGeneralBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\ParametrizacionGeneralBundle\Entity\Moneda;

/**
 * @author ldelia
 */
class LoadMonedas extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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
            array( 'nombre' => 'Pesos Argentinos', 'codigoISO' => "ARS", 'abreviatura' => 'Peso', 'signoMonetario' => '$', 'slug' => 'pesos' ),
            array( 'nombre' => 'Dólar Estadounidense', 'codigoISO' => "USD", 'abreviatura' => 'Dólar', 'signoMonetario' => 'u$d', 'slug' => 'dolares' ),
        );
        
        foreach( $values as $v ){
            
            $moneda = new Moneda();
            $moneda->setNombre( $v['nombre'] );
            $moneda->setCodigoISO( $v['codigoISO'] );
            $moneda->setAbreviatura( $v['abreviatura'] );
            $moneda->setSignoMonetario( $v['signoMonetario'] );

            $manager->persist($moneda);

            $this->addReference('pronit-parametrizaciongeneral-moneda-' . $v['slug'], $moneda);            
        }
        
        $manager->flush();
    }
    
    function getOrder()
    {
        return 40; 
    }
}
