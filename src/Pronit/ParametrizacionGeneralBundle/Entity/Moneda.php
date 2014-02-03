<?php

namespace Pronit\ParametrizacionGeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 
 *
 * @author gcaseres
 * @ORM\Entity
 * @ORM\Table(name="pgener_monedas")
 */
class Moneda
{
    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    private $id;
    
    /**
     * @ORM\Column(type="string", length=100)
     */    
    private $nombre;
    
    /**
     * @ORM\Column(type="string", length=20)
     */    
    private $abreviatura;
    
    /**
     * @ORM\Column(type="string", length=5)
     */        
    private $signoMonetario;
    
    /**
     * @ORM\Column(type="string", length=3)
     */        
    private $codigoISO;
    
    
    
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
        return (string)$this->getNombre();
    }
}

