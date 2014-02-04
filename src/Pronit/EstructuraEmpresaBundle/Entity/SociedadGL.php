<?php

namespace Pronit\EstructuraEmpresaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @author ldelia
 * @ORM\Entity
 */
class SociedadGL extends Sociedad
{
    /**
     * @ORM\ManyToOne(targetEntity="SociedadCO")
     */
    private $sociedadCO;    
    
    public function getSociedadCO()
    {
        return $this->sociedadCO;
    }

    public function setSociedadCO($sociedadCO)
    {
        $this->sociedadCO = $sociedadCO;
    }    
}

