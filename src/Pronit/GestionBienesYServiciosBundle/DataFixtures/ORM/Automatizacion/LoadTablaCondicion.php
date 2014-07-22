<?php

namespace Pronit\GestionBienesYServiciosBundle\DataFixtures\ORM\Automatizacion;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\CoreBundle\Entity\Automatizacion\Secuencias\TablaCondicion;

use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\LogicTableMetadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\AttributeMetadata;


/**
 * @author ldelia
 */
class LoadTablaCondicion extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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

        $logicTableMetadata1 = new LogicTableMetadata( 'TablaCondicion.1' );
        $logicTableMetadata1->addAttribute(new AttributeMetadata("material", "object", array('entityType'=>'\Pronit\GestionBienesYServiciosBundle\Entity\Material') ));
                
        $manager->persist($logicTableMetadata1);       

        $logicTableMetadata2 = new LogicTableMetadata( 'TablaCondicion.2' );
        $logicTableMetadata2->addAttribute(new AttributeMetadata("material", "object", array('entityType'=>'\Pronit\GestionBienesYServiciosBundle\Entity\Material') ));
        $logicTableMetadata2->addAttribute(new AttributeMetadata("proveedor", "string") );
                
        $manager->persist($logicTableMetadata2);       
        
        $manager->flush();
        
        /**
         * Obtengo el provider de metadatos de la entidad 
         */
        /* @var $tablaDeCondicionMetadataProvider \Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\IMetadataProvider */
        
//        $tablaDeCondicionMetadataProvider = $this->container->get('bluegrass.metadata_provider_factory')->getProviderFor( '\Pronit\CoreBundle\Entity\Automatizacion\Secuencias\TablaCondicion' );        
        
        /********************************** **/
        /** Definición Tabla de Condición 1 **/
        /*************************************/
        $tablaCondicion = new TablaCondicion();
        $tablaCondicion->setCodigo('T1');
        $tablaCondicion->setDescripcion('Material');
        $tablaCondicion->setTableMetadata($logicTableMetadata1);
        
  //      $tablaCondicion->setMetadata($tablaDeCondicionMetadataProvider->getMetadata("material"), $this->getReference('pronit-gestionbienesyservicios-bienservicio-SS002'));        
        
        $manager->persist($tablaCondicion);

        $this->addReference('pronit-core-tablacondicion-' . $tablaCondicion->getCodigo(), $tablaCondicion);        
                
        /***************************/
        
        $tablaCondicion2 = new TablaCondicion();
        $tablaCondicion2->setCodigo('T2');
        $tablaCondicion2->setDescripcion('Material/Proveedor');
        $tablaCondicion2->setTableMetadata($logicTableMetadata2);

        $manager->persist($tablaCondicion2);
        
        $this->addReference('pronit-core-tablacondicion-' . $tablaCondicion2->getCodigo(), $tablaCondicion2);        
                
        $manager->flush();
    }
    
    function getOrder()
    {
        return 74; 
    }
}
