<?php

namespace Pronit\CoreBundle\Metadata;

use Pronit\CoreBundle\Entity\Automatizacion\Secuencias\TablaCondicion;
use Pronit\CoreBundle\Entity\Automatizacion\Secuencias\TablaCondicionMetadataValue;

use \Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataEntity;
use \Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\Factory\IMetadataValueFactory;

/**
 * Genera instancias concretas de Valores de Metadatatos
 * @author ldelia
 */
class TablaCondicionMetadataValueFactory implements IMetadataValueFactory
{        
    /**
     * 
     * @param string  $metadataName
     * @param type $value
     * @return \Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataValue 
     */
    public function createMetadataValue( IMetadataEntity $entity, $metadataName, $value )
    {
        return $this->createTablaCondicionMetadataValue($entity, $metadataName, $value );        
    }
    
    public function createTablaCondicionMetadataValue(TablaCondicion $tablaCondicion, $metadataName, $value)
    {
        return new TablaCondicionMetadataValue($tablaCondicion, $metadataName, $value);
    }    
}
