<?php

namespace Pronit\CoreBundle\Entity\Automatizacion\Secuencias;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\MetadataValue;
use Pronit\CoreBundle\Entity\Automatizacion\Secuencias\TablaCondicion;

/**
 *
 * @author ldelia
 */
/** 
 * @ORM\Entity
 */
class TablaCondicionMetadataValue extends MetadataValue
{
    
    /** @ORM\ManyToOne(targetEntity="TablaCondicion") */
    private $tablaCondicion;

    public function __construct(TablaCondicion $tablaCondicion, $metadataName, $value)
    {
        parent::__construct($metadataName, $value);
        $this->setTablaCondicion($tablaCondicion);
    }

    /**
     * 
     * @return \Pronit\CoreBundle\Entity\Automatizacion\Secuencias\TablaCondicion
     */
    public function getTablaCondicion()
    {
        return $this->tablaCondicion;
    }

    /**
     * 
     * @param \Pronit\CoreBundle\Entity\Automatizacion\Secuencias\TablaCondicion $tablaCondicion
     */
    public function setTablaCondicion(TablaCondicion $tablaCondicion)
    {
        $this->tablaCondicion = $tablaCondicion;
    }
}

