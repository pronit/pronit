<?php

namespace Pronit\CoreBundle\Model\Automatizacion\Secuencias\MetadataValueProvider\Factory;

use Pronit\CoreBundle\Entity\Automatizacion\Secuencias\RegistroCondicion;
use Pronit\CoreBundle\Entity\Automatizacion\Secuencias\RegistroCondicionMetadataValue;

use \Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataEntity;
use \Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\Factory\IMetadataValueFactory;

/**
 * Genera instancias concretas de Valores de Metadatatos
 * @author ldelia
 */
class RegistroCondicionMetadataValueFactory implements IMetadataValueFactory
{        
    /**
     * 
     * @param string  $metadataName
     * @param type $value
     * @return \Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataValue 
     */
    public function createMetadataValue( IMetadataEntity $entity, $metadataName, $value )
    {
        return $this->createRegistroCondicionMetadataValue($entity, $metadataName, $value );        
    }
    
    public function createRegistroCondicionMetadataValue(RegistroCondicion $registroCondicion, $metadataName, $value)
    {
        return new RegistroCondicionMetadataValue($registroCondicion, $metadataName, $value);
    }    
}
