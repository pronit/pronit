<?php

namespace Pronit\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataValue;

/**
 *
 * @author ldelia
 */
/** 
 * @ORM\Entity
 * @ORM\Table(name="core_metadatavalue")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"DivisionAdministrativaMetadataValue" = "Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativaMetadataValue", "TablaCondicionMetadataValue" = "Pronit\CoreBundle\Entity\Automatizacion\Secuencias\TablaCondicionMetadataValue"})
 */
abstract class MetadataValue implements IMetadataValue
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;    
    
    /** @ORM\Column(type="string") */
    private $metadataName;
    
    /** @ORM\Column(type="string") */
    private $value;

    public function __construct($metadataName, $value)
    {
        $this->setMetadataName($metadataName);
        $this->setValue( $value );        
    }

    protected function getMetadataName()
    {
        return $this->metadataName;
    }

    protected function setMetadataName($metadataName)
    {
        $this->metadataName = $metadataName;
    }    
    
    public function getValue()
    {
        return $this->value;
    }
    
    protected function setValue($valor)
    {
        $this->value = $valor;                    
    }    
    
}

