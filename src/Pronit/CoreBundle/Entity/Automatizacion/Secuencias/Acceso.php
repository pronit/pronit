<?php
namespace Pronit\CoreBundle\Entity\Automatizacion\Secuencias;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Automatizacion\Secuencias\Secuencia;
use Pronit\CoreBundle\Entity\Automatizacion\Secuencias\TablaCondicion;

use Pronit\CoreBundle\Model\Automatizacion\Secuencias\IBuscadorRegistroCondicion;

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
    
    /*
     * Define las reglas para ordenar accesos.
     * Esta functión siempre retorna -1, 0, o 1.
     */    
    public function compare( Acceso $otroAcceso )
    {
        if ( $this->getOrden() < $otroAcceso->getOrden() ){
            return -1;
        }else if($this->getOrden() == $otroAcceso->getOrden()){
            return 0;
        }else{
            return 1;
        } 
    }
    
    /**
     * 
     * @param type $keyValues
     * @return \Pronit\CoreBundle\Entity\Automatizacion\Secuencias\RegistroCondicion | null
     */        
    public function buscar( $keyValues, IBuscadorRegistroCondicion $buscadorRegistroCondicion)
    {
        $tablaCondicion = $this->getTablaCondicion();
        
        return $buscadorRegistroCondicion->buscarPorTablaCondicion($keyValues, $tablaCondicion);
    }    
}

