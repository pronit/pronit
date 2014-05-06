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
  * @ORM\Table(name="pgener_conversionsistemamedicion")
 */
class ConversionSistemaMedicion
{  
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ParametrizacionGeneralBundle\Entity\SistemaMedicion")
     * @ORM\JoinColumn(nullable=false)
     */    
    protected $desde;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ParametrizacionGeneralBundle\Entity\SistemaMedicion")
     * @ORM\JoinColumn(nullable=false)
     */    
    protected $hasta;    

    /**
     * @ORM\Column(type="float")
     */    
    protected $factor;     
    
    public function __construct( SistemaMedicion $desde, SistemaMedicion $hasta, $factor)
    {
        $this->setDesde($desde);
        $this->setHasta($hasta);
        $this->setFactor($factor);
    }
    
    public function getId()
    {
        return $this->id;
    }
        
    public function getDesde()
    {
        return $this->desde;
    }

    public function getHasta()
    {
        return $this->hasta;
    }

    public function getFactor()
    {
        return $this->factor;
    }

    public function setDesde($desde)
    {
        $this->desde = $desde;
    }

    public function setHasta($hasta)
    {
        $this->hasta = $hasta;
    }

    public function setFactor($factor)
    {
        $this->factor = $factor;
    }


}

