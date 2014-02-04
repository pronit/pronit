<?php

namespace Pronit\ParametrizacionGeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 
 *
 * @author gcaseres
 * @ORM\Entity
 * @ORM\Table(name="pgener_paises")
 */
class Pais
{
    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    private $id;
    
    /**
     * @ORM\Column(type="string", length=50)
     */    
    private $nombre;
    
    /**
     * @ORM\Column(type="string", length=10)
     */    
    private $abreviatura;
    
    /**
     * @ORM\Column(type="string", length=100)
     */        
    private $nombreLargo;
    
    /**
     * @ORM\Column(type="string", length=2)
     */        
    private $codigoISO;
    
    /**
     * @ORM\Column(type="string", length=10)
     */        
    private $claveAlternativa;    

    /**
     * @ORM\Column(type="string", length=3)
     */        
    private $claveISOExtendida;    
    
    /**
     * @ORM\Column(type="integer")
     */        
    private $longitudCodigoPostal;    

    /**
     * @ORM\Column(type="string", length=50)
     */        
    private $nacionalidad;    
    
    
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
    
    public function setNombreLargo($value)
    {
        $this->nombreLargo = $value;
    }
    
    public function getNombreLargo()
    {
        return $this->nombreLargo;
    }
    
    public function setCodigoISO($value)
    {
        $this->codigoISO = $value;
    }
    
    public function getCodigoISO()
    {
        return $this->codigoISO;
    }
    
    public function setClaveAlternativa($value)
    {
        $this->claveAlternativa = $value;
    }
    
    public function getClaveAlternativa()
    {
        return $this->claveAlternativa;
    }
    
    public function setClaveISOExtendida($value)
    {
        $this->claveISOExtendida = $value;
    }
    
    public function getClaveISOExtendida()
    {
        return $this->claveISOExtendida;
    }
    
    public function setLongitudCodigoPostal($value)
    {
        $this->longitudCodigoPostal = $value;
    }
    
    public function getLongitudCodigoPostal()
    {
        return $this->longitudCodigoPostal;
    }
        
    public function setNacionalidad($value)
    {
        $this->nacionalidad = $value;
    }
    
    public function getNacionalidad()
    {
        return $this->nacionalidad;
    }
    
    public function __toString() 
    {
        return (string)$this->getNombre();
    }
}

