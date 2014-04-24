<?php

namespace Pronit\ParametrizacionGeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 
 *
 * @author gcaseres
 */
class Moneda
{
    
    private $id;
    
    private $nombre;
    
    private $abreviatura;
    
    private $signoMonetario;
    
    private $codigoISO;
    
    public function __construct($nombre, $abreviatura,$signoMonetario, $codigoISO)
    {
        $this->setNombre($nombre);
        $this->setAbreviatura($abreviatura);
        $this->setSignoMonetario($signoMonetario);
        $this->setCodigoISO($codigoISO);
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setNombre($valor)
    {
        $this->nombre = $valor;
    }
    
    public function getNombre()
    {
        return $this->nombre;
    }
    
    
    public function setAbreviatura($value)
    {
        $this->abreviatura = $value;
    }
    
    public function getAbreviatura()
    {
        return $this->abreviatura;
    }
    
    public function setSignoMonetario($value)
    {
        $this->signoMonetario = $value;
    }
    
    public function getSignoMonetario()
    {
        return $this->signoMonetario;
    }
    
    public function setCodigoISO($value)
    {
        $this->codigoISO = $value;
    }
    
    public function getCodigoISO()
    {
        return $this->codigoISO;
    }
        
    public function __toString() 
    {        
        return (string)$this->nombre;
    }
    
    public function getDescripcion()
    {
        return sprintf("%s (%s)", $this->codigoISO, $this->nombre);
    }  
}

