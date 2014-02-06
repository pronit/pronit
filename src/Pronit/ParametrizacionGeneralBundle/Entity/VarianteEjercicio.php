<?php

namespace Pronit\ParametrizacionGeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * 
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\Table(name="pgener_varianteejercicio")
 */
class VarianteEjercicio
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
     * @ORM\OneToMany(targetEntity="PeriodoVarianteEjercicio", mappedBy="varianteEjercicio", cascade={"persist"}, orphanRemoval=true)
     */    
    private $periodos;    

    public function __construct()
    {
        $this->periodos = new ArrayCollection();
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
    
    public function getPeriodos()
    {
        return $this->periodos;
    }
    
    public function addPeriodo( PeriodoVarianteEjercicio $periodo )
    {
        $periodo->setVarianteEjercicio($this);
        $this->periodos->add($periodo);
    }

    public function removePeriodo( PeriodoVarianteEjercicio $periodo )
    {
        $this->periodos->removeElement($periodo);
    }
    
    public function __toString() 
    {
        return (string)$this->getNombre();
    }
    
}

