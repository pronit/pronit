<?php

namespace Pronit\CoreBundle\Entity\Contabilidad;

use Doctrine\ORM\Mapping as ORM;


/**
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\Table(name="core_clavecontabilizacion")
 */
class ClaveContabilizacion
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
    
    /**
     * @ORM\Column(type="integer")
     */    
    protected $signo;    
    
    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getSigno()
    {
        return $this->signo;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setSigno($signo)
    {
        $this->signo = $signo;
    }    
    
    public function __toString() {
        return $this->nombre;
    }
}
