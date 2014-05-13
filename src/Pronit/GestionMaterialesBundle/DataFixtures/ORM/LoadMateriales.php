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

        $categoriaValoracion = $this->getReference('pronit-gestionmateriales-categoriavaloracion-3006');
        $sistemaMedicionLitro = $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-litro');
        
        $materialMM001 = new Material();
        $materialMM001->setCodigo("MM001");
        $materialMM001->setNombre("Aditivo A1SW");
        $materialMM001->setCategoriaValoracion($categoriaValoracion);
        $materialMM001->setSistemaMedicion($sistemaMedicionLitro);
        
        $manager->persist($materialMM001);
        
        $manager->flush();
        
        $this->addReference('pronit-gestionmateriales-materialmm001', $materialMM001);        
    }
    
    function getOrder()
    {
        return 41; 
    }
}
