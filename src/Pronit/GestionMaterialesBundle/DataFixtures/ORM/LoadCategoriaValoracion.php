<?php

namespace Pronit\GestionMaterialesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\GestionMaterialesBundle\Entity\CategoriaValoracion;

/**
 * @author ldelia
 */
class LoadCategoriaValoracion extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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
            array( "codigo" => "3000", "descripcion" => "Equipos" ),
            array( "codigo" => "3001", "descripcion" => "Materias Primas" ),
            array( "codigo" => "3002", "descripcion" => "Piezas de recambio" ),
            array( "codigo" => "3003", "descripcion" => "Mercadería" ),
            array( "codigo" => "3004", "descripcion" => "Servicios" ),
            array( "codigo" => "3005", "descripcion" => "Embalaje y emvases" ),
            array( "codigo" => "3006", "descripcion" => "Materia aux./Combustible" ),
            array( "codigo" => "3007", "descripcion" => "Productos semiterminados" ),
            array( "codigo" => "3008", "descripcion" => "Productos terminados" ),
        );
        
        foreach( $values as $value ){
            $obj = new CategoriaValoracion();
            $obj->setCodigo($value['codigo']);
            $obj->setDescripcion($value['descripcion']);
        
            $manager->persist($obj);
            
            $this->addReference('pronit-gestionmateriales-categoriavaloracion-' . $value['codigo'], $obj);        
        }
        
        $manager->flush();
    }
    
    function getOrder()
    {
        return 70; 
    }
}
