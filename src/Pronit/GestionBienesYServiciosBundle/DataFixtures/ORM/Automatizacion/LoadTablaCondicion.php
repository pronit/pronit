<?php

namespace Pronit\GestionBienesYServiciosBundle\DataFixtures\ORM\Automatizacion;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\CoreBundle\Entity\Automatizacion\Secuencias\TablaCondicion;
use Pronit\CoreBundle\Entity\Automatizacion\Secuencias\RegistroCondicion;

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

        /********************************** **/
        /**   Definición Tabla Logica 1     **/
        /*************************************/
        
        $logicTableMetadata1 = new LogicTableMetadata( 'TablaCondicion.1' );
        $logicTableMetadata1->addAttribute(new AttributeMetadata("material", "object", array('entityType'=>'\Pronit\GestionBienesYServiciosBundle\Entity\Material') ));
                
        $manager->persist($logicTableMetadata1);       

        /********************************** **/
        /** Definición Tabla de Condición 1 **/
        /*************************************/
        $tablaCondicion1 = new TablaCondicion();
        $tablaCondicion1->setCodigo('T1');
        $tablaCondicion1->setDescripcion('Material');
        $tablaCondicion1->setTableMetadata($logicTableMetadata1);
        
        $manager->persist($tablaCondicion1);

        $manager->flush();
        
        $this->addReference('pronit-core-tablacondicion-' . $tablaCondicion1->getCodigo(), $tablaCondicion1);        

        /************************************************************/
        /** Definición Registros de Condición Tabla de Condición 1 **/
        /***********************************************t*************/

        /* @var $registroCondicionMetadataProvider1 \Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\IMetadataProvider */
        $registroCondicionMetadataProvider1 = $this->container->get('bluegrass.metadata_provider_factory')->getMetadataProviderFor($logicTableMetadata1);        
        
        /* @var $registroCondicion \Pronit\CoreBundle\Entity\Automatizacion\Secuencias\RegistroCondicion  */                                  
        $registroCondicion = new RegistroCondicion();        
        $registroCondicion->setClave( $registroCondicionMetadataProvider1->getMetadata('material'), $this->getReference('pronit-gestionbienesyservicios-bienservicio-MM001'));
                
        $tablaCondicion1->addRegistroCondicion($registroCondicion);
        
        $registroCondicion = new RegistroCondicion();        
        $registroCondicion->setClave( $registroCondicionMetadataProvider1->getMetadata('material'), $this->getReference('pronit-gestionbienesyservicios-bienservicio-610615008'));        
        $tablaCondicion1->addRegistroCondicion($registroCondicion);
        
        $manager->flush();
                        
                
        /***************************/
        /********* EJEMPLO 2 *******/
        /***************************/

        /********************************** **/
        /**   Definición Tabla Logica 2     **/
        /*************************************/
        
        $logicTableMetadata2 = new LogicTableMetadata( 'TablaCondicion.2' );
        $logicTableMetadata2->addAttribute(new AttributeMetadata("material", "object", array('entityType'=>'\Pronit\GestionBienesYServiciosBundle\Entity\Material') ));
        $logicTableMetadata2->addAttribute(new AttributeMetadata("proveedor", "string") );
                
        $manager->persist($logicTableMetadata2);       

        
        $tablaCondicion2 = new TablaCondicion();
        $tablaCondicion2->setCodigo('T2');
        $tablaCondicion2->setDescripcion('Material/Proveedor');
        $tablaCondicion2->setTableMetadata($logicTableMetadata2);

        $manager->persist($tablaCondicion2);
        
        $this->addReference('pronit-core-tablacondicion-' . $tablaCondicion2->getCodigo(), $tablaCondicion2);        
                
        $manager->flush();
        
        /************************************************************/
        /** Definición Registros de Condición Tabla de Condición 2 **/
        /************************************************************/

        /* @var $registroCondicionMetadataProvider2 \Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\IMetadataProvider */
        $registroCondicionMetadataProvider2 = $this->container->get('bluegrass.metadata_provider_factory')->getMetadataProviderFor($logicTableMetadata2);        
        
        /* @var $registroCondicion \Pronit\CoreBundle\Entity\Automatizacion\Secuencias\RegistroCondicion  */
        
        $registroCondicion = new RegistroCondicion();        
        $registroCondicion->setClave( $registroCondicionMetadataProvider2->getMetadata('material') , $this->getReference('pronit-gestionbienesyservicios-bienservicio-MM001'));
        $registroCondicion->setClave( $registroCondicionMetadataProvider2->getMetadata('proveedor'), 'colo');
                
        $tablaCondicion2->addRegistroCondicion($registroCondicion);
        
        $registroCondicion = new RegistroCondicion();        
        $registroCondicion->setClave( $registroCondicionMetadataProvider2->getMetadata('material'), $this->getReference('pronit-gestionbienesyservicios-bienservicio-610615008'));        
        $registroCondicion->setClave( $registroCondicionMetadataProvider2->getMetadata('proveedor'), 'lycho');
        $tablaCondicion2->addRegistroCondicion($registroCondicion);

        $registroCondicion = new RegistroCondicion();        
        $registroCondicion->setClave( $registroCondicionMetadataProvider2->getMetadata('material'), $this->getReference('pronit-gestionbienesyservicios-bienservicio-SS001'));        
        $registroCondicion->setClave( $registroCondicionMetadataProvider2->getMetadata('proveedor'), 'lycho');
        $tablaCondicion2->addRegistroCondicion($registroCondicion);
        
        $manager->flush();
        
    }
    
    function getOrder()
    {
        return 74; 
    }
}
