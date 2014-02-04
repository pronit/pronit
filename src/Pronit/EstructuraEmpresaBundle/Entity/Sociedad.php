<?php

namespace Pronit\EstructuraEmpresaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
abstract class Sociedad
{    
    /**
     * @ORM\Column(type="string", length=100)
     */    
    private $nombre;
    
    /**
     * @ORM\Column(type="string", length=20)
     */    
    private $abreviatura;
    
    /**
     * @ORM\Column(type="string", length=100)
     */        
    private $nombreFantasia;
    
    /**
     * @ORM\Column(type="boolean")
     */        
    private $activa;
    
    //private $oficinaEnteControladorImpositivo;

    /**
     * @ORM\Column(type="date")
     */            
    private $fechaFundacion;
        
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
    
    public function setNombreFantasia($value)
    {
        $this->nombreFantasia = $value;
    }
    
    public function getNombreFantasia()
    {
        return $this->nombreFantasia;
    }
    
    public function setActiva($value)
    {
        $this->activa = $value;
    }
    
    public function isActiva()
    {
        return $this->activa;
    }
    
    public function setFechaFundacion($value)
    {
        $this->fechaFundacion = $value;
    }
    
    public function getFechaFundacion()
    {
        return $this->fechaFundacion;
    }
    
    public function __toString() 
    {
        return (string)$this->getNombre();
    }
}

