<?php

namespace Pronit\ParametrizacionGeneralBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\ParametrizacionGeneralBundle\Entity\Bancos\CuentaBancaria;

/**
 * @author ldelia
 */
class LoadCuentasBancarias extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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
                "banco-slug" => "banco-frances", 
                "cuentas" => array(
                    array( "numero" => "998844" )
                ) 
            ),
        );
        
        foreach( $values as $value ){
            
            $banco = $this->getReference('pronit-parametrizaciongeneral-banco-' . $value['banco-slug']);
            
            foreach( $value["cuentas"] as $cuentaValue ){
            
                $cuentaBancaria = new CuentaBancaria();
                $cuentaBancaria->setNumero( $cuentaValue['numero'] );

                $banco->addCuenta( $cuentaBancaria );               
            }
            
            $manager->persist($banco);
        }
        
        $manager->flush();
    }
    
    function getOrder()
    {
        return 46; 
    }
}
