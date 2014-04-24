<?php

namespace Pronit\Geographic\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\MetadataValue;
use Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa;

/**
 *
 * @author ldelia
 */
/** 
 * @ORM\Entity
 */
class DivisionAdministrativaMetadataValue extends MetadataValue
{
    
    /** @ORM\ManyToOne(targetEntity="DivisionAdministrativa", inversedBy="atributos") */
    private $divisionadministrativa;

    public function __construct( DivisionAdministrativa $divisionAdministrativa, $metadataName, $value)
    {
        parent::__construct($metadataName, $value);
        $this->setDivisionAdministrativa($divisionAdministrativa);
    }

    /**
     * 
     * @return \Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa
     */
    public function getDivisionAdministrativa()
    {
        return $this->divisionadministrativa;
    }

    /**
     * 
     * @param \Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa $divisionadministrativa
     */
    public function setDivisionAdministrativa($divisionadministrativa)
    {
        $this->divisionadministrativa = $divisionadministrativa;
    }    
}

