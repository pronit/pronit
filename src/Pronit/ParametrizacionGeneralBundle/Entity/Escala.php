<?php

namespace Pronit\ParametrizacionGeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 
 *
 * @author ldelia
 */
/** 
 * @ORM\Entity
  * @ORM\Table(name="pgener_escala")
 */
class Escala
{    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    protected $id;

    /**
     * @ORM\Column(type="string", length=50)
     */    
    protected $nombre;
    
    /**
     * @ORM\Column(type="string", length=10)
     */        
    protected $abreviatura;
    
    /** @ORM\ManyToOne(targetEntity="Pronit\ParametrizacionGeneralBundle\Entity\SistemaMedicion", inversedBy="escalas") */
    protected $sistemaMedicion;
    
    /**
     * @ORM\Column(type="float")
     */    
    private $factor;    
    
    public function __construct()
    {
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

    public function getSistemaMedicion()
    {
        return $this->sistemaMedicion;
    }

    public function setSistemaMedicion($sistemaMedicion)
    {
        $this->sistemaMedicion = $sistemaMedicion;
    }
      
    public function getFactor()
    {
        return $this->factor;
    }

    public function setFactor($factor)
    {
        $this->factor = $factor;
    }    
}

