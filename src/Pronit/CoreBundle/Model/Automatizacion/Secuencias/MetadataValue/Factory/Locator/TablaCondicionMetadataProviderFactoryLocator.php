<?php

namespace Pronit\CoreBundle\Model\Automatizacion\Secuencias\MetadataValue\Factory\Locator;

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\Factory\Locator\IMetadataProviderFactoryLocator;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\Factory\LogicTableMetadataProviderFactory;
use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\EntityTableMetadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\LogicTableMetadata;


use Pronit\CoreBundle\Model\Automatizacion\Secuencias\MetadataValueProvider\Factory\RegistroCondicionMetadataValueFactory;

use Doctrine\ORM\EntityManager;

class TablaCondicionMetadataProviderFactoryLocator implements IMetadataProviderFactoryLocator 
{
    protected $em;
    protected $metadataValueFactory;
    
    public function __construct(EntityManager $em, RegistroCondicionMetadataValueFactory $metadataValueFactory) 
    {
        $this->em = $em;
        $this->metadataValueFactory = $metadataValueFactory;
    }

    public function  lookupMetadataProviderFactoryForEntityTableMetadata( EntityTableMetadata $tableMetadata )
    {
        return null;    
    }
    
    public function  lookupMetadataProviderFactoryForLogicTableMetadata( LogicTableMetadata $tableMetadata )
    {
        /* Determino si la logicTableMetadata está asociada a una TablaCondicion */
        $tablasCondicion = $this->em->getRepository('Pronit\CoreBundle\Entity\Automatizacion\Secuencias\TablaCondicion')->findByTableMetadata($tableMetadata);
        
        if ( count( $tablasCondicion ) ){               
            return new LogicTableMetadataProviderFactory($this->em, $tableMetadata->getName(), $this->metadataValueFactory);            
        }else{
            return null;
        }
    }
}

    