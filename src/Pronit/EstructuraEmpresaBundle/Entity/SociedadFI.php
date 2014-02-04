<?php

namespace Pronit\EstructuraEmpresaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @author gcaseres
 * @ORM\Entity
 */
class SociedadFI extends Sociedad
{
    
    /**
     * @ORM\ManyToOne(targetEntity="SociedadGL")
     */
    private $sociedadGL;        

    public function getSociedadGL()
    {
        return $this->sociedadGL;
    }

    public function setSociedadGL($sociedadGL)
    {
        $this->sociedadGL = $sociedadGL;
    }    
}

