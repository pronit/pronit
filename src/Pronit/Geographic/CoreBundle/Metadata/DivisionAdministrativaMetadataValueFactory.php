<?php

namespace Pronit\Geographic\CoreBundle\Metadata;

use \Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa;
use \Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativaMetadataValue;

use \Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataEntity;
use \Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\Factory\IMetadataValueFactory;

/**
 * Genera instancias concretas de Valores de Metadatatos
 * @author ldelia
 */
class DivisionAdministrativaMetadataValueFactory implements IMetadataValueFactory
{        
    /**
     * 
     * @param string  $metadataName
     * @param type $value
     * @return \Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataValue 
     */
    public function createMetadataValue( IMetadataEntity $entity, $metadataName, $value )
    {
        return $this->createDivisionAdministrativaMetadataValue($entity, $metadataName, $value );        
    }
    
    public function createDivisionAdministrativaMetadataValue(DivisionAdministrativa $divisionAdministrativa, $metadataName, $value)
    {
        return new DivisionAdministrativaMetadataValue($divisionAdministrativa, $metadataName, $value);
    }    
}
