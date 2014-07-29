<?php

namespace Pronit\CoreBundle\Entity\Automatizacion\Secuencias;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\MetadataValue;
use Pronit\CoreBundle\Entity\Automatizacion\Secuencias\RegistroCondicion;

/**
 *
 * @author ldelia
 */
/** 
 * @ORM\Entity
 */
class RegistroCondicionMetadataValue extends MetadataValue
{
    
    /** @ORM\ManyToOne(targetEntity="RegistroCondicion") */
    private $registroCondicion;

    public function __construct( RegistroCondicion $registroCondicion, $metadataName, $value)
    {
        parent::__construct($metadataName, $value);
        $this->setRegistroCondicion($registroCondicion);
    }

    public function getRegistroCondicion()
    {
        return $this->registroCondicion;
    }

    public function setRegistroCondicion(RegistroCondicion $registroCondicion)
    {
        $this->registroCondicion = $registroCondicion;
    }
}