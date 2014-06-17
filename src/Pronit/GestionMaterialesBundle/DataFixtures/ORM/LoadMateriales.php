<?php

namespace Pronit\GestionMaterialesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\GestionMaterialesBundle\Entity\Material;

/**
 * @author ldelia
 */
class LoadMateriales extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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

        $sistemaMedicionLitro = $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-litro');

        $values = array(
            array('codigo' => "MM001", 
                    "nombre" => "Aditivo A1SW", 
                    'categoria' => $this->getReference('pronit-gestionmateriales-categoriavaloracion-3006'), 
                    "sistemaMedicion" => $sistemaMedicionLitro),
            array('codigo' => "610615008", 
                    "nombre" => "Caja Telescopica I 3 90 Libras", 
                    'categoria' => $this->getReference('pronit-gestionmateriales-categoriavaloracion-3001'), 
                    "sistemaMedicion" => $sistemaMedicionLitro),
        );
        
        foreach( $values as $v ){
            
            $material = new Material();
            $material->setCodigo( $v['codigo'] );
            $material->setNombre( $v['nombre'] );
            $material->setCategoriaValoracion( $v['categoria'] );
            $material->setSistemaMedicion( $v['sistemaMedicion'] );
        
            $manager->persist($material);
            
            $this->addReference('pronit-gestionmateriales-material-' . $v['codigo'], $material);        
        }
        
        $manager->flush();
        
        
    }
    
    function getOrder()
    {
        return 71; 
    }
}
