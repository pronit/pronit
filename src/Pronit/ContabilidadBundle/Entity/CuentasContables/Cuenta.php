<?php

namespace Pronit\ContabilidadBundle\Entity\CuentasContables;

use Doctrine\ORM\Mapping as ORM;


/**
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\Table(name="conta_cuenta")
 */
class Cuenta
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    protected $id;

    /**
     * @ORM\Column(type="string")
     */        
    protected $nombre;
    
    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }    
    
    public function __toString()
    {
        return (string) $this->getNombre();
    }
}
