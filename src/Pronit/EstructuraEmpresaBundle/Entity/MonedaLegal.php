<?php

namespace Pronit\EstructuraEmpresaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pronit\ParametrizacionGeneralBundle\Entity as PGener;

/**
 * Moneda legal para una sociedad durante un intervalo de fechas
 *
 * @author gcaseres
 * @ORM\Entity
 * @ORM\Table(name="eempre_monedaslegales")
 */
class MonedaLegal 
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */        
    private $id;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Sociedad", inversedBy="monedasLegales")
     */
    private $sociedad;
    
    /**
     * 
     * @ORM\ManyToOne(targetEntity="Pronit\ParametrizacionGeneralBundle\Entity\Moneda")
     */    
    private $moneda;
    
    /**
     *
     * @ORM\Column(type="date")
     */
    private $fechaDesde;
    
    /**
     *
     * @ORM\Column(type="date", nullable=true)
     */
    private $fechaHasta;
        
    
    public function __construct()
    {
        $this->setFechaDesde(new \DateTime());
        $this->setFechaHasta(new \DateTime());
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setSociedad($value)
    {
        $this->sociedad = $value;
    }
    
    public function getSociedad()
    {
        return $this->sociedad;
    }
    
    public function setFechaDesde(\Datetime $value)
    {
        $this->fechaDesde = $value;
    }
    
    public function getFechaDesde()
    {
        return $this->fechaDesde;
    }            
    
    public function setFechaHasta(\Datetime $value = null)
    {
        $this->fechaHasta = $value;
    }
    
    public function getFechaHasta()
    {
        return $this->fechaHasta;
    }            
            
    public function setMoneda(PGener\Moneda $value)
    {
        $this->moneda = $value;
    }
    
    public function getMoneda()
    {
        return $this->moneda;
    }
}


