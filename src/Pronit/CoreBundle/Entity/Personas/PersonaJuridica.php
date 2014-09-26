<?php

namespace Pronit\CoreBundle\Entity\Personas;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @author ldelia
 * @ORM\Entity
 */
class PersonaJuridica extends Persona
{
    /** 
     * @ORM\Column(type="string") 
     */    
    protected $razonSocial;
    
    /** 
     * @ORM\Column(type="string") 
     */    
    protected $nombre;

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getRazonSocial()
    {
        return $this->razonSocial;
    }

    public function setRazonSocial($razonSocial)
    {
        $this->razonSocial = $razonSocial;
    }
    
    public function __toString()
    {
        return (string) $this->getNombre() . " (" . $this->getRazonSocial() . ")";
    }
}

