<?php
namespace Pronit\CoreBundle\Entity\Automatizacion\Secuencias;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Automatizacion\Secuencias\Secuencia;
use Pronit\CoreBundle\Entity\Automatizacion\Secuencias\TablaCondicion;

/**
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\Table(name="core_accesos")
 */
class Acceso {
    
   /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    protected $id;
    
    /** 
     * @ORM\Column(type="integer")
     */        
    protected $orden;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Automatizacion\Secuencias\Secuencia")
     * @ORM\JoinColumn(nullable=false)
     */    
    protected $secuencia;    

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Automatizacion\Secuencias\TablaCondicion")
     * @ORM\JoinColumn(nullable=false)
     */    
    protected $tablaCondicion;    
    
    public function __construct() 
    {
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getOrden()
    {
        return $this->orden;
    }

    public function getSecuencia()
    {
        return $this->secuencia;
    }

    public function setOrden($orden)
    {
        $this->orden = $orden;
    }

    public function setSecuencia(Secuencia $secuencia)
    {
        $this->secuencia = $secuencia;
    }    
    
    public function getTablaCondicion()
    {
        return $this->tablaCondicion;
    }

    public function setTablaCondicion(TablaCondicion $tablaCondicion)
    {
        $this->tablaCondicion = $tablaCondicion;
    }    
}

