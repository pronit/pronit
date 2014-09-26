<?php

namespace Pronit\CoreBundle\Entity\Personas;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @author ldelia
 * @ORM\Entity
 */
class PersonaFisica extends Persona
{
    /** 
     * @ORM\Column(type="string") 
     */    
    protected $apellido;
    
    /** 
     * @ORM\Column(type="string") 
     */    
    protected $nombre;

    public function getApellido()
    {
        return $this->apellido;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    
    public function __toString()
    {
        return (string) $this->getApellido() . ", " . $this->getNombre();
    }
}

